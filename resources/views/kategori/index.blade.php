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
                                <h2> Data Kategori</h2>
                            </div>
                            <div class="col-md-6">
                                <button type="button" style="float:right" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                                    Tambah Data Kategori
                                </button>
                                <a href="/kategori/exportPDF">
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
                                    <th>NAMA KATEGORI</th>
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
        <h2 class="modal-title" id="exampleModalLabel">Tambah Data Kategori</h2>
      </div>
      <div class="modal-body">
        <form action="/kategori/create" method="POST">
        {{csrf_field()}}
            <div class="form-group{{$errors->has('nama_kategori') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Nama Kategori</label>
                <input name="nama_kategori" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Kategori"  value="{{old('nama_kategori')}}">
                @if($errors->has('nama_kategori'))
                    <span class="help-block">{{$errors->first('nama_kategori')}}</span>
                @endif
            </div>

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
            ajax:"{{route('ajax.get.data.kategori')}}",
            columns:[
                {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'nama_kategori',name:'nama_kategori'},
                {data:'aksi',name:'aksi'},
            ]
        })
    });

    
    </script>
@endsection
@stop

