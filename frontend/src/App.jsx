import { useState } from 'react'
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

function App() {
    return (
        <div className="flex flex-col min-h-screen">
            <Navbar/>
                <Routes>
                    <Route path={innerRoutes.login} element={<Login/>}/>
                    <Route path={innerRoutes.home} element={<Home/>}/>
                    <Route path={innerRoutes.training} element={<Training/>}/>
                    <Route path={innerRoutes.progress} element={<Progress/>}/>
                    <Route path={innerRoutes.dictionary} element={<Dictionary/>}/>
                    <Route path={innerRoutes.profile} element={<Profile/>}/>
                </Routes>
            <Footer/>
        </div>
    )
}

export default App
