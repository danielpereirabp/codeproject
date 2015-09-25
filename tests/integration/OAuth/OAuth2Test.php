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
    public function test_success_authentication()
    {
        DB::insert('insert into oauth_clients (id, secret, name) values (?, ?, ?)', ['appid1', 'secret', 'APP AngularJS']);

        factory(CodeProject\Entities\User::class)->create([
            'name' => 'Daniel Pereira',
            'email' => 'danielpereirabp@gmail.com',
            'password' => bcrypt(123456),
            'remember_token' => str_random(10)
        ]);

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
    public function test_invalid_credentials()
    {
        DB::insert('insert into oauth_clients (id, secret, name) values (?, ?, ?)', ['appid1', 'secret', 'APP AngularJS']);

        factory(CodeProject\Entities\User::class)->create([
            'name' => 'Daniel Pereira',
            'email' => 'danielpereirabp@gmail.com',
            'password' => bcrypt(123456),
            'remember_token' => str_random(10)
        ]);

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

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function invalid_client()
    {
        $this->post('/oauth/access_token', [
                'username' => 'danielpereirabp@gmail.com',
                'password' => '1234567',
                'client_id' => 'appid1',
                'client_secret' => 'secret',
                'grant_type' => 'password',
            ])
            ->seeJson([
                'error' => '"invalid_client"'
            ]);
    }
}
