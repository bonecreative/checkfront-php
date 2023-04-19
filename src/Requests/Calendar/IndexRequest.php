<?php

namespace BoneCreative\CheckFront\Requests\Calendar;

use FuquIo\LaravelRequest\GetStringVarsValidationTrait;
use FuquIo\LaravelRequest\SanitizedRequest;

class IndexRequest extends SanitizedRequest
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
			'start_date'     => 'required|date|date_format:Y-m-d',
			'end_date'       => 'required|date|date_format:Y-m-d|after_or_equal:start_date',
			'category_ids'   => 'sometimes|array',
			'category_ids.*' => 'sometimes|integer',
		];
	}
}
