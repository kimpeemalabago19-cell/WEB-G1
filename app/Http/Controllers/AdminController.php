<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->role !== 'admin') {
                return redirect()->route('login')->with('error', 'Access denied. Admin only.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $categories = \App\Models\Item::ALLOWED_CATEGORIES;
        $search = request('search');

        $itemsQuery = Item::query()
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('item_name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('category', 'like', '%' . $search . '%');
                });
            });

        $items = (clone $itemsQuery)->latest()->get();

        $lostItems = (clone $itemsQuery)
            ->where('status','lost')
            ->latest()
            ->take(6)
            ->get();

        $foundItems = (clone $itemsQuery)
            ->where('status','found')
            ->whereNull('claimed_by')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'categories',
            'items',
            'lostItems',
            'foundItems'
        ));
    }

    public function reported()
    {
        $items = Item::orderBy('created_at', 'desc')->get();
        return view('admin.reported', compact('items'));
    }

    public function found()
    {
        $search = request('search');
        $items = Item::where('status', 'found')->when($search, function($query) use ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('item_name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%');
            });
        })->orderBy('created_at', 'desc')->get();
        return view('admin.found', compact('items'));
    }

    public function lost()
    {
        $search = request('search');
        $items = Item::where('status', 'lost')->when($search, function($query) use ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('item_name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%');
            });
        })->orderBy('created_at', 'desc')->get();
        return view('admin.lost', compact('items'));
    }

    public function claim()
    {
        $search = request('search');
        $items = Item::whereIn('status', ['found', 'claimed'])
            ->when($search, function($query) use ($search) {
                return $query->where(function($q) use ($search) {
                    $q->where('item_name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhere('category', 'like', '%' . $search . '%');
                });
            })
            ->with('claimer')
            ->orderByRaw("CASE WHEN status = 'claimed' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.claim', compact('items'));
    }
}

