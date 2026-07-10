import {del} from "../../plugins/request.js";
import {apiClearWordProgress} from "../../plugins/apiRoutes.js";
import {useState} from "react";

export default function Word({ word, translation, level = null, repeat = null , progressId = null, activeTab = 1}) {
    const [isHidden, setHidden] = useState(false)
    async function handleProgress(id) {
        const response = await del(
            apiClearWordProgress(id),
            null,
            {withCredentials: true}
        );
        setHidden(true)

    }
    function setLevelColor(level){
        switch (level) {
            case 'Начальный':
                return 'bg-red-500 hover:bg-red-600 text-white';
            case 'Базовый':
                return 'bg-orange-500 hover:bg-orange-600 text-white';
            case 'Средний':
                return 'bg-yellow-500 hover:bg-yellow-600 text-white';
            case 'Выше среднего':
                return 'bg-green-500 hover:bg-green-600 text-white';
            case 'Продвинутый':
                return 'bg-blue-500 hover:bg-blue-600 text-white';
            case 'Профессиональный':
                return 'bg-purple-500 hover:bg-purple-600 text-white';
            default:
                return 'bg-gray-500 hover:bg-gray-600 text-white';
        }
    }
    return (
        <div
            className={`flex items-center gap-4 w-full px-5 py-3 bg-white rounded-xl border border-slate-200 hover:border-slate-300 hover:shadow-md transition-all duration-200 ${isHidden ? 'hidden' : ''}`}>
            <div className="flex-1 min-w-0">
                <div className="font-semibold text-slate-800 truncate">{word}</div>
                <div className="text-slate-500 text-sm truncate">{translation}</div>
            </div>
            <div className="flex items-center gap-2 flex-shrink-0">
                {repeat !== null && (
                    <span
                        className="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-medium whitespace-nowrap">
                {repeat}
            </span>
                )}
                {level !== null && (
                    <span
                        className={`px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap ${setLevelColor(level)}`}>
                {level}
            </span>
                )}
            </div>
            <div className={`flex items-center gap-2 flex-shrink-0 ${activeTab !== 1 && progressId ? '' : 'hidden'}`}>
                <button
                    className="flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-red-500 to-rose-500 text-white text-sm font-medium shadow-sm hover:shadow-md hover:scale-105 hover:from-red-600 hover:to-rose-600 active:scale-95 transition-all duration-200 cursor-pointer"
                    onClick={() => handleProgress(progressId)}
                >
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" strokeWidth={2}>
                        <path strokeLinecap="round" strokeLinejoin="round"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span>Сбросить прогресс</span>
                </button>
            </div>
        </div>
    );
}