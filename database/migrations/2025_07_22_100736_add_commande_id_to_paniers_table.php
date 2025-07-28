<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommandeIdToPaniersTable extends Migration
{
    public function up()
    {
        Schema::table('paniers', function (Blueprint $table) {
            $table->unsignedBigInteger('commande_id')->nullable()->after('user_id');

            // Clé étrangère vers la table commandes
            $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('paniers', function (Blueprint $table) {
            $table->dropForeign(['commande_id']);
            $table->dropColumn('commande_id');
        });
    }
}
