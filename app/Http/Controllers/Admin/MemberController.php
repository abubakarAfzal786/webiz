<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MembersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ImageUploadHelper;
use App\Http\Requests\StoreMemberRequest;
use App\Models\Company;
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
use Illuminate\Support\Facades\Log;
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

        if ($request->ajax()) return $dataTable->ajax();
        if ($request->get('action') == 'excel') return $dataTable->render('admin.members.test');

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
        $companies = Company::query()->pluck('name', 'id');
        $member = Member::query()->withoutGlobalScopes()->findOrFail($id);
        return view('admin.members.profile', compact('member', 'companies'));
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
                try {
                    $member->notify(new MemberResetPassword($token));
                } catch (Exception $exception) {
                    Log::channel('mail')->error($exception);
                    return response()->json(['success' => false]);
                }
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
        return abort(404);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse|void
     */
    public function addCredits($id, Request $request)
    {
        if ($request->ajax()) {
            /** @var Member $member */
            $member = Member::query()->withoutGlobalScopes()->findOrFail($id);
            $credits = $request->get('credits');
            if ($member && ($credits > 0)) {
                $credits = (float)$request->get('credits');
                $member->update(['balance' => $member->balance + $credits]);
                $memberUpdated = Member::query()->select('id', 'company_id')->find($id);
                return response()->json(['success' => true, 'balance' => $memberUpdated->balance]);
            } else {
                return response()->json(['success' => false]);
            }
        }
        return abort(404);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse|void
     */
    public function changeStatus($id, Request $request)
    {
        if ($request->ajax()) {
            /** @var Member $member */
            $member = Member::query()->withoutGlobalScopes()->findOrFail($id);
            if ($member) {
                $status = (bool)$request->get('status');
                $member->update(['status' => $status]);
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }
        return abort(404);
    }
}
