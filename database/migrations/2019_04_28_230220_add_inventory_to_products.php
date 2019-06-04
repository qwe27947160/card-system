<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class AddInventoryToProducts extends Migration { public function up() { if (!Schema::hasColumn('products', 'inventory')) { Schema::table('products', function (Blueprint $sp9e8103) { $sp9e8103->tinyInteger('inventory')->default(\App\User::INVENTORY_AUTO)->after('enabled'); $sp9e8103->tinyInteger('fee_type')->default(\App\User::FEE_TYPE_AUTO)->after('inventory'); }); } } public function down() { foreach (array('inventory', 'fee_type') as $sp3305d3) { try { Schema::table('products', function (Blueprint $sp9e8103) use($sp3305d3) { $sp9e8103->dropColumn($sp3305d3); }); } catch (\Throwable $sp1b3a33) { } } } }