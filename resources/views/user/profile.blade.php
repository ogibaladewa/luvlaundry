@extends('layouts.master')

@section('content')
    <div id="main-content">
        <div id="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center;">
                                <h2>PROFILE USER</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                
                            </div>
                            <div class="col-md-2">
                                <img src="{{$user->getAvatar()}}" width="100%" height="auto">
                            </div>
                            
                            <div class="col-md-8">
                                <table class="table">
                                    <tr>
                                        <th>Nama</th>
                                        <td>:</td>
                                        <td>{{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td>:</td>
                                        <td>{{$user->role}}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>:</td>
                                        <td>{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td>:</td>
                                        <td>{{$user->tempat_lahir}}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>:</td>
                                        <td>{{$user->tanggal_lahir}}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>:</td>
                                        <td>{{$user->jenis_kelamin}}</td>
                                    </tr>
                                    <tr>
                                        <th>No Telp.</th>
                                        <td>:</td>
                                        <td>{{$user->no_telp}}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>:</td>
                                        <td>{{$user->alamat}}</td>
                                    </tr>
                                    <tr>
                                        <th>Cabang</th>
                                        <td>:</td>
                                        <td>{{$user->cabang->nama_cabang}}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>:</td>
                                        <td>{{$user->status}}</td>
                                    </tr>
                                    <tr>
                                    </tr>
                                    
                                </table>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop