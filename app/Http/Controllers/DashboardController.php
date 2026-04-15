<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lending;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('dashboard', [
                'role' => 'admin',
                'totalItems' => Item::count(),
                'totalCategories' => Category::count(),
                'totalUsers' => User::count(),
                'totalLendings' => Lending::count(),
            ]);
        }

        return view('dashboard', [
            'role' => 'operator',
            'myLendings' => Lending::where('edited_by', $user->id)->count(),
            'todayLendings' => Lending::whereDate('date', today())->count(),
            'totalItems' => Item::count(),
        ]);
    }
}