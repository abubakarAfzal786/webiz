<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BookingsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Member;
use App\Models\Room;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param BookingsDataTable $dataTable
     * @return Response
     */
    public function index(BookingsDataTable $dataTable)
    {
        return $dataTable->render('admin.bookings.index');
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

        return view('admin.bookings.form', compact('rooms', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBookingRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBookingRequest $request)
    {
        /** @var Room $room */
        $room = Room::query()->findOrFail($request->get('room_id'));
        $request->merge(['price' => $room->price]);
        Booking::query()->create($request->except('_token'));

        return redirect()->route('admin.bookings.index')->with([
            'message' => __('Booking successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Booking $booking
     * @return Factory|View
     */
    public function edit(Booking $booking)
    {
        $rooms = Room::query()->pluck('name', 'id');
        $members = Member::query()->pluck('name', 'id');

        return view('admin.bookings.form', compact('rooms', 'members', 'booking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreBookingRequest $request
     * @param Booking $booking
     * @return RedirectResponse
     */
    public function update(StoreBookingRequest $request, Booking $booking)
    {
        $booking->update($request->except('_token', '_method'));

        return redirect()->route('admin.bookings.index')->with([
            'message' => __('Booking successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Booking $booking
     * @return JsonResponse
     */
    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
