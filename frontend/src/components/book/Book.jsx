import {useRedirect} from "../../hooks/useRedirect.js";
import {useEffect, useRef, useState} from "react";
import {get} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import {innerRoutes} from "../../plugins/routes.js";
import {getText, lang} from "../../lang/lang.js";
import ButtonBack from "../layouts/ButtonBack.jsx";

export default function Book() {
    const {redirect} = useRedirect()
    const [title, setTitle] = useState('')
    const [chapters, setChapters] = useState([])

    useEffect(() => {
        const fetchPosts = async () => {
            try {
                const id = window.location.pathname.split('/').pop();
                const response = await get(apiRoutes.books + '/' + id, {}, {withCredentials: true});
                const data = await response.data;
                setTitle(data.title)
                setChapters(data.chapters)

            } catch (error) {
                console.error('Error fetching books:', error);
            }
        };
        fetchPosts();
    }, []);
    function goToChapter(id) {
        redirect(innerRoutes.chapters + '/' + id);
    }

    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="max-w-5xl mx-auto space-y-8">
                <div>
                    <div className={"flex justify-between items-center mb-3"}>
                        <div className="flex items-center gap-4">
                            <ButtonBack/>
                            <h1 className="text-2xl font-bold text-slate-800">{title}</h1>
                        </div>
                        <div className={'flex items-center gap-4 justify-between'}>
                        </div>
                    </div>
                    {chapters.length > 0 ? (
                        chapters.map((e) => (
                            <div key={e.id} className="cursor-pointer bg-white items-center gap-3 mb-4 shadow rounded-3xl p-8 transition-all"
                                 onClick={() => goToChapter(e.id)}>
                                <div className={'flex justify-between items-start'}>
                                    <div className="flex items-center gap-3 mb-4">
                                        <h1 className="text-xl font-bold text-slate-800">{e.name}</h1>
                                    </div>
                                    <div className="flex items-center gap-2 mb-4">
                                        <span className="text-sm font-medium text-slate-700">
                                            # {e.number}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <div className="text-center py-12">
                            <p className="text-slate-500 text-lg">{getText(lang.books.noChapters)}</p>
                        </div>
                    )}
                </div>
            </div>
        </main>
    );
}