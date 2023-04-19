<?php

namespace BoneCreative\CheckFront\Requests\Orm;

use FuquIo\LaravelRequest\SanitizedRequest;

class CheckFrontSiteResourceRequest extends SanitizedRequest{

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(){
		return [
			//
			'domain' => 'required|fqdn|unique:check_front_sites,domain'
		];
	}
}
