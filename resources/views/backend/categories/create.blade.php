@extends('backend.layouts.app')

@section('title','Form Tambah Data Kategori')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2 class="h2">Tambah Data Kategori</h2>
        </div>
        <form action="{{ route('kategori.store') }}" method="post" >
            <div class="card-body">

            </div>
            <div class="card-footer">

            </div>
    </form>
    </div>
</div>
@endsection
