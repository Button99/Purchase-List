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
        Schema::create('item_list_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('item_id')->constrained('items')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('item_list_id')->constrained('item_lists')
                ->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('item_list_item');
    }
};