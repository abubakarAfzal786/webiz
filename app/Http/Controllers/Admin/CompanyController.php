<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CompanyDataTable;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ImageUploadHelper;
use App\Http\Requests\StoreCompanyRequest;
use App\Models\Company;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    use ImageUploadHelper;

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(CompanyDataTable $dataTable)
    {
        return $dataTable->render('admin.companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.companies.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompanyRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCompanyRequest $request)
    {
        $data = $request->except('_token');
        if($request->expiration_date){
            $offsetStart = Carbon::createFromFormat(Company::DATE_TIME_LOCAL, $request->get('expiration_date'), 'Asia/Jerusalem')->offsetHours;
            $start_date = Carbon::createFromFormat(Company::DATE_TIME_LOCAL, $request->get('expiration_date'))->subHours($offsetStart);
            $data['expiration_date'] = $start_date;
        }
        $company = Company::query()->create($data);
        make_transaction(null, null, null, null, $request->get('balance'), Transaction::TYPE_CREDIT, $company->id);

        $logo = $request->file('logo');
        if ($logo) {
            $path = $this->uploadImage($logo);
            if ($path) {
                $company->logo()->create([
                    'path' => $path,
                    'size' => $logo->getSize(),
                    'main' => true,
                    'is_logo' => true
                ]);
            }
        }

        return redirect()->route('admin.companies.index')->with([
            'message' => __('Company successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return Application|Factory|View
     */
    public function edit(Company $company)
    {
        return view('admin.companies.form', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCompanyRequest $request
     * @param Company $company
     * @return RedirectResponse
     */
    public function update(StoreCompanyRequest $request, Company $company)
    {
        $oldBalance = $company->balance;

        $data = $request->except('_token', '_method');
        if($request->expiration_date){
            $offsetStart = Carbon::createFromFormat(Company::DATE_TIME_LOCAL, $request->get('expiration_date'), 'Asia/Jerusalem')->offsetHours;
            $start_date = Carbon::createFromFormat(Company::DATE_TIME_LOCAL, $request->get('expiration_date'))->subHours($offsetStart);
            $data['expiration_date'] = $start_date;
        }
        $company->update($data);

        make_transaction(null, null, null, null, ($request->get('balance') - $oldBalance), Transaction::TYPE_CREDIT, $company->id);

        $logo = $request->file('logo');
        if ($logo) {
            $path = $this->uploadImage($logo);
            if ($path) {
                $company->logo()->delete();
                $company->logo()->create([
                    'path' => $path,
                    'size' => $logo->getSize(),
                    'main' => true,
                    'is_logo' => true
                ]);
            }
        }

        return redirect()->route('admin.companies.index')->with([
            'message' => __('Company successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return JsonResponse
     */
    public function destroy(Company $company)
    {
        try {
            $company->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
