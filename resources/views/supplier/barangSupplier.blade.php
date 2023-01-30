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
                                <h2> Detail Barang Supplier {{$data_barang_supplier->nama_supplier}}  @foreach($pivot as $apivot)
                        
                        {q}
                    @endforeach</h2>
                            </div>
                            <div class="col-md-6">
                                <button type="button" style="float:right" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                                    Tambah Barang
                                </button>
                            </div>
                        </div>
                        <table class="table table-hover no-margin" id="datatable">
							<thead>
								<tr>
                                    <th>KODE BARANG</th>
                                    <th>NAMA BARANG</th>
                                    
								</tr>
							</thead>
							<tbody>
                            @foreach($data_barang_supplier->barang as $barang)
                                <tr>
                                    <td>{{$barang->kode_barang}}</td>
                                    <td>{{$barang->nama_barang}}</td>
                                    <td><a href="/supplier/{{$barang->id}}/{{$data_barang_supplier->id}}/deleteBarang" class="btn btn-danger btn-sm" onclick="return confirm('Yakin Hapus Data?')"><i class="lnr lnr-trash"></i></a></td>
                                    
                                </tr> 
                            @endforeach
                                 
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
        <h2 class="modal-title" id="exampleModalLabel">Tambah Barang Supplier</h2>
      </div>
      <div class="modal-body">
        <form action="/supplier/addBarang" method="POST">
        {{csrf_field()}}
            <div class="field-detail">
                <div class="form-group{{$errors->has('barang') ? ' has-error' : ''}}">
                    <label for="exampleInputEmail1">Barang</label>
                    <select name="barang_id[]" class="form-control" id="exampleInputEmail1">
                    @foreach($data_barang as $barang)
                        <?php $hide = ''; ?>
                        @foreach($data_barang_supplier->barang as $apivot)
                            @if($barang->id == $apivot->id )
                            <?php $hide = 'disabled' ?>
                            @endif
                        @endforeach
                            <option value="{{$barang->id}}" {{$hide}}>{{$barang->nama_barang}}</option>
                    @endforeach
                    </select>
                    @if($errors->has('barang'))
                        <span class="help-block">{{$errors->first('barang')}}</span>
                    @endif
                </div>
            </div>
            <input type="hidden" name="supplier_id[]" value="{{$id}}">
            <div class="form-group">
                <a href="#" class="mt-4 btn btn-sm btn-primary" id="add-field"><i class="fa fa-plus"></i></a>             
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
    $(document).ready(function() {
        var btn_addfield = $('#add-field');
            var field_detail = $('.field-detail');
            
            var field = '<div id="new-field"><div class="form-group{{$errors->has('barang') ? ' has-error' : ''}}"><select name="barang_id[]" class="form-control" id="exampleInputEmail1"> @foreach($data_barang as $barang)'+
            '<?php $hide = ""; ?>@foreach($data_barang_supplier->barang as $apivot)@if($barang->id == $apivot->id )<?php $hide = "disabled" ?>@endif @endforeach <option value="{{$barang->id}}" {{$hide}}>{{$barang->nama_barang}}</option>'+
            '@endforeach</select>@if($errors->has('barang'))<span class="help-block">{{$errors->first('barang')}}</span>@endif </div>' +
            '<div class="form-group"><a href="#" id="delete-field"><i class="fa fa-minus"></i></a></div><input type="hidden" name="supplier_id[]" value="{{$id}}"></div>'
            btn_addfield.click(function(e){
                e.preventDefault();
            
                $(field_detail).append(field)
            });
            $(field_detail).on('click', '#delete-field', function(e){
                e.preventDefault();
                $('#new-field').remove();
        })
    } );
    </script>
@endsection
@stop

