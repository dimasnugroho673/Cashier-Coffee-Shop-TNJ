@extends('backend.layouts.app')

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-sm-8">
                <div class="card shadow-sm">
                    <div class="card-body">
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
                                <input type="text" name="name" id="name" class="form-control">
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
    {{-- <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script> --}}
        <script>

            $(document).ready(function() {
                let formData = 'create'
                let tmpID = ''
                showData()
                manipulateForm()

                $('#btn-reset-form').on('click', function() {
                    form = 'create'
                    manipulateForm
                })

                $('#btn-submit-ad-typeincome').on('click', function(){
                    let name = $('#name').val()
                    let token = $("meta[name='csrf-token']").attr("content")

                    if (formData == 'create') {
                        $.ajax({
                            url: "{{  url('backend/finance/typeincome/create') }}",
                            data : {
                                "_token" :token,
                                name: name,
                            },
                            type :'POST',
                            dataType :'JSON',
                            success : function(response) {
                                if (response.status) {
                                    Swal.fire(
                                        'Berhasil dibuat',
                                        'Data berhasil dibuat',
                                        'success'
                                    )
                                    $('#btn-reset-form').trigger('reset')
                                }
                                $('#typeincomeTable').DataTable().ajax().reload();
                            },
                            error : function(response) {
                                console.error(response);
                            }
                        })
                    } else if (formData == 'edit') {
                        $.ajax({
                            url:"{{ url('backend/finance/income/update') }}" + "/" +tmpID,
                            data: {
                                "_method" : "PUT",
                                "_token" :token,
                                name: name,
                            },
                            type: 'POST',
                            dataType: "JSON",
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire(
                                        'Berhasil diubah',
                                        'Data berhasil diubah',
                                        'success'
                                    )
                                    $('#btn-reset-form').trigger('reset')
                                }
                                $('#typeincomeTable').DataTable().ajax().reload();
                                formData = 'create'
                                manipulateForm()
                            },
                            error: function(response) {
                                console.error(response);
                            }
                        })
                    }
                })

                $('#typeincomeTable').on('click',".btn-edit", function() {

                    let id = $(this).data('id')
                    $.ajax({
                        url:"{{ url('backend/finance/typeincome/edit') }}/" + id,
                        type : "GET",
                        dataType : 'JSON',
                        success : function (response) {
                            $('name').val(response.data.name)
                            formData = 'edit'
                            tmpID = response.data.id
                            manipulateForm()
                        },
                        error :function(response) {
                            console.error(response);
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
                                console.error(response);
                            }
                        })
                    }
                })
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
