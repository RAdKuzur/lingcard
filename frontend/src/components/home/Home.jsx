import PanelHome from "./PanelHome.jsx";
import {innerRoutes} from "../../plugins/routes.js";
import ButtonBack from "../layouts/ButtonBack.jsx";
import {useState} from "react";
import {get} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import {getText, lang} from "../../lang/lang.js";
import {useRedirect} from "../../hooks/useRedirect.js";

export default function Home() {
    const {redirect} = useRedirect()
    const [language, setLanguage] = useState('')
    const [news, setNews] = useState([])
    const countries = [
        { name: 'Қазақша', flag: '/flags/kz.svg' },
        { name: 'Русский', flag: '/flags/ru.svg' },
    ];

    useState(async () => {
        const lang1 = localStorage.getItem('lang') ?? 'ru'
        const response = await get(apiRoutes.news + '/' + lang1, {}, {withCredentials: true})
        const data = await response.data
        setNews(data)
        setLanguage(lang1)
    },[])
    function goToArticle(id) {
        redirect(innerRoutes.article + '/' + id)
    }
    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="max-w-5xl mx-auto space-y-8">
                <div>
                    <div className="flex items-center gap-3 mb-4 pl-4">
                        <h1 className="text-2xl font-bold text-slate-800">{getText(lang.home.news)}</h1>
                    </div>
                    {
                        news.length > 0 ?
                            (news.map((e) => (
                                <div key={e.id} className="cursor-pointer bg-white items-center gap-3 mb-4 shadow rounded-3xl p-8 transition-all" onClick={() => goToArticle(e.id)}>
                                    <div className={'flex justify-between items-start'}>
                                        <div className="flex items-center gap-3 mb-4">
                                            <h1 className="text-xl font-bold text-slate-800">{e.title}</h1>
                                        </div>
                                        <div className="flex items-center gap-2 mb-4">
                                            <img
                                                src={`/flags/${language}.svg`}
                                                alt={language}
                                                className="w-6 h-6 rounded-sm object-cover"
                                                onError={(e) => {
                                                    e.target.style.display = 'none';
                                                }}
                                            />
                                            <span className="text-sm font-medium text-slate-700">
                                                {language}
                                            </span>
                                            <span className="text-sm text-slate-500 ml-1">
                                                {e.date}
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <p className="text-slate-600 leading-relaxed text-lg">
                                            {e.content}
                                        </p>
                                    </div>
                                    <div className="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
                                        <div className="flex items-center gap-2">
                                            <span className="text-sm text-slate-600 font-medium">
                                            Автор: {e.username}
                                        </span>
                                        </div>
                                        <div className="flex items-center gap-2">
                                            <svg className="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span className="text-sm text-slate-500">
                                            {e.address}
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            )))
                            : ''
                    }
                </div>
            </div>
        </main>
    );
}