<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectControllerTest extends TestCase
{
    protected $token;

    public function setUp()
    {
        parent::setUp();

        $response = $this->call(
            'POST',
            '/oauth/access_token',
            [
                'username' => 'danielpereirabp@gmail.com',
                'password' => '123456',
                'client_id' => 'appid1',
                'client_secret' => 'secret',
                'grant_type' => 'password'
            ]
        );

        $this->token = $response->getData()->access_token;
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndexWithoutMiddleware()
    {
        $this->withoutMiddleware()->get('/project')
            ->seeJson([
                'data' => []
            ]);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndexWithoutToken()
    {
        $this->get('/project')
            ->seeJson([
                'error' => 'invalid_request'
            ]);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndexWithToken()
    {
        $this->get('/project', ['HTTP_Authorization' => 'Bearer ' . $this->token])
            ->seeJson([
                'data' => []
            ]);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndexWithIncorrectToken()
    {
        $this->get('/project', ['HTTP_Authorization' => 'Bearer IncorrectToken'])
            ->seeJson([
                'error' => 'access_denied'
            ]);
    }

    public function testStoreWithoutToken()
    {
        $data = [
            'owner_id' => 1,
            'client_id' => 10,
            'name' => 'Projeto Teste',
            'progress' => 0,
            'status' => 3,
            'due_date' => '2015-10-20'
        ];

        //dd($this->call('PUT', '/project/11', $data)->getData());

        $this->put('/project/11', $data)
            ->seeJson([
                'error' => 'invalid_request'
            ]);
    }

    public function testStoreWithToken()
    {
        $data = [
            'owner_id' => 1,
            'client_id' => 10,
            'name' => 'Projeto Teste',
            'progress' => 0,
            'status' => 3,
            'due_date' => '2015-10-20'
        ];

        $this->put('/project/11', $data, ['HTTP_Authorization' => 'Bearer ' . $this->token])
            ->seeJson([
                'error' => 'Access Forbidden'
            ]);
    }
}
