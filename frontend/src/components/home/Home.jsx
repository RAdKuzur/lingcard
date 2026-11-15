import { useState, useEffect } from 'react';
import {apiRoutes} from "../../plugins/apiRoutes.js";
import {get} from "../../plugins/request.js";
import {useRedirect} from "../../hooks/useRedirect.js";
import {innerRoutes} from "../../plugins/routes.js";
import {useAuth} from "../../plugins/AuthContext.jsx";
import {getText, lang} from "../../lang/lang.js";
import Loading from "../layouts/Loading.jsx";

export default function Home() {
    const [loading, setLoading] = useState(true)
    const [map, setMap] = useState([]);
    const {redirect} = useRedirect();
    const auth = useAuth();
    useEffect(() => {
        async function Languages() {
            const response = await get(apiRoutes.langMap, {}, { withCredentials: true });
            const data = await response.data;
            setMap(data.map);
            setLoading(false)
        }
        Languages();
    }, []);

    function goLogin() {
        return redirect(innerRoutes.login)
    }
    function goRegister() {
        return redirect(innerRoutes.register)
    }
    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            {
                loading ? (<Loading></Loading>) :
                (
                    <div className="max-w-6xl mx-auto">
                        <div className="text-center mb-8">
                            <h1 className="text-4xl sm:text-5xl font-bold text-slate-800 mb-4">
                                LingCard
                            </h1>
                            <p className="text-lg sm:text-xl text-slate-600 max-w-3xl mx-auto mb-6">
                                {getText(lang.home.mainLabel)}
                            </p>
                            {!auth.isAuthenticated() ? (
                                <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                                    <button className="cursor-pointer px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105"
                                            onClick={goRegister}
                                    >
                                        {getText(lang.home.startTraining)}
                                    </button>
                                    <button className="cursor-pointer px-8 py-3 bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg border border-slate-200 transform hover:scale-105"
                                            onClick={goLogin}
                                    >
                                        {getText(lang.home.login)}
                                    </button>
                                </div>)
                                :
                            <></>}
                        </div>
                        <div className="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div
                                className="px-1 sm:px-1 py-4 bg-gradient-to-r from-slate-50 to-white border-b border-slate-200">
                                <h2 className="text-lg font-semibold text-slate-800 flex items-center gap-2">
                                    <span className="w-1.5 h-5 rounded-full"/>
                                    {getText(lang.home.availableLang)}
                                </h2>
                            </div>

                            <div className="p-3 sm:p-4">
                                <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3">
                                    {map.map((language) => (
                                        <div
                                            key={language.code}
                                            className="group relative flex items-center gap-3 p-3 rounded-xl
                               border border-slate-200 bg-white
                               hover:border-indigo-300 hover:bg-indigo-50/40
                               hover:shadow-md hover:-translate-y-0.5
                               transition-all duration-200"
                                        >
                                            <div className="relative flex-shrink-0">
                                                <img
                                                    src={`/flags/${language.code}.svg`}
                                                    alt={language.code}
                                                    className="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-sm
                                                       outline outline-1 outline-black/60"
                                                />
                                            </div>
                                            <div className="flex-1 min-w-0">
                                                <div className="text-sm font-semibold text-slate-800 truncate">
                                                {language.label}
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                )
            }
        </main>
    );
}