@extends('backend.layouts.app')
@section('content')
   <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="">Table Kategori</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-condensed" id="categories">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h2>Tambah Data Kategori</h2>
                    </div>
                    <form action="{{ route('kategori.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                    <label for="" class=" fw-semibold font-monospace fs-3">Nama Kategori:</label>
                                    <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Kategori ...">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class=" btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   </div>

   <script>
   $(document).ready(function () {

   })

    })
   </script>
@endsection
