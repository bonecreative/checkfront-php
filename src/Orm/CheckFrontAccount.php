<?php

namespace BoneCreative\CheckFront\Orm;

use BoneCreative\CheckFront\Client;
use FuquIo\LaravelUser\Scopes\UserScopeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckFrontAccount extends Model{
	//
	use SoftDeletes;
	use UserScopeTrait;

	protected $fillable = ['api', 'token', 'secret'];

	public function CheckFrontSites(){
		return $this->hasMany(CheckFrontSite::class);
	}

	public function getApiConnection(){
		return new Client($this->api, $this->token, $this->secret);
	}
}
