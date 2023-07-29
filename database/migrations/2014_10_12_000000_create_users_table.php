<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('provider')->nullable(true);
            $table->integer('provider_id')->nullable(true);
            $table->timestamp('email_verified_at')->nullable(true);
            $table->string('password')->nullable(true);
            $table->boolean('active')->default(1);
            $table->string('language')->default('vi');
            $table->integer('status')->default(1);
            $table->timestamp('last_active_start')->nullable(true);
            $table->timestamp('last_active_end')->nullable(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
