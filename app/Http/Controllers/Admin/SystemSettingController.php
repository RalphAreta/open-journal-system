<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SystemSettingController extends Controller
{
    public function index(): View
    {
        $settings = SystemSetting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $inputs = $request->except('_token', '_method');
        foreach ($inputs as $key => $value) {
            if (str_starts_with($key, 'setting_')) {
                $settingKey = substr($key, 8);
                $setting = SystemSetting::where('key', $settingKey)->first();
                if ($setting) {
                    SystemSetting::setValue($settingKey, $value ?? '', $setting->type, $setting->group);
                }
            }
        }

        return back()->with('success', 'Settings saved.');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:system_settings,key'],
            'value' => ['nullable', 'string'],
            'type' => ['required', 'in:string,boolean,integer,json'],
            'group' => ['required', 'string', 'max:255'],
        ]);

        SystemSetting::create($validated);
        return back()->with('success', 'Setting added.');
    }

    public function destroy(SystemSetting $setting): RedirectResponse
    {
        $setting->delete();
        return back()->with('success', 'Setting removed.');
    }
}
