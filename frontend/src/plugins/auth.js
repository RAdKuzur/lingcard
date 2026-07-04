import axios from "axios";
import {apiRoutes} from "./apiRoutes.js";
import {post} from "./request.js";
export async function loginAxios(email, password, setAuth) {
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