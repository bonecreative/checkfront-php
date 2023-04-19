<?php

namespace BoneCreative\CheckFront\Controllers;

use App\Http\Controllers\Controller;
use BoneCreative\CheckFront\Client as CheckFront;
use BoneCreative\CheckFront\Requests\DetailRequest;
use Carbon\Carbon;

class DetailController extends Controller
{

	public function __invoke(DetailRequest $request, CheckFront $checkfront)
	{

		$params = [
			'date'    => $request->date->format('Ymd'),
			'item_id' => $request->details,
			'param'   => ['qty' => $request->quantity],
		];

		$checkfront->item($params);

		if($checkfront->rate['status'] != 'AVAILABLE')
		{
			return [];
		}

		$stamp   = Carbon::parse($request->date->format('Y-m-d') . ' ' . $checkfront->rate['start_time'], (string) $request->CheckFrontSite->TimeZone);
		$pricing = self::makePriceChart($checkfront);

		try
		{
			$ret = [
				'id'       => $request->details,
				'name'     => $checkfront->record['name'],
				'status'   => $checkfront->rate['status'],
				'hint'     => ($checkfront->rate['available'] > 10) ? 'Available' : $checkfront->rate['summary']['title'],
				'time'     => $stamp->format('g:i a'),
				'pricing'  => $pricing,
				'limit'    => $checkfront->rate['available'],
				'position' => $checkfront->record['pos'],
				//'token'   => $checkfront->rate['slip'],
			];
		}catch(\Exception $e)
		{
			abort(500, $e->getMessage());
		}

		if(Carbon::now((string) $request->CheckFrontSite->TimeZone)->greaterThanOrEqualTo($stamp))
		{
			$ret['status'] = 'UNABAILABLE';
			$ret['hint']   = 'expired';
		}

		return $ret;
	}

	public static function makePriceChart(CheckFront $checkfront)
	{
		$labels = $checkfront->record['param'];
		$prices = $checkfront->rate['summary']['price']['param'];

		$ret = [];
		foreach($labels as $field => $param)
		{
			$ret[] = [
				'label' => $param['lbl'],
				'price' => (!empty($prices[$field])) ? preg_replace("/[^0-9.]/", "", $prices[$field]) : 0,
				'field' => $field,
				'sku'   => $checkfront->record['sku'],
			];
		}

		return $ret;
	}

}