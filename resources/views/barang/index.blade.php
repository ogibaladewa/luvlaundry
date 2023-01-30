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
                                <h2> Data Barang</h2>
                            </div>
                            <div class="col-md-6">
                                <button type="button" style="float:right" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                                    Tambah Data Barang
                                </button>
                                <a href="/barang/exportPDF">
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
                                  <th>KODE BARANG</th>
                                  <th>NAMA BARANG</th>
                                  <th>SATUAN</th>
                                  <th>KATEGORI</th>
                                  <th>STATUS</th>
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
            <h2 class="modal-title" id="exampleModalLabel">Tambah Data Barang</h2>   
      </div>
      <div class="modal-body">
        <form name="tambah_barang" action="/barang/create" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
            <div class="form-group{{$errors->has('kode_barang') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Kode Barang</label>
                <input name="kode_barang" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Kode Barang" value="{{old('kode_barang')}}">
                @if($errors->has('kode_barang'))
                    <span class="help-block">{{$errors->first('kode_barang')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('nama_barang') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Nama Barang</label>
                <input name="nama_barang" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Barang" value="{{old('nama_barang')}}">
                @if($errors->has('nama_barang'))
                    <span class="help-block">{{$errors->first('nama_barang')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('satuan') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Satuan</label>
                <input name="satuan" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Satuan" value="{{old('satuan')}}">
                @if($errors->has('satuan'))
                    <span class="help-block">{{$errors->first('satuan')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('kategori_id') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Kategori</label>
                <select name="kategori_id" class="form-control" id="exampleInputEmail1">
                @foreach($data_kategori as $kategori)
                    <option value="{{$kategori->id}}">{{$kategori->nama_kategori}}</option>
                @endforeach
                </select>
                @if($errors->has('kategori_id'))
                    <span class="help-block">{{$errors->first('kategori_id')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('deskripsi') ? ' has-error' : ''}}">
                <label for="exampleFormControlTextarea1">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" id="exampleFormControlTextarea1" rows="3">{{old('deskripsi')}}</textarea>
                @if($errors->has('deskripsi'))
                    <span class="help-block">{{$errors->first('deskripsi')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('foto') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Foto</label>
                <input type="file" name="foto" class="form-control">
                @if($errors->has('foto'))
                    <span class="help-block">{{$errors->first('foto')}}</span>
                @endif
            </div>
            <input type="hidden" name="status" value="Active">
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
            ajax:"{{route('ajax.get.data.barang')}}",
            columns:[
                {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'kode_barang',name:'kode_barang'},
                {data:'nama_barang',name:'nama_barang'},
                {data:'satuan',name:'satuan'},
                {data:'kategori',name:'kategori'},
                {data:'status',name:'status'},
                {data:'aksi',name:'aksi'},
                
            ]
        })
    });
    </script>
@endsection



@stop

