<?php

namespace BoneCreative\CheckFront\Controllers;

use App\Http\Controllers\Controller;
use BoneCreative\CheckFront\Client as CheckFront;
use BoneCreative\CheckFront\Requests\Calendar\IndexRequest;
use BoneCreative\CheckFront\Requests\Calendar\ShowRequest;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
	/**
	 * Return a list of calendar days to highlight.
	 *
	 * @param IndexRequest $request
	 * @param CheckFront   $checkfront
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(IndexRequest $request, CheckFront $checkfront)
	{

		$dates = $request->only(['start_date', 'end_date']);

		foreach($dates as &$date)
		{
			$date = str_replace('-', '', $date);
		}

		$params = $dates;

		if($request->has('category_ids'))
		{
			$result = collect([]);
			foreach($request->category_ids as $category_id)
			{
				$params['category_id'] = $category_id;
				$checkfront->calendarItems($params);

				$batch = collect($checkfront->toArray())
					->whereNotIn('available', [0]);

				$result = $result->merge($batch);
			}
		}else
		{
			$checkfront->calendarItems($params);

			$result = collect($checkfront->toArray())
				->whereNotIn('available', [0]);
		}

		$start_range = Carbon::parse($dates['start_date']);
		$start_range = ($start_range->greaterThanOrEqualTo(Carbon::today())) ? $start_range : Carbon::today();

		$range           = CarbonPeriod::create($start_range, Carbon::parse($dates['end_date']));
		$capacity_by_day = [];
		foreach($range as $day)
		{
			$capacity_by_day[$day->format('j')] = 0;
			foreach($result as $event)
			{
				$capacity_by_day[$day->format('j')] += $event[$day->format('Ymd')];
			}
		}

		$capacity_by_day = collect($capacity_by_day)->filter()->toArray();

		return array_keys($capacity_by_day);
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
	 * @param ShowRequest $request
	 * @param Carbon      $date
	 * @param CheckFront  $checkfront
	 *
	 * @return CheckFront
	 */
	public function show(ShowRequest $request, Carbon $date, CheckFront $checkfront)
	{
		//
		$params = [
			'start_date' => $date->format('Ymd'),
			'end_date'   => $date->format('Ymd'),
		];

		if($request->has('category_ids'))
		{

			$result = collect([]);
			foreach($request->category_ids as $category_id)
			{
				$params['category_id'] = $category_id;
				$checkfront->calendarItems($params);
				$batch = collect($checkfront->toArray())
					->transform(function ($item, $key) use ($category_id){
						$item['category'] = (int) $category_id;
						return $item;
					});
				$result = $result->merge($batch);
			}

		}else
		{
			$checkfront->calendarItems($params);
			$result = collect($checkfront->toArray());
		}

		$ret         = $result->whereNotIn('available', [0])
		                      ->transform(function ($item, $key) use ($category_id, $date)
		                      {
			                      $ret             = collect($item)->only(['id', 'available'])->toArray();
			                      $ret['category'] = (int) $item['category'];
			                      $ret['stamp']    = $date->format('Y-m-d');

			                      return $ret;
		                      })
		                      ->values();

		return $ret;
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
