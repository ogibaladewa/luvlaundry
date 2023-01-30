@extends('layouts.master')
@section('content')
<div id="main-content">
    <div id="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-content">
                <h2>Edit Data User</h2>
                    <form action="/user/{{$user->id}}/update" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <div class="form-group{{$errors->has('name') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Nama</label>
                            <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama User" value="{{$user->name}}">
                            @if($errors->has('name'))
                                <span class="help-block">{{$errors->first('name')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('role') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Jabatan</label>
                            <select name="role" class="form-control" id="exampleInputEmail1">
                                <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
                                <option value="owner" @if($user->role == 'owner') selected @endif>Owner</option>
                                <option value="pegawai" @if($user->role == 'pegawai') selected @endif>Pegawai</option>
                            </select>
                            @if($errors->has('role'))
                                <span class="help-block">{{$errors->first('role')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Email</label>
                            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" value="{{$user->email}}">
                            @if($errors->has('email'))
                                <span class="help-block">{{$errors->first('email')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('tempat_lahir') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Tempat Lahir</label>
                            <input name="tempat_lahir" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Tempat Lahir" value="{{$user->tempat_lahir}}">
                            @if($errors->has('tempat_lahir'))
                                <span class="help-block">{{$errors->first('tempat_lahir')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('tanggal_lahir') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Tanggal Lahir</label>
                            <input name="tanggal_lahir" type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Tanggal Lahir" value="{{$user->tanggal_lahir}}">
                            @if($errors->has('tanggal_lahir'))
                                <span class="help-block">{{$errors->first('tanggal_lahir')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('jenis_kelamin') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" id="exampleInputEmail1">
                                <option value="L" @if($user->role ==  'L') selected @endif>Laki-Laki</option>
                                <option value="P" @if($user->role ==  'P') selected @endif>Perempuan</option>
                            </select>
                            @if($errors->has('role'))
                                <span class="help-block">{{$errors->first('jenis_kelamin')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('no_telp') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">No Telepon</label>
                            <input name="no_telp" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="No Telepon" value="{{$user->no_telp}}">
                            @if($errors->has('no_telp'))
                                <span class="help-block">{{$errors->first('no_telp')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('alamat') ? ' has-error' : ''}}">
                            <label for="exampleFormControlTextarea1">Alamat</label>
                            <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$user->alamat}}</textarea>
                            @if($errors->has('alamat'))
                                <span class="help-block">{{$errors->first('alamat')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('avatar') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Avatar</label>
                            <input type="file" name="avatar" class="form-control">
                            @if($errors->has('avatar'))
                                <span class="help-block">{{$errors->first('avatar')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('status') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Status</label>
                            <select name="status" class="form-control" id="exampleInputEmail1">
                                <option value="Active" @if($user->status ==  'Active') selected @endif>Active</option>
                                <option value="Inactive" @if($user->status ==  'Inactive') selected @endif>Inactive</option>
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