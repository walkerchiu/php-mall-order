<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('wk-core.table.user'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create(config('wk-core.table.mall-cart.channels'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_enabled')->default(0);
            $table->timestamps();
        });
        Schema::create(config('wk-core.table.mall-shelf.stocks'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('quantity');
            $table->boolean('is_enabled')->default(0);
            $table->timestamps();
        });
        Schema::create(config('wk-core.table.morph-address.addresses'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('morph');
            $table->string('type', 15);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->char('area', 2)->default('TW');

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['morph_type', 'morph_id', 'type']);
            $table->index('type');
            $table->index('phone');
            $table->index('email');
            $table->index('area');
        });
        Schema::create(config('wk-core.table.morph-address.addresses_lang'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('host_id');
            $table->string('code');
            $table->string('key');
            $table->text('value')->nullable();
            $table->boolean('is_current')->default(1);

            $table->timestampsTz();
            $table->softDeletes();

            $table->foreign('host_id')->references('id')
                  ->on(config('wk-core.table.morph-address.addresses'))
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->index(['host_id', 'code', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('wk-core.table.morph-address.addresses_lang'));
        Schema::dropIfExists(config('wk-core.table.morph-address.addresses'));
        Schema::dropIfExists(config('wk-core.table.mall-shelf.stocks'));
        Schema::dropIfExists(config('wk-core.table.mall-cart.channels'));
        Schema::dropIfExists(config('wk-core.table.user'));
    }
}
