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
import About from "./components/about/About.jsx";
import ProtectedRoute from "./components/layouts/ProtectedRoute.jsx";
import Register from "./components/auth/Register.jsx";
import UnprotectedRoute from "./components/layouts/UnprotectedRoute.jsx";
import echo from "./plugins/echo.js";
import {useAuth} from "./plugins/AuthContext.jsx";
import Article from "./components/article/Article.jsx";
function App() {
    const auth = useAuth()
    const username = auth.user?.username;
    const [notification, setNotification] = useState(null);
    useEffect(() => {
        if (!username) return;
        const channel = echo.channel(`private-notifications.${username}`);
        channel.listen(`.words.repeated`, (e) => {
            setNotification(e.message);
            setTimeout(() => {
                setNotification(null);
            }, 5000);
        });
        return () => {
            echo.leaveChannel(`private-notifications.${username}`);
        };
    }, [username]);

    return (
        <div className="flex flex-col min-h-screen">
            <Navbar/>
            <Routes>
                <Route path={innerRoutes.register} element={
                    <UnprotectedRoute>
                        <Register/>
                    </UnprotectedRoute>
                }/>
                <Route path={innerRoutes.login} element={
                    <UnprotectedRoute>
                        <Login/>
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
                <Route path={innerRoutes.articlePath} element={
                    <ProtectedRoute>
                        <Article/>
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
                        <Profile/>
                    </ProtectedRoute>
                }/>
                <Route path={innerRoutes.about} element={
                    <ProtectedRoute>
                        <About/>
                    </ProtectedRoute>
                }/>
            </Routes>
            {notification && (
                <div className="fixed bottom-5 right-5 bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg">
                    {notification}
                </div>
            )}
            <Footer/>
        </div>
    )
}

export default App