<?php

namespace App\Observers;

use App\Mail\MemberRegistered;
use App\Models\Member;
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
        Mail::to('app@31floor-mail.kala-crm.co.il')->queue(new MemberRegistered($member));
    }

    /**
     * Handle the member "updated" event.
     *
     * @param Member $member
     * @return void
     */
    public function updated(Member $member)
    {
        //
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
