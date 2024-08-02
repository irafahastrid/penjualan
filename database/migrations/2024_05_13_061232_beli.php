<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $table = 'beli';
    public function up(): void
    {
        //
        Schema::create($this->table,function(Blueprint $table){
            $table->integer('id_beli',true,false)->nullable(false);
            $table->integer('id_barang',false,false)->index('IdBarangBeli')->nullable(false);
            $table->dateTime('tanggal_beli',0)->default('2024-01-01')->nullable(false);
            $table->integer('jumlah_beli',false,false)->nullable(false);
            $table->decimal('harga_beli_satuan',10,2,false)->nullable(false); 
            $table->decimal('total_harga_beli',10,2,false)->nullable(false);
            $table->timestamps();
            //Foreign key barang
            $table->foreign('id_barang','ConstraintIdBarang')->on('barang')->references('id_barang')
                            ->onDelete('cascade')->onUpdate('cascade');
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
