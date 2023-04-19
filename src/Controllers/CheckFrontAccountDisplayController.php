<?php

namespace BoneCreative\CheckFront\Controllers;

use App\Http\Controllers\Controller;
use BoneCreative\CheckFront\Orm\CheckFrontAccount;
use BoneCreative\CheckFront\Requests\Orm\CheckFrontAccountResourceRequest;
use BoneCreative\CheckFront\ServiceProvider;
use FuquIo\LaravelPrototypeUi\Helpers;

/**
 * Class CheckFrontAccountDisplayController
 * @package App\Http\Controllers\Orm
 */
class CheckFrontAccountDisplayController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
		return view(ServiceProvider::SHORT_NAME . '::OrmGridDisplays.checkFrontAccount');
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
		return view(ServiceProvider::SHORT_NAME . '::OrmForms.checkFrontAccount');
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CheckFrontAccountResourceRequest $request
	 *
	 * @return \Illuminate\Routing\Redirector
	 */
	public function store(CheckFrontAccountResourceRequest $request)
	{
		//
		
		$check_front_account = CheckFrontAccount::create($request->only(['api', 'token', 'secret']));
		
		return Helpers::redirectLogically($check_front_account->exists);
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param CheckFrontAccount $check_front_account
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(CheckFrontAccount $check_front_account)
	{
		//
		return view(ServiceProvider::SHORT_NAME . '::OrmForms.checkFrontAccount')
			->with([
				       'check_front_account' => $check_front_account,
				       'unique'              => uniqid('server-side-')
			       ]);
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param CheckFrontAccountResourceRequest $request
	 * @param CheckFrontAccount $check_front_account
	 *
	 * @return \Illuminate\Routing\Redirector
	 */
	public function update(CheckFrontAccountResourceRequest $request, CheckFrontAccount $check_front_account)
	{
		//
		$check_front_account->fill($request->only(['api', 'token', 'secret']));
		return Helpers::redirectLogically($check_front_account->save());
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
