import {useEffect, useState} from 'react'
import './App.css'
import Navbar from "./components/layouts/Navbar.jsx";
import Footer from "./components/layouts/Footer.jsx";
import Login from "./components/auth/Login.jsx";
import {Route, Routes, Navigate} from "react-router-dom";
import Home from "./components/home/Home.jsx";
import {innerRoutes} from "./plugins/routes.js";
import Training from "./components/training/Training.jsx";
import Dictionary from "./components/dictionary/Dictionary.jsx";
import Progress from "./components/progress/Progress.jsx";
import Profile from "./components/profile/Profile.jsx";
import Knowledge from "./components/knowledge/Knowledge.jsx";
import ProtectedRoute from "./components/layouts/ProtectedRoute.jsx";
import Register from "./components/auth/Register.jsx";
import UnprotectedRoute from "./components/layouts/UnprotectedRoute.jsx";

function App() {
    const [isAuth, setAuth] = useState(false);

    useEffect(() => {
        const username = localStorage.getItem('username');
        const role = localStorage.getItem('role');
        setAuth(username !== null && role !== null);
    }, []);

    return (
        <div className="flex flex-col min-h-screen">
            <Navbar isAuth={isAuth}/>
            <Routes>
                <Route path={innerRoutes.register} element={
                    <UnprotectedRoute>
                        <Register/>
                    </UnprotectedRoute>
                }/>
                <Route path={innerRoutes.login} element={
                    <UnprotectedRoute>
                        <Login setAuth={setAuth}/>
                    </UnprotectedRoute>
                }/>
                <Route path={innerRoutes.all} element={
                    <ProtectedRoute>
                        <Home/>
                    </ProtectedRoute>
                }/>
                <Route path={innerRoutes.home} element={
                    <ProtectedRoute>
                        <Home/>
                    </ProtectedRoute>
                }/>
                <Route path={innerRoutes.training} element={
                    <ProtectedRoute>
                        <Training/>
                    </ProtectedRoute>
                }/>
                <Route path={innerRoutes.progress} element={
                    <ProtectedRoute>
                        <Progress/>
                    </ProtectedRoute>
                }/>
                <Route path={innerRoutes.dictionary} element={
                    <ProtectedRoute>
                        <Dictionary/>
                    </ProtectedRoute>
                }/>
                <Route path={innerRoutes.profile} element={
                    <ProtectedRoute>
                        <Profile setAuth={setAuth}/>
                    </ProtectedRoute>
                }/>
                <Route path={innerRoutes.knowledge} element={
                    <ProtectedRoute>
                        <Knowledge/>
                    </ProtectedRoute>
                }/>
                <Route path="*" element={<Navigate to={innerRoutes.login} replace />} />
            </Routes>
            <Footer/>
        </div>
    )
}

export default App