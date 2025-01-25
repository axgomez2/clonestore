<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusFieldsToVinylSecsTable extends Migration
{
    public function up()
    {
        Schema::table('vinyl_secs', function (Blueprint $table) {
            $table->enum('cover_status', ['mint', 'near_mint', 'very_good', 'good', 'fair', 'poor', 'generic'])->nullable()->after('vinyl_master_id');
            $table->enum('midia_status', ['mint', 'near_mint', 'very_good', 'good', 'fair', 'poor'])->nullable()->after('cover_status');
        });
    }

    public function down()
    {
        Schema::table('vinyl_secs', function (Blueprint $table) {
            $table->dropColumn('cover_status');
            $table->dropColumn('midia_status');
        });
    }
}
