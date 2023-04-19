<?php

namespace BoneCreative\CheckFront;

use BoneCreative\CheckFront\Orm\CheckFrontSite;
use Closure;

class Middleware{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next){

		$server = $request->server();
		$origin = (!empty($server['HTTP_ORIGIN'])) ? $server['HTTP_ORIGIN'] : 'unknown';
		if($origin != 'unknown'){
			$origin = parse_url($origin, PHP_URL_HOST);
		}

		$site = CheckFrontSite::whereDomain($origin)
		                      ->firstOrFail();

		$request = self::appendRequest($request, ['CheckFrontSite' => $site]);

		return $next($request);
	}

	/**
	 * @param $request
	 * @param $items
	 *
	 * @return mixed $request
	 */
	protected static function appendRequest($request, $items){
		$inputs = $request->all();

		foreach($items as $k => $v){
			$inputs[$k] = $v;
		}

		$request->request->replace($inputs);

		return $request;
	}
}
