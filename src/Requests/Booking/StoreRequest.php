<?php

namespace BoneCreative\CheckFront\Requests\Booking;

use BoneCreative\CheckFront\Client as CheckFront;
use FuquIo\LaravelRequest\SanitizedRequest;

class StoreRequest extends SanitizedRequest
{

	protected static $dates = ['date'];

	/**
	 * @var CheckFront
	 */
	private $checkfront;

	public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null, CheckFront $checkfront)
	{

		$this->checkfront = $checkfront;

		parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
	}


	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [ //
		         'date'              => 'required|date',
		         'details'           => 'required|integer:min:1',
		         'quantities'        => 'required|array',
		         'quantities.*'      => 'required|integer|min:0',
		         'discount'          => 'sometimes',
		         'form'              => 'required|array',
		         'addons'            => 'sometimes|array',
		         'addons.*.id'       => 'sometimes|integer',
		         'addons.*.quantity' => 'sometimes|integer',
		         'fees'              => 'sometimes|array',
		         'fees.*.id'         => 'sometimes|integer',
		         'fees.*.quantity'   => 'sometimes|integer',
		         'included'          => 'sometimes|array',
		         'included.*.id'     => 'sometimes|integer',
		         'included.*.for'    => 'sometimes|in:guest,party',

		       ] + $this->discoverCheckFrontRequirements();
	}

	protected function preProcessInputs($inputs){

		$info   = $this->checkfront->form()->data;
		$fields = CheckFront::parseFields($info['booking_form_ui']);

		$arrays = [];
		foreach($inputs['form'] as $k => $v){
			if(strpos($k, '[')){
				$n = explode('[', $k);
				if(empty($arrays[$n[0]])){
				$arrays[$n[0]] = [];
				}
				$target = str_replace(']','', $n[1]);

				$target = $info["booking_form_ui"][$n[0]]["define"]["layout"]["options"][$target];

				$arrays[$n[0]][] = $target;
				unset($inputs['form'][$k]);
			}

		}

		$inputs['form'] = array_merge($inputs['form'], $arrays);

		return $inputs;
	}

	private function discoverCheckFrontRequirements()
	{
		$info   = $this->checkfront->form()->data;
		$fields = CheckFront::parseFields($info['booking_form_ui'])
		                    ->keyBy('field')
		                    ->filter(
			                    function ($el, $key)
			                    {
				                    return (!empty($el['rules']) and !empty($el['rules'][0]['required'])) ? true : false;
			                    })->toArray();

		$fields = array_keys($fields);

		$rules = [];
		foreach($fields as $k)
		{
			$rules['form.' . $k] = 'required';
		}

		return $rules;
	}
}
