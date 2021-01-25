<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateListShortUrlTableExternalIdToIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('list_short_url', function (Blueprint $table) {
            $table->dropUnique('list_short_url_externalid_unique');
            $table->dropIndex('list_short_url_externalid_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('list_short_url', function (Blueprint $table) {
            $table->unique('externalId');
            $table->index('externalId');
        });
    }
}
