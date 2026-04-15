<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('lendings', function (Blueprint $table) {
        $table->string('borrower_type')->after('name');
    });
}

public function down()
{
    Schema::table('lendings', function (Blueprint $table) {
        $table->dropColumn('borrower_type');
    });
}
};
