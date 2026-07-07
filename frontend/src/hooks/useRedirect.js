// hooks/useRedirect.js
import { useNavigate } from 'react-router-dom';
import { useCallback } from 'react';

export function useRedirect() {
    const navigate = useNavigate();

    const isAuthenticated = useCallback(() => {
        return localStorage.getItem('username') !== null &&
            localStorage.getItem('role') !== null;
    }, []);

    const redirect = useCallback((path, options = {}) => {
        navigate(path, options);
    }, [navigate]);

    const redirectIfAuth = useCallback((path, fallbackPath = '/login', options = {}) => {
        if (isAuthenticated()) {
            navigate(path, options);
        } else {
            navigate(fallbackPath, {
                ...options,
                state: { from: path },
                replace: true
            });
        }
    }, [navigate, isAuthenticated]);

    const redirectIfNotAuth = useCallback((path, fallbackPath = '/', options = {}) => {
        if (!isAuthenticated()) {
            navigate(path, options);
        } else {
            navigate(fallbackPath, { replace: true });
        }
    }, [navigate, isAuthenticated]);

    const goBack = useCallback(() => {
        navigate(-1);
    }, [navigate]);

    const redirectWithUserData = useCallback((path, userData = {}, options = {}) => {
        navigate(path, {
            ...options,
            state: { user: userData }
        });
    }, [navigate]);

    return {
        redirect,
        redirectIfAuth,
        redirectIfNotAuth,
        goBack,
        redirectWithUserData,
        isAuthenticated
    };
}