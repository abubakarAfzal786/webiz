<?php

namespace App\GraphQL\Queries;

use App\Http\Helpers\TwilioHelper;

class SendVerification
{
    use TwilioHelper;

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return bool
     */
    public function __invoke($_, array $args)
    {
        return $this->sendVerificationSMS($args['phone']);
    }
}
