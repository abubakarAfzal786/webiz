<?php

namespace App\GraphQL\Directives;

use Illuminate\Auth\AuthenticationException;
use Nuwave\Lighthouse\Schema\Directives\GuardDirective;

class GuardTabletDirective extends GuardDirective
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'SDL'
"""
Run authentication through one or more guards.
This is run per field and may allow unauthenticated
users to still receive partial results.
"""
directive @guardTablet(
  """
  Specify which guards to use, e.g. ["api"].
  When not defined, the default from `lighthouse.php` is used.
  """
  with: [String!]
) on FIELD_DEFINITION | OBJECT
SDL;
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param string[] $guards
     *
     * @throws AuthenticationException
     */
    protected function authenticate(array $guards): void
    {
        if (empty($guards)) {
            $guards = ['api-tablet'];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $this->auth->shouldUse($guard);

                return;
            }
        }

        $this->unauthenticated($guards);
    }
}
