
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage, Link } from '@inertiajs/inertia-react';
import axios from 'axios';
import { toNumber } from 'lodash';
import { Fragment } from "react"
import Layout from "../layouts/app"

const Checkout = () => {
    // let data = JSON.parse(orderedMenus.orderedMenus)
    const { orderedMenus, userLoggedIn } = usePage().props
    // const { userLoggedIn } = usePage().props
    const data = JSON.parse(orderedMenus)

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
            Inertia.visit('/frontend/order', { method: 'get' })
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

    return (
        <Fragment>
            <div className="container">
                <div className="row">
                    <div className="col-md-12">
                        Menu checkout:
                        {data.map((menu) => (
                            <ol class="list-group mb-3">
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

                        <div className="mt-5">
                            <Link href={`/frontend/order?ordered_menus=${JSON.stringify(data)}`}>Back</Link>
                            <button className='btn btn-danger ms-4' onClick={() => attemptOrderToPaymentData()}>Bayar: {calculateTotalPrice()}</button>
                        </div>
                    </div>
                </div>
            </div>
        </Fragment>
    )
}

Checkout.layout = page => <Layout children={page} />

export default Checkout