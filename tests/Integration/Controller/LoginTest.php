<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\GraphQL\Base\Tests\Integration\Controller;

use OxidEsales\GraphQL\Base\Tests\Integration\TestCase;

class LoginTest extends TestCase
{
    public function testLoginWithMissingCredentials()
    {
        $result = $this->query('query { token }');

        $this->assertEquals(
            400,
            $result['status']
        );
    }

    public function testLoginWithWrongCredentials()
    {
        $result = $this->query('query { token (username: "foo", password: "bar") }');

        $this->assertEquals(
            401,
            $result['status']
        );
    }

    public function testLoginWithValidCredentials()
    {
        $result = $this->query('query { token (username: "admin", password: "admin") }');

        $this->assertEquals(
            200,
            $result['status']
        );
    }

    public function testLoginWithValidCredentialsInVariables()
    {
        $result = $this->query(
            'query ($username: String!, $password: String!) { token (username: $username, password: $password) }',
            [
                'username' => 'admin',
                'password' => 'admin'
            ]
        );

        $this->assertEquals(
            200,
            $result['status']
        );
    }
}
