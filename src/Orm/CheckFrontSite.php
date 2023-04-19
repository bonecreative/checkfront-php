<?php

namespace BoneCreative\CheckFront\Orm;

use FuquIo\LaravelCore\TimeZone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckFrontSite extends Model{
	//
	use SoftDeletes;
	//use TimeZoneTrait;

	protected $with = ['TimeZone'];
	protected $fillable = ['domain'];

	public function CheckFrontAccount(){
		return $this->belongsTo(CheckFrontAccount::class);
	}
	
	public function TimeZone(){
		return $this->belongsTo(TimeZone::class);
	}

}
