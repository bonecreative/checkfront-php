<?php

namespace BoneCreative\CheckFront;

class ChunkedStream implements \Countable, \Iterator{

	private $client;
	private $page = 1;
	private $pages = 1;
	private $max_per_page = 100;
	private $pointer = 0;
	private $size = 0;
	private $chunk = [];

	public function __construct(Client $client){
		$this->client = $client;
		$this->applyClientToProps($this->client);

		if($this->client->page != 1){
			$this->pointer = (($this->client->page - 1) * $this->max_per_page);
		}
	}

	private function pagePointer(){
		return ($this->pointer - ($this->max_per_page * ($this->page - 1)));
	}

	public function current(){
		return $this->chunk[$this->pagePointer()];
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
		return !empty($this->chunk[$this->pagePointer()]);
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
		$this->chunk        = array_values($client->chunk);
		$this->size         = $client->request['records'];
	}

	private function paginate($x = null){
		$last_call = $this->client->getLastCall();
		$method    = $last_call['name'];
		$args      = $last_call['args'];

		if(empty($args)){
			$args = [null, []];
		}elseif(empty($args[0])){
			$args[0] = [];
		}

		if(empty($args[0]['page'])){
			$args[0]['page'] = $this->page;
		}

		if(empty($x)){
			$args[0]['page']++;
		}

		$this->client->$method($args[0], $args[1]);
		$this->applyClientToProps($this->client);
	}
}