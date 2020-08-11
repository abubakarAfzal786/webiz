<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\TwilioHelper;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use TwilioHelper;

    public function index()
    {
        if ($this->sendVerificationSMS('+37455555555')) {
            dd('success');
        } else {
            dd('fail');
        }
    }
}
