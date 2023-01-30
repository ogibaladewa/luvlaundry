@extends('layouts.master')

@section('content')
    <div id="main-content">
        <div id="container-fluid">
            <div class="row">
            
                <div class="col-md-12">
                    <div class="panel-content">
                    @if(session('sukses'))
                    <div class="alert alert-success" role="alert">
                        Data Berhasil Ditambahkan !
                    </div>
                    @endif
                    @if(session('editsukses'))
                    <div class="alert alert-success" role="alert">
                        Data Berhasil Diubah!
                    </div>
                    @endif
                    @if(session('hapus'))
                    <div class="alert alert-success" role="alert">
                        Data Berhasil Dihapus !
                    </div>
                    @endif
                        <div class="row">
                            <div class="col-md-6">
                                <h2> Data Penyediaan</h2>
                            </div>
                            <div class="col-md-6">
                                <a href="/penyediaan/add">
                                    <button type="button" style="float:right" class="btn btn-primary float-right">
                                        Tambah Data Penyediaan
                                    </button>
                                </a>
                                <a href="/penyediaan/exportPDF">
                                    <button type="button" style="float:right; margin-right:5px;" class="btn btn-danger float-right">
                                        <i class="fa fa-save"></i> &nbsp;PDF
                                    </button>
                                </a>
                            </div>
                        </div>
                        <table class="table table-hover no-margin" id="datatable">
							<thead>
								<tr>
                                    <th>NO.</th>
                                    <th style="text-align:left;">TANGGAL</th>
                                    <th>CABANG</th>
                                    <th>DIBELI DARI</th>
                                    <th>PENCATAT</th>
                                    <th>AKSI</th>
								</tr>
							</thead>
							<tbody>
                                        
							</tbody>
						</table>   
                    </div>
                </div>
            </div>
        </div>
    </div>

  @section('script')
    @if (count($errors) > 0)
	    <script>
        $(document).ready(function() {
            $('#exampleModal').modal('show');
        } );
	    </script>
    @endif
  
    <script>
    $(document).ready(function() 
    {
        $('#datatable').DataTable({
            processing:true,
            serverside:true,
            ajax:"{{route('ajax.get.data.penyediaan')}}",
            columns:[
                {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'tanggalO',name:'tanggalO'},
                {data:'cabang',name:'cabang'},
                {data:'supplier',name:'supplier'},
                {data:'user',name:'user'},
                {data:'aksi',name:'aksi'},
            ]
        })
    });
    </script>
@endsection
@stop

