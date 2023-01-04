import { toNumber } from "lodash";
import { InertiaLink, usePage, Link } from '@inertiajs/inertia-react';
import React, { Fragment, useState, useEffect } from "react";
import Layout from "../layouts/app";

const Order = (menus) => {

    const [menusData, setMenusData] = useState(menus)
    const [filtertedData, setFiltertedData] = useState(menus.menus)
    const [orderMenuModal, setOrderMenuModal] = useState([])
    const [cartModal, setCartModal] = useState([])
    const [quantityCount, setQuantityCount] = useState(1)
    const [menuTmp, setMenuTmp] = useState({})
    const [orderedMenus, setOrderedMenus] = useState([])

    useEffect(() => {
        var orderMenuModal = new bootstrap.Modal(document.getElementById('modalQuantity'), {
            keyboard: false
        })
        setOrderMenuModal(orderMenuModal)

        var cartModal = new bootstrap.Modal(document.getElementById('previewPreCheckoutModal'), {
            keyboard: false
        })
        setCartModal(cartModal)

        // setOrderedMenus()
        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });
        // Get the value of "some_key" in eg "https://example.com/?some_key=some_value"
        //   let value = params.some_key; // "some_value"

        // setMenusData(menus)

        if (params.ordered_menus) {
            let data = JSON.parse(params.ordered_menus)

            for (let i = 0; i < data.length; i++) {
                // setOrderedMenus([ ...orderedMenus, data[i]])
                // console.log('data: ' + i)
                // orderedMenus.push(data[0])

                orderedMenus.push(data[i])
            }

            console.log(params.ordered_menus)
            console.log(JSON.parse(params.ordered_menus))

        }

        window.onbeforeunload = function () {
            return "Leave this page ?";
        }

        if (document.getElementById('input-search-mobile') == null) {
            const input = document.createElement('input');

            input.className = 'form-control mt-3 mb-2';
            input.id = 'input-search-mobile'
            input.placeholder = "Cari menu..."
    
            const navbarContainer = document.getElementById('navbar-container')
            navbarContainer.append(input)
        }

        handleOnSearchTyping()
    }, [])

    const handleOnSearchTyping = () => {
        const inputMobile = document.getElementById('input-search-mobile')
        inputMobile.addEventListener('keyup', function () {
            let data = menusData.menus.filter(menu => menu.name.toLowerCase().includes(inputMobile.value.toLowerCase()))
            setFiltertedData(data)
        })

        const inputDesktop = document.getElementById('input-search-desktop')
        inputDesktop.addEventListener('keyup', function () {
            let data = menusData.menus.filter(menu => menu.name.toLowerCase().includes(inputDesktop.value.toLowerCase()))
            setFiltertedData(data)
        })
    }


    const handleSelectMenu = (menu) => {

        orderMenuModal.toggle()

        document.getElementsByClassName('modal-title')[0].innerHTML = menu.name

        setMenuTmp({ ...menuTmp, name_customer: `Customer ${quantityCount}`, quantity: quantityCount, menu_id: menu.id, menu_name: menu.name, price: menu.price })
    }

    const handleCancelSelectMenu = () => {
        setMenuTmp({})

        orderMenuModal.hide()
        setQuantityCount(1)
    }

    const addToOrderedMenus = () => {
        orderMenuModal.hide()

        setOrderedMenus([...orderedMenus,
        {
            name_customer: menuTmp.name_customer,
            quantity: quantityCount,
            menu_id: menuTmp.menu_id,
            menu_name: menuTmp.menu_name,
            price: menuTmp.price
        }
        ])

        setQuantityCount(1)
    }

    const removeFromOrderedMenus = (menu) => {
        const findObjectIndex = orderedMenus.findIndex(key => key.menu_id == menu.menu_id)
        // orderedMenus.splice(findObjectIndex)

        setOrderedMenus([
            ...orderedMenus.slice(0, findObjectIndex),
            ...orderedMenus.slice(findObjectIndex + 1, orderedMenus.length)
        ])

        console.log(orderedMenus)
    }

    const calculateTotalPrice = () => {
        let total = 0

        orderedMenus.map((menu) => {
            return total += (toNumber(menu.price) * menu.quantity)
        })

        return rupiahFormatter(total)
    }

    const decreaseQuantityOnOrderedMenu = (menu) => {
        let decreaseQuantity = orderedMenus.map(item => {
            if (item.menu_id == menu.menu_id) {
                return { ...item, quantity: item.quantity != 1 ? item.quantity - 1 : item.quantity }
            }

            return item
        })

        setOrderedMenus(decreaseQuantity)
    }

    const increaseQuantityOnOrderedMenu = (menu) => {
        let increaseQuantity = orderedMenus.map(item => {
            if (item.menu_id == menu.menu_id) {
                return { ...item, quantity: item.quantity + 1 }
            }

            return item
        })

        setOrderedMenus(increaseQuantity)
    }

    // const 

    const rupiahFormatter = (number) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(number);
    }

    return (
        <Fragment>
            <div>
                <div className="container">
                    <div className="row my-5">

                        <div className="row mt-5">
                            <div className="col-md-6 offset-md-3">
                                <input type="text" className="form-control mb-4" id="input-search-desktop" placeholder="Cari menu..." />
                            </div>
                        </div>

                        <div className="col-md-12 mt-5">
                            <table class="table" id="menuFrontendTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {filtertedData.map((menu, index) => (
                                        <tr key={menu.id} onClick={() => handleSelectMenu(menu)}>
                                            <td>{index + 1}</td>
                                            <td>{menu.name}</td>
                                            <td>{rupiahFormatter(menu.price)}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>

                            <div id="modalQuantity" class="modal fade" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modal title</h5>
                                        </div>
                                        <div class="modal-body">
                                            <div className="form-group">
                                                <label htmlFor="">Quantity</label>
                                                <div class="input-group mt-2 mb-3">
                                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2" onClick={() => setQuantityCount(quantityCount == 1 ? 1 : quantityCount - 1)}>-</button>
                                                    <input type="text" class="form-control" value={quantityCount} />
                                                    <button class="btn btn-outline-secondary" type="button" id="button-addon2" onClick={() => setQuantityCount(quantityCount + 1)}>+</button>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" onClick={() => handleCancelSelectMenu()} >Batal</button>
                                            <button type="button" class="btn btn-danger" onClick={() => addToOrderedMenus()}>Tambahkan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-bottom ">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">Pesanan {orderedMenus.length}</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarFooterToggler" aria-controls="navbarFooterToggler" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarFooterToggler">
                            <div class="navbar-nav">
                                <a class="nav-link" href="#" tabindex="-1" onClick={() => cartModal.show()}>Keranjang</a>
                            </div>
                        </div>
                    </div>
                </nav>

                <div id="previewPreCheckoutModal" class="modal" tabindex="-1">
                    <div class="modal-dialog modal-fullscreen">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Keranjang</h5>
                                <button type="button" class="btn-close" onClick={() => cartModal.hide()}></button>
                            </div>
                            <div class="modal-body">
                                {orderedMenus.map((menu, index) => (
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div className="row">
                                                <div className="col-9">
                                                    {menu.menu_name} <span class="badge bg-secondary">{menu.quantity}</span> {rupiahFormatter(menu.price)} x {menu.quantity} -> {rupiahFormatter(menu.price * menu.quantity)}
                                                </div>
                                                <div className="col-3">
                                                    <a href="javascript: void(0)" className="text-danger" onClick={() => removeFromOrderedMenus(menu)}>Hapus</a>
                                                </div>
                                            </div>

                                        </div>
                                        <div className="card-footer">

                                            <div class="input-group mb-3">
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon2" onClick={() => decreaseQuantityOnOrderedMenu(menu)}>-</button>
                                                <input type="text" class="form-control" value={menu.quantity} />
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon2" onClick={() => increaseQuantityOnOrderedMenu(menu)}>+</button>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            <div class="modal-footer">
                                <h6>Total harga: {calculateTotalPrice()}</h6>
                                <button type="button" class="btn btn-secondary" onClick={() => cartModal.hide()}>Close</button>
                                {/* <InertiaLink
                          tabIndex="-1" onClick={() => cartModal.hide()}
                          href={'/checkout'}
                          className="flex items-center px-4"
                        >
                        Checkout
                        </InertiaLink> */}
                                <Link className="btn btn-danger" onClick={() => cartModal.hide()} href={`/frontend/checkout?ordered_menus=${JSON.stringify(orderedMenus)}`}>Checkout</Link>
                                {/* <Link className="btn btn-danger" onClick={() => cartModal.hide()} href={`/checkout`} method="get" data={{ ordered_menus: `${JSON.stringify(orderedMenus)}` }}>Checkout</Link> */}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Fragment>
    )
}

Order.layout = page => <Layout children={page} title="Tes title order" />

export default Order;