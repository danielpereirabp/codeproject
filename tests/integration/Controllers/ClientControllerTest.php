<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use Illuminate\Foundation\Testing\WithoutMiddleware;

class ClientControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
    * @var Faker
    */
    private $faker;

    public function setUp()
    {
        parent::setUp();
        
        $this->faker = Faker\Factory::create();
    }

    public function testShouldCreateOneClient()
    {
    	$data = [
            'name' => $this->faker->name,
            'responsible' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'obs' => $this->faker->sentence
        ];

        $this->post('client', $data)
            ->seeJson($data);

        $this->seeInDatabase('clients', $data);
    }
}