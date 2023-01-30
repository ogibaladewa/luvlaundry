@extends('layouts.master')

@section('content')
    <div id="main-content">
        <div id="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center;">
                                <h2>DETAIL BARANG</h2>
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
                                <img src="{{asset('images/'.$barang->foto.'')}}" width="100%" height="auto">
                            </div>
                            
                            <div class="col-md-8">
                                <table class="table">
                                    <tr>
                                        <th>Kode Barang</th>
                                        <td>:</td>
                                        <td>{{$barang->kode_barang}}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td>:</td>
                                        <td>{{$barang->nama_barang}}</td>
                                    </tr>
                                    <tr>
                                        <th>satuan</th>
                                        <td>:</td>
                                        <td>{{$barang->satuan}}</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>:</td>
                                        <td>{{$barang->deskripsi}}</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td>:</td>
                                        <td>{{$barang->kategori->nama_kategori}}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>:</td>
                                        <td>{{$barang->status}}</td>
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