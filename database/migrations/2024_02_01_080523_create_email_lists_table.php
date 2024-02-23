<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string('file_name', 30);
            $table->string('email', 100);
            $table->string('status', 100);
            $table->string('type', 100)->nullable();
            $table->string('safe_to_send', 5)->nullable();
            $table->string('response')->nullable();
            $table->string('score', 10)->nullable();
            $table->string('bounce_type', 10)->nullable();
            $table->string('account', 100)->nullable();
            $table->string('domain', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_lists');
    }
};
