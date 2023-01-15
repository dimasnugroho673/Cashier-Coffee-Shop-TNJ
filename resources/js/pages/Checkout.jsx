
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage, Link } from '@inertiajs/inertia-react';
import axios from 'axios';
import { toNumber } from 'lodash';
import { Fragment, useEffect, useState } from "react"
import Layout from "../layouts/app"

const Checkout = () => {
    // let data = JSON.parse(orderedMenus.orderedMenus)
    const { orderedMenus, userLoggedIn } = usePage().props
    // const { userLoggedIn } = usePage().props
    const data = JSON.parse(orderedMenus)

    const [filteredMenus, setFilteredMenus] = useState(data)
    const [filterActive, setFilterActive] = useState('all')

    useEffect(() => {
        appendNavCategory()

        const links = document.getElementsByClassName('nav-link-filter')
        switchFilterActive(links, filterActive)

        for (var i = 0; i < links.length; i++) {
            links[i].addEventListener('click', (link) => {
                let label = link.target.getAttribute('data-filter-label')
                setFilterActive(label)
                switchFilterActive(links, label)
                handleShowData(label)
            })
        }

        return () => {
            const nav = document.getElementById('nav-menu-categories')
            nav.remove()
        }
    }, [])

    const switchFilterActive = (links, label) => {
        switch (label) {
            case "all":
                links[0].classList.add('active')
                links[1].classList.remove('active')
                links[2].classList.remove('active')
                links[3].classList.remove('active')
                break;
            case "makanan":
                links[0].classList.remove('active')
                links[1].classList.add('active')
                links[2].classList.remove('active')
                links[3].classList.remove('active')
                break;
            case "minuman":
                links[0].classList.remove('active')
                links[1].classList.remove('active')
                links[2].classList.add('active')
                links[3].classList.remove('active')
                break;

            default:
                links[0].classList.remove('active')
                links[1].classList.remove('active')
                links[2].classList.remove('active')
                links[3].classList.add('active')
                break;
        }
    }

    const appendNavCategory = () => {
        if (document.getElementById('nav-menu-categories') == null) {
            const nav = `<ul class="nav nav-pills nav-fill m-2 w-100" id="nav-filter-mobile">
            <li class="nav-item">
              <a class="nav-link nav-link-filter" data-filter-label="all" aria-current="page" href="#">Semua</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-filter" data-filter-label="makanan" href="#">Makanan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-filter" data-filter-label="minuman" href="#">Minuman</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-filter" data-filter-label="">Lain-lain</a>
            </li>
          </ul>`

            const navbarContainer = document.getElementById('navbar-container')
            navbarContainer.innerHTML += nav
        }
    }

    const handleShowData = (label) => {
        if (label != 'all') {
            let dataNew = data.filter(menu => menu.category_name.toLowerCase().includes(label.toLowerCase()))
            setFilteredMenus(dataNew)
        } else {
            setFilteredMenus(data)
        }


    }

    const attemptOrderToPaymentData = () => {
        const dataTotal = {
            table_number: 0,
            ordered_menus: data,
            desc: "",
            cashier_name: userLoggedIn.name,
            total_price: calculateTotalPrice()
        }

        // console.log(dataTotal)

        axios.post('http://127.0.0.1:8000/api/order', dataTotal)
            .then(function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pemesanan berhasil',
                    text: 'Menu berhasil dipesan',
                })

                setTimeout(() => {
                    Inertia.visit('/frontend/order', { method: 'get' })
                }, 1000)

            })
            .catch(function (error) {
                console.log(error);
            });
    }

    const calculateTotalPrice = () => {
        let total = 0

        data.map((menu) => {
            return total += (toNumber(menu.price) * menu.quantity)
        })

        return total
    }

    const rupiahFormatter = (number) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(number);
    }

    return (
        <Fragment>
            <div className="container">
                <div className="row" style={{ marginTop: '130px' }}>
                    <div className="col-md-12">
                        {filteredMenus.map((menu) => (
                            <ol class="list-group mb-3 bg-white shadow-sm" style={{ borderRadius: '12px' }}>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">{menu.menu_name}</div>
                                        <ul>
                                            <li>Harga: {menu.price}</li>
                                            <li>Qty: {menu.quantity}</li>
                                        </ul>
                                    </div>
                                </li>
                            </ol>
                        ))}

                        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-bottom ">
                            <div class="container">
                                <a class="navbar-brand modal-title" href="#">{rupiahFormatter(calculateTotalPrice())}</a>

                                <button className="btn btn-primary btn-primary-custom shadow" onClick={() => attemptOrderToPaymentData()}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="6" cy="19" r="2"></circle>
                                        <circle cx="17" cy="19" r="2"></circle>
                                        <path d="M17 17h-11v-14h-2"></path>
                                        <path d="M6 5l14 1l-1 7h-13"></path>
                                    </svg>

                                    Bayar
                                </button>
                            </div>
                        </nav>

                        {/* <div className="mt-5">
                            <Link href={`/frontend/order?ordered_menus=${JSON.stringify(data)}`}>Back</Link>
                            <button className='btn btn-danger ms-4' onClick={() => attemptOrderToPaymentData()}>Bayar: {calculateTotalPrice()}</button>
                        </div> */}
                    </div>
                </div>
            </div>
        </Fragment>
    )
}

Checkout.layout = page => <Layout children={page} />

export default Checkout