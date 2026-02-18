<?php

namespace App\Http\Controllers\Admin;

use App\Models\EditorExpertise;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditorExpertiseController extends Controller
{
    public function index()
    {
        $editors = User::whereHas('roles', function ($query) {
            $query->where('name', 'editor');
        })->with('editorExpertise')->paginate(10);

        return view('admin.editor-expertise.index', compact('editors'));
    }

    public function show(User $user)
    {
        if (!$user->hasRole('editor')) {
            abort(403);
        }

        return view('admin.editor-expertise.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!$user->hasRole('editor')) {
            abort(403);
        }

        $expertise = $user->editorExpertise;
        $fieldOptions = EditorExpertise::getFieldOptions();

        return view('admin.editor-expertise.edit', compact('user', 'expertise', 'fieldOptions'));
    }

    public function update(Request $request, User $user)
    {
        if (!$user->hasRole('editor')) {
            abort(403);
        }

        $validated = $request->validate([
            'expertise' => 'array',
            'expertise.*' => 'string|in:' . implode(',', array_keys(EditorExpertise::getFieldOptions())),
            'description.*' => 'nullable|string|max:500',
        ]);

        // Delete existing expertise
        $user->editorExpertise()->delete();

        // Add new expertise
        $expertise = $request->input('expertise', []);
        foreach ($expertise as $index => $field) {
            if (!empty($field)) {
                EditorExpertise::create([
                    'user_id' => $user->id,
                    'field_name' => $field,
                    'description' => $request->input("description.{$index}"),
                ]);
            }
        }

        return redirect()->route('admin.editor-expertise.show', $user)
            ->with('success', 'Editor expertise updated successfully.');
    }

    public function addField(Request $request, User $user)
    {
        if (!$user->hasRole('editor')) {
            abort(403);
        }

        $validated = $request->validate([
            'field_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        EditorExpertise::create([
            'user_id' => $user->id,
            'field_name' => $validated['field_name'],
            'description' => $validated['description'],
        ]);

        return back()->with('success', 'Expertise field added successfully.');
    }

    public function removeField(EditorExpertise $expertise)
    {
        $user = $expertise->editor;
        $expertise->delete();

        return back()->with('success', 'Expertise field removed successfully.');
    }
}
