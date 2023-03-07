<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerShipPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_ship_plans', function (Blueprint $table) {
            $table->id();
            $table->string('PlanTitle');
            $table->text('Objective');
            $table->text('Process');
            $table->text('Report');
            $table->text('DeliveryMode');
            $table->text('Limitations');
            $table->string('PlanTitleAr');
            $table->text('ObjectiveAr');
            $table->text('ProcessAr');
            $table->text('ReportAr');
            $table->text('DeliveryModeAr');
            $table->text('LimitationsAr');
            $table->integer('Audience');
            $table->string('TamplatePath');
            $table->double('Price');
            $table->integer('PaymentMethod');
            $table->boolean('Status');
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
        Schema::dropIfExists('partner_ship_plans');
    }
}
