<?php

namespace App\GraphQL\Scalars;

use Carbon\Carbon;
use Nuwave\Lighthouse\Schema\Types\Scalars\DateScalar;

class DateTimeOrDate extends DateScalar
{
    /**
     * @inheritDoc
     */
    protected function format(Carbon $carbon): string
    {
        return $carbon->toDateTimeString();
    }

    /**
     * @inheritDoc
     */
    protected function parse($value): Carbon
    {
        if (Carbon::hasFormat($value, 'Y-m-d')) {
            return Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
        }

        return Carbon::createFromFormat(Carbon::DEFAULT_TO_STRING_FORMAT, $value);
    }
}
