<?php

use BoneCreative\CheckFront\Client;

class ClientTest extends BaseTest{

	/**
	 * @see \BoneCreative\CheckFront\Client::__call
	 *
	 * @test
	 */
	public function can_ping(){

		$client = new Client(getenv('API'), getenv('TOKEN'), getenv('SECRET'));
		$client->ping();
		$this->assertTrue($client->status == 200);
		$this->assertIsArray($client->data);

		$provider = $client->provider;
		$this->assertEquals('API', $provider);
	}

}