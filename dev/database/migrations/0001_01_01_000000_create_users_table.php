<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('label', 255);
            $table->json('data')->nullable();
            $table->dateTime('created_at')->default(now());
            $table->dateTime('updated_at')->default(now())->nullable();
            $table->dateTime('deleted_at')->nullable();
        });

        Schema::create('user_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('label', 255);
            $table->json('data')->nullable();
            $table->dateTime('created_at')->default(now());
            $table->dateTime('updated_at')->default(now())->nullable();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('status');
            $table->unsignedBigInteger('role');
            $table->json('data')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('invited_by')->nullable();
            $table->dateTime('created_at')->default(now());
            $table->dateTime('updated_at')->default(now())->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->foreign('status')->references('id')->on('user_status');
            $table->foreign('role')->references('id')->on('user_roles');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('invited_by')->references('id')->on('users');

            $table->index('status');
            $table->index('created_at');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('users_status');
        Schema::dropIfExists('users_roles');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
