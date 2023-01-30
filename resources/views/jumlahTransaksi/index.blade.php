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
                    @if(session('gagal'))
                    <div class="alert alert-danger" role="alert">
                        Data Untuk Periode Tersebut Sudah Ada !
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
                                <h2> Data Jumlah Transaksi</h2>
                            </div>
                            <div class="col-md-6">
                                <button type="button" style="float:right" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                                    Tambah Data Jumlah Transaksi
                                </button>
                                <a href="/jumlahTransaksi/exportPDF">
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
                                    <th>PERIODE</th>
                                    <th style="text-align:left">JUMLAH</th>
                                    <th style="text-align:left">TOTAL BERAT(kg)</th>
                                    <th>CABANG</th>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="modal-title" id="exampleModalLabel">Tambah Data Jumlah Transaksi</h2>
      </div>
      <div class="modal-body">
        <form action="/jumlahTransaksi/create" method="POST">
        {{csrf_field()}}
            <div class="form-group{{$errors->has('periode') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Periode</label>
                <input name="periode" type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{old('periode')}}">
                @if($errors->has('periode'))
                    <span class="help-block">{{$errors->first('periode')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('jumlah') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Jumlah</label>
                <input name="jumlah" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Jumlah" value="{{old('jumlah')}}">
                @if($errors->has('jumlah'))
                    <span class="help-block">{{$errors->first('jumlah')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('total_berat') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Total Berat</label>
                <input name="total_berat" type="number"  step="0.01" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Total Berat" value="{{old('total_berat')}}">
                @if($errors->has('total_berat'))
                    <span class="help-block">{{$errors->first('total_berat')}}</span>
                @endif
            </div>
            <input type="hidden" name="cabang_id" value="{{auth()->user()->cabang_id}}">
            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
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
            ajax:"{{route('ajax.get.data.jumlahtransaksi')}}",
            columns:[
                {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'periodeO',name:'periodeO'},
                {data:'jumlah',name:'jumlah'},
                {data:'total_berat',name:'total_berat'},
                {data:'cabang',name:'cabang'},
                {data:'user',name:'user'},
                {data:'aksi',name:'aksi'},
            ],
            columnDefs: [
                {"className": "dt-right", "targets": [2,3]}
            ]
        })
    });
    </script>
@endsection
@stop

