<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class CreatePaysTable extends Migration { public function up() { Schema::create('pays', function (Blueprint $sp9e8103) { $sp9e8103->increments('id'); $sp9e8103->string('name'); $sp9e8103->integer('sort')->default(1000); $sp9e8103->string('img'); $sp9e8103->string('driver'); $sp9e8103->string('way'); $sp9e8103->text('config'); $sp9e8103->text('comment')->nullable(); $sp9e8103->float('fee_system', 8, 4)->default(0.01); $sp9e8103->boolean('enabled'); $sp9e8103->timestamps(); }); } public function down() { Schema::dropIfExists('pays'); } }