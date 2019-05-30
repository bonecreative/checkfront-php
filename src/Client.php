<?php

namespace BoneCreative\CheckFront;

use GuzzleHttp\Client as Guzzle;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Client
 * @package BoneCreative\CheckFront
 */
class Client{

	/**
	 * @var Guzzle
	 */
	private $guzzle;
	/**
	 * @var int
	 */
	public $status = 205;
	/**
	 * @var null
	 */
	public $data = null;


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
	 * @throws Exception
	 */
	public function __call($name, $arguments){
		$arguments[0] = (!empty($arguments[0])) ? $arguments[0] : [];
		$params       = (!empty($arguments[1])) ? $arguments[0] : [];

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

		$result = $this->guzzle->$call($url, $params);

		$this->setStatusAndContent($result);
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

		$iterator  = new \RecursiveArrayIterator($this->data);
		$recursive = new \RecursiveIteratorIterator(
			$iterator,
			\RecursiveIteratorIterator::SELF_FIRST
		);
		foreach ($recursive as $key => $value) {
			if ($key === $name) {
				return $value;
			}
		}

		return null;
	}


	/**
	 * @param ResponseInterface $result
	 */
	private function setStatusAndContent(ResponseInterface $result){
		$this->status = $result->getStatusCode();

		try{
			$this->data = $result->getBody();
			$this->data = (!empty($this->data)) ? json_decode($this->data, true) : null;
			if(json_last_error() !== JSON_ERROR_NONE){
				throw new Exception('Could not read CheckFront response.');
			}
		}catch(\Exception $exception){
			$this->status = 205;
			$this->data   = null;
		}
	}
}
