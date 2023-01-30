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
                                <h2> Data Supplier</h2>
                            </div>
                            <div class="col-md-6">
                                <button type="button" style="float:right" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                                    Tambah Data Supplier
                                </button>
                                <a href="/supplier/exportPDF">
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
                                                <th>NAMA SUPPLIER</th>
                                                <th>NO TELP.</th>
                                                <th>EMAIL</th>
                                                <th>ALAMAT</th>
                                                <th>STATUS</th>
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
        <h2 class="modal-title" id="exampleModalLabel">Tambah Data Supplier</h2>
      </div>
      <div class="modal-body">
        <form action="/supplier/create" method="POST">
        {{csrf_field()}}
            <div class="form-group{{$errors->has('nama_supplier') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Nama Supplier</label>
                <input name="nama_supplier" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Supplier"  value="{{old('nama_supplier')}}">
                @if($errors->has('nama_supplier'))
                    <span class="help-block">{{$errors->first('nama_supplier')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('no_telp') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">No Telepon</label>
                <input name="no_telp" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="No Telepon"  value="{{old('no_telp')}}">
                @if($errors->has('no_telp'))
                    <span class="help-block">{{$errors->first('no_telp')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Email</label>
                <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email"  value="{{old('email')}}">
                @if($errors->has('email'))
                    <span class="help-block">{{$errors->first('email')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('alamat') ? ' has-error' : ''}}">
                <label for="exampleFormControlTextarea1">Alamat</label>
                <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3">{{old('alamat')}}</textarea>
                @if($errors->has('alamat'))
                    <span class="help-block">{{$errors->first('alamat')}}</span>
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
            ajax:"{{route('ajax.get.data.supplier')}}",
            columns:[
                {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'nama_supplier',name:'nama_supplier'},
                {data:'no_telp',name:'no_telp'},
                {data:'email',name:'email'},
                {data:'alamat',name:'alamat'},
                {data:'status',name:'status'},
                {data:'aksi',name:'aksi'},
            ]
        })
    });
    </script>
@endsection
@stop

