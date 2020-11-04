<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FaqCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFaqCategoryRequest;
use App\Models\FaqCategory;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param FaqCategoryDataTable $dataTable
     * @return Response
     */
    public function index(FaqCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.faq-category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.faq-category.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFaqCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreFaqCategoryRequest $request)
    {
        FaqCategory::query()->create($request->except('_token'));

        return redirect()->route('admin.faq-category.index')->with([
            'message' => __('FAQ Category successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FaqCategory $faqCategory
     * @return Factory|View
     */
    public function edit(FaqCategory $faqCategory)
    {
        return view('admin.faq-category.form', compact('faqCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreFaqCategoryRequest $request
     * @param FaqCategory $faqCategory
     * @return RedirectResponse
     */
    public function update(StoreFaqCategoryRequest $request, FaqCategory $faqCategory)
    {
        $faqCategory->update($request->except('_token', '_method'));

        return redirect()->route('admin.faq-category.index')->with([
            'message' => __('FAQ Category successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FaqCategory $faqCategory
     * @return JsonResponse
     */
    public function destroy(FaqCategory $faqCategory)
    {
        try {
            $faqCategory->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
