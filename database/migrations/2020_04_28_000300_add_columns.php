<?php namespace Thoughtco\Mealtimes\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumns extends Migration
{
    public function up()
    {
        Schema::table('mealtimes', function (Blueprint $table) {
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('availability');
        });      
    }

    public function down()
    {
        Schema::table('mealtimes', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('availability');
        });                         
    }
}