<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use Illuminate\Http\Request;

class StokController extends Controller
{
    //
    protected $id_stok;
    protected $jumlah_stok;
    protected $id_barang;
    protected $stokModel;

    public function __construct()  
    {
        $this->stokModel = new StokModel();
    }

    public function lihat(Request $request){
        /**
         * Method ini untuk melihat stok
         */
    }

}
