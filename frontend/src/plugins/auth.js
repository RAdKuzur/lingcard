import axios from "axios";
import {apiRoutes} from "./apiRoutes.js";
import Cookies from 'js-cookie';
import {use} from "react";
import {useNavigate} from "react-router-dom";
import {innerRoutes} from "./routes.js";
export async function loginAxios(email, password, setAuth) {
    const responseToken = await axios.get(apiRoutes.csrf, { withCredentials: true });
    const csrfToken = Cookies.get('XSRF-TOKEN')
    const response = await axios.post(
        apiRoutes.login,
        {
            email: email,
            password: password
        },
        {
            headers: {
                'X-XSRF-TOKEN': csrfToken
            },
            withCredentials: true
        }
    );
    const data = await response.data;
    setAuth(true);
    localStorage.setItem('username', data.user.username);
    localStorage.setItem('role', data.user.role);
}

export async function logoutAxios(setAuth) {
    const responseToken = await axios.get(apiRoutes.csrf, { withCredentials: true });
    const csrfToken = Cookies.get('XSRF-TOKEN')
    console.log(csrfToken)
    const response = await axios.post(
        apiRoutes.logout,
        null,
        {
            headers: {
                'X-XSRF-TOKEN': csrfToken
            },
            withCredentials: true
        }
    );
    setAuth(false);
    localStorage.removeItem('username');
    localStorage.removeItem('role');
}