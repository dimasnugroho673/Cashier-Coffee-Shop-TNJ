@extends('backend.layouts.app')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="card shadow-sm">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link button-tab" data-id="yearly" id="yearly-tab" data-bs-toggle="tab" data-bs-target="#yearly-tab-pane" type="button" role="tab" aria-controls="yearly-tab-pane" aria-selected="false">Per tahun</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link button-tab" data-id="monthly" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly-tab-pane" type="button" role="tab" aria-controls="monthly-tab-pane" aria-selected="false">Per bulan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link button-tab" data-id="custom" id="custom-tab" data-bs-toggle="tab" data-bs-target="#custom-tab-pane" type="button" role="tab" aria-controls="custom-tab-pane" aria-selected="false">Filter data</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="yearly-tab-pane" role="tabpanel" aria-labelledby="yearly-tab" tabindex="0">
                            <div class="row my-3">
                                <div class="col-md-6 offset-md-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <th>No</th>
                                            <th>Tahun</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1 ?>
                                            @for($year = date('Y'); $year >= $year_start; $year--)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $year }}</td>
                                                <td><button class="btn btn-sm btn-outliine-light btn-show-modal-recap" data-name="year" data-year="{{ $year }}" data-bs-toggle="modal" data-bs-target="#recapModal">Lihat</button></td>
                                            </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="monthly-tab-pane" role="tabpanel" aria-labelledby="monthly-tab" tabindex="1">
                            <div class="row my-3">
                                <div class="col-md-6 offset-md-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <th>No</th>
                                            <th>Tahun</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1 ?>
                                            @for($year = date('Y'); $year >= $year_start; $year--)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $year }}</td>
                                                <td>
                                                    <form class="form-select-month-on-recap">
                                                        <!-- <input type="hidden" name="input-month-on-recap" class="input-month-on-recap" value="{{ $year }}" required> -->
                                                        <select id="select-month-on-recap-{{ $year }}" required>
                                                            <option value="" selected disabled>Pilih bulan</option>
                                                            <?php $monthArr = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Desember'] ?>
                                                            @for($month = 0; $month < count($monthArr); $month++)
                                                                <option value="{{ $month + 1 }}">{{ $monthArr[$month] }}</option>
                                                            @endfor
                                                        </select>

                                                        <button type="submit" class="btn btn-sm btn-outliine-light btn-show-modal-recap" data-name="month" data-year="{{ $year }}">Lihat</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tab-pane" role="tabpanel" aria-labelledby="custom-tab" tabindex="2">
                            <div class="row my-3">
                                <div class="col-md-6 offset-md-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">Fiter data</div>
                                        </div>
                                        <form id="form-filter-on-recap">
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
                                                <button type="submit" class="btn btn-outline-primary btn-show-modal-recap" data-name="custom" id="btn-submit-filter">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
                                                    </svg>
                                                    Terapkan
                                                </button>

                                                <button type="reset" class="btn btn-outline-warning ms-2" id="btn-filter-reset">Reset</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="table-responsive">
                        <table id="menuTable" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('No')}}</th>
                                    <th>{{ __('Name')}}</th>
                                    <th>{{ __('Kategori')}}</th>
                                    <th>{{ __('harga')}}</th>
                                    <th>{{ __('Status')}}</th>
                                    <th>{{ __('Aksi')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div> -->
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="recapModal" tabindex="-1" aria-labelledby="recapModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="recapModalLabel">Lihat data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-recap">
                <div id="modal-recap-file">
                    <div class="card card-recap-file-touchable mb-3" data-url="" style="border-radius: 12px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <span class="bg-primary text-white avatar shadow" style="border-radius: 12px;"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                            <line x1="9" y1="9" x2="10" y2="9"></line>
                                            <line x1="9" y1="13" x2="15" y2="13"></line>
                                            <line x1="9" y1="17" x2="15" y2="17"></line>
                                        </svg>
                                    </span>
                                </div>

                                <div class="col-md-9">
                                    <h4 class="m-0" id="label-file-name-recap"></h4>
                                    <small class="text-muted m-0">Tipe file: PDF</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="modal-recap-info"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        const lastUri = `{{ request()->segment(4) }}`
        setTabActive(lastUri == '' ? 'yearly' : lastUri)
        const modal = new bootstrap.Modal(document.getElementById('recapModal'), {})

        $('.button-tab').on('click', function() {
            const id = $(this).data('id')
            history.pushState('', 'Admin {{ $title }}', `{{ url('backend/finance/recapitulations/${id}') }}`)

            setTabActive($(this).data('id'))
        })

        $('.btn-show-modal-recap').on('click', function() {
            let data = $(this).data('name')
            const dateNow = new Date()

            switch (data) {
                case 'year':
                    let yearSelected = $(this).data('year')
                    $('#modal-recap-info').html(``)
                    if (dateNow.getFullYear() == yearSelected) {
                        if ((dateNow.getMonth() + 1) < '12') {
                            $('#modal-recap-info').html(`
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                                <div>
                                    Tahun yang dipilih belum sampai 12 bulan.
                                </div>
                            </div>
                            `)
                        } else if ((dateNow.getMonth() + 1) == '12') {

                        }
                    }
       
                    $('#label-file-name-recap').text(`Rekap_${yearSelected}`)
                    $('.card-recap-file-touchable').data('url', `{{ url('/backend/finance/recapitulation/year?at=${yearSelected}') }}`)

                    break;
                case 'month':
                    let yearSelected2 = $(this).data('year')
                    let monthSelected = $(`#select-month-on-recap-${yearSelected2}`).val()

                    modal.show()
                    $('#modal-recap-info').html(``)
                    $('#label-file-name-recap').text(`Rekap_${monthSelected}_${yearSelected2}`)

                    $('.card-recap-file-touchable').data('url', `{{ url('/backend/finance/recapitulation/month?on_month=${monthSelected}&at_year=${yearSelected2}') }}`.replace('&amp;','&'))

                    break;

                case 'custom':
                    let dateFrom = $('#date-from').val()
                    let dateTo = $('#date-to').val()

                    modal.show()
                    $('#modal-recap-info').html(``)
                    $('#label-file-name-recap').text(`Rekap_${dateFrom}_${dateTo}`)

                    $('.card-recap-file-touchable').data('url', `{{ url('/backend/finance/recapitulation/custom?date_from=${dateFrom}&date_to=${dateTo}') }}`.replace('&amp;','&'))

                    break;
                default:
                    break;
            }
        })

        $('.form-select-month-on-recap').on('submit', function(e) {
            e.preventDefault()
        })

        $('#form-filter-on-recap').on('submit', function(e) {
            e.preventDefault()
        })

        $('.card-recap-file-touchable').on('click', function() {
            window.open($(this).data('url'), '_blank')
        })

        function setTabActive(name) {
            $(`[data-id="${name}"]`).addClass('active')

            $(`#${name}-tab-pane`).addClass('show active')
        }
    })
</script>
@endpush

@endsection