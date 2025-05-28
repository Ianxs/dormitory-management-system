<?php

namespace App\Http\Controllers;

use App\Models\ArchivedTenant;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['getAvailableRooms', 'storeTenant']);
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        // Get total number of non-archived tenants
        $totalTenants = Tenant::where(function($query) {
            $query->where('status', '!=', 'Archived')
                  ->orWhereNull('status');
        })->count();

        // Get total amount paid by all tenants
        $totalBalance = Tenant::sum('total_paid');

        // Get rooms information
        $totalRooms = Room::count();
        // Get rooms that are not at full capacity (limited to 6 total rooms)
        $availableRooms = Room::whereRaw('current_occupants < capacity')->count();
        // Ensure we don't exceed 6 rooms total
        $availableRooms = min($availableRooms, 6);

        // Get pending maintenance requests
        $pendingRequests = \App\Models\MaintenanceRequest::where('status', 'Pending')->count();

        // Get tenant information for the table (including tenants with null status)
        $tenants = Tenant::where(function($query) {
            $query->where('status', '!=', 'Archived')
                  ->orWhereNull('status');
        })->get();

        return view('admin.admin-dashboard', [
            'adminTitle' => 'Dashboard',
            'totalTenants' => $totalTenants,
            'totalBalance' => $totalBalance,
            'availableRooms' => $availableRooms,
            'pendingRequests' => $pendingRequests,
            'tenants' => $tenants
        ]);
    }

    /**
     * Show the add tenant page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addTenant()
    {
        // Get all non-archived tenants
        $tenants = Tenant::where('status', '!=', 'Archived')->get();

        // Get room occupancy data
        $roomOccupancy = [];
        foreach ($tenants as $tenant) {
            $roomNumber = $tenant->room_number;
            if (!isset($roomOccupancy[$roomNumber])) {
                // Get or create the room
                $room = Room::firstOrCreate(
                    ['room_number' => $roomNumber],
                    [
                        'room_type' => $tenant->subscriptions,
                        'capacity' => 6, // All rooms have capacity of 6 as per requirements
                        'current_occupants' => 0,
                        'is_available' => true
                    ]
                );

                // Calculate current occupants for this room
                $currentOccupants = Tenant::where('room_number', $roomNumber)
                    ->where('status', '!=', 'Archived')
                    ->sum('total_occupants');

                // Update room data if needed
                if ($room->current_occupants != $currentOccupants) {
                    $room->current_occupants = $currentOccupants;
                    $room->is_available = $currentOccupants < $room->capacity;
                    $room->save();
                }

                $roomOccupancy[$roomNumber] = [
                    'current' => $currentOccupants,
                    'capacity' => $room->capacity
                ];
            }
        }

        return view('admin.admin-addTenant', [
            'adminTitle' => 'Add Tenants',
            'tenants' => $tenants,
            'roomOccupancy' => $roomOccupancy,
            'showTenants' => true
        ]);
    }

    /**
     * Show the archive page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function archive()
    {
        // Get archived tenants
        $archivedTenants = Tenant::where('status', 'Archived')->get();

        return view('admin.admin-archive', [
            'adminTitle' => 'Archive',
            'tenants' => $archivedTenants,
            'showTenants' => !$archivedTenants->isEmpty()
        ]);
    }

    public function showArchive()
    {
        try {
            $archivedTenants = ArchivedTenant::all();
            return view('admin.admin-archive', [
                'archivedTenants' => $archivedTenants,
                'adminTitle' => 'Archived Tenants'
            ]);
        } catch (\Exception $e) {
            return view('admin.admin-archive', [
                'archivedTenants' => collect(),
                'adminTitle' => 'Archived Tenants'
            ]);
        }
    }

    /**
     * Archive a tenant.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function archiveTenant($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->status = 'Archived';
        $tenant->save();

        return redirect()->route('admin.add-tenant')
            ->with('success', 'Tenant archived successfully!');
    }

    /**
     * Extend a tenant's end date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function extendTenant(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'new_end_date' => 'required|date|after:today',
        ]);

        $tenant = Tenant::findOrFail($id);
        $tenant->lease_end = $validated['new_end_date'];
        $tenant->save();

        return redirect()->route('admin.add-tenant')
            ->with('success', 'Tenant lease extended successfully!');
    }

    /**
     * Show the maintenance requests page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function maintenanceRequests()
    {
        // Get total number of non-archived tenants
        $totalTenants = Tenant::where('status', '!=', 'Archived')->count();

        // Get total balance (sum of due amounts)
        $totalBalance = Tenant::sum('due_amount');

        // Get rooms information
        $totalRooms = Room::count();
        // Get rooms that are not at full capacity
        $availableRooms = Room::whereRaw('current_occupants < capacity')->count();

        // Get maintenance requests from the database with tenant relationship
        $maintenanceRequests = \App\Models\MaintenanceRequest::with('tenant')->orderBy('created_at', 'desc')->get();

        // Count pending maintenance requests
        $pendingRequests = \App\Models\MaintenanceRequest::where('status', 'Pending')->count();

        return view('admin.admin-maintainReq', [
            'adminTitle' => 'Maintenance Requests',
            'totalTenants' => $totalTenants,
            'totalBalance' => $totalBalance,
            'availableRooms' => $availableRooms,
            'pendingRequests' => $pendingRequests,
            'maintenanceRequests' => $maintenanceRequests
        ]);
    }

// In AdminController.php
    public function deleteArchivedTenant($id)
    {
        try {
            $archivedTenant = ArchivedTenant::findOrFail($id);
            $archivedTenant->forceDelete();

            return redirect()->route('admin.archive')
                ->with('success', "Archived tenant permanently deleted!");

        } catch (\Exception $e) {
            return redirect()->route('admin.archive')
                ->with('error', 'Failed to delete archived tenant: ' . $e->getMessage());
        }
    }


    /**
     * Show the manage dormitory page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function manageDorm()
    {
        // Get dorm settings from JSON file
        $settings = $this->getDormSettings();

        return view('admin.admin-manageDorm', [
            'adminTitle' => 'Manage Dormitory',
            'settings' => $settings
        ]);
    }

    /**
     * Update dorm settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateDormSettings(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'student_plan' => 'required|numeric',
            'regular_plan' => 'required|numeric',
            'vip_plan' => 'required|numeric',
            'rules' => 'required|string'
        ]);

        // Update settings
        $settings = [
            'pricing' => [
                'student_plan' => (float) $validated['student_plan'],
                'regular_plan' => (float) $validated['regular_plan'],
                'vip_plan' => (float) $validated['vip_plan']
            ],
            'rules' => $validated['rules']
        ];

        // Save settings to JSON file
        Storage::put('dorm_settings.json', json_encode($settings, JSON_PRETTY_PRINT));

        return redirect()->route('admin.manage-dorm')->with('success', 'Dorm settings updated successfully!');
    }

    /**
     * Get dorm settings from JSON file.
     *
     * @return array
     */
    private function getDormSettings()
    {
        if (Storage::exists('dorm_settings.json')) {
            return json_decode(Storage::get('dorm_settings.json'), true);
        }

        // Default settings if file doesn't exist
        return [
            'pricing' => [
                'student_plan' => 10000,
                'regular_plan' => 12000,
                'vip_plan' => 15000
            ],
            'rules' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident placeat, consequatur eveniet veritatis quos dignissimos beatae dolores exercitationem laboriosam officia magnam atque blanditiis illum doloremque magni ex corrupti tempora quis.'
        ];
    }

    /**
     * Store a new tenant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeTenant(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'tenant_name' => 'required|string|max:255',
            'tenant_contact' => 'required|string|max:255',
            'total_occupants' => 'required|integer|min:1|max:6',
            'room_number' => 'required|integer',
            'subscriptions' => 'required|string|in:Student Plan,Regular Plan,Premium Plan',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'tenant_id' => 'nullable|string|max:255',
        ]);

        // Check if the room exists, if not create it
        $room = Room::firstOrCreate(
            ['room_number' => $validated['room_number']],
            [
                'room_type' => $validated['subscriptions'],
                'capacity' => 6, // All rooms have capacity of 6 as per requirements
                'current_occupants' => 0,
                'is_available' => true
            ]
        );

        // Get the current occupants count for this room
        $currentOccupants = Tenant::where('room_number', $validated['room_number'])
            ->where('status', '!=', 'Archived')
            ->sum('total_occupants');

        // Check if adding new occupants would exceed room capacity
        if ($currentOccupants + $validated['total_occupants'] > $room->capacity) {
            return redirect()->route('admin.add-tenant')
                ->with('error', 'Cannot add tenant. Room ' . $validated['room_number'] . ' has a capacity of ' . $room->capacity .
                       ' and already has ' . $currentOccupants . ' occupants. Adding ' . $validated['total_occupants'] .
                       ' more would exceed the capacity.')
                ->withInput();
        }

        // Generate a sequential tenant ID starting from 10001
        $highestTenant = Tenant::orderBy('tenant_id', 'desc')->first();

        if ($highestTenant) {
            // If tenants exist, increment the highest tenant ID
            $tenantId = (int)$highestTenant->tenant_id + 1;
        } else {
            // If no tenants exist, start from 10001
            $tenantId = 10001;
        }

        // Convert to string
        $tenantId = (string)$tenantId;

        // Generate a default password (you can customize this logic)
        $defaultPassword = bcrypt('password123');

        // Create the tenant
        $tenant = Tenant::create([
            'tenant_id' => $tenantId,
            'tenant_password' => $defaultPassword,
            'tenant_name' => $validated['tenant_name'],
            'tenant_contact' => $validated['tenant_contact'],
            'total_occupants' => $validated['total_occupants'],
            'subscriptions' => $validated['subscriptions'],
            'room_number' => $validated['room_number'],
            'lease_end' => $validated['end_date'],
            'total_paid' => 0, // Default value
            'due_amount' => 0, // Default value
            'status' => 'Active', // Default status
        ]);

        // Update the room's current occupants count
        $room->current_occupants = $currentOccupants + $validated['total_occupants'];
        $room->is_available = $room->current_occupants < $room->capacity;
        $room->save();

        return redirect()->route('admin.add-tenant')
            ->with('success', 'Tenant added successfully! Tenant ID: ' . $tenantId . ' | Password: password123')
            ->with('showTenants', true);
    }

    /**
     * Show the payment history page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function paymentHistory()
    {
        // Get total number of non-archived tenants
        $totalTenants = Tenant::where('status', '!=', 'Archived')->count();

        // Get total balance (sum of due amounts)
        $totalBalance = Tenant::sum('due_amount');

        // Get rooms information
        $totalRooms = Room::count();
        // Get rooms that are not at full capacity
        $availableRooms = Room::whereRaw('current_occupants < capacity')->count();

        // Get pending maintenance requests
        $pendingRequests = \App\Models\MaintenanceRequest::where('status', 'Pending')->count();

        // Get tenant information for the payment history table (excluding archived tenants)
        $tenants = Tenant::where('status', '!=', 'Archived')->with('payments')->get();

        // Get all payments for the payment history table
        $payments = \App\Models\Payment::with('tenant')->orderBy('payment_date', 'desc')->get();

        return view('admin.admin-paymentHistory', [
            'adminTitle' => 'Payment History',
            'totalTenants' => $totalTenants,
            'totalBalance' => $totalBalance,
            'availableRooms' => $availableRooms,
            'pendingRequests' => $pendingRequests,
            'tenants' => $tenants,
            'payments' => $payments
        ]);
    }

    /**
     * Update the status of a maintenance request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRequestStatus(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'status' => 'required|string|in:Pending,In Progress,Completed',
        ]);

        try {
            // Find the maintenance request
            $maintenanceRequest = \App\Models\MaintenanceRequest::findOrFail($id);

            // Update the status
            $maintenanceRequest->status = $validated['status'];
            $maintenanceRequest->save();

            return response()->json([
                'success' => true,
                'message' => 'Maintenance request status updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update maintenance request status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear all tenant data to reset tenant IDs to start from 10001.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteTenantById(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        try {
            $tenant = Tenant::findOrFail($id);

            ArchivedTenant::create([
                'original_tenant_id' => $tenant->tenant_id,
                'name' => $tenant->tenant_name,
                'phone' => $tenant->tenant_contact ?? null,
                'room_number' => $tenant->room_number,
                'archived_at' => now(),
                'reason' => $request->reason,
            ]);

            $tenant->forceDelete();

            return redirect()->route('admin.add-tenant')
                ->with('success', "Tenant {$tenant->name} archived and deleted successfully!");

        } catch (\Exception $e) {
            return redirect()->route('admin.add-tenant')
                ->with('error', 'Failed to archive/delete tenant: ' . $e->getMessage());
        }
    }

    /**
     * Delete a maintenance request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMaintenanceRequest(Request $request, $id)
    {
        try {
            // Find the maintenance request
            $maintenanceRequest = \App\Models\MaintenanceRequest::findOrFail($id);

            // Delete the maintenance request
            $maintenanceRequest->delete();

            return response()->json([
                'success' => true,
                'message' => 'Maintenance request deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete maintenance request: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'tenant_name' => 'required|string|max:255',
            'tenant_contact' => 'required|string|max:255',
            'total_occupants' => 'required|integer|min:1|max:6',
            'room_number' => 'required|integer',
            'subscriptions' => 'required|string|in:Student Plan,Regular Plan,Premium Plan',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            DB::beginTransaction();

            // Check if the room exists, if not create it
            $room = Room::firstOrCreate(
                ['room_number' => $request->room_number],
                [
                    'room_type' => $request->subscriptions,
                    'capacity' => 6, // All rooms have capacity of 6 as per requirements
                    'current_occupants' => 0,
                    'is_available' => true
                ]
            );

            // Get the current occupants count for this room
            $currentOccupants = Tenant::where('room_number', $request->room_number)
                ->where('status', '!=', 'Archived')
                ->sum('total_occupants');

            // Check if adding new occupants would exceed room capacity
            if ($currentOccupants + $request->total_occupants > $room->capacity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add tenant. Room ' . $request->room_number . ' has a capacity of ' . $room->capacity .
                        ' and already has ' . $currentOccupants . ' occupants. Adding ' . $request->total_occupants .
                        ' more would exceed the capacity.'
                ], 422);
            }

            // Generate a sequential tenant ID starting from 10001
            $highestTenant = Tenant::orderBy('tenant_id', 'desc')->first();

            if ($highestTenant) {
                // If tenants exist, increment the highest tenant ID
                $tenantId = (int)$highestTenant->tenant_id + 1;
            } else {
                // If no tenants exist, start from 10001
                $tenantId = 10001;
            }

            // Convert to string
            $tenantId = (string)$tenantId;

            // Generate a default password
            $defaultPassword = bcrypt('password123');

            // Create the tenant
            $tenant = Tenant::create([
                'tenant_id' => $tenantId,
                'tenant_password' => $defaultPassword,
                'tenant_name' => $request->tenant_name,
                'tenant_contact' => $request->tenant_contact,
                'total_occupants' => $request->total_occupants,
                'subscriptions' => $request->subscriptions,
                'room_number' => $request->room_number,
                'lease_end' => $request->end_date,
                'total_paid' => 0, // Default value
                'due_amount' => 0, // Default value
                'status' => 'Active', // Default status
            ]);

            // Update the room's current occupants count
            $room->current_occupants = $currentOccupants + $request->total_occupants;
            $room->is_available = $room->current_occupants < $room->capacity;
            $room->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tenant added successfully! Tenant ID: ' . $tenantId . ' | Password: password123',
                'data' => $tenant
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create tenant',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Record a payment for a tenant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recordPayment(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        try {
            // Get the tenant
            $tenant = Tenant::findOrFail($validated['tenant_id']);

            // Get the dorm settings to calculate the due amount
            $settings = $this->getDormSettings();

            // Calculate due amount based on subscription, number of occupants, and days of stay
            $subscriptionPrice = 0;
            switch ($tenant->subscriptions) {
                case 'Student Plan':
                    $subscriptionPrice = $settings['pricing']['student_plan'];
                    break;
                case 'Regular Plan':
                    $subscriptionPrice = $settings['pricing']['regular_plan'];
                    break;
                case 'Premium Plan':
                    $subscriptionPrice = $settings['pricing']['vip_plan'];
                    break;
            }

            // Calculate days of stay
            $startDate = $tenant->created_at;
            $endDate = $tenant->lease_end ? new \DateTime($tenant->lease_end) : now();
            $daysOfStay = $startDate->diff($endDate)->days;
            $daysOfStay = max(1, $daysOfStay); // Ensure at least 1 day

            // Calculate due amount: subscription price * occupants * days of stay
            $dueAmount = $subscriptionPrice * $tenant->total_occupants * $daysOfStay;

            // Update tenant's total paid amount
            $tenant->total_paid += $validated['amount'];

            // Determine payment status
            $paymentStatus = 'partially_paid';
            if ($tenant->total_paid >= $dueAmount) {
                $paymentStatus = 'fully_paid';
            }

            // Create a new payment record
            $payment = new \App\Models\Payment([
                'tenant_id' => $tenant->id,
                'payment_date' => $validated['payment_date'],
                'amount' => $validated['amount'],
                'due_amount' => $dueAmount,
                'status' => $paymentStatus
            ]);

            $payment->save();

            // Update tenant's due amount and save
            $tenant->due_amount = $dueAmount - $tenant->total_paid;
            $tenant->save();

            return redirect()->route('admin.payment-history')
                ->with('success', 'Payment recorded successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.payment-history')
                ->with('error', 'Failed to record payment: ' . $e->getMessage());
        }
    }
    /**
     * Update due amounts for all tenants.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAllDueAmounts()
    {
        try {
            // Get all tenants
            $tenants = Tenant::all();
            $settings = $this->getDormSettings();
            $updatedCount = 0;

            foreach ($tenants as $tenant) {
                // Calculate due amount based on subscription, number of occupants, and days of stay
                $subscriptionPrice = 0;
                switch ($tenant->subscriptions) {
                    case 'Student Plan':
                        $subscriptionPrice = $settings['pricing']['student_plan'];
                        break;
                    case 'Regular Plan':
                        $subscriptionPrice = $settings['pricing']['regular_plan'];
                        break;
                    case 'Premium Plan':
                        $subscriptionPrice = $settings['pricing']['vip_plan'];
                        break;
                }

                // Calculate days of stay
                $startDate = $tenant->created_at;
                $endDate = $tenant->lease_end ? new \DateTime($tenant->lease_end) : now();
                $daysOfStay = $startDate->diff($endDate)->days;
                $daysOfStay = max(1, $daysOfStay); // Ensure at least 1 day

                // Calculate due amount: subscription price * occupants * days of stay
                $dueAmount = $subscriptionPrice * $tenant->total_occupants * $daysOfStay;

                // Update tenant's due amount
                $tenant->due_amount = $dueAmount - $tenant->total_paid;
                $tenant->save();
                $updatedCount++;
            }

            return redirect()->back()
                ->with('success', "Due amounts updated for {$updatedCount} tenants.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update due amounts: ' . $e->getMessage());
        }
    }

    public function getAvailableRooms()
    {
        $rooms = Room::where('is_available', true)
            ->get();

        return response()->json($rooms);
    }
}
