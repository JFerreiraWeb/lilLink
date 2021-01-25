<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsedShortUrlTableWithForeignKeyFromListShortUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('used_short_url', function (Blueprint $table) {
            $table->bigInteger('short_url_id')->unsigned()->index()->change();
            $table->foreign('short_url_id')->references('id')->on('list_short_url')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('used_short_url', function (Blueprint $table) {
            //
        });
    }
}
