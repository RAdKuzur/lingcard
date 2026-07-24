import {useEffect, useState} from "react";
import {get, post} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import ButtonBack from "../layouts/ButtonBack.jsx";
import {getText, lang} from "../../lang/lang.js";
export default function Article() {
    const [article, setArticle] = useState([])
    const [isLike, setLike] = useState(false)
    const [isDislike, setDislike] = useState(false)
    const [likeCount, setLikeCount] = useState(0)
    const [dislikeCount, setDislikeCount] = useState(0)
    useEffect(() => {
        const fetchArticle = async () => {
            const id = window.location.pathname.split('/').pop();
            const response = await get(apiRoutes.article + '/' + id, {}, { withCredentials: true });
            const data = await response.data;
            setArticle(data);
            setLike(data.is_liked)
            setDislike(data.is_disliked)
            setLikeCount(data.likes_count)
            setDislikeCount(data.dislikes_count)
        };
        fetchArticle();
    }, [])


    function like() {
        const id = window.location.pathname.split('/').pop();
        if(dislikeCount) {
            setDislike(false)
            reactUnset(id)
        }
        if (!isLike) {
            setLike(true)
            reactLike(id)
        }
        else {
            setLike(false)
            reactUnset(id)
        }
    }

    function dislike() {
        const id = window.location.pathname.split('/').pop();
        if (isLike) {
            setLike(false)
            reactUnset(id)
        }
        if (!isDislike) {
            setDislike(true)
            reactDislike(id)
        }
        else {
            setDislike(false)
            reactUnset(id)
        }
    }

    async function reactLike(id) {
        const response = await post(apiRoutes.like + '/' + id, {}, {withCredentials: true})
    }
    async function reactDislike(id) {
        const response = await post(apiRoutes.dislike + '/' + id, {}, {withCredentials: true})
    }
    async function reactUnset(id) {
        const response = await post(apiRoutes.unset + '/' + id, {}, {withCredentials: true})
    }

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
                    <div className="mt-4 pt-4 border-t border-slate-100 flex gap-4 justify-between items-center">
                        <div className="flex gap-4 items-center">
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
                        <div className={"flex gap-4 items-center"}>
                            <span className="text-sm text-slate-600 font-medium flex items-center gap-2">
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {article.views_count ?? 0}
                            </span>
                            <span className="text-sm text-slate-600 font-medium flex items-center gap-2">
                                <svg className="w-4 h-4 cursor-pointer" fill={`${isLike ? 'black' : 'none'}`} stroke="currentColor" viewBox="0 0 24 24" onClick={like}>
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                          d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                </svg>
                                {likeCount ?? 0}
                            </span>
                            <span className="text-sm text-slate-600 font-medium flex items-center gap-2">
                                <svg className="w-4 h-4 cursor-pointer" fill={`${isDislike ? 'black' : 'none'}`} stroke="currentColor" viewBox="0 0 24 24" onClick={dislike}>
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                          d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018c.163 0 .326.02.485.06L17 4m-7 10v5a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13v-9m-7 10h2M17 4h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/>
                                </svg>
                                {dislikeCount ?? 0}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    );
}