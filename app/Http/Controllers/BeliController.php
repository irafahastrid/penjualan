<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeliRequest;
use App\Http\Requests\StroreRequestBeli;
use App\Models\BeliModel; 
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class BeliController extends Controller
{
    //
    /*
    */
    public function index(Request $request){
        if($request->ajax()){
            $data = BeliModel::with('barang')->get();
            return DataTables::of($data)->toJson();
        }
        return view('beli.index');
    }
    public function simpan(StoreBeliRequest $request){

        $data = $request->validated();

        $data['total_harga_beli'] = $request->harga_beli_satuan * $request->jumlah_beli;

        $insert = BeliModel::create($data);

        if($insert):
            $pesan = [
                'status' => 'success',
                'pesan' => 'Pembeliin berhasil dilakukan'
            ];
        else:
            $pesan = [
                'status' => 'error',
                'pesan' => 'Pembelian gagal dilakukan'
            ];
        endif;

        return response()->json($pesan);
    }
    public function tambah(){
        //Menampilkan form tambah barang
        return view('beli.tambah');
    }

}