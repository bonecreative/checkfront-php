<?php

namespace BoneCreative\CheckFront;

class DataSet implements \Countable, \Iterator{

	public $client;
	public $page = 1;
	public $pages = 1;
	public $pointer = 0;
	public $size = 0;
	public $records = [];

	public function __construct(Client $client){

		$this->client = $client;
		$this->applyClientToProps($this->client);

	}

	private function pagePointer(){
		return ($this->pointer - ($this->max_per_page * ($this->page -1)));
	}

	/**
	 * Return the current element
	 * @link  https://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 * @since 5.0.0
	 */
	public function current(){
		return $this->records[$this->pagePointer()];
	}

	public function next(){
		$this->pointer++;
		if(!$this->valid() and $this->page < $this->pages){
			$this->paginate();
		}
	}

	public function key(){
		return $this->pointer;
	}

	public function valid(){
		return !empty($this->records[$this->pagePointer()]);
	}

	public function rewind(){
		$this->pointer = 0;
		if($this->page != 1){
			$this->paginate(1);
		}
	}

	public function count(){
		return $this->size;
	}

	private function applyClientToProps(Client $client){
		$this->page         = $client->page;
		$this->pages        = $client->pages;
		$this->max_per_page = $client->limit;
		$this->records      = array_values($client->records);
		$this->size         = $client->total_records;
	}

	private function paginate($x = null){
		$last_call = $this->client->getLastCall();
		$method = $last_call['name'];
		$args = $last_call['args'];

		if(empty($args)){
			$args = [null, []];
		}elseif(empty($args[1])){
			$args[1] = [];
		}

		if(empty($args[1]['page'])){
			$args[1]['page'] = $this->page;
		}

		if(empty($x)){
			$args[1]['page']++;
		}


		$this->client->$method($args[0], $args[1]);
		$this->applyClientToProps($this->client);
	}
}