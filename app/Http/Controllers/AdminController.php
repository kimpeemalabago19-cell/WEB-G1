<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

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
        $categories = ['Clothing', 'Bags', 'Gadgets', 'Documents', 'Accessories', 'Others'];
        return view('admin.dashboard', compact('categories'));
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
}

