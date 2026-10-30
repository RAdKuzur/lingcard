import { useEffect, useRef, useState } from "react";
import { get } from "../../plugins/request.js";
import { apiRoutes } from "../../plugins/apiRoutes.js";
import { getText, lang } from "../../lang/lang.js";
import ButtonBack from "../layouts/ButtonBack.jsx";
import Loading from "../layouts/Loading.jsx";

function WordWithHint({ word, hints, help }) {
    const [open, setOpen] = useState(false);
    const [tooltip, setTooltip] = useState(false);
    const ref = useRef(null);

    useEffect(() => {
        if (!tooltip) return;
        const onDoc = (e) => {
            if (ref.current && !ref.current.contains(e.target)) setTooltip(false);
        };
        document.addEventListener("pointerdown", onDoc);
        return () => document.removeEventListener("pointerdown", onDoc);
    }, [tooltip]);

    useEffect(() => {
        if (!open) return;
        const onKey = (e) => {
            if (e.key === "Escape") setOpen(false);
        };
        document.addEventListener("keydown", onKey);
        const prevOverflow = document.body.style.overflow;
        document.body.style.overflow = "hidden";
        return () => {
            document.removeEventListener("keydown", onKey);
            document.body.style.overflow = prevOverflow;
        };
    }, [open]);

    if (!help) {
        return <span className="relative inline-block">{word}</span>;
    }

    return (
        <>
            <span ref={ref} className="relative inline-block">
                <button
                    type="button"
                    onClick={() => setOpen(true)}
                    onMouseEnter={() => setTooltip(true)}
                    onMouseLeave={() => setTooltip(false)}
                    onFocus={() => setTooltip(true)}
                    onBlur={() => setTooltip(false)}
                    className="cursor-help rounded-md bg-slate-100 text-slate-700 border-b border-dashed border-slate-400 transition-colors hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400"
                >
                    {word}
                </button>

                {tooltip && !open && (
                    <span
                        role="tooltip"
                        className="pointer-events-none absolute left-1/2 bottom-full z-20 mb-2 -translate-x-1/2 w-max max-w-[80vw] whitespace-normal text-center rounded-lg bg-slate-800 px-2.5 py-1 text-xs font-normal text-white shadow-lg"
                    >
                        {hints}
                        <span className="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-slate-800" />
                    </span>
                )}
            </span>

            {open && (
                <div
                    role="dialog"
                    aria-modal="true"
                    className="fixed inset-0 z-50 flex items-center justify-center p-4"
                    onClick={() => setOpen(false)}
                >
                    <div className="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" />
                    <div
                        className="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl"
                        onClick={(e) => e.stopPropagation()}
                    >
                        <div className="flex items-start justify-between gap-4 mb-3">
                            <h3 className="text-lg font-bold text-slate-800">
                                {word}
                            </h3>
                            <button
                                type="button"
                                onClick={() => setOpen(false)}
                                aria-label="Закрыть"
                                className="shrink-0 rounded-lg p-1.5 text-slate-400 transition-colors hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="2"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                >
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>

                        <p className="text-slate-600 leading-relaxed whitespace-pre-line">
                            {hints}
                        </p>
                    </div>
                </div>
            )}
        </>
    );
}

export default function Chapter() {
    const [help, setHelp] = useState(false);
    const [chapter, setChapter] = useState(null);
    const [textChapter, setTextChapter] = useState(null);
    const [hover, setHover] = useState(false);
    const [loading, setLoading] = useState(true);

    function changeStatus(status) {
        setHelp(!status);
    }

    useEffect(() => {
        const fetchPosts = async () => {
            try {
                const id = window.location.pathname.split("/").pop();
                const response = await get(
                    apiRoutes.chapters + "/" + id,
                    {},
                    { withCredentials: true }
                );
                const data = await response.data;
                setChapter(data);
                setTextChapter(JSON.parse(data.content));
                setLoading(false);
            } catch (error) {
                console.error("Error fetching chapter:", error);
            }
        };
        fetchPosts();
    }, []);

    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="max-w-5xl mx-auto space-y-8">
                {loading ? (
                    <Loading />
                ) : (
                    <div>
                        <div className={"flex justify-between items-center mb-3"}>
                            <div className="flex items-center gap-4">
                                <ButtonBack />
                            </div>
                            <div className="flex items-center gap-4">
                                <div
                                    className={[
                                        "flex items-center gap-2 px-4 py-2 rounded-xl cursor-pointer",
                                        "transition-all duration-200 border font-bold",
                                        hover
                                            ? "bg-slate-100 border-slate-300 shadow"
                                            : "bg-white border-slate-200 shadow-sm",
                                        help ? "text-blue-500" : "text-slate-600",
                                    ].join(" ")}
                                    onClick={() => changeStatus(help)}
                                    onMouseEnter={() => setHover(true)}
                                    onMouseLeave={() => setHover(false)}
                                >
                                    ?
                                </div>
                            </div>
                        </div>
                        {chapter ? (
                            <div
                                key={chapter.id}
                                className="bg-white items-center gap-3 mb-4 shadow rounded-3xl p-8 transition-all"
                            >
                                <div className={"flex justify-between items-start"}>
                                    <div className="flex items-center gap-3 mb-4">
                                        <h1 className="text-xl font-bold text-slate-800">
                                            {chapter.author + ". " + chapter.book + ". " + chapter.name}
                                        </h1>
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
                                            className="text-slate-600 font-medium mb-4 leading-relaxed"
                                        >
                                            {paragraph.map((e, index) => {
                                                const isPunct = /^[.,;:!?–—-]+$/.test(e.word);
                                                return (
                                                    <span key={index}>
                                                        {isPunct ? "" : " "}
                                                        {e.hints ? (
                                                            <WordWithHint
                                                                word={e.word}
                                                                hints={e.hints}
                                                                help={help}
                                                            />
                                                        ) : (
                                                            e.word
                                                        )}
                                                    </span>
                                                );
                                            })}
                                        </p>
                                    ))}
                                </div>
                            </div>
                        ) : (
                            <div className="text-center py-12">
                                <p className="text-slate-500 text-lg">
                                    {getText(lang.books.emptyChapter)}
                                </p>
                            </div>
                        )}
                    </div>
                )}
            </div>
        </main>
    );
}