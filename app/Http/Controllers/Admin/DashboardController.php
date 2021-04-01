<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Review;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $new_reviews = Review::query()->orderBy('created_at', 'DESC')->limit(5)->get();
        $today_transactions_count = Transaction::query()->whereDate('created_at', Carbon::today())->count();

        $now = Carbon::now();
        $occupancy = Booking::query()
            ->whereNotIn('status', [Booking::STATUS_CANCELED])
            ->where('start_date', '<=', $now)
            ->where(function ($q) use ($now) {
                return $q->where('end_date', '>=', $now)->orWhere('status', Booking::STATUS_EXTENDED);
            })
            ->count();

        $current_credits = Company::query()->sum('balance');
        $used_credits = Transaction::query()
            ->where('type', Transaction::TYPE_ROOM)
            ->where('created_at', '>', $now->subMonth())
            ->sum('credit');
        $totalUsed = Transaction::query()->where('type', Transaction::TYPE_ROOM)->sum('credit');
        $overall_credits = $current_credits + $totalUsed;

        return view('home', compact('new_reviews', 'today_transactions_count', 'occupancy', 'current_credits', 'used_credits', 'overall_credits'));
    }
}
