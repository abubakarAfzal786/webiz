<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SettingDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Models\Setting;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SettingDataTable $dataTable
     * @return Response
     */
    public function index(SettingDataTable $dataTable)
    {
        return $dataTable->render('admin.settings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('admin.settings.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSettingRequest $request
     * @return RedirectResponse
     */
    public function store(StoreSettingRequest $request)
    {
        Setting::query()->create($request->except('_token'));

        return redirect()->route('admin.settings.index')->with([
            'message' => __('Setting successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Setting $setting
     * @return Application|Factory|Response|View
     */
    public function edit(Setting $setting)
    {
        return view('admin.settings.form', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreSettingRequest $request
     * @param Setting $setting
     * @return RedirectResponse
     */
    public function update(StoreSettingRequest $request, Setting $setting)
    {
        $setting->update($request->except('_token', '_method'));

        return redirect()->route('admin.settings.index')->with([
            'message' => __('Setting successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Setting $setting
     * @return JsonResponse
     */
    public function destroy(Setting $setting)
    {
        try {
            $setting->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
