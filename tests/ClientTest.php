<?php

use BoneCreative\CheckFront\Client;

class ClientTest extends BaseTest{

	/**
	 * @see \BoneCreative\CheckFront\Client::__call
	 *
	 * @test
	 */
	public function can_ping(){

		$client = new Client(getenv('CHECKFRONT_API'), getenv('CHECKFRONT_TOKEN'), getenv('CHECKFRONT_SECRET'));
		$client->ping();
		$this->assertTrue($client->status == 200);
		$this->assertTrue(is_array($client->data));

		$provider = $client->provider;
		$this->assertEquals('API', $provider);
	}

}