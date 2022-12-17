@extends('backend.layouts.app')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="userTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>{{ __('No') }}</th>
                                        <th>{{ __('Nama') }}</th>
                                        <th>{{ __('Email Address') }}</th>
                                        <th>{{ __('Level') }}</th>
                                        <th>{{ __('Aksi') }}</th>
                                        <!-- <th>{{ __('Created at') }}</th>
                            <th>{{ __('Updated in') }}</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Buat user (belum kelar)</div>
                    </div>
                    <div class="card-body">
                        <form id="form-add-user">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" placeholder="Nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat email</label>
                                <input type="email" class="form-control" id="email" placeholder="Alamat email valid" aria-describedby="emailHelp" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-showPassword">
                                <label class="form-check-label text-muted" for="checkbox-showPassword">Tampilkan password</label>
                            </div>
                            <button type="button" class="btn btn-primary" id="btn-submit-form-add-user">Buat user</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        showData()

        $('#btn-submit-add-form').on('click', function() {
            let name = $('#name').val()
            let email = $('#email').val()
            let password = $('#password').val()
            let token = $("meta[name='csrf-token']").attr("content")

            $.ajax({
                        url: "{{ url('backend/user') }}",
                        data: {
                            "_token": token,
                            name: name,
                            email: email,
                            password: password
                        },
                        type: 'POST',
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status) {
                                Swal.fire(
                                    'Berhasil dibuat!',
                                    'Data berhasil dibuat',
                                    'success'
                                )
                            }

                            $('#userTable').DataTable().ajax.reload();
                        },
                        error: function(response) {
                            console.log(response)
                        }
                    })


        })

        $('#checkbox-showPassword').on('click', function() {
            if ($('#password').attr('type') == 'password') {
                $('#password').attr('type','text')
            } else {
                $('#password').attr('type','password')
            }
        })

        $('#userTable').on('click', '.btn-edit', function() {
            alert("edit")
        })

        $('#userTable').on('click', '.btn-delete', function() {
            Swal.fire({
                title: 'Hapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let id = $(this).data("id")
                    let token = $("meta[name='csrf-token']").attr("content")

                    $.ajax({
                        url: "{{ url('backend/user/destroy') }}/" + id,
                        data: {
                            "_token": token
                        },
                        type: 'DELETE',
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status) {
                                Swal.fire(
                                    'Berhasil dihapus!',
                                    'Data berhasil dihapus',
                                    'success'
                                )
                            }

                            $('#userTable').DataTable().ajax.reload();
                        },
                        error: function(response) {
                            console.log(response)
                        }
                    })
                }
            })
        })


        function showData() {
            $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('backend/users/json') }}",
                lengthMenu: [50, 100, 200, 500],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'nama'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ]
            })
        }

    })
</script>

@endsection