<?php

namespace BoneCreative\CheckFront\Requests\Calendar;

use FuquIo\LaravelRequest\GetStringVarsValidationTrait;
use FuquIo\LaravelRequest\SanitizedRequest;

class ShowRequest extends SanitizedRequest{
	use GetStringVarsValidationTrait;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(){
		return [
			//
			'category_ids'   => 'sometimes|array',
			'category_ids.*' => 'sometimes|integer',
		];
	}
}
