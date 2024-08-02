@extends('template/template')
@section('title','Riwayat Pembelian Barang')

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <H1>Data Beli Barang</H1>
            <div>
                <button class="btn btn-success btnBeliBarang" data-bs-title="Tambsah Stok Barang" data-bs-target='#modalForm' data-bs-toggle="modal" attr-href="{{route('beli.tambah')}}"><i class="bi bi-plus-circle"></i> Tambah Stok Barang </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table DataTable table-hovered table-bordered">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="card-footer">

        </div>
    </div>
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btnSimpanBarang" id="btnSimpan"><i class='bi bi-save'></i> Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class='bi bi-x-square'></i> Cancel</button>
                </div>
            </div>

        </div>
    </div>
</div>

</div>
@endsection

@section('footer')
<script type="module">
    const barangModel = document.querySelector('#modalForm');
    const modal = bootstrap.Modal.getOrCreateInstance(barangModel);

    function changeHTML(element, find, text) {
        $(element).find(find).html();
        return $(element).find(find).html(text).promise().done();
    }

    var table = $('.DataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{!!route('beli.data')!!}",
        columns: [{
               render:function(data,type,row){
                    return row.barang.kode_barang;
               }
            },
            { 
                render:function(data,type,row){
                    return row.barang.nama_barang;
               }
            },
            {
                data : 'tanggal_beli',
                name : 'tanggal_beli'
            },
            {
                data : 'jumlah_beli',
                name : 'jumlah_beli'
            },
            {
                data : 'harga_beli_satuan',
                name : 'harga_beli_satuan'
            },
            {
                data : 'total_harga_beli',
                name : 'total_harga_beli'

            },
            {
                render: function(data, type, row) {
                    return "<btn class='btn btn-primary editBtn' data-bs-toggle='modal' data-bs-target='#modalForm' attr-href='{!!url('/barang/edit/" + row.id_barang + "')!!}'><i class='bi bi-pencil'></i> Edit</btn> <btn class='btn btn-danger btnHapusBarang' attr-id='"+row.id_barang+"'><i class='bi bi-trash'></i> Delete</btn>"
                }
            },
        ]
    });
    //Hapus Callback
    $('.DataTable tbody').on('click','.btnHapusBarang',function(hapusEvent){
        let idBarang = $(this).closest('.btnHapusBarang').attr('attr-id');
        //alert(idBarang);
        Swal.fire({
            title: "Apakah anda sudah yakin?",
            text: "Data yang anda hapus tidak bisa dikembalikan lho!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Setuju, Hapus data!"
        }).then((result) => {
             if (result.isConfirmed) {
                let hapusData = {
                    'id_barang' : idBarang,
                    '_token'    : '{{csrf_token()}}'
                };
                axios.post('{{url("barang/hapus")}}',hapusData).then(response => {
                    if(response.data.status == 'success'){
                        Swal.fire({
                            title: 'Berhasil',
                            text : response.data.pesan,
                            icon : 'success'
                        }).then(()=>{
                            table.ajax.reload();
                        });
                    }else{

                    }
                });
                /*
                 Swal.fire({
                 title: "Deleted!",
                 text: "Your file has been deleted.",
                 icon: "success"
                 });
                 */
  }
});
        
    });
    //Edit Data Barang Callback
    $('.DataTable tbody').on('click', '.editBtn', function(event) {
        changeHTML('#modalForm', '.modal-title', 'Edit Data Barang');
        let modalForm = document.getElementById('modalForm');
        modalForm.addEventListener('shown.bs.modal', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            let link = event.relatedTarget.getAttribute('attr-href');
            axios.get(link).then(response => {
                $('#modalForm .modal-body').html(response.data);
            });

            //Aksi Simpan Button
            $('.btnSimpanBarang').on('click',function(editSimpanEvent){
                editSimpanEvent.stopImmediatePropagation();
                let dataEdit = {
                    'id_barang'   : $('#idBarang').val(),
                    'nama_barang' : $('#namaBarang').val(),
                    'kode_barang' : $('#kodeBarang').val(),
                    'harga'       : $('#hargaBarang').val(),
                    '_token'      : "{{csrf_token()}}"
                };

                axios.post('{{url("barang/simpan")}}',dataEdit).then(response => {
                    if(response.data.status =='success'){
                        Swal.fire({
                            title : "Berhasil",
                            text  : 'Data sudah berhasil diedit',
                            icon  : 'success'
                        }).then( () => {
                            modal.hide();
                            table.ajax.reload();
                        });
                    }else{
                        Swal.fire({
                            title : "OPpps. Error nih.",
                            text  : response.data.pesan,
                            icon  : 'error'
                        });
                    };
                });
            });
        });
        modalForm.addEventListener('hidden.bs.modal', function(closeEvent){
            closeEvent.preventDefault();
            closeEvent.stopImmediatePropagation();

            $('#modalFrom').removeData();
        });
    });
    

    //Tambah barang 
    $('.btnBeliBarang').on('click', function(a) {
        changeHTML('#modalForm', '.modal-title', 'Beli Barang');
        const modalfrom = document.getElementById('modalForm');
        modalForm.addEventListener('shown.bs.modal', function(eventTambah) {
            eventTambah.preventDefault();
            eventTambah.stopImmediatePropagation();
            const link = eventTambah.relatedTarget.getAttribute('attr-href');
            //alert(link)
            axios.get(link).then(response => {
                // $('#judulModal).html('<span  class="judulTambah">Tambah DATA BARANG</span>');
                $('#modalForm .modal-body').html(response.data);
                $('.autoDropdownBarang').select2({
                    placeholder    : 'Pilih barang yang ingin dibeli',
                    theme          : 'bootstrap-5',
                    cache          : true,
                    dropdownParent : $('#modalForm'),
                    ajax           : {
                        url : "{!! route('barang.list')!!}",
                        dataType : 'json',
                        processResults : function(data){
                            $.each(data,function(i,d){
                                //i = Iterasi ke n
                                //d = data dari iterasi i
                                data[i]['text'] = d.nama_barang;
                                data[i]['id']   = d.id_barang;
                            });
                            return {
                                    results: data
                                }
                        }
                    }
                });
            });

            //event simpan
            $('.btnSimpanBarang').on('click', function(submitEvent) {
                submitEvent.stopImmediatePropagation();
                var data = {
                    'id_barang' : $('#idBarang').val(),
                    'tanggal_beli' : $('#tanggalBeli').val(),
                    'jumlah_beli' : $('#jumlahBeli').val(),
                    'harga_beli_satuan' : $('#hargaBeliSatuan').val(),
                    '_token': "{{csrf_token()}}"
                }
                if (
                    data.id_barang !== '' &&
                     data.tanggal_beli !== '' && 
                     data.jumlah_beli !== ''  && 
                     data.harga_beli_satuan !== '') 
                     {
                    //console.log(data);
                    axios.post('beli/simpan', data).then(resp => {
                        if (resp.data.status == 'success') {

                            //tampilkan popup berhasil
                            Swal.fire({
                                title: "Berhasil!!!",
                                text: 'Data sudah berhasil ditambahkan',
                                icon: "success"
                            }).then(() => {
                                //Close modal  dan refresh datatables.
                                //Modal.getOrCreateInstance();
                                modal.hide();
                                table.ajax.reload();
                            });
                        } else {
                            //tampilkan popup gagal
                            Swal.fire({
                                title: "uppssss, gagal gmn dong!!",
                                text: resp.data.pesan,
                                icon: "eror"
                            });
                        }
                    });
                } else {
                    alert('data tidak boleh kosong');
                }
            });
        });
        modalForm.addEventListener('hidden.bs.modal', function(closeEvent) {
            closeEvent.preventDefault();
            closeEvent.stopImmediatePropagation();

            $('#modalForm').removeData();
        });
    });



    /** contoh pake ajax
    $.ajax({
        url: link,
        method: 'GET',
        success: function(response){
            $(".modal-header .modal-title").html(response);
        }
    });
    */
</script>
@endsection