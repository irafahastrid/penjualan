<?php

namespace App\Http\Controllers;

use App\Models\LogsModel;
use Illuminate\Http\Request;

class logsController extends Controller
{
    //
    protected $id_logs;
    protected $pesan;
    protected $tanggal;
    protected $logsModel;

    public function __construct()  
    {
        $this->logsModel = new LogsModel();
    }

    public function lihat(Request $request){
        //method ini untuk melihat logs

    }
    public function bersihkkan(Request $request){
        //metod ini untuk 
    }
}
