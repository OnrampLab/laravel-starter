<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_user', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('account_id')->unsigned()->nullable()->index();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_user');
    }
};
