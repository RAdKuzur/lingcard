import { Navigate } from 'react-router-dom';
import {innerRoutes} from "../../plugins/routes.js";

const ProtectedRoute = ({ children }) => {
    const isAuth = localStorage.getItem('username') !== null &&
        localStorage.getItem('role') !== null;

    if (isAuth) {
        return <Navigate to={innerRoutes.home} replace />;
    }

    return children;
};

export default ProtectedRoute;