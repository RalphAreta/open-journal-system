<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeclineReason;
use Illuminate\Http\Request;

class DeclineReasonController extends Controller
{
    public function index()
    {
        $reasons = DeclineReason::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.decline-reasons.index', compact('reasons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:255', 'unique:decline_reasons,reason'],
        ]);

        $maxOrder = DeclineReason::max('sort_order') ?? 0;

        DeclineReason::create([
            'reason'     => $request->reason,
            'is_active'  => true,
            'sort_order' => $maxOrder + 1,
        ]);

        return back()->with('success', 'Decline reason added successfully.');
    }

    public function update(Request $request, DeclineReason $declineReason)
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:255', 'unique:decline_reasons,reason,' . $declineReason->id],
        ]);

        $declineReason->update([
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Decline reason updated successfully.');
    }

    public function toggleActive(DeclineReason $declineReason)
    {
        $declineReason->update(['is_active' => ! $declineReason->is_active]);

        $status = $declineReason->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Decline reason {$status}.");
    }

    public function destroy(DeclineReason $declineReason)
    {
        $declineReason->delete();
        return back()->with('success', 'Decline reason deleted.');
    }

    // API endpoint consumed by the reviewer's JS (declineInvitation())
    public function apiIndex()
    {
        return response()->json(
            DeclineReason::active()->pluck('reason')
        );
    }
}