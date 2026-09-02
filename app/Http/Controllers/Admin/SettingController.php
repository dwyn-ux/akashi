<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');

        return view('admin.pengaturan.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'nullable|string|max:255',
            'event_full_name' => 'nullable|string|max:255',
            'school_name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'event_date' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'primary_color' => 'nullable|string|max:7',
            'primary_color_hex' => 'nullable|string|max:7',
            'whatsapp' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|url|max:500',
            'tiktok_url' => 'nullable|url|max:500',
            'facebook_url' => 'nullable|url|max:500',
            'google_maps_embed' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'footer_text' => 'nullable|string',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'account_holder' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|max:2048',
            'school_logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:512',
            // backward compat for old field names if still posted
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'secondary_color' => 'nullable|string|max:7',
            'logo_url' => 'nullable|string|max:255',
        ]);

        // Handle file uploads — store to public disk and save path
        foreach (['site_logo', 'school_logo', 'favicon'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $path = $request->file($fileKey)->store('settings', 'public');
                // save as the same key
                Setting::updateOrCreate(['key' => $fileKey], ['value' => $path]);
            }
        }

        // Normalize color: prefer primary_color, fallback to primary_color_hex
        if (!empty($validated['primary_color_hex']) && empty($validated['primary_color'])) {
            $validated['primary_color'] = $validated['primary_color_hex'];
        }
        unset($validated['primary_color_hex'], $validated['site_logo'], $validated['school_logo'], $validated['favicon']);

        // Backward compat: map old keys to new
        if (isset($validated['site_name']) && !isset($validated['event_name'])) {
            $validated['event_name'] = $validated['site_name'];
        }
        if (isset($validated['site_description']) && !isset($validated['tagline'])) {
            $validated['tagline'] = $validated['site_description'];
        }
        if (isset($validated['whatsapp_number']) && !isset($validated['whatsapp'])) {
            $validated['whatsapp'] = $validated['whatsapp_number'];
        }
        if (isset($validated['logo_url']) && !isset($validated['site_logo'])) {
            // keep as string path if provided
            $validated['site_logo'] = $validated['logo_url'];
        }
        unset($validated['site_name'], $validated['site_description'], $validated['whatsapp_number'], $validated['logo_url'], $validated['secondary_color']);

        // Normalize Instagram: strip leading @ if present (we add it back in views)
        if (!empty($validated['instagram'])) {
            $validated['instagram'] = ltrim($validated['instagram'], '@');
        }

        foreach ($validated as $key => $value) {
            // Convert null (from empty nullable fields) to empty string to satisfy NOT NULL before migration runs
            // After migration value is nullable, but empty string is still cleaner for display
            if ($value === null) {
                $value = '';
            }
            Setting::updateOrCreate(['key' => $key], ['value' => (string) $value]);
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
