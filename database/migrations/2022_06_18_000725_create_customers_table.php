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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('name');
            $table->string('number')->unique();
            $table->enum('gender', ['L', 'P'])->default('L');
            $table->date('birth')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->string('last_education')->nullable();
            $table->string('profession')->nullable();
            $table->enum('status', ['active','nonactive', 'blacklist'])->default('active');
            $table->string('photo')->nullable();
            $table->dateTime('joined_at')->nullable();
            $table->timestamps();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedInteger('total_pokok')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
        
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('total_pokok');
        });
    }
};