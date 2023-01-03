@extends('backend.layouts.app')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Fiter data</div>
                    </div>
                    <form id="form-filter">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="date-from-label">Dari</span>
                                        <input type="date" class="form-control" id="date-from" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="date-to-label">Sampai</span>
                                        <input type="date" class="form-control" id="date-to" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-outline-primary" id="btn-submit-filter">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
                                </svg>
                                Terapkan
                            </button>

                            <button type="reset" class="btn btn-outline-warning ms-2" id="btn-filter-reset">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table" id="ordersTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>{{ __('No.') }}</th>
                                <th>{{ __('No. order') }}</th>
                                <th>{{ __('Kasir') }}</th>
                                <th>{{ __('No. customer') }}</th>
                                <th>{{ __('Total harga') }}</th>
                                <th>{{ __('Tanggal') }}</th>
                                <th>{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Invice Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="invoiceModalLabel">Invoice</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="invoice-modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        showData(getQueryString().date_from == undefined ? '' : getQueryString().date_from, getQueryString().date_to == undefined ? '' : getQueryString().date_to)

        let invoiceModal = new bootstrap.Modal(document.getElementById('invoiceModal'), {})

        function showData(dateFrom, dateTo) {
            $('#ordersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ url('backend/finance/orders?date_from=${dateFrom}') }}` + `&date_to=${dateTo}`,
                method: "GET",
                lengthMenu: [30, 100],
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false
                }, {
                    data: 'order_number',
                    name: 'order_number'
                }, {
                    data: 'cashier_name',
                    name: 'cashier_name',
                    orderable: false
                }, {
                    data: 'customer_number',
                    name: 'customer_number'
                }, {
                    data: 'total_price',
                    name: 'total_price'
                }, {
                    data: 'created_at',
                    name: 'created_at'
                }, {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }]
            })
        }

        $('#ordersTable').on('click', '.btn-invoice', function() {
            let data = $(this).data("detail")
            invoiceModal.show()

            $('#invoice-modal-body').html(`
                <div class="row">
                    <div class="col-12">
                        <embed type="application/pdf" src="{{ url('backend/finance/order/${data.order_number}/invoice') }}" width="100%" height="600"></embed>
                    </div>
                </div>
            `)
        })

        $('#form-filter').on('submit', function(e) {
            e.preventDefault()
            let dateFrom = $('#date-from').val()
            let dateTo = $('#date-to').val()

            $('#ordersTable').DataTable().clear().destroy()
            showData(dateFrom, dateTo)
            history.pushState('', null, `{{ url('backend/finance/orders?date_from=${dateFrom}') }}` + `&date_to=${dateTo}`)
            Toast.fire({
                icon: 'success',
                title: 'Data tampil berdasarkan filter'
            })
        })

        $('#btn-filter-reset').on('click', function() {
            $('#ordersTable').DataTable().clear().destroy()
            showData('', '')            
            history.pushState('', null, `{{ url('backend/finance/orders') }}`)
            Toast.fire({
                icon: 'success',
                title: 'Filter direset ulang'
            })
        })
    })
</script>

@endsection