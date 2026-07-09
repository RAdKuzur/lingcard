import React from 'react';
import { Navigate } from 'react-router-dom';
import { innerRoutes } from "../../plugins/routes.js";
import {useAuth} from "../../plugins/AuthContext.jsx";

const UnprotectedRoute = ({ children, redirectTo = innerRoutes.home }) => {
    const auth = useAuth();
    if (auth.isLoading) {
        return (
            <div className="loading-spinner">
                Loading...
            </div>
        );
    }

    if (auth.isAuthenticated()) {
        return <Navigate to={redirectTo} replace />;
    }

    return children;
};

export default UnprotectedRoute;