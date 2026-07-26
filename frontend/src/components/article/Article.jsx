import {useEffect, useState} from "react";
import {get, post} from "../../plugins/request.js";
import {apiCreateComment, apiRoutes} from "../../plugins/apiRoutes.js";
import ButtonBack from "../layouts/ButtonBack.jsx";
import {getText, lang} from "../../lang/lang.js";
export default function Article() {
    const [article, setArticle] = useState([])
    const [isLike, setLike] = useState(false)
    const [isDislike, setDislike] = useState(false)
    const [likeCount, setLikeCount] = useState(0)
    const [dislikeCount, setDislikeCount] = useState(0)
    const [comments, setComments] = useState([])
    const [textComment, setTextComment] = useState('')
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
            setComments(data.comments)
        };
        fetchArticle();
    }, [])


    function like() {
        const id = window.location.pathname.split('/').pop();
        if (isDislike) {
            setDislike(false)
            setDislikeCount(prev => prev - 1)
            reactUnset(id)
            setLike(true)
            setLikeCount(prev => prev + 1)
            reactLike(id)
        } else if (!isLike) {
            setLike(true)
            setLikeCount(prev => prev + 1)
            reactLike(id)
        } else {
            setLike(false)
            setLikeCount(prev => prev - 1)
            reactUnset(id)
        }
    }

    function dislike() {
        const id = window.location.pathname.split('/').pop();
        if (isLike) {
            setLike(false)
            setLikeCount(prev => prev - 1)
            reactUnset(id)
            setDislike(true)
            setDislikeCount(prev => prev + 1)
            reactDislike(id)
        } else if (!isDislike) {
            setDislike(true)
            setDislikeCount(prev => prev + 1)
            reactDislike(id)
        } else {
            setDislike(false)
            setDislikeCount(prev => prev - 1)
            reactUnset(id)
        }
    }

    async function reactLike(id) {
        await post(apiRoutes.like + '/' + id, {}, {withCredentials: true})
    }

    async function reactDislike(id) {
        await post(apiRoutes.dislike + '/' + id, {}, {withCredentials: true})
    }

    async function reactUnset(id) {
        await post(apiRoutes.unset + '/' + id, {}, {withCredentials: true})
    }
    async function handleSendComment(text) {
        const id = window.location.pathname.split('/').pop();
        if (text !== '') {
            await post(apiCreateComment(id), {
                text: text
            }, {withCredentials: true})
            window.location.reload()
        }
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
                                {likeCount}
                            </span>
                            <span className="text-sm text-slate-600 font-medium flex items-center gap-2">
                                <svg className="w-4 h-4 cursor-pointer" fill={`${isDislike ? 'black' : 'none'}`} stroke="currentColor" viewBox="0 0 24 24" onClick={dislike}>
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                                          d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018c.163 0 .326.02.485.06L17 4m-7 10v5a2 2 0 002 2h.095c.5 0 .905.405.905.905 0 .714.211 1.412.608 2.006L17 13v-9m-7 10h2M17 4h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/>
                                </svg>
                                {dislikeCount}
                            </span>
                        </div>
                    </div>
                </div>
                <div id={"comments"} className={"bg-white items-center gap-3 mb-4 shadow rounded-3xl p-8 transition-all"}>
                    <div>
                        <div className="flex items-center gap-3 mb-4">
                            <h1 className="text-xl font-bold text-slate-800">{getText(lang.article.comments)}</h1>
                        </div>
                        <div className="flex items-center gap-3 mb-4">
                            <input className={'w-full rounded-2xl p-2 outline-2 border-black'} onInput={(e) => {setTextComment(e.target.value)}}></input>
                            <button className={'bg-indigo-500 p-2 rounded-2xl cursor-pointer'} onClick={() => handleSendComment(textComment)}>
                                <span className={'text-white font-bold'}>
                                    {getText(lang.article.send)}
                                </span>
                            </button>
                        </div>
                        <hr className="border-black-500 mb-3 mt-3"/>
                        {comments.length > 0 ? (
                            comments.map((e) => (
                                <div key={e.id}
                                     className="bg-white items-center p-8 transition-all">
                                    <div className={'flex justify-between items-start'}>
                                        <div className="flex items-center gap-3 mb-4">
                                            <h6 className="font-bold text-slate-800">{e.username}</h6>
                                            {e.is_fixed && (
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" className="bi bi-pin" viewBox="0 0 16 16">
                                                    <path
                                                        d="M4.146.146A.5.5 0 0 1 4.5 0h7a.5.5 0 0 1 .5.5c0 .68-.342 1.174-.646 1.479-.126.125-.25.224-.354.298v4.431l.078.048c.203.127.476.314.751.555C12.36 7.775 13 8.527 13 9.5a.5.5 0 0 1-.5.5h-4v4.5c0 .276-.224 1.5-.5 1.5s-.5-1.224-.5-1.5V10h-4a.5.5 0 0 1-.5-.5c0-.973.64-1.725 1.17-2.189A6 6 0 0 1 5 6.708V2.277a3 3 0 0 1-.354-.298C4.342 1.674 4 1.179 4 .5a.5.5 0 0 1 .146-.354m1.58 1.408-.002-.001zm-.002-.001.002.001A.5.5 0 0 1 6 2v5a.5.5 0 0 1-.276.447h-.002l-.012.007-.054.03a5 5 0 0 0-.827.58c-.318.278-.585.596-.725.936h7.792c-.14-.34-.407-.658-.725-.936a5 5 0 0 0-.881-.61l-.012-.006h-.002A.5.5 0 0 1 10 7V2a.5.5 0 0 1 .295-.458 1.8 1.8 0 0 0 .351-.271c.08-.08.155-.17.214-.271H5.14q.091.15.214.271a1.8 1.8 0 0 0 .37.282"/>
                                                </svg>
                                            )}
                                        </div>
                                        <div className="flex items-center gap-2 mb-4">
                                            <span className="text-slate-500 ml-1">
                                                {e.time}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <p className="text-slate-600 leading-relaxed text-lg">
                                            {e.text}
                                        </p>
                                    </div>
                                </div>
                            ))
                        ) : (
                            <div className="text-center">
                                <p className="text-slate-500 text-lg">{getText(lang.article.noComments)}</p>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </main>
    );
}