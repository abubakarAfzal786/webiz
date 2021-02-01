<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeviceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceRequest;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Room;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $room_id
     * @param DeviceDataTable $dataTable
     * @return Response
     */
    public function index($room_id, DeviceDataTable $dataTable)
    {
        $room = Room::query()->withoutGlobalScopes()->findOrFail($room_id);
        return $dataTable->with('room_id', $room_id)->render('admin.device.index', compact('room'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $room_id
     * @return Application|Factory|Response|View
     */
    public function create($room_id)
    {
        $room = Room::query()->withoutGlobalScopes()->findOrFail($room_id);
        $types = DeviceType::query()->pluck('name', 'id');
        return view('admin.device.form', compact('room', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $room_id
     * @param StoreDeviceRequest $request
     * @return RedirectResponse
     */
    public function store($room_id, StoreDeviceRequest $request)
    {
        /** @var Room $room */
        $room = Room::query()->withoutGlobalScopes()->findOrFail($room_id);
        $room->devices()->create($request->except('_token'));

        return redirect()->route('admin.devices.index', [$room_id])->with([
            'message' => __('Device successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $room_id
     * @param Device $device
     * @return Application|Factory|Response|View
     */
    public function edit($room_id, Device $device)
    {
        /** @var Room $room */
        $room = Room::query()->withoutGlobalScopes()->findOrFail($room_id);
        $device = $room->devices()->findOrFail($device->id);
        $types = DeviceType::query()->pluck('name', 'id');

        return view('admin.device.form', compact('room', 'types', 'device'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $room_id
     * @param StoreDeviceRequest $request
     * @param Device $device
     * @return RedirectResponse
     */
    public function update($room_id, StoreDeviceRequest $request, Device $device)
    {
        /** @var Room $room */
        $room = Room::query()->withoutGlobalScopes()->findOrFail($room_id);
        $room->devices()->findOrFail($device->id)->update($request->except('_token', '_method'));

        return redirect()->route('admin.devices.index', [$room_id])->with([
            'message' => __('Device successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $room_id
     * @param Device $device
     * @return JsonResponse
     */
    public function destroy($room_id, Device $device)
    {
        try {
            /** @var Room $room */
            $room = Room::query()->withoutGlobalScopes()->findOrFail($room_id);
            $room->devices()->findOrFail($device->id)->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
