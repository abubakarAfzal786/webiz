<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeviceTypeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceTypeRequest;
use App\Models\DeviceType;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DeviceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DeviceTypeDataTable $dataTable
     * @return Response
     */
    public function index(DeviceTypeDataTable $dataTable)
    {
        return $dataTable->render('admin.device-type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.device-type.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDeviceTypeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreDeviceTypeRequest $request)
    {
        DeviceType::query()->create($request->except('_token'));

        return redirect()->route('admin.device-type.index')->with([
            'message' => __('Device Type successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DeviceType $deviceType
     * @return Application|Factory|View
     */
    public function edit(DeviceType $deviceType)
    {
        return view('admin.device-type.form', compact('deviceType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreDeviceTypeRequest $request
     * @param DeviceType $deviceType
     * @return RedirectResponse
     */
    public function update(StoreDeviceTypeRequest $request, DeviceType $deviceType)
    {
        $deviceType->update($request->except('_token', '_method'));

        return redirect()->route('admin.device-type.index')->with([
            'message' => __('Device Type successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeviceType $deviceType
     * @return JsonResponse
     */
    public function destroy(DeviceType $deviceType)
    {
        try {
            $deviceType->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
