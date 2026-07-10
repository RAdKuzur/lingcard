import React from 'react';
import { Navigate } from 'react-router-dom';
import { innerRoutes } from "../../plugins/routes.js";
import { useAuth } from "../../plugins/AuthContext.jsx";

const ProtectedRoute = ({ children, requiredRole = null }) => {
    const auth = useAuth();

    if (auth.isLoading) {
        return (
            <div className="flex justify-center items-center min-h-[200px]">
                <div className="text-gray-500">Loading...</div>
            </div>
        );
    }

    const isAuth = auth.isAuthenticated();
    console.log('ProtectedRoute: isAuth =', isAuth, 'user =', auth.user);
    if (!isAuth) {
        auth.logout();
        return <Navigate to={innerRoutes.login} replace />;
    }
    return children;
};

export default ProtectedRoute;