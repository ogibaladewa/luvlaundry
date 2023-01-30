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
                                <h2> Tambah Penyediaan</h2>
                            </div>
                            <div class="col-md-6">
                            <a href="/penyediaan">
                                    <button type="button" style="float:right" class="btn btn-primary float-right">
                                        Lihat Data Penyediaan
                                    </button>
                                </a>
                            </div>
                        </div>
                        <form action="/penyediaan/add" method="GET" name="formBarang">
                            <div class="row">
                                <div class="col-md-6">
                                <label for="exampleInputEmail1">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-control" id="exampleInputEmail1" >
                                            @foreach($data_supplier as $supplier)
                                                <option value="{{$supplier->id}}" <?php if($supplier_id == $supplier->id){echo 'selected';} ?>>{{$supplier->nama_supplier}}</option>
                                            @endforeach
                                            </select>
                                            @if($errors->has('supplier_id'))
                                                <span class="help-block">{{$errors->first('supplier_id')}}</span>
                                            @endif
                                </select>
                                </div>
                                <div class="col-md-1">
                                <label for="exampleInputEmail1">Tampil</label>
                                <button type="submit" class="btn btn-primary">
                                    Tampilkan
                                </button>
                                </div>
                            </div>
                        </form>
                        <form action="/penyediaan/addPenyediaan" method="POST">
                        {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{$errors->has('supplier_id') ? ' has-error' : ''}}">
                                        <select style="display:none" name="supplier_id" class="form-control" id="exampleInputEmail1">
                                        @foreach($data_supplier as $supplier)
                                            <option value="{{$supplier->id}}" <?php if($supplier_id == $supplier->id){echo 'selected';} ?>>{{$supplier->nama_supplier}}</option>
                                        @endforeach
                                        </select>
                                        @if($errors->has('supplier_id'))
                                            <span class="help-block">{{$errors->first('supplier_id')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group{{$errors->has('tanggal') ? ' has-error' : ''}}">
                                        <label for="exampleInputEmail1">Tanggal</label>
                                        <input name="tanggal" type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="tanggal" value="{{old('tanggal')}}">
                                        @if($errors->has('tanggal'))
                                            <span class="help-block">{{$errors->first('tanggal')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="field-detail">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group{{$errors->has('barang') ? ' has-error' : ''}}">
                                            <label for="exampleInputEmail1">Barang</label>
                                            <select name="barang_id[]" class="form-control" id="exampleInputEmail1">
                                            @foreach($data_barang as $barang)
                                                <option value="{{$barang->id}}">{{$barang->nama_barang}}</option>
                                            @endforeach
                                            </select>
                                            @if($errors->has('barang'))
                                                <span class="help-block">{{$errors->first('barang')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group{{$errors->has('qty') ? ' has-error' : ''}}">
                                            <label for="exampleInputEmail1">Qty</label>
                                            <input name="qty[]" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{old('qty')}}">
                                            @if($errors->has('qty'))
                                                <span class="help-block">{{$errors->first('qty')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{$errors->has('harga') ? ' has-error' : ''}}">
                                            <label for="exampleInputEmail1">Harga/pcs</label>
                                            <input name="harga[]" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{old('harga')}}">
                                            @if($errors->has('harga'))
                                                <span class="help-block">{{$errors->first('harga')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="#" class="mt-4 btn btn-sm btn-primary" id="add-field"><i class="fa fa-plus"></i></a>             
                            </div>
                            
                            <input type="hidden" name="cabang_id" value="{{auth()->user()->cabang_id}}">
                            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">

                            
                            
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
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
                {data:'tanggal',name:'tanggal'},
                {data:'cabang',name:'cabang'},
                {data:'supplier',name:'supplier'},
                {data:'user',name:'user'},
                {data:'aksi',name:'aksi'},
            ]
        });

        var btn_addfield = $('#add-field');
        var field_detail = $('.field-detail');
        
        var field = '<div id="new-field"><div class="row"><div class="col-md-4"><div class="form-group{{$errors->has('barang') ? ' has-error' : ''}}"><select name="barang_id[]" class="form-control" id="exampleInputEmail1"> @foreach($data_barang as $barang)'+
        '<option value="{{$barang->id}}">{{$barang->nama_barang}}</option>@endforeach</select>@if($errors->has('barang'))<span class="help-block">{{$errors->first('barang')}}</span>@endif </div> </div>' +
        '<div class="col-md-2"><div class="form-group{{$errors->has('qty') ? ' has-error' : ''}}"><input name="qty[]" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{old('qty')}}">@if($errors->has('qty'))<span class="help-block">{{$errors->first('qty')}}</span>@endif </div></div>' +
        '<div class="col-md-3"><div class="form-group{{$errors->has('harga') ? ' has-error' : ''}}"><input name="harga[]" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{old('harga')}}">@if($errors->has('harga'))<span class="help-block">{{$errors->first('harga')}}</span>@endif</div></div>' +
        '<div class="form-group"><a href="#" id="delete-field"><i class="fa fa-minus"></i></a></div></div></div>'
        btn_addfield.click(function(e){
            e.preventDefault();
        
            $(field_detail).append(field)
        });
        $(field_detail).on('click', '#delete-field', function(e){
            e.preventDefault();
            $('#new-field').remove();
        })
    });
    </script>
@endsection
@stop

