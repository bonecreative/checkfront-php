<?php

use BoneCreative\CheckFront\Client;

class ClientTest extends BaseTest
{

	/**
	 * @see \BoneCreative\CheckFront\Client::__call
	 *
	 * @test
	 */
	public function can_get_reservation_by_id()
	{
		$client = new Client(getenv('CHECKFRONT_API'), getenv('CHECKFRONT_TOKEN'), getenv('CHECKFRONT_SECRET'));
		$result = $client->booking(['booking_id' => 'NNLG-280321']);
		$x      = 5;
	}

	/**
	 * @see \BoneCreative\CheckFront\Client::__call
	 *
	 * @dataProvider basicEndpoints
	 * @test
	 */
	public function can_perform_basic_get_requests($endpoint)
	{

		$client = new Client(getenv('CHECKFRONT_API'), getenv('CHECKFRONT_TOKEN'), getenv('CHECKFRONT_SECRET'));
		$this->assertTrue($client->status == 205);
		$client->$endpoint();
		$this->assertTrue($client->status == 200);

	}

	public function basicEndpoints()
	{
		return [
			['endpoint' => 'ping'],
			['endpoint' => 'account'],
			['endpoint' => 'bookings'],
		];
	}

	/**
	 * @see \BoneCreative\CheckFront\Client::__call
	 *
	 * @test
	 */
	public function can_paginate_thru_result_data()
	{

		$client = new Client(getenv('CHECKFRONT_API'), getenv('CHECKFRONT_TOKEN'), getenv('CHECKFRONT_SECRET'));
		$this->assertTrue($client->status == 205);
		$client->bookings(['page' => 2]);
		$this->assertTrue($client->status == 200);

	}

}