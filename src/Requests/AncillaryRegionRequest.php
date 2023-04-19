<?php

namespace BoneCreative\CheckFront\Requests;

use FuquIo\LaravelRequest\GetStringVarsValidationTrait;
use FuquIo\LaravelRequest\SanitizedRequest;

class AncillaryRegionRequest extends SanitizedRequest
{
	use GetStringVarsValidationTrait;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
			'country' => 'required',
		];
	}
}
