import {useEffect, useState} from "react";
import {get} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import {getText, lang} from "../../lang/lang.js";
import ButtonBack from "../layouts/ButtonBack.jsx";

export default function Chapter() {
    const [chapter, setChapter] = useState(null)
    useEffect(() => {
        const fetchPosts = async () => {
            try {
                const id = window.location.pathname.split('/').pop();
                const response = await get(apiRoutes.chapters + '/' + id, {}, {withCredentials: true});
                const data = await response.data;
                setChapter(data);
            } catch (error) {
                console.error('Error fetching books:', error);
            }
        };
        fetchPosts();
    }, []);
    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="max-w-5xl mx-auto space-y-8">
                <div>
                    <div className={"flex justify-between items-center mb-3"}>
                        <div className="flex items-center gap-4">
                            <ButtonBack/>
                        </div>
                    </div>
                    {chapter ? (
                        <div key={chapter.id}
                             className="bg-white items-center gap-3 mb-4 shadow rounded-3xl p-8 transition-all"
                        >
                            <div className={'flex justify-between items-start'}>
                                <div className="flex items-center gap-3 mb-4">
                                    <h1 className="text-xl font-bold text-slate-800">{chapter.author + ". " + chapter.book + ". " + chapter.name}</h1>
                                </div>
                                <div className="flex items-center gap-2 mb-4">
                                    <span className="text-sm font-medium text-slate-700">
                                        # {chapter.number}
                                    </span>
                                </div>
                            </div>
                            <div className="pt-4 border-t border-slate-100 flex justify-between items-center">
                                <div className="flex items-center gap-2">
                                        <span className="text-sm text-slate-600 font-medium">
                                            {chapter.content}
                                        </span>
                                </div>
                            </div>
                        </div>
                    ) : (
                        <div className="text-center py-12">
                            <p className="text-slate-500 text-lg">{getText(lang.books.emptyChapter)}</p>
                        </div>
                    )}
                </div>
            </div>
        </main>
    );
}