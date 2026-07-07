import { Navigate } from 'react-router-dom';

const ProtectedRoute = ({ children }) => {
    const isAuth = localStorage.getItem('username') !== null &&
        localStorage.getItem('role') !== null;

    if (!isAuth) {
        return <Navigate to="/login" replace />;
    }

    return children;
};

export default ProtectedRoute;