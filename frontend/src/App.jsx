import { useState } from 'react'
import './App.css'
import Navbar from "./components/layouts/Navbar.jsx";
import Footer from "./components/layouts/Footer.jsx";
import Login from "./components/auth/Login.jsx";
import {Route, Routes} from "react-router-dom";

function App() {
    return (
        <div className="flex flex-col min-h-screen">
            <Navbar/>
                <main className="flex flex-1 bg-gray-200 items-center justify-center">
                    <Routes>
                        <Route path='/login' element={<Login/>}/>
                    </Routes>
                </main>
            <Footer/>
        </div>
    )
}

export default App
