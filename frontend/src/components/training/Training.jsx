import {useEffect, useState} from "react";
import ButtonBack from "../layouts/ButtonBack.jsx";
import { get, patch } from "../../plugins/request.js";
import { apiRoutes } from "../../plugins/apiRoutes.js";
import InitWindow from "./InitWindow.jsx";
import {getText, lang} from "../../lang/lang.js";
import {studyStatuses} from "../../plugins/studyStatus.js";
import EndTraining from "./EndTraining.jsx";
import WaitingTraining from "./WaitingTraining.jsx";
export default function Training() {
    const [isTraining, setTraining] = useState(studyStatuses.none)
    const [isLoading, setIsLoading] = useState(true)
    const [word, setWord] = useState(true)
    const [isHoverNo, setHoverNo] = useState(false)
    const [isHoverShow, setHoverShow] = useState(false)
    const [isHoverYes, setHoverYes] = useState(false)
    const [direction, setDirection] = useState('')
    const [opacityCard, setOpacityCard] = useState(true)
    const [opacityTranslation, setOpacityTranslation] = useState(false)
    const [countryCode, setCountryCode] = useState('')

    const [cardId, setCardId] = useState(0)
    const [text, setText] = useState('')
    const [translation, setTranslation] = useState('')
    const [level, setLevel] = useState('')
    const [status, setStatus] = useState('')
    const [repeat, setRepeat] = useState(0)

    function show() {
        setWord(!word);
        setOpacityTranslation(!opacityTranslation)
        return word
    }

    async function trainingRepeat(status) {
        const response = await patch(apiRoutes.training + '/' + cardId, {
            status: status
        }, {withCredentials: true})
    }

    function swipe(way){
        setDirection(way)
        setOpacityCard(false)

        if (way === 'left') {
            trainingRepeat(false)
        }
        if (way === 'right') {
            trainingRepeat(true)
        }

        setTimeout(() => {
            setOpacityTranslation(false)
            setWord(true)
            setDirection('')
            newWord()
        }, 1000)
        setTimeout(() => {
            setOpacityCard(true)
        }, 1500)
    }

    async function handleCheckTrainingStatus() {
        try {
            const response = await get(apiRoutes.teachable, {}, {withCredentials: true})
            const data = await response.data
            setTraining(response.data.training)
            setCountryCode(response.data.language)
            return response.data.training
        } catch (error) {
            return false
        } finally {
            setIsLoading(false)
        }
    }

    useEffect(() => {
        const fetchData = async () => {
            setIsLoading(true)
            const status = await handleCheckTrainingStatus()
            if (status === studyStatuses.learning) {
                setIsLoading(true)
                newWord()
            }
            setIsLoading(false)
        }
        fetchData()
    }, [])

    async function newWord() {
        const response = await get(apiRoutes.training, null, {withCredentials: true});
        const data = await response.data;
        if(data) {
            setCardId(data.id)
            setText(data.text)
            setTranslation(data.translation)
            setLevel(data.level)
            setStatus(data.status)
            setRepeat(data.repeat)
        }
        else {
            setTraining(studyStatuses.waiting)
        }
    }

    function handleSetTraining(status) {
        setIsLoading(true)
        setTimeout(() => {
            newWord()
            setTraining(status)
            setIsLoading(false)
        }, 6000)
    }

    return (
        <main
            className="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 flex flex-col items-center justify-center p-6">
            {isLoading ? (
                <div className="flex flex-col items-center justify-center gap-4">
                    <div className="w-16 h-16 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                    <p className="text-lg font-medium text-slate-600 animate-pulse">{getText(lang.training.loading)}</p>
                </div>
            ) : isTraining === studyStatuses.none ? (
                <InitWindow countryCode={countryCode} setTraining={handleSetTraining}/>
            ) : isTraining === studyStatuses.waiting ? (
                <WaitingTraining />
            ) : isTraining === studyStatuses.learned ? (
                <EndTraining/>
            ) : (
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
            )}
        </main>
    );
}