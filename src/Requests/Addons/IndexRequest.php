<?php

namespace BoneCreative\CheckFront\Requests\Addons;

use FuquIo\LaravelRequest\GetStringVarsValidationTrait;
use FuquIo\LaravelRequest\SanitizedRequest;

class IndexRequest extends SanitizedRequest
{
	use GetStringVarsValidationTrait;

	protected static $dates = ['date'];

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
			'category_id' => 'required|integer',
			'date'        => 'required|date',
		];
	}
}
