<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimezoneToCheckfrontsite extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('check_front_sites', function (Blueprint $table)
		{
			//
			$table->integer('time_zone_id')->after('domain')->default(1)->unsigned()->index();
			$table->foreign('time_zone_id')->references('id')->on('time_zones')->onDelete('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('check_front_sites', function (Blueprint $table)
		{
			//
			$table->dropForeign($table->getTable() . '_time_zone_id_foreign');
			$table->dropColumn('time_zone_id');
		});
	}
}
