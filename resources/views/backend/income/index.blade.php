@extends('backend.layouts.app')

@section('content')
    <div class="container-xl">
        <div class="card shadow-sm">

            <div class="card-body">
                <div class=" d-grid justify-content-end mb-3">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-report">
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
                showData()
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


        });
    </script>
    @endpush
@endsection
