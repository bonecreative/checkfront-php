<?php

namespace BoneCreative\CheckFront\Requests\Orm;

use FuquIo\LaravelPrototypeUi\Requests\GridRequestTrait;
use FuquIo\LaravelRequest\SanitizedRequest;

class CheckFrontAccountGridRequest extends SanitizedRequest{

	use GridRequestTrait;

	public static $can_update = [];

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules(){
		return [
			//

		];
	}
}