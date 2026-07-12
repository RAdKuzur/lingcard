import {useEffect, useState} from "react";
import {useRedirect} from "../../hooks/useRedirect.js";
import {getText, lang} from "../../lang/lang.js";

export default function ButtonBack() {
    const {redirectIfAuth} = useRedirect();
    const [hover, setHover] = useState(false);
    function goBack() {
        redirectIfAuth(-1);
    }

    return (
        <div
            className={`flex items-center gap-2 px-4 py-2 rounded-xl cursor-pointer transition-all duration-200 border border-slate-200 shadow-sm ${
                hover ? 'bg-slate-100 border-slate-300 shadow' : 'bg-white'
            }`}
            onClick={goBack}
            onMouseEnter={() => setHover(true)}
            onMouseLeave={() => setHover(false)}
        >
            <svg className="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span className="text-sm font-medium text-slate-600">{getText(lang.back.button)}</span>
        </div>
    );
}