<?php

namespace App\Http\Controllers;

use App\Models\JualModel; 
use Illuminate\Http\Request;

class JualController extends Controller
{
    //
    protected $id_jual;
    protected $id_barang; 
    protected $jumlah_jual;
    protected $harga_jual_satuan;
    protected $total_harga_jual;
    protected $tanggal_jual;
    protected $jualModel;

    public function __construct()  
    {
        $this->jualModel = new JualModel();
    }
    public function index(){
        /**
         * menampilkan daftar jual barang yang ada pada tabel barang
         * dan diparsing kedalam format tabel menggunakan template
         * yang disediakan oleh datatable
         */

         $data = [
            'jualList' => $this->jualModel::all()
        ];

         /**
          * tampilkan $data kedalam view
          * file barang/list.blade.php
          */
          return view('jual.list',$data);
    }

    public function jual(){
        /**
         * Method ini akan menampilkan form htnml
         * untuk input data yang dijual
         * data form akan dikirim kecontroller jual
         */
    }
    public function simpan(){
        /**
         * Method ini akan menyimpan data yang dikirim 
         * Method simpan
         */ 
    }
    public function laporan(Request $request){
        /**
         * Method ini akan menampilkan laporan jual
         * Method laporan
         */ 
    }
}
 