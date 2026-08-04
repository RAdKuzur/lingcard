import ButtonBack from "../layouts/ButtonBack.jsx";
import {getText, lang} from "../../lang/lang.js";
import {useState} from "react";
import {post} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";

export default function Card({opacityCard, direction, status, repeat, translation , transcription, opacityTranslation, text, isHoverNo, setHoverNo, swipe, isHoverShow, setHoverShow, word, isHoverYes, setHoverYes, show }) {
    const [isProblem, setProblem] = useState(false)
    const [textProblem, setTextProblem] = useState('')
    function handleProblem() {
        setProblem(!isProblem)
    }

    async function sendProblem(problemText) {
        if (problemText) {
            const response = await post(apiRoutes.suggestions, {
                message: JSON.stringify({
                    word: text,
                    translation: translation,
                    transcription: transcription,
                    problem: problemText
                })
            }, {withCredentials: true})
            setTextProblem('')
            handleProblem()
        }
    }
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
                    <div className="flex justify-center items-center mb-6">
                        {
                            <div className={'flex justify-start items-center w-3/5'}>
                                {status === 1 ? (
                                    <span className="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-semibold bg-gradient-to-r from-emerald-400 to-emerald-500 text-white shadow-lg shadow-emerald-500/25">
                                {getText(lang.training.newWord)}
                            </span>
                        ) : (
                            <span
                                className={`inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-semibold bg-gradient-to-r from-amber-400 to-amber-500 text-white shadow-lg shadow-amber-500/25`}>
                                {getText(lang.training.amountRepeat)} {repeat}
                            </span>
                                )}
                            </div>
                        }
                        <div className={'flex cursor-pointer justify-end w-2/5'} onClick={handleProblem}>
                            {
                                !isProblem ? (
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32"
                                         fill="none" stroke="#000" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path d="M4 21V3"/>
                                        <path d="M4 4h11l-2 4l2 4H4"/>
                                    </svg>
                                ) : (
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32"
                                         fill="none" stroke="#000" stroke-width="2" stroke-linecap="round">
                                        <line x1="4" y1="4" x2="20" y2="20"/>
                                        <line x1="20" y1="4" x2="4" y2="20"/>
                                    </svg>
                                )
                            }
                        </div>
                    </div>

                    <div className="py-8">
                        <div className="text-4xl font-bold text-slate-800 mb-4 tracking-tight">
                            {text}
                        </div>
                        {transcription === '' || transcription === null ? '' : (<div
                            className={`text-2xl text-slate-600 transition-all duration-300 ${opacityTranslation ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'}`}>
                            [{transcription}]
                        </div>)}
                        <div
                            className={`text-2xl text-slate-600 transition-all duration-300 ${opacityTranslation ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-2'}`}>
                            {translation}
                        </div>
                    </div>
                    {
                        isProblem ? (
                            <>
                               <textarea
                                   className="border-2 border-black-300 focus:border-black-500 outline-none w-full rounded-2xl p-2 sm:p-4 min-h-[100px] sm:min-h-[120px] text-base"
                                   onInput={(e) => setTextProblem(e.target.value)}
                                   placeholder={getText(lang.training.problem)}
                               />
                                <button
                                    className={`active:scale-95 p-3 rounded-2xl sm:w-auto transition-all duration-200 shadow-md hover:shadow-lg ${textProblem === '' ? 'bg-gray-500 cursor-not-allowed' : 'bg-blue-500 hover:bg-blue-600 cursor-pointer'}`}
                                    onClick={() => sendProblem(textProblem)}
                                    aria-label="Отправить"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        width="28"
                                        height="28"
                                        fill="none"
                                        stroke="#ffffff"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        className="shrink-0"
                                    >
                                        <path d="M22 2L11 13"/>
                                        <path d="M22 2L15 22l-4-9l-9-4l20-7z"/>
                                    </svg>
                                </button>
                            </>
                        ) : (
                            <></>
                        )
                    }
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