<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->string('SN', 20)->unique()->primary();
            $table->boolean('State')->default(0);
            $table->datetime('LastActivity')->nullable();
            $table->string('TransTimes', 50)->nullable();
            $table->integer('TransInterval')->default(1);
            $table->string('LogStamp', 20)->nullable();
            $table->string('OpLogStamp', 20)->nullable();
            $table->string('PhotoStamp', 20)->nullable();
            $table->string('Alias', 20)->nullable();
            $table->integer('DeptID')->nullable();
            $table->string('UpdateDB', 10)->nullable();
            $table->string('Style', 20)->nullable();
            $table->string('FWVersion', 30)->nullable();
            $table->integer('FPCount')->nullable();
            $table->integer('TransactionCount')->nullable();
            $table->integer('UserCount')->nullable();
            $table->string('MainTime', 20)->nullable();
            $table->integer('MaxFingerCount')->nullable();
            $table->integer('MaxAttLogCount')->nullable();
            $table->string('DeviceName', 30)->nullable();
            $table->string('AlgVer', 30)->nullable();
            $table->string('FlashSize', 10)->nullable();
            $table->string('FreeFlashSize', 10)->nullable();
            $table->string('Language', 30)->nullable();
            $table->string('VOLUME', 10)->nullable();
            $table->string('DtFmt', 10)->nullable();
            $table->string('IPAddress', 20)->nullable();
            $table->string('IsTFT', 5)->nullable();
            $table->string('Platform', 20)->nullable();
            $table->string('Brightness', 5)->nullable();
            $table->string('BackupDev', 30)->nullable();
            $table->string('OEMVendor', 30)->nullable();
            $table->string('City', 50)->nullable();
            $table->smallInteger('AccFun')->nullable();
            $table->smallInteger('TZAdj')->nullable();
            $table->smallInteger('DelTag')->nullable();
            $table->string('FPVersion', 10)->nullable();
            $table->string('PushVersion', 10)->nullable();
            $table->timestamps('created_at');

        });
    }

    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
