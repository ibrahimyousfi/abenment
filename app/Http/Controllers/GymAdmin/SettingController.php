<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $gym = auth()->user()->gym;
        return view('gym_admin.settings.edit', compact('gym'));
    }

    public function update(Request $request)
    {
        $gym = auth()->user()->gym;

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048', // 2MB Max
            // Explicitly NOT validating or updating user credentials here
        ]);

        $data = [
            'name' => $request->name,
        ];

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($gym->logo) {
                Storage::disk('public')->delete($gym->logo);
            }
            $data['logo'] = $request->file('logo')->store('gym_logos', 'public');
        }

        $gym->update($data);

        return back()->with('success', 'Paramètres mis à jour avec succès.');
    }
}
