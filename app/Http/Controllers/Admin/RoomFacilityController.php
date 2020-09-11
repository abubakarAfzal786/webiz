<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoomFacilityDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomFacilityRequest;
use App\Models\RoomFacility;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RoomFacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(RoomFacilityDataTable $dataTable)
    {
        return $dataTable->render('admin.room-facility.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.room-facility.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoomFacilityRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRoomFacilityRequest $request)
    {
        RoomFacility::query()->create($request->except('_token'));

        return redirect()->route('admin.room-facility.index')->with([
            'message' => __('Room Facility successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RoomFacility $roomFacility
     * @return Factory|View
     */
    public function edit(RoomFacility $roomFacility)
    {
        return view('admin.room-facility.form', compact('roomFacility'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRoomFacilityRequest $request
     * @param RoomFacility $roomFacility
     * @return RedirectResponse
     */
    public function update(StoreRoomFacilityRequest $request, RoomFacility $roomFacility)
    {
        $roomFacility->update($request->except('_token', '_method'));

        return redirect()->route('admin.room-facility.index')->with([
            'message' => __('Room Facility successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RoomFacility $roomFacility
     * @return JsonResponse
     */
    public function destroy(RoomFacility $roomFacility)
    {
        try {
            $roomFacility->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
