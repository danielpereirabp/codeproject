<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OAuth2Test extends TestCase
{
    public function testShouldReturnSuccessAuthentication()
    {
        // DB::insert('insert into oauth_clients (id, secret, name) values (?, ?, ?)', ['appid1', 'secret', 'APP AngularJS']);
        DB::table('oauth_clients')->insert([
            'id' => 'appid1',
            'secret' => 'secret',
            'name' => 'APP AngularJS'
        ]);

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

    public function testShouldReturnInvalidCredentials()
    {
        // DB::insert('insert into oauth_clients (id, secret, name) values (?, ?, ?)', ['appid1', 'secret', 'APP AngularJS']);
        DB::table('oauth_clients')->insert([
            'id' => 'appid1',
            'secret' => 'secret',
            'name' => 'APP AngularJS'
        ]);

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
