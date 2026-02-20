<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            // 外部キー（typo注意）
            $table->unsignedBigInteger('categry_id');

            $table->string('first_name');
            $table->string('last_name');

            // 1:男 2:女 3:その他
            $table->tinyInteger('gender');

            $table->string('email');
            $table->string('tel');

            $table->string('address');
            $table->string('building')->nullable();

            $table->text('detail');

            $table->timestamps();

            $table->foreign('categry_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
