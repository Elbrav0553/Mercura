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
        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('description');
        });
        Schema::create('option_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('option_id');
            $table->string('locale')->index();
            $table->string('name');
            $table->string('description')->nullable();
            $table->unique(['option_id', 'locale']);
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('options', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('description')->after('name');
        });
        Schema::dropIfExists('option_translations');
    }
};
