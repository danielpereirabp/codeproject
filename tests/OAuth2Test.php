<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OAuth2Test extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->post('/oauth/access_token', [
                'username' => 'danielpereirabp@gmail.com',
                'password' => '123456',
                'client_id' => 'appid1',
                'client_secret' => 'secret',
                'grant_type' => 'password',
            ])
            ->seeJson([
                'token_type' => 'Bearer'
            ]);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testFailLogin()
    {
        $this->post('/oauth/access_token', [
                'username' => 'danielpereirabp@gmail.com',
                'password' => '1234567',
                'client_id' => 'appid1',
                'client_secret' => 'secret',
                'grant_type' => 'password',
            ])
            ->seeJson([
                'error' => 'invalid_credentials'
            ]);
    }
}
