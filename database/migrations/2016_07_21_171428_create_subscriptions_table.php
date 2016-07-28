<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned()->index();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->integer('plan_id')->unsigned()->index();
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->string('plan_level');
            $table->string('token');
            $table->dateTime('date_deleted')->nullable();
            $table->dateTime('current_period_start');
            $table->dateTime('current_period_end');
            /**
             * Determines the state of the subscription.
             *
             * Possible values:
             *      ACTIVE - The subscription is active.
             *
             *      WAITING_ON_PAYMENT, - One or more of the subscription's invoices failed. After 3 failed invoices, the
             *                            state should be changed to DISABLED.
             *
             *      DISABLED - The subscription has been disabled becuase of too many failed invoice attempts.
             *                 (see invoice object below).
             *
             *      CANCELED - The subscription was cancelled by the user.
             *
             * @var string
             */
            $table->string('state');
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
        Schema::drop('subscriptions');
    }
}
