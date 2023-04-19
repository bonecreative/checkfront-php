<?php

namespace BoneCreative\CheckFront\Requests\Orm;

use FuquIo\LaravelRequest\SanitizedRequest;

class CheckFrontAccountResourceRequest extends SanitizedRequest{

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(){
		return [
			//
			'api'    => 'required|url',
			'token'  => 'required|filled',
			'secret' => 'required|filled'
		];
	}
}
