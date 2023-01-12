@extends('backend.layouts.app')

@section('content')
<div class="container-xl">
    <div class="row g-3">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
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
                            <p class="mt-3 text-info fw-bold fs-2"><span> RP. 100.000,00</span></p>
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
            <div class="card">
                <div class="card-status-top bg-success-lt"></div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <h1 class="text-muted font-weight-bold fs-1">Total Order</h1>
                            <p class="mt-3 text-success fw-bold fs-2"><span> RP. 10.000.000,00</span></p>
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
@endsection
