@extends('/backend/layouts/app')
@section('content')
    <div class="container-fluid">
        <div class="row g-2">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class=" text-bold">General Data</h4>
                    </div>
                    <form action="{{ route('backend.setting.generaldata') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name" class=" form-label">Nama usaha anda :</label>
                                <input type="text" name="name" value="{{ $setting->name }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="address" class=" form-label">Alamat usaha anda :</label>
                                <input type="text" name="address" value="{{ $setting->address }}"  class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="phone" class=" form-label">Nomor telp usaha anda :</label>
                                <input type="text" name="phone" value="{{ $setting->phone }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email" class=" form-label">Email usaha anda :</label>
                                <input type="text" name="email" value="{{ $setting->email }}" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class=" btn btn-primary ">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h4> Modal awal</h4>
                    </div>
                    <form action="{{ route('backend.setting.updateModal') }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="modal" class=" form-label">Masukan nomimal modal:</label>
                                <input type="text" name="modal" value="{{ $setting->modal }}" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                <div class="card mt-2">
                    <div class="card-header">
                        <h4>Logo perusahaan/usaha</h4>
                    </div>
                    <form action="{{ route('backend.setting.updateLogo') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if ($setting->icons == null)
                                <img src="{{ $setting->icons }}" alt="logo" width="256" class="mb-2 img-thumbnail">
                            @else
                                <img src="{{ asset($setting->icons) }}" alt="logo" width="256" class="mb-2 img-thumbnail">
                            @endif
                                {{-- <img src="{{ asset($setting->icons)}}" alt="logo" width="256" class="mb-2 img-thumbnail"> --}}
                            <div class="form-group mb-3">
                                <label for="" class=" form-label">Choose file</label>
                                <input type="file" name="icons"  class="form-control" value="{{ $setting->icons }}">
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
