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
use App\Models\RoomAttribute;
use App\Models\Transaction;
use Carbon\Carbon;
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
        $roomAttributes = RoomAttribute::query()->get();

        return view('admin.bookings.form', compact('rooms', 'members', 'roomAttributes'));
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
        $offsetStart = Carbon::createFromFormat(Booking::DATE_TIME_LOCAL, $request->get('start_date'), 'Asia/Jerusalem')->offsetHours;
        $offsetEnd = Carbon::createFromFormat(Booking::DATE_TIME_LOCAL, $request->get('end_date'), 'Asia/Jerusalem')->offsetHours;

        $start_date = Carbon::createFromFormat(Booking::DATE_TIME_LOCAL, $request->get('start_date'))->subHours($offsetStart);
        $end_date = Carbon::createFromFormat(Booking::DATE_TIME_LOCAL, $request->get('end_date'))->subHours($offsetEnd);

        if (room_is_busy($room->id, $start_date, $end_date)) {
            return redirect()->back()->withInput()->with([
                'message' => __('Room is busy'),
                'class' => 'danger'
            ]);
        }

        $attributes = [];
        foreach ($request->get('quantity') as $id => $quantity) {
            $attributes[] = ['id' => $id, 'quantity' => $quantity];
        }
        $attributesToSync = get_attributes_to_sync($attributes);
        $price = calculate_room_price($attributesToSync, $room->price, $start_date, $end_date)['price'];

        /** @var Member $member */
        $member = Member::query()->findOrFail($request->get('member_id'));
        if (($member->balance < $price) || !$member->company_id) {
            return redirect()->back()->withInput()->with([
                'message' => __('Member has no enough balance to book this room'),
                'class' => 'danger'
            ]);
        }

        $request->merge([
            'price' => $price,
            'door_key' => generate_door_key(),
            'status' => Booking::STATUS_PENDING,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'company_id' => $member->company_id
        ]);

        try {
            /** @var Booking $booking */
            $booking = Booking::query()->create($request->except('_token'));
            $booking->room_attributes()->attach($attributesToSync);
            make_transaction($member->id, null, $room->id, $booking->id, $price, Transaction::TYPE_ROOM);
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->with([
                'message' => __('Something went wrong'),
                'class' => 'danger'
            ]);
        }

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
        $roomAttributes = RoomAttribute::query()->get();
        $bookingAttributes = $booking->room_attributes()->pluck('quantity', 'room_attributes.id');

        return view('admin.bookings.form', compact('rooms', 'members', 'booking', 'roomAttributes', 'bookingAttributes'));
    }

    public function bookingCalender(Request $request)
    {
        $date = $request->has('date') ? $request->date : Carbon::now();
        $search_date = Carbon::now()->addHours(5)->toDateString();
        if ($request->input('search_date')) {
            $search_date = $request->search_date;
        }
        $rooms = Room::get();
        return view('book-calender', compact('rooms', 'search_date'));
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
        /** @var Room $room */
        $room = Room::query()->findOrFail($request->get('room_id'));
        $offsetStart = Carbon::createFromFormat(Booking::DATE_TIME_LOCAL, $request->get('start_date'), 'Asia/Jerusalem')->offsetHours;
        $offsetEnd = Carbon::createFromFormat(Booking::DATE_TIME_LOCAL, $request->get('end_date'), 'Asia/Jerusalem')->offsetHours;

        $start_date = Carbon::createFromFormat(Booking::DATE_TIME_LOCAL, $request->get('start_date'))->subHours($offsetStart);
        $end_date = Carbon::createFromFormat(Booking::DATE_TIME_LOCAL, $request->get('end_date'))->subHours($offsetEnd);

        if (room_is_busy($room->id, $start_date, $end_date, $booking->id)) {
            return redirect()->back()->withInput()->with([
                'message' => __('Room is busy'),
                'class' => 'danger'
            ]);
        }

        //        TODO check
        //        if ($booking->status == Booking::STATUS_COMPLETED) {
        //            $now = Carbon::now();
        //            $start = Carbon::createFromFormat(Booking::DATE_TIME_LOCAL, $request->get('start_date'));
        //            $end = Carbon::createFromFormat(Booking::DATE_TIME_LOCAL, $request->get('end_date'));
        //
        //            if ($end->gt($now) && $start->lt($now)) {
        //                $request->merge(['status' => Booking::STATUS_ACTIVE]);
        //            }
        //
        //            if ($end->gt($now) && $start->gt($now)) {
        //                $request->merge(['status' => Booking::STATUS_PENDING]);
        //            }
        //        }

        $attributes = [];
        foreach ($request->get('quantity') as $id => $quantity) {
            $attributes[] = ['id' => $id, 'quantity' => $quantity];
        }
        $attributesToSync = get_attributes_to_sync($attributes);
        $newPrice = calculate_room_price($attributesToSync, $room->price, $start_date, $end_date)['price'];
        $priceDiff = $newPrice - $booking->price;

        /** @var Member $member */
        $member = Member::query()->findOrFail($request->get('member_id'));

        if ($member->balance < $priceDiff) {
            return redirect()->back()->withInput()->with([
                'message' => __('Member has no enough balance to book this room'),
                'class' => 'danger'
            ]);
        }

        $request->merge([
            'price' => $newPrice,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);

        try {
            $booking->update($request->except('_token', '_method'));
            $booking->room_attributes()->sync($attributesToSync);
            make_transaction($member->id, null, $room->id, $booking->id, $priceDiff, Transaction::TYPE_ROOM);
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->with([
                'message' => __('Something went wrong'),
                'class' => 'danger'
            ]);
        }

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
            make_transaction($booking->member_id, null, $booking->room_id, $booking->id, -$booking->price, Transaction::TYPE_ROOM);
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
            /** @var Booking $booking */
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
