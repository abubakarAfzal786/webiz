<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BookingsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Helpers\FCMHelper;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Member;
use App\Models\PushNotification;
use App\Models\Room;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookingController extends Controller
{
    use FCMHelper;

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

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse|void
     */
    public function end(Request $request, $id)
    {
        if ($request->ajax()) {
            $booking = Booking::query()->find($id);
            if (!$booking) return response()->json(['success' => false, 'message' => 'Booking not found'], 500);

            $booking->update(['status' => Booking::STATUS_COMPLETED]);
            try {
                DB::beginTransaction();

                $data = [
                    'title' => 'הזמנתך הסתיימה בהצלחה', // Booking completed
                    'body' => 'איך היה לך? לחץ כאן בשביל לספר לנו.', // How was it? Click here to tell us.
                ];

                $extraData = [
                    'id' => $booking->id,
                    'type' => 'bookings',
                    'action' => 'completed',
                ];

                PushNotification::query()->create([
                    'title' => $data['title'],
                    'body' => $data['body'],
                    'member_id' => $booking->member_id,
                    'seen' => false,
                    'additional' => json_encode($extraData),
                ]);

                if ($this->sendPush($booking->member->mobile_token, $data, $extraData)) {
                    DB::commit();
                } else {
                    DB::rollBack();
                    return response()->json(['success' => true, 'message' => 'Booking completed, but push NOT sent'], 200);
                }
            } catch (Exception $exception) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Something went wrong'], 500);
            }

            return response()->json(['success' => true, 'message' => 'Booking completed. Push sent'], 200);
        }
        return abort(404);
    }
}
