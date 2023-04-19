<?php

namespace BoneCreative\CheckFront\Controllers;

use App\Http\Controllers\Controller;
use BoneCreative\CheckFront\Client as CheckFront;
use BoneCreative\CheckFront\Requests\Booking\CreateRequest;
use BoneCreative\CheckFront\Requests\Booking\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class BookingController
 * @package App\Http\Controllers\CheckFront
 */
class BookingController extends Controller
{

	CONST PAYMENT_IFRAME_URL = 'reserve/booking/{booking_id}?CFX={token}&view=pay';

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
	 * @param CreateRequest $request
	 * @param CheckFront    $checkfront
	 *
	 * @return array
	 */
	public function create(CreateRequest $request, CheckFront $checkfront)
	{
		//
		$info = $checkfront->form()->data;

		$fields = CheckFront::parseFields($info['booking_form_ui']);

		$fields->push(['field' => 'notes',
		               'type'  => 'textarea',
		               'label' => 'Notes']);

		$policy      = $info['booking_policy'];
		$rules       = $fields->pluck('rules', 'field')->filter()->toArray();
		$definitions = $fields->keyby('field')->transform(
			function ($item, $key)
			{
				unset($item['field']);

				return $item;
			}
		)->toArray();


		if($request->has('display'))
		{
			$display = $request->display;

			return $$display;
		}

		return [
			'policy'      => $policy,
			'definitions' => $definitions,
			'rules'       => $rules,
		];
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param StoreRequest $request
	 * @param CheckFront   $checkfront
	 *
	 * @return void
	 */
	public function store(StoreRequest $request, CheckFront $checkfront)
	{

		$slips  = [];
		$params = array_filter([
			                       'date'          => $request->date->format('Ymd'),
			                       'item_id'       => $request->details,
			                       'param'         => $request->quantities,
			                       'discount_code' => ($request->has('discount')) ? $request->discount : null,
		                       ]);

		$checkfront->item($params);
		if(empty($checkfront->rate['slip']))
		{
			abort(406, 'Unable to accommodate.');
		}

		if($request->has('discount') and empty($checkfront->record['discount']['type']))
		{
			abort(406, 'Discount not applicable.  Coupon has been removed.  Please submit again if you wish to proceed.');
		}

		$slips[] = $checkfront->rate['slip'];

//		if($request->has('included'))
//		{
//			foreach($request->included as $fee)
//			{
//				$params = [
//					'date'    => $request->date->format('Ymd'),
//					'item_id' => $fee['id'],
//					'param'   => ['fee' => (($fee['for'] == 'party') ? 1 : array_sum($request->quantities))],
//				];
//
//				$checkfront->item($params);
//				$slips[] = $checkfront->rate['slip'];
//			}
//
//		}

		foreach(['addon', 'fee'] as $singular)
		{
			$plural = Str::plural($singular);
			if($request->has($plural))
			{

				foreach($request->$plural as $$singular)
				{
					if(empty($$singular['quantity']))
					{
						continue;
					}

					$params = [
						'date'    => $request->date->format('Ymd'),
						'item_id' => $$singular['id'],
						'param'   => [$$singular['field'] => $$singular['quantity']],
					];

					$checkfront->item($params);
					$slips[] = $checkfront->rate['slip'];
				}

			}
		}


		$params = [
			'slip' => $slips,
			'form' => array_filter($request->form),
		];

		$checkfront->book($params);


		if(empty($checkfront->record['id']))
		{
			return response()->json(['status' => 'error'], 409);
		}

		$payment_url = str_replace('api/3.0/', '', $checkfront->api_host)
		               . str_replace(['{booking_id}', '{token}'],
		                             [$checkfront->record['id'], $checkfront->record['token']],
		                             self::PAYMENT_IFRAME_URL);

		$ret = response()->json(['status'       => 'success',
		                         'confirmation' => $checkfront->record['id'],
		                         'payment_url'  => $payment_url], 200);

		$checkfront->update(['booking_id' => $checkfront->record['id'], 'status_id' => 'WAIT']);

		return $ret;

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
