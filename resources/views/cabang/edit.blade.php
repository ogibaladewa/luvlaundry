@extends('layouts.master')
@section('content')
<div id="main-content">
    <div id="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-content">
                <h2>Edit Data Cabang</h2>
                    <form action="/cabang/{{$cabang->id}}/update" method="POST">
                    {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Cabang</label>
                            <input name="nama_cabang" type="text" class="form-control" id="exampleInputEmail1" 
                            aria-describedby="emailHelp" placeholder="Nama Cabang" value="{{$cabang -> nama_cabang}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Telepon</label>
                            <input name="no_telp" type="text" class="form-control" id="exampleInputEmail1" 
                            aria-describedby="emailHelp" placeholder="No Telepon" value="{{$cabang -> no_telp}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Alamat</label>
                            <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$cabang -> alamat}}</textarea>
                        </div>
                        <div class="form-group{{$errors->has('status') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Status</label>
                            <select name="status" class="form-control" id="exampleInputEmail1">
                                <option value="Active" @if($cabang->status ==  'Active') selected @endif>Active</option>
                                <option value="Inactive" @if($cabang->status ==  'Inactive') selected @endif>Inactive</option>
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