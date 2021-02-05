<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PackageDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePackageRequest;
use App\Models\Package;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(PackageDataTable $dataTable)
    {
        return $dataTable->render('admin.packages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|void
     */
    public function create()
    {
        return view('admin.packages.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePackageRequest $request
     * @return RedirectResponse
     */
    public function store(StorePackageRequest $request)
    {
        Package::query()->create($request->except('_token'));

        return redirect()->route('admin.packages.index')->with([
            'message' => __('Package successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Package $package
     * @return Application|Factory|View|void
     */
    public function edit(Package $package)
    {
        return view('admin.packages.form', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePackageRequest $request
     * @param Package $package
     * @return RedirectResponse
     */
    public function update(StorePackageRequest $request, Package $package)
    {
        $package->update($request->except('_token', '_method'));

        return redirect()->route('admin.packages.index')->with([
            'message' => __('Package successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Package $package
     * @return JsonResponse
     */
    public function destroy(Package $package)
    {
        try {
            $package->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
