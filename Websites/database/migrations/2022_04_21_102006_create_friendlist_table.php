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
        Schema::create('friendlist', function (Blueprint $table) {
            $table->bigInteger('sender_id')
                    ->foreignIdFor('users', 'id')
                    ->onDelete('cascade');
            $table->bigInteger('receiver_id')
                    ->foreignIdFor('users', 'id')
                    ->onDelete('cascade');
            $table->primary(['sender_id', 'receiver_id']);
            $table->timestamps();
        });
    }
    //$table->foreignIdFor(User::class);
    //$table->foreignId('user_id')
    // ->onUpdate('cascade')
    // ->onDelete('cascade');
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friendlist');
    }
};
