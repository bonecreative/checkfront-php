<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckFrontSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_front_sites', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('check_front_account_id')->unsigned()->index();
            $table->foreign('check_front_account_id')->references('id')->on('check_front_accounts')->onDelete('CASCADE');

            $table->char('domain')->unique();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_front_sites');
    }
}
