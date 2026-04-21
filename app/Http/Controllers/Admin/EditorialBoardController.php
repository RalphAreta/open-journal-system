<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EditorialBoardMember;
use Illuminate\Http\Request;

class EditorialBoardController extends Controller
{
    protected array $roles = [
    'editor-in-chief'  => 'Editor-in-Chief',
    'guest-editors'    => 'Guest Editors',
    'editors'          => 'Editors',
    'managing-editor'  => 'Managing Editor',
    'layout-editor'    => 'Layout Editor',
    'editorial-advisors' => 'Editorial Advisors',
];

    public function index()
    {
        $all     = EditorialBoardMember::ordered()->get();
        $total   = $all->count();
        $active  = $all->where('is_active', true)->count();
        $members = $all->groupBy('role');   // groups by the 'role' column value
        $roles   = $this->roles;

        return view('admin.editorial-board.index', compact(
            'total',
            'active',
            'members',
            'roles',
        ));
    }

    public function create()
    {
        $roles = $this->roles;
        return view('admin.editorial-board.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'nullable|string|max:100',
            'name'        => 'required|string|max:255',
            'role'        => 'required|string|max:100',
            'affiliation' => 'nullable|string|max:255',
            'location'    => 'nullable|string|max:255',
            'expertise'   => 'nullable|string|max:255',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        EditorialBoardMember::create($data);

        return redirect()->route('admin.editorial-board.index')
                         ->with('success', 'Member added successfully.');
    }

    public function edit(EditorialBoardMember $editorialBoard)
    {
        $roles = $this->roles;
        return view('admin.editorial-board.edit', compact('editorialBoard', 'roles'));
    }

    public function update(Request $request, EditorialBoardMember $editorialBoard)
    {
        $data = $request->validate([
            'title'       => 'nullable|string|max:100',
            'name'        => 'required|string|max:255',
            'role'        => 'required|string|max:100',
            'affiliation' => 'nullable|string|max:255',
            'location'    => 'nullable|string|max:255',
            'expertise'   => 'nullable|string|max:255',
            'sort_order'  => 'nullable|integer',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $editorialBoard->update($data);

        return redirect()->route('admin.editorial-board.index')
                         ->with('success', 'Member updated.');
    }

    public function toggle(EditorialBoardMember $editorialBoard)
    {
        $editorialBoard->update(['is_active' => ! $editorialBoard->is_active]);

        return back()->with('success', 'Visibility updated.');
    }

    public function destroy(EditorialBoardMember $editorialBoard)
    {
        $editorialBoard->delete();

        return redirect()->route('admin.editorial-board.index')
                         ->with('success', 'Member removed.');
    }
}