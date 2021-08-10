<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user', function (Blueprint $table) {
            $table->increments("au_id");
            $table->string("au_name", 255)->nullable();
            $table->string("au_email", 50)->nullable();
            $table->text("au_password")->nullable();
            $table->text("au_token")->nullable();
            $table->string("au_2fa", 50)->nullable();
            $table->string("au_expired")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_user');
    }
}
