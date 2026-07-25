import ButtonBack from "../layouts/ButtonBack.jsx";
import {getText, lang} from "../../lang/lang.js";
import {useEffect, useState} from "react";
import {get, post} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";

export default function About() {
    const [countries, setCountries] = useState([])
    const [isHidden, setHidden] = useState(true)
    const [input, setInput] = useState('')
    const [isMessage, setMessage] = useState(false)
    useEffect(() => {
        async function Languages() {
            const response = await get(apiRoutes.languages, {}, {withCredentials: true})
            const data = await response.data
            setCountries(data)
        }
        Languages()
    }, [])

    function handleFeedback() {
        setHidden(false)
    }
    async function sendFeedback() {
        await post(apiRoutes.suggestions, {
            message: input
        }, {withCredentials: true})
        setMessage(true)
        setTimeout(() => {
            setMessage(false)
        }, 5000)
        setHidden(true)
    }
    function hideFeedback() {
        setHidden(true)
    }
    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="flex max-w-5xl mx-auto justify-start mb-6">
                <ButtonBack />
            </div>
            <div className="max-w-5xl mx-auto space-y-8">
                <div className="bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-8 transition-all hover:shadow-xl hover:shadow-slate-300/50">
                    <div className="flex items-center gap-3 mb-4">
                        <h1 className="text-2xl font-bold text-slate-800">{getText(lang.about.me)}</h1>
                    </div>
                    <p className="text-slate-600 leading-relaxed text-lg">
                        {getText(lang.about.mission)}
                    </p>
                </div>
                <div className="bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-8 transition-all hover:shadow-xl hover:shadow-slate-300/50">
                    <div className="flex items-center gap-3 mb-4">
                        <h1 className="text-2xl font-bold text-slate-800">{getText(lang.about.contacts)}</h1>
                    </div>
                    <div className="space-y-3">
                        <a
                            href="mailto:drive16052003@gmail.com"
                            className="flex items-center gap-3 text-slate-600 hover:text-blue-600 transition-colors group"
                        >
                            <span className="text-lg group-hover:underline">
                                drive16052003@gmail.com
                            </span>
                        </a>
                    </div>
                    <div className={'mt-4'}>

                        {!isHidden ? (<div>
                            <textarea className={'border-solid border-indigo-500 outline-2 w-full  rounded-2xl p-2'}
                                      onInput={(e) => {setInput(e.target.value)}}>
                            </textarea>
                        </div>) : ''}
                        {
                            isMessage ? (<span className={`font-bold`}>Ваше предложение успешно отправлено!</span>) : ''
                        }
                        <div className={'flex gap-4'}>
                            {isHidden ? (<button
                                className={'bg-indigo-600 cursor-pointer p-2 rounded-2xl mt-3'}
                                onClick={handleFeedback}>
                                <span className={'font-bold text-white'}>{getText(lang.about.feedback)}</span>
                            </button>) : ''}
                            {!isHidden ? (<button
                                className={'bg-green-600 cursor-pointer p-2 rounded-2xl mt-3'}
                                onClick={(e) => sendFeedback(e.target.value)}>
                                <span className={'font-bold text-white'}>{getText(lang.about.sendFeedback)}</span>
                            </button>) : '' }
                            {!isHidden ? (<button
                                className={'bg-red-600 cursor-pointer p-2 rounded-2xl mt-3 border-indigo-500'}
                                onClick={hideFeedback}>
                                <span className={'font-bold text-white'}>{getText(lang.about.hide)}</span>
                            </button>) : ''}
                        </div>

                    </div>
                </div>
                <div>
                    <div className="flex items-center gap-3 mb-6 justify-center">
                        <h1 className="text-2xl font-bold text-slate-800">{getText(lang.about.languages)}</h1>
                    </div>
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        {countries.map((country, index) => (
                            <div
                                key={index}
                                className="group bg-white rounded-2xl shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300 hover:scale-105 cursor-pointer p-6 flex flex-col items-center justify-center"
                            >
                                <div className="w-30 h-30 mb-3 group-hover:scale-110 transition-transform duration-300 rounded-lg overflow-hidden shadow-md">
                                    <img
                                        src={`/flags/${country.code}.svg`}
                                        alt={country.code}
                                        className="w-full h-full object-cover"
                                    />
                                </div>
                                <span className="text-lg font-semibold text-slate-700">
                                {country.name}
                            </span>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </main>
    );
}