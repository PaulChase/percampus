<?php

use App\Models\Campus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToCampusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campuses', function (Blueprint $table) {
            $table->integer('type')->default(Campus::UNIVERSITY);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campuses', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
