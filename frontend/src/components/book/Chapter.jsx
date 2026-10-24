import {useEffect, useState} from "react";
import {get} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import {getText, lang} from "../../lang/lang.js";
import ButtonBack from "../layouts/ButtonBack.jsx";

export default function Chapter() {
    const [chapter, setChapter] = useState(null)
    const [textChapter, setTextChapter] = useState(null)
    useEffect(() => {
        const fetchPosts = async () => {
            try {
                const id = window.location.pathname.split('/').pop();
                const response = await get(apiRoutes.chapters + '/' + id, {}, {withCredentials: true});
                const data = await response.data;
                setChapter(data);
                setTextChapter(JSON.parse(data.content))
            } catch (error) {
                console.error('Error fetching chapter:', error);
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
                            <div className="pt-4 border-t border-slate-100">
                                {textChapter.map((paragraph, pIndex) => (
                                    <p
                                        key={pIndex}
                                        className="text-slate-600 font-medium mb-4"
                                    >
                                        <span className="inline-flex flex-wrap items-center gap-x-1 gap-y-1">
                                            {paragraph.map((e, index) => {
                                                const isPunct = /^[.,;:!?–—-]+$/.test(e.word);
                                                return (
                                                    <span
                                                        key={index}
                                                        className={
                                                            "relative inline-block " +
                                                            (isPunct ? "-ml-1" : "")
                                                        }
                                                    >
                                                        {e.hints ? (
                                                            <span className="group relative inline-block cursor-help">
                                                                <span
                                                                    className="rounded-md bg-slate-100 text-slate-700 border-b border-dashed border-slate-400 transition-colors group-hover:bg-indigo-50 group-hover:text-indigo-700 group-hover:border-indigo-400">
                                                                    {e.word}
                                                                </span>
                                                                <span
                                                                    role="tooltip"
                                                                    className="pointer-events-none absolute left-1/2 bottom-full mb-2 -translate-x-1/2 whitespace-nowrap rounded-lg bg-slate-800 px-2.5 py-1 text-xs font-normal text-white opacity-0 shadow-lg transition-opacity duration-150 group-hover:opacity-100 group-focus-within:opacity-100"
                                                                >
                                                                    {e.hints}
                                                                    <span
                                                                        className="absolute top-full border-4 border-transparent border-t-slate-800"/>
                                                                </span>
                                                            </span>
                                                        ) : (
                                                            <span>{e.word}</span>
                                                        )}
                                                    </span>
                                                );
                                            })}
                                        </span>
                                    </p>
                                ))}
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