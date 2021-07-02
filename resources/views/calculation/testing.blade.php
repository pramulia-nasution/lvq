@extends('layouts.template')

@section('breadcrumb')
    <h3 class="animated fadeInLeft">Data Testing</h3>
@endsection

@section('content')
    <div class="col-md-12 padding-0">
        <div style="margin-bottom:20px;">
            <a href="#" onclick="Import()" class="btn btn-primary btn-3d"><i class="fa fa-download"></i> Import Data</a>
            <a href="#" onclick="Truncate()" class="btn btn-danger btn-3d"><i class="fa fa-trash"></i> kosongkan Data</a>
            <a href="#" onclick="Tambah()" class="btn btn-success btn-3d"><i class="fa fa-plus"></i> Tambah Data</a>
        <div class="pull-right">
            <form id="form-metode" method="POST" class="form-inline">
                @csrf
                <div class="form-group">
                    <label class="control-label" for="metode">Pilih Metode</label>
                    <select style="width: 100px;" class="form-control" name="type" id="metode">
                        <option value="">-Pilih-</option>
                        <option value="1">LVQ 1</option>
                        <option value="2">LVQ 2.1</option>
                        <option value="3">LVQ 3</option>
                    </select>
                    <button type="submit" id="test" class="btn btn-info btn-round">Generate</button>
                </div>
            </form>
        </div>
        </div> 
        <div class="table-responsive">
            <table class="table bordered table-stripped">
                <thead>
                    <tr style="font-size: 10px;">
                        <th>X1</th><th>X2</th><th>X3</th><th>X4</th><th>X5</th>
                        <th>X6</th><th>X7</th><th>X8</th><th>X9</th><th>X10</th>
                        <th>X11</th><th>X12</th><th>X13</th><th>X14</th><th>X15</th>
                        <th>X16</th><th>X17</th><th>X18</th><th>X19</th><th>X20</th>
                        <th>X21</th><th>X22</th><th>X23</th><th>X24</th><th>X25</th>
                        <th>X26</th><th>X27</th><th>X28</th><th>X29</th><th>X30</th>
                        <th>X31</th><th>X32</th><th>X33</th><th>X34</th><th>Target</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        @include('data.formImport')
        @include('data.form_add')
    </div>

    <style>
        tr{
            font-size:9px;
        }
    </style>
@endsection  

@section('js')
    <script type="text/javascript">
        var tabel;
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            width:200,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        function msg(ic,tit){
            Toast.fire({icon: ic,title: tit })
        }
        $(document).ready(function(){
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        //Support()
            tabel = $('.table').DataTable({
                oLanguage: {
                    sSearch       :"<i class='fa fa-search fa-fw'></i> Cari: ",
                    sLengthMenu   :"Tampilkan _MENU_ data", 
                    sInfo         :"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    sInfoFiltered :"(disaring dari _MAX_ total data)", 
                    sZeroRecords  :"Oops..data kosong", 
                    sEmptyTable   :"Data kosong.", 
                    sInfoEmpty    :"Menampilkan 0 sampai 0 data",
                    sProcessing   :"Sedang memproses...", 
                    oPaginate: {
                        sPrevious :"Sebelumnya",
                        sNext     :"Selanjutnya",
                        sFirst    :"Pertama",
                        sLast     :"Terakhir"
                    }
                },
                processing:true,
                serverSide:true,
                ajax:"{{route('data.testing')}}",
                columns: [
                    {data:'x1'},{data:'x2'},{data:'x3'},{data:'x4'},{data:'x5'},
                    {data:'x6'},{data:'x7'},{data:'x8'},{data:'x9'},{data:'x10'},
                    {data:'x11'},{data:'x12'},{data:'x13'},{data:'x14'},{data:'x15'},
                    {data:'x16'},{data:'x17'},{data:'x18'},{data:'x19'},{data:'x20'},
                    {data:'x21'},{data:'x22'},{data:'x23'},{data:'x24'},{data:'x25'},
                    {data:'x26'},{data:'x27'},{data:'x28'},{data:'x29'},{data:'x30'},
                    {data:'x31'},{data:'x32'},{data:'x33'},{data:'x34'},{data:'target'},
                ]
            });

            $('#form').on('submit',function(e){
                e.preventDefault();
                $('#submit').text('Menambah...').attr('disabled',true);
                $.ajax({
                    url:"{{route('store.testing')}}",
                    method:"POST",
                    data: $('#form').serialize(),
                    dataType:"JSON",
                    beforeSend:function(){
                        $('#modal-form').modal('hide');
                        Swal.showLoading()
                    },
                    success:function(res){
                        tabel.ajax.reload();
                        $('#submit').text('Tambah').attr('disabled',false);
                        msg('success','Tambah Data Berhasil')
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        $('#submit').text('Tambah').attr('disabled',false);
                        msg('error','Tambah Data Gagal')
                    }
                })
            })

            $('#form-metode').on('submit', function (e){
                e.preventDefault();
                $('#test').text('Menggenerate...').attr('disabled',true);
                $.ajax({
                    url: "{{route('generate.testing')}}",
                    method:"POST",
                    data: $('#form-metode').serialize(),
                    dataType: "JSON",
                    beforeSend:function(e){
                        Swal.showLoading()
                    },
                    success:function(e){
                        tabel.ajax.reload();
                        $('#test').text('Generate').attr('disabled',false);
                        if(e.status){
                            msg('success','Sukses generate Hasil');
                        }else{
                            msg('error','Gagal generate hasil');
                        }
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        $('#test').text('Generate').attr('disabled',false);
                        msg('error','Gagal generate hasil');
                    }
                })

            })

            $('#form-import').on('submit',function(e){
                e.preventDefault();
                $('#import').text('Mengimport...').attr('disabled',true);
                $.ajax({
                    url: "{{route('import.testing')}}",
                    method:"post",
                    data: new FormData(this),
                    cache:false,
                    contentType:false,
                    processData:false,
                    beforeSend:function(){
                    $('#modal-import').modal('hide');
                        Swal.showLoading()
                    },
                    success:function(res){
                        tabel.ajax.reload();
                        $('#import').text('Import').attr('disabled',false);
                        msg('success','Import Data Sukses')
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        $('#import').html('Import').attr('disabled',false);
                        msg('error','Import Data Gagal')
                    }
                })
            });
        });

        function Import(){
            $('#form-import')[0].reset();
            $('.modal-title').text('Import Data');
            $('#modal-import').modal('show');
        }

        function Tambah(){
            $('#form')[0].reset();
            $('.modal-title').text('Tambah Data');
            $('#modal-form').modal('show');
        }

        function Truncate(){
            Swal.fire({
            title: 'Ingin kosongkan data?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((res)=>{
            if(res.value){
                $.ajax({
                    url:"{{route('truncate.testing')}}",
                    type:"DELETE",
                    success:function(res){
                        tabel.ajax.reload();
                        msg('success','Data dihapus')
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        msg('error','Data Gagal dihapus')
                    }
                });
            }
        });
    }
    </script>
    
@endsection