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
        $items = Item::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('categories', 'items'));
    }

    public function reported()
    {
        $items = Item::orderBy('created_at', 'desc')->get();
        return view('admin.reported', compact('items'));
    }

    public function found()
    {
        $items = Item::where('status', 'found')->orderBy('created_at', 'desc')->get();
        return view('admin.found', compact('items'));
    }

    public function lost()
    {
        $items = Item::where('status', 'lost')->orderBy('created_at', 'desc')->get();
        return view('admin.lost', compact('items'));
    }

    public function claim()
    {
        $items = Item::where('status', 'found')->orderBy('created_at', 'desc')->get();
        return view('admin.claim', compact('items'));
    }
}

