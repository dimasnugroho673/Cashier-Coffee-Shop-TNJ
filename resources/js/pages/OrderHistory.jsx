import { toNumber } from "lodash";
import { InertiaLink, usePage, Link } from '@inertiajs/inertia-react';
import React, { Fragment, useState, useEffect } from "react";
import Layout from "../layouts/app";
import axios from "axios";
import Pagination from '@/Components/Pagination';
import parse from 'html-react-parser';
import Toast from "../components/Toast";
import { rupiahFormatter } from "../Utils/Helper";

const OrderHistory = () => {

    // const [dataPerPage, setDataPerPage] = useState(20)
    const [currentPage, setCurrentPage] = useState('')
    const [links, setLinks] = useState([])
    const [orders, setOrders] = useState([])
    const [paymentModal, setPaymentModal] = useState(false)

    const token = document.getElementsByName('csrf-token')[0].getAttribute('content')

    const fetchHistoryOrders = (perPage, page, keyword, dateFrom, dateTo) => {
        axios.get(`${window.location.origin}/api/orders?per_page=${perPage}&page=${page}&date_from=${dateFrom}&date_to=${dateTo}`)
            .then(function (response) {
                setCurrentPage(response.data.current_page)
                setLinks(response.data.links)
                setOrders(response.data.data)

                console.log(response.data.data)
            })
            .catch(function (error) {
                console.log(error)
            })
    }

    useEffect(() => {
        fetchHistoryOrders(20, 1, '', '', '')

        var paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'), {
            keyboard: false
        })
        setPaymentModal(paymentModal)
    }, [])

    const paginate = (url) => {
        let params = (new URL(url)).searchParams

        fetchHistoryOrders(20, params.get('page') != null ? params.get('page') : 1, '', '', '')
    }

    const handleFilterForm = (e) => {
        e.preventDefault()

        let dateFrom = document.querySelector('#date-from').value
        let dateTo = document.querySelector('#date-to').value

        fetchHistoryOrders(20, 1, '', dateFrom, dateTo)
    }

    const resetData = () => {
        fetchHistoryOrders(20, 1, '', '', '')
    }

    const handleInvoicePreview = (orderNumber) => {
        document.querySelector('#embed-pdf-invoice').setAttribute('src', `${window.location.origin}/backend/finance/order/${orderNumber}/invoice`)
    }

    const renderStatusPayment = (status) => {
        switch (status) {
            case 'complete':
                return <span className="text-success">Pembayaran selesai</span>
                break;
            case 'waiting':
                return <span className="text-warning">Menunggu pembayaran</span>
                break;
            case 'canceled':
                return <span className="text-muted">Pesanan dibatalkan
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-wash-dryclean-off ms-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M20.048 16.033a9 9 0 0 0 -12.094 -12.075m-2.321 1.682a9 9 0 0 0 12.733 12.723"></path>
                        <path d="M3 3l18 18"></path>
                    </svg>
                </span>
                break;
            default:
                break;
        }
    }

    const showPaymentModal = (order) => {
        paymentModal.show()

        document.getElementById('order_number').value = order.order_number
        document.getElementById('status_payment').value = order.status_payment
        document.getElementById('id_order').value = order.id
    }

    const handleUpdatePayment = (e) => {
        e.preventDefault()

        let id = document.getElementById('id_order').value
        let statusPayment = document.getElementById('status_payment').value

        axios.post(`${window.location.origin}/backend/finance/order/payment/${id}`, {
            "_token": token,
            "_method": 'PUT',
            status_payment: statusPayment
        })
        .then(function (response) {
            resetData()
            paymentModal.hide()

            Toast.fire({
                icon: 'success',
                title: 'Pembayaran berhasil diubah'
            })
        })
        .catch(function (error) {
            console.log(error)
        })
    }

    if (orders != {}) {
        return (
            <Fragment>
                <div>
                    <div className="container">
                        <div className="row">
                            <div className="col-md-6" style={{ marginTop: '100px' }}>

                                <div class="card shadow-sm">
                                    <div class="card-header">Fiter data</div>
                                    <form id="form-filter" onSubmit={(e) => handleFilterForm(e)}>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="date-from-label">Dari</span>
                                                        <input type="date" class="form-control" id="date-from" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="date-to-label">Sampai</span>
                                                        <input type="date" class="form-control" id="date-to" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-outline-primary-custom" id="btn-submit-filter">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
                                                </svg>
                                                Terapkan
                                            </button>

                                            <button type="reset" class="btn btn-outline-warning-custom ms-2" id="btn-filter-reset" onClick={() => resetData()}>Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {/* <div className="row mt-4">
                            <div className="col-2">
                                <div className="form-group">
                                    <label htmlFor="">Data per halaman</label>
                                    <br />
                                    <select name="" id="" className="mt-1" onChange={(e) => changeDataPerPage(e)}>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="75">75</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            <div className="col-md-6"></div>
                        </div> */}
                        <div className="row mt-5">
                            <div className="col-md-12">
                                <div className="table-container p-3">
                                    <div className="table-responsive">
                                        <table className="table" id="">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>No. order</th>
                                                    <th>Kasir</th>
                                                    <th>No. customer</th>
                                                    <th>Total harga</th>
                                                    <th>Status pembayaran</th>
                                                    <th>Tanggal</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                {orders.map((order, index) => (
                                                    <tr key={order.id}>
                                                        <td className={(order.status_payment == 'canceled' ? 'text-muted text-decoration-line-through' : '')}>{order.order_number}</td>
                                                        <td className={(order.status_payment == 'canceled' ? 'text-muted text-decoration-line-through' : '')}>{order.cashier_name}</td>
                                                        <td className={(order.status_payment == 'canceled' ? 'text-muted text-decoration-line-through' : '')}>{order.customer_number}</td>
                                                        <td className={(order.status_payment == 'canceled' ? 'text-muted text-decoration-line-through' : '')}>{rupiahFormatter(order.total_price)}</td>
                                                        <td>{renderStatusPayment(order.status_payment)}</td>
                                                        <td className={(order.status_payment == 'canceled' ? 'text-muted text-decoration-line-through' : '')}>{order.created_at}</td>
                                                        <td>
                                                            <button type="button" class={"btn btn-outline-dark btn-sm " + (order.status_payment == 'canceled' ? 'disabled' : '')} data-bs-toggle="modal" data-bs-target="#exampleModal" onClick={() => handleInvoicePreview(order.order_number)}>
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-invoice me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                                                    <line x1="9" y1="7" x2="10" y2="7"></line>
                                                                    <line x1="9" y1="13" x2="15" y2="13"></line>
                                                                    <line x1="13" y1="17" x2="15" y2="17"></line>
                                                                </svg>

                                                                Invoice
                                                            </button>

                                                            <button type="button" class={"btn btn-outline-dark btn-sm ms-2"} onClick={() => showPaymentModal(order)}>
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-credit-card me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                    <rect x="3" y="5" width="18" height="14" rx="3"></rect>
                                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                                    <line x1="7" y1="15" x2="7.01" y2="15"></line>
                                                                    <line x1="11" y1="15" x2="13" y2="15"></line>
                                                                </svg>

                                                                Update pembayaran
                                                            </button>
                                                        </td>
                                                    </tr>
                                                ))}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div className="row mt-3">
                                    <div className="col-md-12">
                                        <nav aria-label="...">
                                            <ul class="pagination">
                                                {links.map((link, index) => (
                                                    <li class="page-item">
                                                        <a className={"page-link " + (link.active ? 'active' : '')} href="#" onClick={() => paginate(link.url)}>
                                                            {parse(link.label)}
                                                        </a>
                                                    </li>
                                                ))}
                                            </ul>
                                        </nav>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Invoice</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <embed type="application/pdf" id="embed-pdf-invoice" src="" width="100%" height="600"></embed>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="paymentModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="form-update-payment" onSubmit={(e) => handleUpdatePayment(e)}>
                                <div class="modal-header">
                                    <h5 class="modal-title">Update pembayaran</h5>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="id_order" class="form-control" readonly />
                                    <div class="form-group mb-3">
                                        <label className="mb-1">No. Order</label>
                                        <input type="text" id="order_number" class="form-control" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label className="mb-1" for="status_payment">Status pembayaran</label>
                                        <select name="status_payment" id="status_payment" class="form-select" required>
                                            <option selected>Pilih status pembayaran</option>
                                            <option value="complete">Selesai</option>
                                            <option value="waiting">Menunggu</option>
                                            <option value="canceled">Pesanan dibatalkan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Update pembayaran</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </Fragment>
        )
    }


}

OrderHistory.layout = page => <Layout children={page} title="Tes title order" />

export default OrderHistory;