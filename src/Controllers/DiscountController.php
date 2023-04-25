<?php

namespace BoneCreative\CheckFront\Controllers;

use App\Http\Controllers\Controller;
use BoneCreative\CheckFront\CacheCouponsJob;
use BoneCreative\CheckFront\Client as CheckFront;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param            $code
	 * @param CheckFront $checkfront
	 *
	 * @return array
	 */
	public function show($code, CheckFront $checkfront)
	{
		//
		if($found = CacheCouponsJob::inCache($code))
		{
			return $found;
		}

		$checkfront->discounts();
		foreach($checkfront->records as $record)
		{

			if($record['discount_code'] != $code)
			{
				continue;
			}

			/*if(!empty($record['start_date']) and Carbon::parse($record['start_date'])->greaterThan(Carbon::today()))
			{
				continue;
			}*/
			if(!empty($record['end_date']) and Carbon::parse($record['end_date'])->lessThan(Carbon::today()))
			{
				continue;
			}

			return CacheCouponsJob::cleanAndCacheResponse($record);
		}

		abort(404, 'No match found.');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
