<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpertiseCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpertiseCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ExpertiseCategory::orderBy('is_custom')->orderBy('name')->paginate(20);

        return view('admin.expertise-categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:expertise_categories,name'],
        ]);

        ExpertiseCategory::create([
            'name'      => $request->name,
            'is_custom' => true,
        ]);

        return back()->with('success', "Category \"{$request->name}\" added successfully.");
    }

    public function update(Request $request, ExpertiseCategory $expertiseCategory): RedirectResponse
    {
        // Only custom categories can be renamed
        if (! $expertiseCategory->is_custom) {
            return back()->withErrors(['edit' => 'Default categories cannot be renamed.']);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:expertise_categories,name,' . $expertiseCategory->id],
        ]);

        $expertiseCategory->update(['name' => $request->name]);

        return back()->with('success', "Category renamed to \"{$request->name}\".");
    }

    public function destroy(ExpertiseCategory $expertiseCategory): RedirectResponse
    {
        // Only custom categories can be deleted
        if (! $expertiseCategory->is_custom) {
            return back()->withErrors(['delete' => 'Default categories cannot be deleted.']);
        }

        $name = $expertiseCategory->name;
        $expertiseCategory->delete();

        return back()->with('success', "Category \"{$name}\" deleted.");
    }
}