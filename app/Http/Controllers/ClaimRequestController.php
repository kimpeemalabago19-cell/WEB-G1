<?php

namespace App\Http\Controllers;

use App\Models\ClaimRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClaimRequestController extends Controller
{
    // User submits a claim request
    public function store(Request $request)
    {
        $user = Auth::user();
        $itemId = $request->input('item_id');
        $proof = $request->input('proof');

        $item = Item::findOrFail($itemId);
        if ($item->status === 'claimed') {
            return back()->withErrors(['item' => 'This item has already been claimed.']);
        }

        $exists = ClaimRequest::where('user_id', $user->id)
            ->where('item_id', $itemId)
            ->where('status', 'pending')
            ->exists();
        if ($exists) {
            return back()->withErrors(['item' => 'You already have a pending claim request for this item.']);
        }

        $validator = Validator::make($request->all(), [
            'proof' => 'required|string|min:30|max:1000',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        ClaimRequest::create([
            'user_id' => $user->id,
            'item_id' => $itemId,
            'proof' => $proof,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        return back()->with('success', 'Claim Request Submitted Successfully');
    }

    // Admin: list all claim requests
    public function index()
    {
        $requests = ClaimRequest::with(['user', 'item', 'approver'])->orderByDesc('created_at')->get();
        return view('admin.claim_requests', compact('requests'));
    }

    // Admin: approve a claim request
    public function approve($id)
    {
        $request = ClaimRequest::findOrFail($id);
        if ($request->status !== 'pending') {
            return back()->withErrors(['request' => 'Request is not pending.']);
        }
        DB::transaction(function () use ($request) {
            $request->status = 'approved';
            $request->approved_at = now();
            $request->approved_by = Auth::id();
            $request->save();
            $item = $request->item;
            $item->status = 'claimed';
            $item->claimed_by = $request->user_id;
            $item->save();
            // Reject all other pending requests for this item
            ClaimRequest::where('item_id', $item->id)
                ->where('status', 'pending')
                ->where('id', '!=', $request->id)
                ->update(['status' => 'rejected']);
        });
        return back()->with('success', 'Claim request approved and item marked as claimed.');
    }

    // Admin: reject a claim request
    public function reject($id)
    {
        $request = ClaimRequest::findOrFail($id);
        if ($request->status !== 'pending') {
            return back()->withErrors(['request' => 'Request is not pending.']);
        }
        $request->status = 'rejected';
        $request->approved_at = now();
        $request->approved_by = Auth::id();
        $request->save();
        return back()->with('success', 'Claim request rejected.');
    }
}
