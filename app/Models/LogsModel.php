<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsModel extends Model
{
    use HasFactory;
    protected $table = 'logs';
    protected $primary = 'id_logs';
    protected $fillable = ['pesan', 'tanggal'];
}
