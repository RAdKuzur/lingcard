import {useEffect, useState} from "react";
import {get} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import ButtonBack from "../layouts/ButtonBack.jsx";
import {getText, lang} from "../../lang/lang.js";
export default function Article() {
    const [article, setArticle] = useState([])


    useEffect(() => {
        const fetchArticle = async () => {
            const id = window.location.pathname.split('/').pop();
            const response = await get(apiRoutes.article + '/' + id, {}, { withCredentials: true });
            const data = await response.data;
            setArticle(data);
        };
        fetchArticle();
    }, [])

    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="flex max-w-5xl mx-auto justify-start mb-6">
                <ButtonBack/>
            </div>
            <div className="max-w-5xl mx-auto space-y-8">
                <div key={article.id}
                     className="bg-white items-center gap-3 mb-4 shadow rounded-3xl p-8 transition-all">
                    <div className={'flex justify-between items-start'}>
                        <div className="flex items-center gap-3 mb-4">
                            <h1 className="text-xl font-bold text-slate-800">{article.title}</h1>
                        </div>
                        <div className="flex items-center gap-2 mb-4">
                            <img
                                src={`/flags/${article.code}.svg`}
                                alt={article.code}
                                className="w-6 h-6 rounded-sm object-cover"
                            />
                            <span className="text-sm font-medium text-slate-700">
                                {article.code}
                            </span>
                            <span className="text-sm text-slate-500 ml-1">
                                {article.date}
                            </span>
                        </div>
                    </div>
                    <div>
                        <p className="text-slate-600 leading-relaxed text-lg">
                            {article.content}
                        </p>
                    </div>
                    <div className="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
                        <div className="flex items-center gap-2">
                            <span className="text-sm text-slate-600 font-medium">
                            Автор: {article.username}
                            </span>
                        </div>
                        <div className="flex items-center gap-2">
                            <svg className="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                                <span className="text-sm text-slate-500">
                                {article.address}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    );
}