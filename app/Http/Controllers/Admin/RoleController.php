<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(\Illuminate\Http\Request $request): View
    {
        // remember admin dashboard area visited
        $request->session()->put('preferred_dashboard', 'admin');

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

        // Redirecting with success will trigger the SweetAlert in layouts.app
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role "' . $role->display_name . '" updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        // Safety check: Prevent deleting core system roles
        // Added 'editor-in-chief' to match common system structures
        $protectedRoles = ['admin', 'author', 'reviewer', 'editor', 'editor-in-chief'];

        if (in_array(strtolower($role->name), $protectedRoles)) {
            return redirect()->back()->with('error', 'The ' . $role->display_name . ' role is a core system requirement and cannot be deleted.');
        }

        // Check if the role still has users assigned
        // If users exist, we send an 'error' session which triggers the Red SweetAlert
        if ($role->users()->count() > 0) {
            return redirect()->back()->with('error', 'Action Denied: There are still ' . $role->users()->count() . ' users assigned to this role.');
        }

        $roleName = $role->display_name;
        $role->delete();

        // This success message will trigger the Green SweetAlert on the index page
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role "' . $roleName . '" has been permanently removed.');
    }
}
