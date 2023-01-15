import { toNumber } from "lodash";
import { InertiaLink, usePage, Link } from '@inertiajs/inertia-react';
import React, { Fragment, useState, useEffect } from "react";
import Layout from "../layouts/app";
import axios from "axios";
import Pagination from '@/Components/Pagination';
import parse from 'html-react-parser';

const OrderHistory = () => {

    // const [dataPerPage, setDataPerPage] = useState(20)
    const [currentPage, setCurrentPage] = useState('')
    const [links, setLinks] = useState([])
    const [orders, setOrders] = useState([])

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

    const rupiahFormatter = (number) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(number);
    }

    if (orders != {}) {
        return (
            <Fragment>
                <div>
                    <div className="container">
                        <div className="row">
                            <div className="col-md-6" style={{ marginTop: '100px' }}>

                                <div class="card">
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
                                            <button type="submit" class="btn btn-outline-primary" id="btn-submit-filter">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
                                                </svg>
                                                Terapkan
                                            </button>

                                            <button type="reset" class="btn btn-outline-warning ms-2" id="btn-filter-reset" onClick={() => resetData()}>Reset</button>
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
                                <div className="table-responsive">
                                    <table className="table" id="">
                                        <thead>
                                            <tr>
                                                {/* <th>No.</th> */}
                                                <th>No. order</th>
                                                <th>Kasir</th>
                                                <th>No. customer</th>
                                                <th>Total harga</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {orders.map((order, index) => (
                                                <tr key={order.id}>
                                                    {/* <td>{index + 1}</td> */}
                                                    <td>{order.order_number}</td>
                                                    <td>{order.cashier_name}</td>
                                                    <td>{order.customer_number}</td>
                                                    <td>{rupiahFormatter(order.total_price)}</td>
                                                    <td>{order.created_at}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" onClick={() => handleInvoicePreview(order.order_number)}>
                                                            Invoice
                                                        </button>
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>

                                <div className="row">
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
            </Fragment>
        )
    }


}

OrderHistory.layout = page => <Layout children={page} title="Tes title order" />

export default OrderHistory;