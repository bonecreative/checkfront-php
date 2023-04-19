<?php

namespace BoneCreative\CheckFront\Requests\Booking;

use FuquIo\LaravelRequest\GetStringVarsValidationTrait;
use FuquIo\LaravelRequest\SanitizedRequest;

class CreateRequest extends SanitizedRequest{
	use GetStringVarsValidationTrait;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(){
		return [
			//
			'display' => 'sometimes|in:policy,definitions,rules'
		];
	}
}
