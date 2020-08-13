<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FaqDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFaqRequest;
use App\Models\Faq;
use App\Models\FaqCategory;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(FaqDataTable $dataTable)
    {
        return $dataTable->render('admin.faq.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $categories = FaqCategory::query()->get()->pluck('name', 'id');
        return view('admin.faq.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFaqRequest $request
     * @return RedirectResponse
     */
    public function store(StoreFaqRequest $request)
    {
        Faq::query()->create($request->except('_token'));

        return redirect()->route('admin.faq.index')->with([
            'message' => __('FAQ successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Faq $faq
     * @return Factory|View
     */
    public function edit(Faq $faq)
    {
        $categories = FaqCategory::query()->get()->pluck('name', 'id');
        return view('admin.faq.form', compact('faq', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreFaqRequest $request
     * @param Faq $faq
     * @return RedirectResponse
     */
    public function update(StoreFaqRequest $request, Faq $faq)
    {
        $faq->update($request->except('_token', '_method'));

        return redirect()->route('admin.faq.index')->with([
            'message' => __('FAQ successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Faq $faq
     * @return JsonResponse
     */
    public function destroy(Faq $faq)
    {
        try {
            $faq->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
