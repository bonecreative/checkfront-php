<?php

namespace BoneCreative\CheckFront\Controllers;

use App\Http\Controllers\Controller;
use BoneCreative\CheckFront\Orm\CheckFrontAccount;
use BoneCreative\CheckFront\Requests\Orm\CheckFrontAccountGridRequest;
use Illuminate\Http\Request;

class CheckFrontAccountGridController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		return CheckFrontAccount::all();

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
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param CheckFrontAccountGridRequest $request
	 * @param CheckFrontAccount            $check_front_account
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(CheckFrontAccountGridRequest $request, CheckFrontAccount $check_front_account){
		//
		$updated = false;
		foreach(CheckFrontAccountGridRequest::$can_update as $key){
			if($request->has($key)){
				$check_front_account->$key = $request->$key;
				$updated                   = true;
			}
		}

		if($updated and $check_front_account->save()){
			return response()->json(['status' => 'success'], 200);
		}

		return response()->json(['status' => 'error'], 401);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param CheckFrontAccount $check_front_account
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 * @internal param int $id
	 */
	public function destroy(CheckFrontAccount $check_front_account){
		//
		if($check_front_account->delete()){
			return response()->json(['status' => 'success'], 200);
		}

		return response()->json(['status' => 'error'], 500);
	}
}
