<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangStoreRequest;
use App\Models\BarangModel; 
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    //
    protected $id_barang;
    protected $nama_barang; 
    protected $kode_barang;
    protected $harga;
    protected $barangModel;

    public function construct()  
    {
        $this->barangModel = new BarangModel();
    }
    public function index(){
        /**
         * menampilkan daftar barang yang ada pada tabel barang
         * dan diparsing kedalam format tabel menggunakan template
         * yang disediakan oleh datatable
         */

          return view('barang.index');
    }

    public function tambah(){
        /**
         * Method ini akan menampilkan form htnml
         * untuk input data tambah barang
         */  
        return view('barang.tambah');
    }
    public function simpan(BarangStoreRequest $request){
        /**
         * Method ini untuk menyimpan ketabel barang
         * dari from data yang dikirim oleh method tambah
         */ 
    //if($request->ajax){
        $validated = $request->validated();
        if($validated){
            if(isset($request->id_barang)){
                $edit = BarangModel::where('id_barang', $request->id_barang)->update($validated);
                if($edit){
                    $pesan = [
                        'status' => 'success',
                        'pesan' => 'Data berhasil dibuat'
                    ];
                }
            }else{
                $perintah = BarangModel::create($validated);
                if($perintah){
                    $pesan = [
                        'status' => 'success',
                        'pesan' => 'Data berhasil dibuat'
                    ];
                }else{
                    $pesan = [
                        'status' => 'failed',
                        'pesan' => 'Data gagal ditambahkan'
                    ];
                }
            }
            }else{
                $pesan = [
                'status' => 'success',
                'pesan' => 'Data gagal ditambahkan, periksa kembali isian form yang diinput'
                ];
            }
            return response()->json($pesan);
        }

    //}       
    

    public function update(Request $request){
        /**
         * Method ini akan menampilkan from upfate/ubah data
         * yang akan dikirim dari method simpan
         */
        $data =[
            'barangDetil' => BarangModel::where('id_barang',$request->id_barang)->first()
        ];

        return view('barang.edit',$data);
    }
    public function delete(Request $request){
        /**
         * Method ini menghapus data yang dikirim dari
         * form AJAX yang sudah dikonfirmasi
         */
        $aksiHapus = BarangModel::where('id_barang',$request->id_barang)->delete();
        if($aksiHapus):
            $pesan = [
                'status' => 'success',
                'pesan'  => 'Data berhasil dihapus'
            ];
        else:
            $pesan = [
                'status' => 'error',
                'pesan'  => 'Data gagal dihapus'
            ];
        endif;
        return response()->json($pesan);
    }
    public function dataBarang(Request $request){
        /**
         * Method ini akan menjadi endpoint API untuk
         * Datatable serverside
         */
        if($request->ajax()):
           $data = BarangModel::with('stok')->get();
           return DataTables::of($data)->toJson();
    endif;
    }
    public function listBarang(Request $request){
        if($request->filled('term')):
            $data = BarangModel::select(['nama_barang','id_barang'])
                               ->where('nama_barang', 'LIKE', '%' . $request->get('q') . '%')->get();
            return response()->json($data);
        endif;
    }
}

