<?php

use BoneCreative\CheckFront\Client;

class ClientTest extends BaseTest{

	/**
	 * @see \BoneCreative\CheckFront\Client::__call
	 *
	 * @dataProvider basicEndpoints
	 * @test
	 */
	public function can_perform_basic_get_requests($endpoint){

		$client = new Client(getenv('CHECKFRONT_API'), getenv('CHECKFRONT_TOKEN'), getenv('CHECKFRONT_SECRET'));
		$this->assertTrue($client->status == 205);
		$client->$endpoint();
		$this->assertTrue($client->status == 200);

	}

	public function basicEndpoints(){
		return [
			['endpoint' => 'ping'],
			['endpoint' => 'account'],
			['endpoint' => 'bookings'],
		];
	}

}