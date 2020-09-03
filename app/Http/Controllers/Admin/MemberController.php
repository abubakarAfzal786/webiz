<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MembersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Models\Member;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(MembersDataTable $dataTable)
    {
        return $dataTable->render('admin.members.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.members.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMemberRequest $request
     * @return RedirectResponse
     */
    public function store(StoreMemberRequest $request)
    {
        Member::query()->create($request->except('_token'));

        return redirect()->route('admin.members.index')->with([
            'message' => __('Member successfully created.'),
            'class' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Member $member
     * @return Factory|View
     */
    public function edit(Member $member)
    {
        return view('admin.members.form', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreMemberRequest $request
     * @param Member $member
     * @return RedirectResponse
     */
    public function update(StoreMemberRequest $request, Member $member)
    {
        $member->update($request->except('_token', '_method'));

        return redirect()->route('admin.members.index')->with([
            'message' => __('Member successfully updated.'),
            'class' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Member $member
     * @return JsonResponse
     */
    public function destroy(Member $member)
    {
        try {
            $member->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'fail'], 422);
        }
    }
}
