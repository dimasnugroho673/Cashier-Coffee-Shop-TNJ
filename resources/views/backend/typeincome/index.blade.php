@extends('backend.layouts.app')

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-sm-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        {{-- <a href="{{ route('backend.typeincome.show'->$typeincome->id) }}">Test</a> --}}
                        <div class="table-responsive">
                            <table id='typeincomeTable' class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('No') }}</th>
                                        <th>{{ __('Tipe-tipe') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title" id="text-card-title"></div>
                    </div>
                    <form id="form-add-typeincome">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Tipe Pemasukan:</label>
                                <input type="text"  id="name" class="form-control mb-2">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class=" btn btn-primary" id="btn-submit-add-typeincome"></button>
                            <button type="reset" class="btn btn-warning ms-1" id="btn-reset-form">Reset</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>

            $(document).ready(function() {
                let formData = 'create'
                let tmpID = ''
                showData()
                manipulateForm()

                $('#btn-reset-form').on('click', function() {
                    formData = 'create'
                    manipulateForm()
                })

                $('#btn-submit-add-typeincome').on('click', function(){
                    let name = $('#name').val()
                    let token = $("meta[name='csrf-token']").attr("content")
                    $.ajax({
                        url : formData = 'create' ? "{{ url('backend/finance/typeincome/create') }}" : "{{ url('backend/finance/typeincome/edit') }}" +"/" +tmpID,
                        data : {
                            "_method": formData == 'create' ? "POST" : "PUT",
                            "_token" : token,
                            name : name,
                        },
                        type : 'POST',
                        dataType :"JSON",
                        success : function(response) {
                            if (formData == 'create') {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Data berhasil ditambahkan',
                                })
                            } else {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Data berhasil diubah',
                                })
                            }
                            formData = 'create'
                            manipulateForm()
                            $('#typeincomeTable').DataTables().ajax.reload()
                            $('#form-add-typeincome').trigger('reset')
                        }
                    })
                })

                $('#typeincomeTable').on('click','.btn-delete', function() {
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
                            url : "{{ url('backend/finance/typeincome/destroy') }}" + "/" + id,
                            data : {
                                "_token" : token
                            },
                            type : 'DELETE',
                            dataType :"JSON",
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire(
                                        'Berhasil dihapus!',
                                        'Data berhasil dihapus',
                                        'success'
                                    )
                                }
                                $('#typeincomeTable').DataTable().ajax().reload();
                            },
                            error :function(response){
                                console.log(response);
                            }
                        })
                    }
                })
                })

                $('#typeincomeTable').on('click', '.btn-edit', function() {
                let id = $(this).data("id")
                let data = $(this).data("detail")
                tmpID = id
                formData = 'edit'
                manipulateForm()
                $('#name').val(data.name)
            })


                function showData() {
                    $('#typeincomeTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ url('backend/finance/typeincome') }}",
                        lengthMenu: [5,10,25,50],
                        columns :[{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data : 'name',
                            name: 'name'
                        },
                        {
                            data :'action',
                            name: 'action',
                            orderable : false,
                            seacrhable: false
                        },
                    ]
                    })
                }

                function manipulateForm() {
                    if (formData == 'create') {
                        $('#text-card-title').text('Tambah tipe-tipe income')
                        $('#btn-submit-add-typeincome').text('Submit')
                    } else if (formData == 'edit') {
                        $('#text-card-title').text('Edit data tipe-tipe income')
                        $('#btn-submit-add-typeincome').text('Update')
                    }
                }
            })
        </script>
    @endpush
@endsection
