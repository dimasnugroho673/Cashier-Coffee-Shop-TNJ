@extends('backend.layouts.app')

@section('content')
    <div class=" container-xl">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('backend.menu.update',$menu->id) }}" method="post">
                {{ csrf_field() }}
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="" class="form-label">Masukkan Nama Makanan/Minuman :</label>
                            <input type="text" name="name" value="{{ $menu->name }}" class="form-control">
                        </div>
                        <div class=" form-group mt-4">
                            <label for="" class="form-label">Pilih Kategori Makanan/Minuman:</label>
                            <select name="category_id" id="category_id" value="{{ $menu->category_id }}" class="form-select">
                                @foreach ($category as $category)
                                <option value="{{ $category->id }}" {{ ($category->id == $menu->category_id) ? 'selected' : ''  }} >{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="" class="form-label">Masukkan Harga:</label>
                            <input type="number" name="price" value="{{ $menu->price }}" class="form-control">
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="form-label">Deskripsi Makanan/Minuman</label>
                            <textarea name="desc" value=""  rows="5" class=" form-control">{{ $menu->desc }}</textarea>
                        </div>
                        <div class=" d-flex justify-content-end mt-5 gap-4">
                            <a href="{{ route('backend.menu') }}" class="btn btn-info">Kembali</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
                </form>


            </div>
        </div>
    </div>
@endsection
