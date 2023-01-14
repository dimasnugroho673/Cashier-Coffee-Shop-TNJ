@extends('backend.layouts.app')

@section('content')
<div class="container-xl">
    <div class="my-3">
        <div class="row g-2">
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                {{-- <span></span> --}}
                                <h1>1</h1>
                                <span>Orderan Sudah bayar</span>
                            </div>
                            <div class="bg-success-lt rounded-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md icon-tabler icon-tabler-checklist" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8"></path>
                                    <path d="M14 19l2 2l4 -4"></path>
                                    <path d="M9 8h4"></path>
                                    <path d="M9 12h2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1>2</h1>
                                <span>Orderan yang Belum bayar</span>
                            </div>
                            <div class=" bg-red-lt rounded-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md icon-tabler icon-tabler-receipt" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2m4 -14h6m-6 4h6m-2 4h2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1>2</h1>
                                <span>Total Orderan</span>
                            </div>
                            <div class=" bg-indigo-lt rounded-circle">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md icon-tabler icon-tabler-packages" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path>
                                    <path d="M2 13.5v5.5l5 3"></path>
                                    <path d="M7 16.545l5 -3.03"></path>
                                    <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path>
                                    <path d="M12 19l5 3"></path>
                                    <path d="M17 16.5l5 -3"></path>
                                    <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5"></path>
                                    <path d="M7 5.03v5.455"></path>
                                    <path d="M12 8l5 -3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-3">
        <div class="row g-2">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h1>Pendapatan</h1>
                            </div>
                            <div>
                                <span>pendapatan hari ini</span>
                            </div>
                        </div>
                        <hr>
                        <div class=" my-3 d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-success fw-bold">Pendapatan order</span>
                                <h1 class="mt-2">Rp.1.000.000</h1>
                            </div>
                            <div>
                                <span class="text-indigo">Pemasukan diluar order</span>
                                <h1 class="mt-2">Rp.1.000.000</h1>
                            </div>
                            <div>
                                <span class="text-info">Total Keseluruhan Pemasukan</span>
                                <h1 class="mt-2">Rp.1.000.000</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4"></div>
        </div>
    </div>

    <div>
        <span class="fs-1">Rekap keseluruhan</span>
        <div class="row g-3 mt-1">
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-status-top bg-red-lt"></div>
                    <div class="card-body">
                        <div class="row align-items-center ">
                            <div class="col-auto">
                                <h1 class="text-muted font-weight-bold fs-1">Pengeluaran</h1>
                                <p class="mt-3 text-red fw-bold fs-2"><span>{{ $purchase }}</span></p>
                            </div>
                            <div class="col"></div>
                            <div class="col-auto text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md icon-tabler  icon-tabler-trending-down" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <polyline points="3 7 9 13 13 9 21 17"></polyline>
                                    <polyline points="21 10 21 17 14 17"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm">
                    <div class=" card-status-top bg-indigo-lt"></div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h1 class="text-muted font-weight-bold fs-1">Pemasukan</h1>
                                <p class="mt-3 text-indigo fw-bold fs-2"><span>{{ $income_total }}</span></p>
                            </div>
                            <div class="col"></div>
                            <div class="col-auto text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-md icon-tabler-trending-up" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <polyline points="3 17 9 11 13 15 21 7"></polyline>
                                    <polyline points="14 7 21 7 21 14"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm">
                    <div class=" card-status-top bg-info-lt"></div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h1 class="text-muted font-weight-bold fs-1">Modal</h1>
                                <p class="mt-3 text-info fw-bold fs-2"><span> {{ $total_modal }}</span></p>
                            </div>
                            <div class="col"></div>
                            <div class="col-auto text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md icon-tabler icon-tabler-businessplan" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <ellipse cx="16" cy="6" rx="5" ry="3"></ellipse>
                                    <path d="M11 6v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4"></path>
                                    <path d="M11 10v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4"></path>
                                    <path d="M11 14v4c0 1.657 2.239 3 5 3s5 -1.343 5 -3v-4"></path>
                                    <path d="M7 9h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5"></path>
                                    <path d="M5 15v1m0 -8v1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card shadow-sm">
                    <div class="card-status-top bg-success-lt"></div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h1 class="text-muted font-weight-bold fs-1">Total Order</h1>
                                <p class="mt-3 text-success fw-bold fs-2"><span> {{ $order }}0</span></p>
                            </div>
                            <div class="col"></div>
                            <div class="col-auto text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-md icon-tabler icon-tabler-report-money" width="40" height="40" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                                    <rect x="9" y="3" width="6" height="4" rx="2"></rect>
                                    <path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5"></path>
                                    <path d="M12 17v1m0 -8v1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="mt-4">
    <span class="fs-1">Rekapan Harian</span>
    <div class="row g-3 mt-1" >

        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <span class=" fs-1 fw-bold">{{ $now_purchase }}</span>
                </div>
                <div class="card-footer">
                    <span class="text-red fs-4 fw-semibold">Pengeluaran hari ini</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <span class=" fs-1 fw-bold">Rp. 3.000.000,00</span>
                </div>
                <div class="card-footer">
                    <span class="text-indigo fs-4 fw-semibold">Pemasukan hari ini</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <span class="fs-1 fw-bold">Rp. 1.000.000,00</span>
                </div>
                <div class="card-footer">
                    <span class="text-info fw-semibold">Modal</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <span class="fs-1 fw-bold">{{ $now_order }}</span>
                </div>
                <div class="card-footer">
                    <span class="text-success fw-semibold">Order hari ini</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <div class="card">

        <div class="card-body">
            <div class=" table-responsive">
                <table class=" table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No order</th>
                            <th>Kasir</th>
                            <th>No.Customer</th>
                            <th>Total harga</th>
                            <th>tanggal status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
