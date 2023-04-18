<?php

namespace BoneCreative\CheckFront;

use App\Orm\CheckFrontAccount;
use Illuminate\Console\Command;

class CacheCouponsCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'checkfront:coupons';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		//
		$accounts = CheckFrontAccount::withoutUserScope()
		                             ->get();

		foreach($accounts as $account)
		{
			CacheCouponsJob::dispatch($account);
		}
	}
}
