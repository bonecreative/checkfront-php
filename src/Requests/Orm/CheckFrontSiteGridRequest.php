<?php

namespace BoneCreative\CheckFront\Requests\Orm;

use FuquIo\LaravelPrototypeUi\Requests\GridRequestTrait;
use FuquIo\LaravelRequest\SanitizedRequest;

class CheckFrontSiteGridRequest extends SanitizedRequest{
	use GridRequestTrait;

	public static $can_update = ['domain'];

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(){
		return [
			//
			'domain' => 'sometimes'
		];
	}
}