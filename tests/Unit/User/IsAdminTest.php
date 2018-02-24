<?php

namespace Tests\Unit\User;

use App\Models\User;
use Tests\TestCase;

class IsAdminTest extends TestCase
{
    /**
     * @test
     */
    public function isAdmin()
    {
        $user = new User();

        $user->name = 'admin';

        $actual = $user->isAdmin();

        $expected = true;

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function notAdmin()
    {
        $user = new User();

        $user->name = 'user';

        $actual = $user->isAdmin();

        $expected = false;

        $this->assertEquals($expected, $actual);
    }
}
