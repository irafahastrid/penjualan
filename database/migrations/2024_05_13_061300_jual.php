<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'jual';
    public function up(): void
    {
        //
        Schema::create($this->table,function(Blueprint $table){
            $table->integer('id_jual',true,false)->nullable(false); 
            $table->integer('id_barang',false,false)->index('idBarangJual')->nullable(false);
            $table->dateTime('tanggal_jual',0)->default('2024-01-01')->nullable(false);
            $table->integer('jumlah_jual',false,false)->nullable(false)->default(0);
            $table->decimal('harga_jual_satuan',10,2,false)->nullable(true);
            $table->decimal('total_harga_jual',10,2,false)->nullable(true);
            //foreign key
            $table->foreign('id_barang')->on('barang')->references('id_barang')->onDelete('cascade')
                        ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists($this->table);
    }
};
