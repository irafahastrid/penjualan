<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\StokModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarangModel extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primary = 'id_barang';
    protected $fillable = ['nama_barang', 'kode_barang', 'harga'];
    public $timestamps = false;
    public function stok():HasOne
    {
        return $this->hasOne(StokModel::class,'id_barang','id_barang');
    }
    public function beli():HasMany
    {
        return $this->hasMany(BeliModel::class,'id_barang','id_barang');
    }
}
