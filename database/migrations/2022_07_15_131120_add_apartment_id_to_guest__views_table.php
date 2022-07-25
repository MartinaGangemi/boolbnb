<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApartmentIdToGuestViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guest__views', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('apartment_id')->nullable()->after('id');
            // Assegno il valore alla colonna
            $table->foreign('apartment_id')->references('id')->on('apartments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guest__views', function (Blueprint $table) {
            //
            $table->dropForeign('guest__views_apartment_id_foreign');
            // Delete della colonna
            $table->dropColumn('apartment_id');
        });
    }
}
