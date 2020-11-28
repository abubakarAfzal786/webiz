<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $new_reviews = Review::query()->orderBy('created_at', 'DESC')->limit(5)->get();
        $today_transactions_count = Transaction::query()->whereDate('created_at', Carbon::today())->count();

        return view('home', compact('new_reviews', 'today_transactions_count'));
    }
}
