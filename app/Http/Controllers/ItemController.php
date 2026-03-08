<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display items for regular users (lost, found, claimed).
     */
    public function index(Request $request)
    {
        $category = $request->query('category', 'all');
        
        $query = Item::query();
        
        if ($category === 'lost') {
            $query->where('status', 'lost');
        } elseif ($category === 'found') {
            $query->where('status', 'found');
        } elseif ($category === 'claimed') {
            $query->whereNotNull('claimed_by')
                  ->where('claimed_by', Auth::id());
        }
        
        $items = $query->orderBy('created_at', 'desc')->paginate(12);
        
        return view('items.index', compact('items', 'category'));
    }

    /**
     * Display all items for admin.
     */
    public function adminIndex(Request $request)
    {
        $type = $request->query('type');
        
        $query = Item::query();
        
        if ($type === 'lost') {
            $query->where('status', 'lost');
        } elseif ($type === 'found') {
            $query->where('status', 'found');
        } elseif ($type === 'claimed') {
            $query->whereNotNull('claimed_by');
        }
        
        $items = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.items', compact('items'));
    }

    /**
     * Display found items only.
     */
    public function foundItems()
    {
        $items = Item::where('status', 'found')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
        
        return view('admin.items', compact('items'));
    }

    /**
     * Show the form for creating a new item (admin only).
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created item (admin only).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'status' => 'required|in:lost,found',
            'date_found' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        Item::create([
            'item_name' => $validated['item_name'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'status' => $validated['status'],
            'date_found' => $validated['date_found'],
            'image' => $imagePath,
            'reported_by' => Auth::id(),
        ]);

        return redirect()->route('admin.items')->with('success', 'Item added successfully!');
    }

    /**
     * Show the form for editing the specified item (admin only).
     */
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified item (admin only).
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'status' => 'required|in:lost,found',
        ]);

        $item->update($validated);

        return redirect()->route('admin.items')->with('success', 'Item updated successfully!');
    }

    /**
     * Remove the specified item (admin only).
     */
    public function destroy(Item $item)
    {
        // Delete image if exists
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }
        
        $item->delete();

        return redirect()->route('admin.items')->with('success', 'Item deleted successfully!');
    }

    /**
     * Claim an item (user).
     */
    public function claim(Request $request, Item $item)
    {
        $request->validate([
            'confirm' => 'required|accepted',
        ]);

        if ($item->status !== 'lost') {
            return redirect()->back()->with('error', 'This item cannot be claimed.');
        }

        $item->update([
            'status' => 'found',
            'claimed_by' => Auth::id(),
            'claim_date' => now(),
        ]);

        return redirect()->route('items.index', ['category' => 'found'])
                        ->with('success', 'Item successfully claimed! Please proceed to OSAS to collect your item.');
    }
}

