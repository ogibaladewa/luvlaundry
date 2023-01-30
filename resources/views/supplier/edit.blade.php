@extends('layouts.master')
@section('content')
<div id="main-content">
    <div id="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-content">
                <h2>Edit Data Supplier</h2>
                    <form action="/supplier/{{$supplier->id}}/update" method="POST">
                    {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Supplier</label>
                            <input name="nama_supplier" type="text" class="form-control" id="exampleInputEmail1" 
                            aria-describedby="emailHelp" placeholder="Nama Supplier" value="{{$supplier -> nama_supplier}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">No Telepon</label>
                            <input name="no_telp" type="text" class="form-control" id="exampleInputEmail1" 
                            aria-describedby="emailHelp" placeholder="No Telepon" value="{{$supplier -> no_telp}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input name="email" type="email" class="form-control" id="exampleInputEmail1" 
                            aria-describedby="emailHelp" placeholder="Email" value="{{$supplier -> email}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Alamat</label>
                            <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$supplier -> alamat}}</textarea>
                        </div>
                        <div class="form-group{{$errors->has('status') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Status</label>
                            <select name="status" class="form-control" id="exampleInputEmail1">
                                <option value="Active" @if($supplier->status ==  'Active') selected @endif>Active</option>
                                <option value="Inactive" @if($supplier->status ==  'Inactive') selected @endif>Inactive</option>
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