@extends('backend.layouts.app')

{{-- @section('Kategori',{{ $title }}) --}}
@section('title','Kategori')

{{-- @endsection --}}
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Kategori List
                <a href="{{ route('ketegori.create') }}" class="btn btn-primary text-white">Tambah Data</a>
            </div>
            <div class="card-body">
                <table class=" table" id="categories">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                            {{-- <th></th> --}}
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
@push('script')
<script>
    $($document).ready(function () {
        var categories = $('categories').DataTable({
            processing :true,
            serverSide :true,
            ajax : "{{ route('ketegori.index') }}",
            columns :[
                {data : 'id',name :'id'},
                {data : 'name',name :'name'},
                {data : 'aksi',name :'aksi', orderable: false, searchable: false},
            ]
        })

    })
</script>
@endpush

@endsection
