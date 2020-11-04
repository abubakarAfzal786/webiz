<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReviewsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Member;
use App\Models\Review;
use App\Models\Room;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param ReviewsDataTable $dataTable
     * @return Application|Factory|JsonResponse|Response|View
     */
    public function index(Request $request, ReviewsDataTable $dataTable)
    {
        /** @var Review|Collection $data */
        $data = Review::all();
        $reviews_count = $data->count();

        if ($request->ajax()) {
            return $dataTable->ajax();
        }

        return view('admin.reviews.test', compact('reviews_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $rooms = Room::query()->pluck('name', 'id');
        $members = Member::query()->pluck('name', 'id');

        return view('admin.reviews.form', compact('rooms', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReviewRequest $request
     * @return RedirectResponse
     */
    public function store(StoreReviewRequest $request)
    {
        Review::query()->create($request->except('_token'));

        return redirect()->route('admin.reviews.index')->with([
            'message' => __('Reviews successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Review $review
     * @return Factory|View
     */
    public function edit(Review $review)
    {
        $rooms = Room::query()->pluck('name', 'id');
        $members = Member::query()->pluck('name', 'id');

        return view('admin.reviews.form', compact('rooms', 'members', 'review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreReviewRequest $request
     * @param Review $review
     * @return RedirectResponse
     */
    public function update(StoreReviewRequest $request, Review $review)
    {
        $review->update($request->except('_token', '_method'));

        return redirect()->route('admin.reviews.index')->with([
            'message' => __('Reviews successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Review $review
     * @return JsonResponse
     */
    public function destroy(Review $review)
    {
        try {
            $review->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
