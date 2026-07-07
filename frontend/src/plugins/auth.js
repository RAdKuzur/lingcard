import axios from "axios";
import {apiRoutes} from "./apiRoutes.js";
import {post} from "./request.js";
import {innerRoutes} from "./routes.js";
export async function loginAxios(email, password, setAuth, redirect) {
    const response = await axios.post(
        apiRoutes.login,
        {
            email: email,
            password: password
        },
        {
            withCredentials: true
        }
    );
    const data = await response.data;
    setAuth(true);
    redirect(innerRoutes.home);
    localStorage.setItem('username', data.user.username);
    localStorage.setItem('role', data.user.role);
}

export async function logoutAxios(setAuth) {
    const response = post(
        apiRoutes.logout,
        null,
        {
            withCredentials: true
        }
    );
    setAuth(false);
    localStorage.removeItem('username');
    localStorage.removeItem('role');
}

export function checkAuth(navigate) {
    if(localStorage.getItem('username') !== null && localStorage.getItem('role') !== null) {
        return true;
    }
    navigate(innerRoutes.login)
    return false;
}
