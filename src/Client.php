<?php

namespace BoneCreative\CheckFront;

use GuzzleHttp\Client as Guzzle;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 * @package BoneCreative\CheckFront
 */
class Client{


	private $guzzle;
	private $last_call = ['name' => '', 'args' => []];

	public $status = 205;
	public $data = null;

	public $chunk = [];
	public $record = [];
	public $records = [];

	/**
	 * Client constructor.
	 *
	 * @param string $api
	 * @param string $token
	 * @param string $secret
	 * @param string $client_ip
	 * @param string $staff
	 */
	public function __construct(string $api, string $token, string $secret, string $client_ip = '0.0.0.0', string $staff = 'off'){
		$this->guzzle = new Guzzle(['base_uri' => $api, 'auth' => [$token, $secret]]);

		$this->guzzle->setDefaultOption('headers', [
			'User-Agent'      => 'BoneCreative 0.3 FNKe',
			'Authorization'   => 'Basic ' . base64_encode($token . ':' . $secret),
			'X-Forwarded-For' => $client_ip,
			'X-On-Behalf'     => $staff
		]);
	}

	/**
	 * @param $name
	 * @param $arguments
	 *
	 * @return Client
	 * @throws Exception
	 */
	public function __call($name, $arguments){
		$this->last_call = ['name' => $name, 'args' => $arguments];

		$arguments[0] = (!empty($arguments[0])) ? $arguments[0] : [];
		$params       = (!empty($arguments[1])) ? $arguments[1] : [];

		$route_info = parse_ini_file(__DIR__ . '/../config/endpoints.ini', true);
		if(!empty($route_info[$name])){
			$route_info = $route_info[$name];
		}else{
			throw new Exception('Missing CheckFront route info.');
		}

		$route_param_names  = array_keys($arguments[0]);
		$route_param_values = array_values($arguments[0]);

		foreach($route_param_names as $k => $route_param_name){
			$route_param_names[$k] = '{' . $route_param_name . '}';
		}
		$url = str_replace($route_param_names, $route_param_values, $route_info['uri']);

		$call = strtolower($route_info['method']);

		if($call == 'get' and !empty($params)){
			$url    .= '?' . http_build_query($params);
			$params = [];
		}

		$result = $this->guzzle->$call($url, $params);

		$accessor = ($name != str_plural($name)) ? 'record' : 'records';

		if(empty($route_info[$accessor])){
			$route_info[$accessor] = $name;
		}

		$this->setStatusAndContent($result, $route_info);

		return $this;
	}

	/**
	 * @param $name
	 *
	 * @return mixed|null
	 */
	public function __get($name){
		if(!empty($this->$name)){
			return $this->$name;
		}

		$data = [$this->data, $this->record];

		$iterator  = new \RecursiveArrayIterator($data);
		$recursive = new \RecursiveIteratorIterator(
			$iterator,
			\RecursiveIteratorIterator::SELF_FIRST
		);
		foreach($recursive as $key => $value){
			if($key === $name){
				return $value;
			}
		}

		return null;
	}


	/**
	 * @param ResponseInterface $result
	 * @param array             $route_info
	 */
	private function setStatusAndContent(ResponseInterface $result, array $route_info){
		$this->status = $result->getStatusCode();
		$this->chunk  = [];
		$this->record = [];

		try{
			$this->data = $result->getBody();
			$this->data = (!empty($this->data)) ? json_decode($this->data, true) : null;
			if(json_last_error() !== JSON_ERROR_NONE){
				throw new Exception('Could not read CheckFront response.');
			}

			if(!empty($route_info['records'])){
				$this->chunk = $this->data[$route_info['records']];
				//unset($this->data[$route_info['records']]);
				$this->records = new ChunkedStream($this);
			}elseif(!empty($route_info['record'])){
				$this->record = $this->__get($route_info['record']);
				//unset($this->data[$route_info['record']]);
			}

		}catch(\Exception $exception){
			$this->status = 205;
			$this->data   = null;
		}
	}

	/**
	 * @return array
	 * @internal
	 */
	public function getLastCall(){
		return $this->last_call;
	}
}
