<?php

namespace App\Http\Controllers;

use App\Models\ArchivedTenant;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:tenant');
    }

    public function homepage(Request $request)
    {
        $tenant = Auth::guard('tenant')->user();

        // Get date range filter
        $dateFilter = $request->input('date_filter', 'last_30_days');
        $searchDate = $request->input('search_date');

        // Query payments
        $query = Payment::where('tenant_id', $tenant->id);

        // Apply date filter
        if ($searchDate) {
            // If search date is provided, filter by that specific date
            $query->whereDate('payment_date', $searchDate);
        } else {
            // Otherwise apply the selected date range filter
            switch ($dateFilter) {
                case 'last_day':
                    $query->whereDate('payment_date', '>=', Carbon::now()->subDay());
                    break;
                case 'last_7_days':
                    $query->whereDate('payment_date', '>=', Carbon::now()->subDays(7));
                    break;
                case 'last_30_days':
                    $query->whereDate('payment_date', '>=', Carbon::now()->subDays(30));
                    break;
                case 'last_month':
                    $query->whereMonth('payment_date', Carbon::now()->subMonth()->month)
                          ->whereYear('payment_date', Carbon::now()->subMonth()->year);
                    break;
                case 'last_year':
                    $query->whereYear('payment_date', Carbon::now()->subYear()->year);
                    break;
                case 'custom_range':
                    $startDate = $request->input('start_date');
                    $endDate = $request->input('end_date');
                    if ($startDate && $endDate) {
                        $query->whereDate('payment_date', '>=', $startDate)
                              ->whereDate('payment_date', '<=', $endDate);
                    }
                    break;
            }
        }

        // Get payments
        $payments = $query->orderBy('payment_date', 'desc')->get();

        // Get stats for cards
        $pendingRequests = 'Pending'; // This would come from a maintenance requests table

        // Get next rent due date (assuming it's the first of next month)
        $nextRentDue = Carbon::now()->addMonth()->startOfMonth()->format('M j, Y');

        // Count recent notifications (placeholder for now)
        $recentNotifications = 3; // This would come from a notifications table

        // Calculate total paid from all payments
        $totalPaid = $tenant->total_paid ?? 0;

        return view('tenant.tenant-homepage', [
            'adminTitle' => 'Home',
            'payments' => $payments,
            'dateFilter' => $dateFilter,
            'searchDate' => $searchDate,
            'pendingRequests' => $pendingRequests,
            'nextRentDue' => $nextRentDue,
            'recentNotifications' => $recentNotifications,
            'totalPaid' => $totalPaid
        ]);
    }


    /**
     * Show the dorm rules page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dormRules()
    {
        // Get dorm settings from JSON file
        $settings = $this->getDormSettings();

        return view('tenant.tenant-dormRules', [
            'adminTitle' => 'Dorm Rules',
            'rules' => $settings['rules']
        ]);
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
     * Show the maintenance request page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function maintenanceRequest()
    {
        $tenant = Auth::guard('tenant')->user();

        // Get the latest maintenance request for the tenant
        $maintenanceRequest = \App\Models\MaintenanceRequest::where('tenant_id', $tenant->id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Check if tenant has a pending or in-progress maintenance request
        $hasPendingRequest = $maintenanceRequest && ($maintenanceRequest->status == 'Pending' || $maintenanceRequest->status == 'In Progress');

        return view('tenant.tenant-request', [
            'adminTitle' => 'Maintenance Request',
            'hasPendingRequest' => $hasPendingRequest,
            'maintenanceRequest' => $maintenanceRequest
        ]);
    }

    /**
     * Submit a maintenance request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitRequest(Request $request)
    {
        $request->validate([
            'issue_type' => 'required|string',
            'description' => 'required|string',
            'priority' => 'required|string',
            'issue_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $tenant = Auth::guard('tenant')->user();

        // Check if tenant already has a pending or in-progress request
        $hasPendingRequest = \App\Models\MaintenanceRequest::where('tenant_id', $tenant->id)
            ->whereIn('status', ['Pending', 'In Progress'])
            ->exists();

        if ($hasPendingRequest) {
            return redirect()->route('tenant.request')
                ->with('error', 'You already have a pending or in-progress maintenance request. Please wait for it to be completed.');
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('issue_image')) {
            $image = $request->file('issue_image');
            $imageName = time() . '_' . $tenant->id . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/maintenance_images', $imageName);
            $imagePath = 'storage/maintenance_images/' . $imageName;
        }

        // Create the maintenance request
        $maintenanceRequest = new \App\Models\MaintenanceRequest([
            'tenant_id' => $tenant->id,
            'room_number' => $tenant->room_number, // Use the room number from the tenant record
            'issue_type' => $request->issue_type,
            'description' => $request->description,
            'image_path' => $imagePath,
            'priority' => $request->priority,
            'status' => 'Pending',
            'tenant_name' => $tenant->tenant_name,
            'tenant_contact' => $tenant->tenant_contact, // Use the contact from the tenant record
            'date' => now()->format('Y-m-d'),
        ]);

        $maintenanceRequest->save();

        return redirect()->route('tenant.request')->with('success', 'Maintenance request submitted successfully.');
    }

    public function archive($id)
    {
        $tenant = Tenant::find($id);

        if (!$tenant) {
            return redirect()->back()->with('error', 'Tenant not found.');
        }

        try {
            ArchivedTenant::create([
                'original_tenant_id' => $tenant->id,
                'room_number' => $tenant->room_number,
                'name' => $tenant->name,
                'email' => $tenant->email,
                'phone' => $tenant->phone,
                'archived_at' => now(),
                'reason' => 'Deleted by admin', // optional
            ]);

            $tenant->delete();

            return redirect()->back()->with('success', 'Tenant archived successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Archiving failed: ' . $e->getMessage());
        }
    }


    /**
     * Change tenant password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $tenant = Auth::guard('tenant')->user();

        // Check if current password matches
        if (!password_verify($request->current_password, $tenant->tenant_password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        // Update password
        $tenant->tenant_password = bcrypt($request->new_password);
        $tenant->save();

        return back()->with('success', 'Password changed successfully.');
    }
}
