<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apartments', function (Blueprint $table) {
            // Creo la relazione aggiungendo la foreign key alla tabella apartments
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            // Assegno il valore alla colonna
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apartments', function (Blueprint $table) {
            // Drop della colonna nel caso di cancellazione di un dato
            $table->dropForeign('apartments_user_id_foreign');
            // Delete della colonna
            $table->dropColumn('user_id');
        });
    }
}
