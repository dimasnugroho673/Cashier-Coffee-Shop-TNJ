@extends('backend.layouts.app')

@section('content')
    <div class="container-xl">
        <div class="card shadow-sm">

            <div class="card-body">
                <div class=" d-grid justify-content-end mb-3">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-income-form">
                        Tambah Data
                    </a>
                </div>
                <div class=" table-responsive">
                    <table id="incomeTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Tanggal') }}</th>
                                <th>{{ __('Pemasukan') }}</th>
                                <th>{{ __('Tipe - Tipe') }}</th>
                                <th>{{ __('Nominal') }}</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <x-backend.income.modal/>
    </div>


    @push('scripts')
        <script>
            $(document).ready(function () {
                let formMode = 'create'
                let token = $("meta[name='csrf-token']").attr("content")
                let tmpId = ''
                showData()
                manipulateForm()

                // const modal = new boo
                const modal = new bootstrap.Modal(document.querySelector('#modal-income-form'), {
                    backdrop: 'static'
                })

                $('#modalIncome').on('submit', function() {
                    e.preventDefault()
                    $.ajax({
                        url : formMode == 'create' ? "{{ url('backend/finance/income/store') }}" : "{{ url('backend/finance/update') }}" + "/" + tmpId,
                        data: {
                            "_method" : formMode == 'create' ? 'POST' : 'PUT',
                            "_token" : token,
                            date: $('#date').val(),
                            name : $('#name').val(),
                            typeincome_id :$('#typeincome_id').val(),
                            price: $('#price').val(),
                            desc: $('#desc').val(),
                        },
                        type: 'POST',
                        success: function(response) {
                            if (formMode == 'create') {
                                Toast.fire({
                                    icon: 'success',
                                    title: "Data Pemasukan Berhasil Ditambahkan !!!",
                                })
                            }
                            else if (formMode == 'edit') {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Data Pemasukan Berhasilkan Diupdate !!!',
                                })
                            }
                            modal().hide()
                            $('#modalIcome').trigger('reset')
                            $('#incomeTable').DataTable.ajax.reload()
                            manipulateForm()
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    })
                });

                $('#incomeTable').on('click','btn-edit', function() {
                    let id = $(this).data('id')
                    let data = $(this).data("detail")

                    tmpId = id
                    $('#date').val(data.date)
                    $('#name').val(data.name)
                    $('#typeincome_id').val(data.typeincome_id)
                    $('#price').val(data.price)
                    $('#desc').val(data.desc)

                    formMode == 'edit'
                    manipulateForm()
                });


                function showData() {
                    $('#incomeTable').DataTable({
                        processing: true,
                        serverside: true,
                        ajax: "{{ route('backend.income') }}",
                        lengthMenu: [5, 15, 25, 50, 100],
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex'
                            },
                            {
                                data: 'date',
                                name: 'date'
                            },
                            {
                                data: 'name',
                                name: 'name'
                            },
                            {
                                data: 'typeincome',
                                name: 'typeincome',
                                orderable: false,
                                seacrhable: false,
                            },
                            {
                                data: 'price',
                                name: 'price',
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                seacrhable: false,
                            },
                        ],
                });
                }

                function manipulateForm () {
                    if (formMode == 'create') {
                        $('#text-modal-title').text('Tambah Data Pemasukan')
                        $('#btn-submit-form-add-income').text('Submit')
                    } else if (formMode == 'edit') {
                        $('#text-modal-title').text('Edit data Pemasukan')
                        $('#btn-submit-form-add-income').text('Update')
                    }
                }
        });
    </script>
    @endpush
@endsection
