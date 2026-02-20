<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::withCount('users')->orderBy('name')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function edit(Role $role): View
    {
        $role->load('users');
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'display_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $role->update($validated);
        return redirect()->route('admin.roles.index')->with('success', 'Role updated.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        // Safety check: Prevent deleting core system roles
        $protectedRoles = ['admin', 'author', 'reviewer', 'editor'];

        if (in_array(strtolower($role->name), $protectedRoles)) {
            return redirect()->back()->with('error', 'Core system roles cannot be deleted.');
        }

        // Optional: Check if the role still has users assigned
        if ($role->users()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete role while users are still assigned to it.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
