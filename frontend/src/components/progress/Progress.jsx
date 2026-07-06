import { useEffect, useState } from "react";
import Word from "../layouts/Word.jsx";
import ButtonBack from "../layouts/ButtonBack.jsx";
import { get } from "../../plugins/request.js";
import { apiRoutes } from "../../plugins/apiRoutes.js";

export default function Progress() {
    const [isHover1, setHover1] = useState(true);
    const [isHover2, setHover2] = useState(false);
    const [isHover3, setHover3] = useState(false);
    const [activeTab, setActiveTab] = useState(1);
    const [page, setPage] = useState(1);
    const [limit] = useState(10);
    const [words, setWords] = useState([]);
    const [amountWords, setAmountWords] = useState(1);

    useEffect(() => { hover1(); }, []);

    function hover1() {
        setHover1(true);
        setHover2(false);
        setHover3(false);
        setActiveTab(1);
        handleProgress(1, 1, 10);
    }

    function hover2() {
        setHover1(false);
        setHover2(true);
        setHover3(false);
        setActiveTab(2);
        handleProgress(2, 1, 10);
    }

    function hover3() {
        setHover1(false);
        setHover2(false);
        setHover3(true);
        setActiveTab(3);
        handleProgress(3, 1, 10);
    }

    function nextPage() {
        if (page !== totalPages()) {
            const newPage = page + 1;
            setPage(newPage);
            handleProgress(activeTab, newPage, limit);
        }
    }

    function prevPage() {
        if (page > 1) {
            const newPage = page - 1;
            setPage(newPage);
            handleProgress(activeTab, newPage, limit);
        }
    }

    async function handleProgress(status, page = 1, limit = 10) {
        setPage(page);
        const response = await get(
            `${apiRoutes.progress}/${status}?page=${page}&limit=${limit}`,
            null,
            { withCredentials: true }
        );
        const data = await response.data;
        setAmountWords(await response.amountWords);
        setWords(data);
    }

    function totalPages() {
        return Math.floor((amountWords + limit - 1) / limit);
    }

    const tabs = [
        { id: 1, label: 'Новые слова', color: 'rose', hover: isHover1, onClick: hover1 },
        { id: 2, label: 'Изучаемые слова', color: 'blue', hover: isHover2, onClick: hover2 },
        { id: 3, label: 'Изученные слова', color: 'emerald', hover: isHover3, onClick: hover3 }
    ];

    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="max-w-5xl mx-auto space-y-6">
                <div className="flex items-center gap-4">
                    <ButtonBack />
                    <h1 className="text-2xl font-bold text-slate-800">Прогресс</h1>
                </div>

                <div className="flex gap-2 bg-white p-1.5 rounded-xl shadow-lg shadow-slate-200/50">
                    {tabs.map(tab => (
                        <button
                            key={tab.id}
                            onClick={tab.onClick}
                            className={`flex-1 px-4 py-2.5 rounded-lg font-medium transition-all duration-200 cursor-pointer ${
                                tab.hover
                                    ? `bg-${tab.color}-500 text-white shadow-md shadow-${tab.color}-500/25`
                                    : `bg-${tab.color}-100 text-${tab.color}-700 hover:bg-${tab.color}-200`
                            }`}
                        >
                            {tab.label}
                        </button>
                    ))}
                </div>

                <div className="bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-6">
                    <h2 className="text-sm font-medium text-slate-500 mb-4">Слова</h2>
                    <div className="space-y-3 max-h-[50vh] overflow-y-auto">
                        {words.length > 0 ? (
                            words.map((e) => (
                                <Word
                                    key={e.id}
                                    word={e.text}
                                    translation={e.translation}
                                    level={e.level}
                                    repeat={e.repeat_time}
                                />
                            ))
                        ) : (
                            <div className="text-center py-12 text-slate-400">
                                <p className="text-lg">Нет слов</p>
                            </div>
                        )}
                    </div>
                </div>

                {words.length > 0 && (
                    <div className="flex items-center justify-between gap-4 bg-white px-4 py-3 rounded-xl shadow-lg shadow-slate-200/50">
                        <button
                            onClick={prevPage}
                            disabled={page === 1}
                            className="px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer"
                        >
                            Пред.
                        </button>
                        <span className="text-sm text-slate-500 font-medium">
                            {page} / {totalPages()}
                        </span>
                        <button
                            onClick={nextPage}
                            disabled={page === totalPages()}
                            className="px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer"
                        >
                            След.
                        </button>
                    </div>
                )}
            </div>
        </main>
    );
}