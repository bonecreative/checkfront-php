<?php

namespace BoneCreative\CheckFront;

use App\Orm\CheckFrontAccount;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheCouponsJob
 * @package App\Jobs
 */
class CacheCouponsJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable;
	/**
	 * @var CheckFrontAccount
	 */
	private $checkFrontAccount;

	/**
	 * Create a new job instance.
	 *
	 * @param CheckFrontAccount $checkFrontAccount
	 */
	public function __construct(CheckFrontAccount $checkFrontAccount)
	{

		$this->checkFrontAccount = $checkFrontAccount;
	}

	/**
	 * @param array $record
	 *
	 * @return array|void
	 */
	public static function cleanAndCacheResponse(array $record)
	{

		$record = self::trimResponse($record);
		self::cacheResponse($record);

		return $record;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$checkfront = $this->checkFrontAccount->getApiConnection();

		$checkfront->discounts();
		foreach($checkfront->records as $record)
		{

			/*if(!empty($record['start_date']) and Carbon::parse($record['start_date'])->greaterThan(Carbon::today()))
			{
				continue;
			}*/
			if(!empty($record['end_date']) and Carbon::parse($record['end_date'])->lessThan(Carbon::today()))
			{
				continue;
			}

			self::cleanAndCacheResponse($record);
		}
	}

	/**
	 * @param $code
	 *
	 * @return bool
	 */
	public static function inCache($code)
	{
		$cache_key = self::makeKey($code);
		if(Cache::has($cache_key))
		{
			return Cache::get($cache_key);
		}

		return false;
	}

	/**
	 * @param array $ret
	 */
	private static function cacheResponse(array $ret)
	{
		$cache_key = self::makeKey($ret['code']);
		if(Cache::has($cache_key))
		{
			Cache::forget($cache_key);
		}

		Cache::put($cache_key, $ret, now()->addHours(12));
	}

	/**
	 * @param $code
	 *
	 * @return string
	 */
	private static function makeKey($code)
	{
		return 'CheckFront:Discount:' . $code;
	}

	/**
	 * @param array $record
	 *
	 * @return array
	 */
	private static function trimResponse(array $record)
	{

		return [
			'id'      => $record['discount_id'],
			'code'    => $record['discount_code'],
			'rate'    => (float) $record['dynamic_rate'],
			'type'    => $record['dynamic_type'],
			'level'   => $record['discount_type'],
			'display' => $record['label'],
			'on'      => !empty($record['apply_to'] and is_array($record['apply_to'])) ? array_map('intval', $record['apply_to']) : [],
		];

	}
}
