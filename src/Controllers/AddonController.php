<?php

namespace BoneCreative\CheckFront\Controllers;

use App\Http\Controllers\Controller;
use BoneCreative\CheckFront\Client as CheckFront;
use BoneCreative\CheckFront\Requests\Addons\IndexRequest;
use Illuminate\Http\Request;

class AddonController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param IndexRequest $request
	 * @param CheckFront   $checkfront
	 *
	 * @return void
	 */
	public function index(IndexRequest $request, CheckFront $checkfront)
	{
		//
		$checkfront->items(['category_id' => $request->category_id,
		                    'date'        => $request->date->format('Ymd'),
		                    'param'       => ['qty' => 1]]);

		return collect($checkfront->toArray())
			->whereIn('status', ['A'])
			->transform(function ($item, $key)
			{

				return [
					'id'    => $item['item_id'],
					'label' => $item['name'],
					'field' => array_keys($item['param'])[0],
					'price' => $item['rate']['sub_total'],
					'sku'   => $item['sku'],
				];
			});
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
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
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
