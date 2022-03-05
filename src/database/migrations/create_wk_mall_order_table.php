<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateWkMallOrderTable extends Migration
{
    public function up()
    {
        Schema::create(config('wk-core.table.mall-order.orders'), function (Blueprint $table) {
            $table->uuid('id');
            $table->nullableUuidMorphs('host');
            $table->uuid('user_id')->nullable();
            $table->string('identifier')->unique();
            $table->text('note')->nullable();
            $table->unsignedDecimal('grandtotal', config('wk-mall-order.unsigned_decimal.precision'), config('wk-mall-order.unsigned_decimal.scale'))->nullable();
            $table->unsignedDecimal('subtotal', config('wk-mall-order.unsigned_decimal.precision'), config('wk-mall-order.unsigned_decimal.scale'))->nullable();
            $table->unsignedDecimal('fee', config('wk-mall-order.unsigned_decimal.precision'), config('wk-mall-order.unsigned_decimal.scale'))->nullable();
            $table->unsignedDecimal('tax', config('wk-mall-order.unsigned_decimal.precision'), config('wk-mall-order.unsigned_decimal.scale'))->nullable();
            $table->unsignedDecimal('tip', config('wk-mall-order.unsigned_decimal.precision'), config('wk-mall-order.unsigned_decimal.scale'))->nullable();
            $table->unsignedDecimal('discount_coupon', config('wk-mall-order.unsigned_decimal.precision'), config('wk-mall-order.unsigned_decimal.scale'))->nullable();
            $table->unsignedDecimal('discount_point', config('wk-mall-order.unsigned_decimal.precision'), config('wk-mall-order.unsigned_decimal.scale'))->nullable();
            $table->unsignedDecimal('discount_shipment', config('wk-mall-order.unsigned_decimal.precision'), config('wk-mall-order.unsigned_decimal.scale'))->nullable();
            $table->unsignedDecimal('discount_custom', config('wk-mall-order.unsigned_decimal.precision'), config('wk-mall-order.unsigned_decimal.scale'))->nullable();
            $table->json('data')->nullable();
            $table->string('security_code')->nullable();

            $table->timestampsTz();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')
                  ->on(config('wk-core.table.user'))
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->primary('id');
            $table->index('grandtotal');
            $table->index('security_code');
        });

        Schema::create(config('wk-core.table.mall-order.reviews'), function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('order_id');
            $table->uuid('user_id')->nullable();
            $table->char('state', 2);
            $table->text('state_note')->nullable();
            $table->boolean('is_current')->default(1);

            $table->timestampsTz();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')
                  ->on(config('wk-core.table.mall-order.orders'))
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('user_id')->references('id')
                  ->on(config('wk-core.table.user'))
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->primary('id');
            $table->index('state');
        });
    }

    public function down() {
        Schema::dropIfExists(config('wk-core.table.mall-order.reviews'));
        Schema::dropIfExists(config('wk-core.table.mall-order.orders'));
    }
}
