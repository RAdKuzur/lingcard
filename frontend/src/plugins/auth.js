import axios from "axios";
import {apiRoutes} from "./apiRoutes.js";
import Cookies from 'js-cookie';
export async function loginAxios(email, password) {
    const responseToken = await axios.get(apiRoutes.csrf)
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
}