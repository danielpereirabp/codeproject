<?php

use CodeProject\Entities\Client;

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

    public function testShouldListAllClients()
    {
        $client1 = factory(Client::class)->create();
        $client2 = factory(Client::class)->create();
        $client3 = factory(Client::class)->create();

        $jsonResponse = $this->call('GET', 'client')->getContent();
        $responseData = json_decode($jsonResponse);

        $this->assertCount(3, $responseData->data);

        $this->seeInDatabase('clients', ['id' => $client1->id]);
        $this->seeInDatabase('clients', ['id' => $client2->id]);
        $this->seeInDatabase('clients', ['id' => $client3->id]);
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

    /**
     * @dataProvider getClientFields
     */
    public function testShouldUpdateAClientWithPartialFields($field, $expected)
    {
        $client = factory(Client::class)->create();

        $this->put("client/{$client->id}", [$field => $expected])
            ->seeJson([
                $field => $expected
            ]);

        $this->seeInDatabase('clients', [$field => $expected]);
    }

    public function testShouldShowOneClient()
    {
        $client = factory(Client::class)->create();

        $this->get("client/{$client->id}")
            ->seeJson([
                'client_id' => "{$client->id}"
            ]);
    }

    public function testShouldDestroyOneClient()
    {
        $client = factory(Client::class)->create();

        $this->delete("client/{$client->id}")
            ->seeJson([
                'success' => true
            ]);

        $this->notSeeInDatabase('clients', ['id' => $client->id]);
    }

    public function getClientFields()
    {
        return [
            ['name', 'Faker Name Updated'],
            ['email', 'faker@email.com'],
            ['address', 'Faker Address Updated']
        ];
    }
}