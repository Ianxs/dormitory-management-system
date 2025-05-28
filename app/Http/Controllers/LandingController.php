<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingController extends Controller
{
    /**
     * Show the landing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get dorm settings from JSON file
        $settings = $this->getDormSettings();

        return view('landing', [
            'settings' => $settings
        ]);
    }

    /**
     * Show the login section of the landing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login()
    {
        // Get dorm settings from JSON file
        $settings = $this->getDormSettings();

        return view('landing', [
            'currentSection' => 'login',
            'settings' => $settings
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
                'student_plan' => 200,
                'regular_plan' => 350,
                'vip_plan' => 200
            ],
            'rules' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident placeat, consequatur eveniet veritatis quos dignissimos beatae dolores exercitationem laboriosam officia magnam atque blanditiis illum doloremque magni ex corrupti tempora quis.'
        ];
    }
}
