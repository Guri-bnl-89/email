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
        Schema::create('offer_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10);
            $table->string('less', 5);
            $table->enum('less_type', ['percent', 'money']);
            $table->date('expire');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_codes');
    }
};
