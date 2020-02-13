<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


class AddAbstractForFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('files', function (Blueprint $table) {
        // creo una clave unique para no repetir cargas expedientes
        $table->string('abstract')->nullable();
        // Full Text Index
      });
      DB::statement('ALTER TABLE files ADD FULLTEXT fulltext_index (title, abstract)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
