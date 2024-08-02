<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class BeliModel extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $table = 'beli';
    protected $primary = 'id_beli';
    protected $fillable = [
        'id_barang', 'tanggal_beli', 
        'jumlah_beli', 'harga_beli_satuan',
         'total_harga_beli'
    ];
    public function barang(): BelongsTo
    {
        return $this->belongsTo(BarangModel::class,'id_barang','id_barang','inner');
    }
}
