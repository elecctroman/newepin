<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user()->load('orders');

        return view('pages.dashboard.index', compact('user'));
    }

    public function orders(): View
    {
        $orders = Auth::user()->orders()->with('product', 'epins')->latest()->paginate();

        return view('pages.dashboard.orders', compact('orders'));
    }

    public function wallet(): View
    {
        $transactions = Auth::user()->walletTransactions()->latest()->paginate();

        return view('pages.dashboard.wallet', compact('transactions'));
    }
}
