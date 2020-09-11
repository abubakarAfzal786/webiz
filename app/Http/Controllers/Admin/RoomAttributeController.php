<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoomAttributeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomAttributeRequest;
use App\Models\RoomAttribute;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RoomAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(RoomAttributeDataTable $dataTable)
    {
        return $dataTable->render('admin.room-attribute.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.room-attribute.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoomAttributeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRoomAttributeRequest $request)
    {
        RoomAttribute::query()->create($request->except('_token'));

        return redirect()->route('admin.room-attribute.index')->with([
            'message' => __('Room Attribute successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RoomAttribute $roomAttribute
     * @return Factory|View
     */
    public function edit(RoomAttribute $roomAttribute)
    {
        return view('admin.room-attribute.form', compact('roomAttribute'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRoomAttributeRequest $request
     * @param RoomAttribute $roomAttribute
     * @return RedirectResponse
     */
    public function update(StoreRoomAttributeRequest $request, RoomAttribute $roomAttribute)
    {
        $roomAttribute->update($request->except('_token', '_method'));

        return redirect()->route('admin.room-attribute.index')->with([
            'message' => __('Room Attribute successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RoomAttribute $roomAttribute
     * @return JsonResponse
     */
    public function destroy(RoomAttribute $roomAttribute)
    {
        try {
            $roomAttribute->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
