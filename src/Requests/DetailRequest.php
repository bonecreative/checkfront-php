<?php

namespace BoneCreative\CheckFront\Requests;

use FuquIo\LaravelRequest\GetStringVarsValidationTrait;
use FuquIo\LaravelRequest\SanitizedRequest;

class DetailRequest extends SanitizedRequest{
	use GetStringVarsValidationTrait;

	protected static $defaults = [
		'quantity' => 1
	];

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(){
		return [
			'quantity' => 'required|integer|min:1',
			'date'     => 'required|date',
			'details'  => 'required|integer|min:1'
		];
	}
}
