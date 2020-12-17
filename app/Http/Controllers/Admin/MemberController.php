<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MembersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ImageUploadHelper;
use App\Http\Requests\StoreMemberRequest;
use App\Models\Member;
use App\Notifications\MemberResetPassword;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MemberController extends Controller
{
    use ImageUploadHelper;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param MembersDataTable $dataTable
     * @return Application|Factory|JsonResponse|Response|View
     */
    public function index(Request $request, MembersDataTable $dataTable)
    {
        $members_count = Member::query()->withoutGlobalScopes()->count();

        if ($request->ajax()) {
            return $dataTable->ajax();
        }

        return view('admin.members.test', compact('members_count'));
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
        $request->merge(['user_id' => Auth::id()]);
        if (isset($request['password'])) $request['password'] = bcrypt($request['password']);
        /** @var Member $member */
        $member = Member::query()->create($request->except('_token'));

        $avatar = $request->file('avatar');
        if ($avatar) {
            $path = $this->uploadImage($avatar);
            if ($path) {
                $member->avatar()->create([
                    'path' => $path,
                    'size' => $avatar->getSize(),
                    'main' => true,
                ]);
            }
        }

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
        if (isset($request['password'])) $request['password'] = bcrypt($request['password']);
        $member->update($request->except('_token', '_method'));

        $avatar = $request->file('avatar');
        if ($avatar) {
            $path = $this->uploadImage($avatar);
            if ($path) {
                $member->avatar()->delete();
                $member->avatar()->create([
                    'path' => $path,
                    'size' => $avatar->getSize(),
                    'main' => true,
                ]);
            }
        }

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

    /**
     * @param int $id
     * @return Application|Factory|View
     */
    public function profile($id)
    {
        $member = Member::query()->withoutGlobalScopes()->findOrFail($id);
        return view('admin.members.profile', compact('member'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse|void
     */
    public function sendResetLink($id, Request $request)
    {
        if ($request->ajax()) {
            /** @var Member $member */
            $member = Member::query()->withoutGlobalScopes()->findOrFail($id);
            if ($member) {
                $token = generate_pass_reset_token();
                $member->update(['reset_token' => $token]);
                $member->notify(new MemberResetPassword($token));
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
        return abort(404);
    }
}
