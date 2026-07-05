import {useEffect, useState} from 'react'
import './App.css'
import Navbar from "./components/layouts/Navbar.jsx";
import Footer from "./components/layouts/Footer.jsx";
import Login from "./components/auth/Login.jsx";
import {Route, Routes} from "react-router-dom";
import Home from "./components/home/Home.jsx";
import {innerRoutes} from "./plugins/routes.js";
import Training from "./components/training/Training.jsx";
import Dictionary from "./components/dictionary/Dictionary.jsx";
import Progress from "./components/progress/Progress.jsx";
import Profile from "./components/profile/Profile.jsx";
import Knowledge from "./components/knowledge/Knowledge.jsx";

function App() {
    const [isAuth, setAuth] = useState(false);

    useEffect(() => {
        if (localStorage.getItem('username') !== null && localStorage.getItem('role') !== null) {
            setAuth(true)
        }
        else {
            setAuth(false)
        }
    })
    return (
        <div className="flex flex-col min-h-screen">
            <Navbar isAuth={isAuth}/>
                <Routes>
                    <Route path={innerRoutes.all} element={<Home/>}/>
                    <Route path={innerRoutes.login} element={<Login setAuth={setAuth}/>}/>
                    <Route path={innerRoutes.home} element={<Home/>}/>
                    <Route path={innerRoutes.training} element={<Training/>}/>
                    <Route path={innerRoutes.progress} element={<Progress/>}/>
                    <Route path={innerRoutes.dictionary} element={<Dictionary/>}/>
                    <Route path={innerRoutes.profile} element={<Profile setAuth={setAuth}/>}/>
                    <Route path={innerRoutes.knowledge} element={<Knowledge/>}/>
                </Routes>
            <Footer/>
        </div>
    )
}

export default App
