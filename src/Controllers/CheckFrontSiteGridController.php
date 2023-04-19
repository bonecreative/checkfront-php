<?php

namespace BoneCreative\CheckFront\Controllers;

use App\Http\Controllers\Controller;
use BoneCreative\CheckFront\Orm\CheckFrontAccount;
use BoneCreative\CheckFront\Orm\CheckFrontSite;
use BoneCreative\CheckFront\Requests\Orm\CheckFrontSiteGridRequest;
use Illuminate\Http\Request;

class CheckFrontSiteGridController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @param CheckFrontAccount $checkFrontAccount
	 *
	 * @return CheckFrontSite[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function index(CheckFrontAccount $checkFrontAccount){
		return $checkFrontAccount->CheckFrontSites;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(){
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param CheckFrontSiteGridRequest $request
	 * @param CheckFrontAccount         $checkFrontAccount
	 * @param CheckFrontSite            $checkFrontSite
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(CheckFrontSiteGridRequest $request, CheckFrontAccount $checkFrontAccount, CheckFrontSite $checkFrontSite){
		//
		$updated = false;
		foreach(CheckFrontSiteGridRequest::$can_update as $key){
			if($request->has($key)){
				$checkFrontSite->$key = $request->$key;
				$updated      = true;
			}
		}

		if($updated and $checkFrontSite->save()){
			return response()->json(['status' => 'success'], 200);
		}

		return response()->json(['status' => 'error'], 401);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param CheckFrontAccount $checkFrontAccount
	 * @param CheckFrontSite    $checkFrontSite
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 * @internal param int $id
	 */
	public function destroy(CheckFrontAccount $checkFrontAccount, CheckFrontSite $checkFrontSite){
		//
		if($checkFrontSite->delete()){
			return response()->json(['status' => 'success'], 200);
		}

		return response()->json(['status' => 'error'], 500);
	}
}
