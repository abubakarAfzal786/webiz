<?php

namespace App\Observers;

use App\Jobs\SendMailToNewUser;
use App\Jobs\MemberRegisterationJob;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

class MemberObserver
{
    /**
     * Handle the member "created" event.
     *
     * @param Member $member
     * @return void
     */
    public function created(Member $member)
    {
        dispatch(new MemberRegisterationJob($member));
    }

    /**
     * Handle the member "updated" event.
     *
     * @param Member $member
     * @return void
     */
    public function updated(Member $member)
    {
        if($member->isDirty('phone'))
        {
          dispatch(new SendMailToNewUser($member));
        }
    }

    /**
     * Handle the member "deleted" event.
     *
     * @param Member $member
     * @return void
     */
    public function deleted(Member $member)
    {
        //
    }

    /**
     * Handle the member "restored" event.
     *
     * @param Member $member
     * @return void
     */
    public function restored(Member $member)
    {
        //
    }

    /**
     * Handle the member "force deleted" event.
     *
     * @param Member $member
     * @return void
     */
    public function forceDeleted(Member $member)
    {
        //
    }
}
