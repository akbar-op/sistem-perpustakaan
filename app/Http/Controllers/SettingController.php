<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SettingController extends Controller
{
    private const DEFAULTS = [
        'library_name' => 'Perpustakaan Sekolah',
        'address' => 'Perpustakaan Sekolah',
        'email' => 'perpustakaan@sekolah.sch.id',
        'whatsapp' => '+62 8123456789',
        'max_books' => 5,
        'loan_duration_days' => 14,
        'fine_per_day' => 7000,
        'renewal_limit' => 2,
        'email_notifications' => true,
    ];

    public function index(): View
    {
        $settings = DB::table('library_settings')->find(1) ?? (object) self::DEFAULTS;

        return view('setting', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'library_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:30'],
            'max_books' => ['required', 'integer', 'min:1', 'max:50'],
            'loan_duration_days' => ['required', 'integer', 'min:1', 'max:365'],
            'fine_per_day' => ['required', 'integer', 'min:0', 'max:1000000'],
            'renewal_limit' => ['required', 'integer', 'min:0', 'max:10'],
        ]);
        $validated['email_notifications'] = $request->boolean('email_notifications');

        DB::table('library_settings')->updateOrInsert(
            ['id' => 1],
            [...$validated, 'created_at' => now(), 'updated_at' => now()],
        );

        return redirect()->route('setting')->with('success', 'Pengaturan perpustakaan berhasil disimpan.');
    }
}
