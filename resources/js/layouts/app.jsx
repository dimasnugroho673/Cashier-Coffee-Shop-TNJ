import { Link, usePage } from "@inertiajs/inertia-react"
import axios from "axios";
import { Fragment } from "react"

const Layout = ({ children }) => {

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
            <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                <div class="container" id="navbar-container">
                    <a class="navbar-brand" href="/frontend/order">Coffee shop</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarExpandToggler" aria-controls="navbarExpandToggler" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarExpandToggler">
                        <div class="navbar-nav">
                            <Link href="/frontend/order" className="nav-link active">Order</Link>
                        </div>
                        <div class="navbar-nav">
                            <Link class="nav-link active" href="/frontend/order-history">Riwayat Order</Link>
                        </div>
                        <div class="navbar-nav">
                            <Link class="nav-link active" href="/frontend/profile">Profile</Link>
                        </div>
                        <div class="navbar-nav">
                            <a class="nav-link text-danger" onClick={() => handleLogout()} href="#">Logout</a>
                        </div>
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
            <footer>Ini footer</footer>
        </Fragment>
    )
}

export default Layout