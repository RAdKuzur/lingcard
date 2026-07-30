import ButtonBack from "../layouts/ButtonBack.jsx";
import {getText, lang} from "../../lang/lang.js";

export default function Card({opacityCard, direction, status, repeat, translation , transcription, opacityTranslation, text, isHoverNo, setHoverNo, swipe, isHoverShow, setHoverShow, word, isHoverYes, setHoverYes, show }) {
    return (
        <div className="w-full max-w-md">
            <div className="flex w-1/5 mb-6">
                <ButtonBack/>
            </div>

            <div className={`relative bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl shadow-indigo-500/10 p-8 transition-all duration-500 border border-white/50
                ${direction === 'right' ? 'translate-x-full rotate-12 opacity-0 scale-90' : ''}
                ${direction === 'left' ? '-translate-x-full -rotate-12 opacity-0 scale-90' : ''}
                ${opacityCard ? 'opacity-100' : 'opacity-0 pointer-events-none'}
            `}>
                <div className="text-center">
                    <div className="flex flex-wrap items-center justify-center gap-2 mb-6">
                        {status === 1 ? (
                            <span
                                className="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-semibold bg-gradient-to-r from-emerald-400 to-emerald-500 text-white shadow-lg shadow-emerald-500/25">
                                {getText(lang.training.newWord)}
                            </span>
                        ) : (
                            <span
                                className={`inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-semibold bg-gradient-to-r from-amber-400 to-amber-500 text-white shadow-lg shadow-amber-500/25`}>
                                {getText(lang.training.amountRepeat)} {repeat}
                            </span>
                        )}
                    </div>

                    <div className="py-8">
                        <div className="text-4xl font-bold text-slate-800 mb-4 tracking-tight">
                            {translation}
                        </div>
                        {transcription === '' || transcription === null ? '' : (<div
                            className={`text-2xl text-slate-600 transition-all duration-300 ${opacityTranslation ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'}`}>
                            [{transcription}]
                        </div>)}
                        <div
                            className={`text-2xl text-slate-600 transition-all duration-300 ${opacityTranslation ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'}`}>
                            {text}
                        </div>
                    </div>

                    <div className="flex gap-3 mt-8">
                        <button
                            className={`flex-1 py-3.5 rounded-xl font-semibold transition-all duration-200 shadow-lg cursor-pointer ${
                                isHoverNo
                                    ? 'bg-rose-600 shadow-rose-500/40 transform scale-[1.02]'
                                    : 'bg-rose-500 shadow-rose-500/30 hover:bg-rose-600'
                            } text-white`}
                            onMouseEnter={() => setHoverNo(true)}
                            onMouseLeave={() => setHoverNo(false)}
                            onClick={() => swipe('left')}
                        >
                            {getText(lang.training.unknown)}
                        </button>
                        <button
                            className={`flex-1 py-3.5 rounded-xl font-semibold transition-all duration-200 shadow-lg cursor-pointer ${
                                isHoverShow
                                    ? 'bg-cyan-600 shadow-cyan-500/40 transform scale-[1.02]'
                                    : 'bg-cyan-500 shadow-cyan-500/30 hover:bg-cyan-600'
                            } text-white`}
                            onMouseEnter={() => setHoverShow(true)}
                            onMouseLeave={() => setHoverShow(false)}
                            onClick={show}
                        >
                            {word ? getText(lang.training.show) : getText(lang.training.hide)}
                        </button>
                        <button
                            className={`flex-1 py-3.5 rounded-xl font-semibold transition-all duration-200 shadow-lg cursor-pointer ${
                                isHoverYes
                                    ? 'bg-emerald-600 shadow-emerald-500/40 transform scale-[1.02]'
                                    : 'bg-emerald-500 shadow-emerald-500/30 hover:bg-emerald-600'
                            } text-white`}
                            onMouseEnter={() => setHoverYes(true)}
                            onMouseLeave={() => setHoverYes(false)}
                            onClick={() => swipe('right')}
                        >
                            {getText(lang.training.known)}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}