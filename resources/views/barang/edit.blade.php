@extends('layouts.master')
@section('content')
<div id="main-content">
    <div id="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-content">
                <h2>Edit Data Barang</h2>
                    <form action="/barang/{{$barang->id}}/update" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <div class="form-group{{$errors->has('nama_barang') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Nama Barang</label>
                            <input name="nama_barang" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama Barang" value="{{$barang->nama_barang}}">
                            @if($errors->has('nama_barang'))
                                <span class="help-block">{{$errors->first('nama_barang')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('satuan') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Satuan</label>
                            <input name="satuan" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="No Telepon" value="{{$barang->satuan}}">
                            @if($errors->has('satuan'))
                                <span class="help-block">{{$errors->first('satuan')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('deskripsi') ? ' has-error' : ''}}">
                            <label for="exampleFormControlTextarea1">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$barang->deskripsi}}</textarea>
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
                        <div class="form-group{{$errors->has('status') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Status</label>
                            <select name="status" class="form-control" id="exampleInputEmail1">
                                <option value="Active" @if($barang->status ==  'Active') selected @endif>Active</option>
                                <option value="Inactive" @if($barang->status ==  'Inactive') selected @endif>Inactive</option>
                            </select>
                            @if($errors->has('status'))
                                <span class="help-block">{{$errors->first('status')}}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop