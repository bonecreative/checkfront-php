<?php

namespace BoneCreative\CheckFront\Controllers;

use App\Http\Controllers\Controller;
use BoneCreative\CheckFront\Orm\CheckFrontAccount;
use BoneCreative\CheckFront\Orm\CheckFrontSite;
use BoneCreative\CheckFront\Requests\Orm\CheckFrontSiteResourceRequest;
use BoneCreative\CheckFront\ServiceProvider;
use FuquIo\LaravelPrototypeUi\Helpers;

/**
 * Class CheckFrontSiteDisplayController
 * @package App\Http\Controllers\Orm
 */
class CheckFrontSiteDisplayController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param CheckFrontAccount $check_front_account
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(CheckFrontAccount $check_front_account)
	{
		//
		return view(ServiceProvider::SHORT_NAME . '::OrmGridDisplays.checkFrontSite')->with(['check_front_account' => $check_front_account]);
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @param CheckFrontAccount $account
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(CheckFrontAccount $check_front_account)
	{
		//
		return view(ServiceProvider::SHORT_NAME . '::OrmForms.checkFrontSite')->with(['check_front_account' => $check_front_account]);
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CheckFrontSiteResourceRequest $request
	 *
	 * @param CheckFrontAccount $check_front_account
	 *
	 * @return \Illuminate\Routing\Redirector
	 */
	public function store(CheckFrontSiteResourceRequest $request, CheckFrontAccount $check_front_account)
	{
		//
		
		$check_front_site = new CheckFrontSite($request->only(['domain']));
		$check_front_site->CheckFrontAccount()->associate($check_front_account);
		
		
		return Helpers::redirectLogically($check_front_site->save());
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
	 * @param CheckFrontSite $check_front_site
	 *
	 * @param CheckFrontAccount $account
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(CheckFrontSite $check_front_site, CheckFrontAccount $check_front_account)
	{
		//
		return view(ServiceProvider::SHORT_NAME . '::OrmForms.checkFrontSite')
			->with([
				       'check_front_account' => $check_front_account,
				       'check_front_site'    => $check_front_site
			       ]);
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param CheckFrontSiteResourceRequest $request
	 * @param CheckFrontAccount $check_front_account
	 * @param CheckFrontSite $check_front_site
	 *
	 * @return \Illuminate\Routing\Redirector
	 */
	public function update(CheckFrontSiteResourceRequest $request, CheckFrontAccount $check_front_account, CheckFrontSite $check_front_site)
	{
		//
		$check_front_site->fill($request->only(['domain']));
		
		return Helpers::redirectLogically($check_front_site->save());
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
