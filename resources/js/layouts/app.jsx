import { Link, usePage } from "@inertiajs/inertia-react"
import axios from "axios";
import { Fragment, useEffect } from "react"

const Layout = ({ children }) => {

    useEffect(() => {
        // const navLinks = document.querySelectorAll('.nav-item')
        // const menuToggle = document.getElementById('navbarSupportedContent')
        // const bsCollapse = new bootstrap.Collapse(menuToggle)
        // navLinks.forEach((l) => {
        //     l.addEventListener('click', () => { bsCollapse.toggle() })
        // })
    }, [])

    const handleLogout = () => {
        const csrfElement = window.document.getElementsByName('csrf-token')[0]
        const csrf = csrfElement.getAttribute('content')

        axios.post(window.location.protocol + "//" + window.location.host + '/logout', {
            "_token": csrf
        })
            .then(function (response) {
                window.location.replace("/login")
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    return (
        <Fragment>
            <nav class="navbar navbar-expand-lg bg-white fixed-top shadow-sm">
                <div class="container" id="navbar-container">
                    <a class="navbar-brand" id="navbar-brand" href="/frontend/order">Coffee Shop</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <Link className="nav-link" href="/frontend/order">Order</Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link" href="/frontend/order-history">Riwayat Order</Link>
                            </li>
                            <li class="nav-item">
                                <Link class="nav-link" href="/frontend/profile">Profile</Link>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-danger" onClick={() => handleLogout()} href="#">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            {/* <ul class="nav justify-content-center mt-5 nav-top">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                </li>
            </ul> */}

            <div className="content">
                {children}
            </div>
            {/* <footer>Ini footer</footer> */}
        </Fragment>
    )
}

export default Layout