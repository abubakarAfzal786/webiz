<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Member;
use App\Models\Review;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * @return View
     */
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
            ->select(['type', 'credit', 'created_at'])
            ->where('type', Transaction::TYPE_ROOM)
            ->where('created_at', '>', $now->subMonth())
            ->sum('credit');

        $total_used = Transaction::query()
            ->select(['type', 'credit'])
            ->where('type', Transaction::TYPE_ROOM)
            ->sum('credit');

        $overall_credits = $current_credits + $total_used;

        return view('home', compact('new_reviews', 'today_transactions_count', 'occupancy', 'current_credits', 'used_credits', 'overall_credits'));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function statistics(Request $request)
    {
        $month = $request->get('month');
        $start = Carbon::now()->subMonth();
        $end = Carbon::now();

        if ($month) {
            $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $end = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
        }

        $current_credits = Company::query()->sum('balance');

        $total_used = Transaction::query()
            ->select(['type', 'credit'])
            ->where('type', Transaction::TYPE_ROOM)
            ->sum('credit');

        $overall_credits = $current_credits + $total_used;

        $used_credits = Transaction::query()
            ->select(['type', 'credit', 'created_at'])
            ->where('type', Transaction::TYPE_ROOM)
            ->whereBetween('created_at', [$start, $end])
            ->sum('credit');

        $bought_credits = Transaction::query()
            ->select(['type', 'credit', 'created_at'])
            ->where('type', Transaction::TYPE_CREDIT)
            ->whereBetween('created_at', [$start, $end])
            ->where('credit', '<>', 0)
            ->orderBy('created_at', 'ASC')
            ->pluck('credit', 'created_at')
            ->toArray();

        $data = implode(', ', array_values($bought_credits));

        $labels = [];
        foreach (array_keys($bought_credits) as $date) {
            $labels[] = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d M');
        }
        $labels = '"' . implode('", "', $labels) . '"';

        return view('admin.transactions.statistics', compact(
            'used_credits',
            'current_credits',
            'overall_credits',
            'data',
            'labels'
        ));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function customerService(Request $request)
    {
        $justJoined = Member::query()
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])
            ->orderBy('created_at', 'DESC')
            ->paginate(10, ['*'], 'justJoined');

        $firstOrders = Member::query()
            ->whereHas('bookings', function (Builder $q) {
                $q->where('start_date', '>', Carbon::now())->where('status', Booking::STATUS_PENDING);
            })
            ->whereDoesntHave('bookings', function (Builder $q) {
                $q->where('start_date', '<', Carbon::now());
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10, ['*'], 'firstOrders');

        return view('admin.members.customer-service', compact(
            'justJoined',
            'firstOrders'
        ));
    }
}
