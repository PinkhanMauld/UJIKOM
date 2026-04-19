<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lending;
use App\Models\Category;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index()
{
    
    $user = request()->user();

    $totalItems = Item::count();

    $activeLendings = Lending::whereNull('return_date')->count();

    $returnedLendings = Lending::whereNotNull('return_date')->count();

    $totalDamaged = Repair::sum('total');

    $latestLendings = Lending::with('details.item')
        ->latest()
        ->take(5)
        ->get();

    $latestRepairs = Repair::with('item')
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'user',
        'totalItems',
        'activeLendings',
        'returnedLendings',
        'totalDamaged',
        'latestLendings',
        'latestRepairs'
    ));
}
}