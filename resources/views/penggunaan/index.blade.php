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
                                <h2> Data Penggunaan</h2>
                            </div>
                            <div class="col-md-6">
                                <button type="button" style="float:right" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                                    Tambah Data Penggunaan
                                </button>
                                <a href="/penggunaan/exportPDF">
                                    <button type="button" style="float:right; margin-right:5px;" class="btn btn-danger float-right">
                                        <i class="fa fa-save"></i> &nbsp;PDF
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                               
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                        <table class="table table-hover no-margin" id="datatable">
							<thead>
								<tr>
                                  <th>NO.</th>
                                  <th>TANGGAL</th>
                                  <th>BARANG</th>
                                  <th>CABANG</th>
                                  <th style="text-align:left;">TERPAKAI</th>
                                  <th>SATUAN</th>
                                  <th>PENCATAT</th>
                                  <th>AKSI</th>
								</tr>
							</thead>
							<tbody>
                            
							</tbody>
						</table>
                        <div class="row">
                            <div class="col-md-12">
                                
                            </div>
                        </div>  
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
            <h2 class="modal-title" id="exampleModalLabel">Tambah Data Penggunaan</h2>   
      </div>
      <div class="modal-body">
        <form name="tambah_penggunaan" action="/penggunaan/create" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        
            <div class="form-group{{$errors->has('tanggal') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Tanggal</label>
                <input name="tanggal" type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{old('tanggal')}}">
                @if($errors->has('tanggal'))
                    <span class="help-block">{{$errors->first('tanggal')}}</span>
                @endif
            </div>
                                
            <div class="form-group{{$errors->has('barang_id') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Barang</label>
                <select name="barang_id" class="form-control" id="exampleInputEmail1">
                @foreach($data_barang as $barang)
                    <option value="{{$barang->id}}">{{$barang->nama_barang}}</option>
                @endforeach
                </select>
                @if($errors->has('barang_id'))
                    <span class="help-block">{{$errors->first('barang_id')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('terpakai') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Terpakai</label>
                <input name="terpakai" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{old('terpakai')}}">
                @if($errors->has('terpakai'))
                    <span class="help-block">{{$errors->first('terpakai')}}</span>
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
            ajax:"{{route('ajax.get.data.penggunaan')}}",
            columns:[
                {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'tanggalO',name:'tanggalO'},
                {data:'barang',name:'barang'},
                {data:'cabang',name:'cabang'},
                {data:'terpakai',name:'terpakai'},
                {data:'satuan',name:'satuan'},
                {data:'user',name:'user'},
                {data:'aksi',name:'aksi'},
            ],
            columnDefs: [
                {"className": "dt-right", "targets": [4]}
            ]
        })
    });
    </script>
@endsection



@stop

