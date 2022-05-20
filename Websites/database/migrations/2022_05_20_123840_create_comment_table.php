<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->id()
                    ->autoIncrement()
                    ->onDelete('cascade');
            $table->bigInteger('user_receiver_id')
                    ->foreignIdFor('users', 'id')
                    ->onDelete('cascade');
            $table->string('sender_username')
                    ->foreignIdFor('users', 'username')
                    ->onDelete('cascade');
            $table->string('content');
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
        Schema::dropIfExists('comment');
    }
};
