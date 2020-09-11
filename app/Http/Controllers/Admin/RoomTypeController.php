<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoomTypeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomTypeRequest;
use App\Models\RoomType;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(RoomTypeDataTable $dataTable)
    {
        return $dataTable->render('admin.room-type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.room-type.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoomTypeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRoomTypeRequest $request)
    {
        Roomtype::query()->create($request->except('_token'));

        return redirect()->route('admin.room-type.index')->with([
            'message' => __('Room Type successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RoomType $roomType
     * @return Factory|View
     */
    public function edit(RoomType $roomType)
    {
        return view('admin.room-type.form', compact('roomType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRoomTypeRequest $request
     * @param RoomType $roomType
     * @return RedirectResponse
     */
    public function update(StoreRoomTypeRequest $request, RoomType $roomType)
    {
        $roomType->update($request->except('_token', '_method'));

        return redirect()->route('admin.room-type.index')->with([
            'message' => __('Room Type successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RoomType $roomType
     * @return JsonResponse
     */
    public function destroy(RoomType $roomType)
    {
        try {
            $roomType->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
