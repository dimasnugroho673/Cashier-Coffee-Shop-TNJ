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
                        <table class="table table-bordered " id="categoriTable">
                            <thead>
                                <tr>
                                    <th>{{ __('No') }}</th>
                                    <th>{{ __('Kategori') }}</th>
                                    <th>{{ __('Aksi') }}</th>
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
                    <form id="form-add-category">
                        <div class="card-body">
                            <div class="form-group">
                                    <label for="" class=" fw-semibold font-monospace fs-3">Nama Kategori:</label>
                                    <input type="text" id="name" class="form-control" required placeholder="Masukkan Nama Kategori ...">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class=" btn btn-primary" id="btn-submit-add-categori"></button>
                            <button type="reset" class="btn btn-warning ms-1" id="btn-reset-form">Reset</button>
                        </form>
                    </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   </div>


 <script>
    $(document).ready(function () {
        let formData = 'create'
        let tmpID = ''
        showData()
        manipulateForm()

        $('#btn-reset-form').on('click',function () {
            formData = 'create'
            manipulateForm()
        })
        $('#btn-submit-add-categori').on('click',function() {
            let name = $('#name').val()
            let token = $("meta[name='csrf-toke']").attr("content")

            if (formData == 'create'){
                $.ajax({
                    url:"{{ url('backend/kategori/create') }}",
                    data:{
                        "_token": token,
                        name: name,
                    },
                    type : 'POST',
                    dataType : "JSON",
                    success : function(response) {
                        if (response.status) {
                            Swal.fire(
                                'Berhasil dibuat',
                                'Data berhasil dibuat',
                                'success'
                                )
                                $('#btn-reset-form').trigger('reset');
                        }
                        $('#categoriTable').Datatable().ajax().reload();
                    },
                    error : function(response) {
                            console.log(response)
                    }
                })
            } else if (formData == 'edit') {
                $.ajax({
                    url: "{{ url('backend/kategori') }}" + "/" + tmpID,
                    data: {
                        "_method": "PUT",
                        "_token": token,
                        name:name,
                    },
                    type: 'POST',
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status) {
                            Swal.fire(
                                'Berhasil diubah',
                                'Data Berhasil diubah',
                                'success'
                            )
                                $('#btn-reset-form').trigger('reset');
                            }
                            $('#categoriTable').Datatable().ajax().reload();
                            formData = 'create'
                            manipulateForm()
                        },
                        error: function(response) {
                            console.error(response);
                        }
                })
            }
        })

        $('#categoriTable').on('click', function() {
            let id = $this().data("id")

            $.ajax({
                url: "{{ url('backend/kategori') }}/" +id,
                type:"GET",
                dataType:"JSON",
                success: function(response) {
                    $('#name').val(response.data.name)

                    formData = 'edit'
                    tempID = response.data.id
                    manipulateForm()
                },
                error:function(response) {
                    console.error(response);
                }
            })
        })
        $('#categoriTable').on('click', '.btn-delete', function() {
            Swal.fire({
                title: 'Hapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6D7A91',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let id = $(this).data("id")
                    let token = $("meta[name='csrf-token']").attr("content")
                    $.ajax({
                        url: "{{ url('backend/kategori/destroy') }}" + "/" + id,
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
                            $('#categoriTable').DataTable().ajax.reload();
                        },
                        error: function(response) {
                            console.log(response)
                        }
                    })
                }
            })
        })

        function showData() {
            $('#categoriTables').Datatable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('backend/kategori') }}",
                lengthMenu: [50, 100, 200, 500],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'nama'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            })
        }

        function manipulateForm() {
            if (formMode == 'create') {
                $('#text-card-title').text('Tambah Katehori')
                $('#btn-submit-form-add-user').text('Submit')
            } else if (formMode == 'edit') {
                $('#text-card-title').text('Edit data Kategori')
                $('#btn-submit-form-add-user').text('Update')
            }
        }

    })
 </script>
@endsection
