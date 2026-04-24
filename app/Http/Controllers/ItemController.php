<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    private array $categories = \App\Models\Item::ALLOWED_CATEGORIES;

    /* ================= USER DASHBOARD ================= */

    public function userDashboard(Request $request)
    {
        $category = $request->query('search_category', 'all');
        $search = $request->query('search');
        $userId = Auth::id();

        $items = Item::with(['reporter', 'claimer'])
            ->when($category === 'claimed', function($query) use ($userId) {
                return $query->where('status', 'claimed')->where('claimed_by', $userId);
            })
            ->when($category === 'found', function($query) use ($userId) {
                return $query->where(function($q) use ($userId) {
                    $q->where('status', 'found')
                      ->orWhere(function($sub) use ($userId) {
                          $sub->where('status', 'claimed')->where('claimed_by', $userId);
                      });
                });
            })
            ->when(in_array($category, ['lost', 'all']), function($query) use ($category) {
                if ($category !== 'all') {
                    return $query->where('status', $category);
                }
            })
->when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('item_name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('category', 'like', '%' . $search . '%');
                })->orderByRaw("CASE WHEN item_name LIKE ? THEN 1 WHEN category LIKE ? THEN 2 WHEN description LIKE ? THEN 3 ELSE 4 END", ['%{$search}%', '%{$search}%', '%{$search}%']);
            })
->latest()
            ->get();

        $stats = [
            'total' => Item::count(),
            'lost' => Item::where('status', 'lost')->count(),
            'found' => Item::where('status', 'found')->count(),
            'available' => Item::where('status', 'found')->whereNull('claimed_by')->count(),
        ];

        return view('user.dashboard', compact('items', 'category', 'stats'));
    }

    /* ================= CLAIM ITEM ================= */

    public function claimItem(Request $request)
    {
        $request->validate([
            'item_id'=>'required|integer|exists:items,id',
            'contact'=>'required|string|max:255',
            'confirm'=>'required|accepted'
        ]);

        $item = Item::findOrFail($request->item_id);
        $item->update([
            'status'=>'claimed',
            'claimed_by'=>Auth::id(),
            'claim_date'=>now(),
            'claim_details'=>$request->proof ?? null,
            'claim_contact'=>$request->contact
        ]);

        return redirect()->route('user.dashboard', ['search_category' => 'found'])->with('success','Item claim submitted successfully! Admin will contact you.');
    }

    /* ================= STORE ITEM ================= */

    public function store(Request $request)
    {
        $request->validate([
            'reporter_name'=>'required|string|max:255',
            'item_name'=>'required|string|max:255|different:category',
            'description'=>'required|string|max:1000',
            'category'=>'required|string|max:50',
            'status'=>'required|in:lost,found',
            'date_found'=>'nullable|date',
            'image'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $imagePath = null;

        if($request->hasFile('image')){
            $imagePath = $request->file('image')
                ->store('images','public');
        }

        Item::create([
            'reporter_name'=>$request->reporter_name,
            'item_name'=>$request->item_name,
            'description'=>$request->description,
            'category'=>$request->category,
            'status'=>$request->status,
            'date_found'=>$request->date_found,
            'image'=>$imagePath,
            'reported_by'=>Auth::id()
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success','Item added successfully!');
    }

    /* ================= REPORTED ITEMS ================= */

    public function reportedItems(Request $request)
    {
        $search = $request->query('search');
        
        $items = Item::when($search, function($query) use ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('item_name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%');
            });
        })->latest()->get();

        return view('admin.reported',[
            'items'=>$items,
            'categories'=>$this->categories
        ]);
    }



    /* ================= EDIT ITEM ================= */

    public function edit($id)
    {
        $item = Item::findOrFail($id);

        return view('admin.edit',[
            'item'=>$item,
            'categories'=>$this->categories
        ]);
    }

    /* ================= UPDATE ITEM ================= */

    public function update(Request $request,$id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'item_name'=>'required|string|max:255|different:category',
            'description'=>'nullable|string|max:1000',
            'category'=>'required|string|max:50',
            'status'=>'required|in:lost,found',
            'image'=>'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $data = $request->only([
            'item_name',
            'description',
            'category',
            'status'
        ]);

        /* IMAGE UPDATE */

        if($request->hasFile('image')){

            if($item->image){
                Storage::disk('public')->delete($item->image);
            }

            $data['image'] = $request->file('image')
                ->store('images','public');
        }

        $item->update($data);

        return redirect()->route('admin.reported')
            ->with('success','Item updated successfully!');
    }

    /* ================= USER CLAIM PAGE ================= */

    public function userClaim(Request $request)
    {
        $category = $request->query('search_category', 'all');
        $search = $request->query('search');

        $items = Item::with(['reporter', 'claimer'])
            ->where('status', 'found')
            ->when(in_array($category, $this->categories), function($query) use ($category) {
                return $query->where('category', $category);
            })
            ->when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('item_name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('category', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->get();

        return view('user.claim', [
            'items' => $items,
            'categories' => $this->categories,
            'search_category' => $category,
            'search' => $search
        ]);
    }

    /* ================= DELETE ITEM ================= */

    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        if($item->image){
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->back()
            ->with('success','Item deleted successfully!');
    }

    /* ================= DELETE ALL ITEMS ================= */

    public function destroyAll(Request $request)
    {
        $items = Item::all();

        foreach ($items as $item) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
        }

        Item::query()->delete();

        return redirect()->route('admin.reported')
            ->with('success', 'All reported items have been deleted successfully.');
    }
}

