import SelectLanguage from "../layouts/SelectLanguage.jsx";
import {useEffect, useState} from "react";
import ButtonBack from "../layouts/ButtonBack.jsx";
import { logoutAxios } from "../../plugins/auth.js";
import { useNavigate } from "react-router-dom";
import { innerRoutes } from "../../plugins/routes.js";
import { patch, get, del } from "./../../plugins/request.js";
import { apiRoutes } from "../../plugins/apiRoutes.js";

export default function Profile({setAuth}) {
    const navigate = useNavigate()
    const [isHover1, setHover1] = useState(false)
    const [isHover2, setHover2] = useState(false)
    const [baseLang, setBaseLang] = useState(0)
    const [targetLang, setTargetLang] = useState(0)
    const [noneWords, setNoneWords] = useState(0)
    const [learningWords, setLearningWords] = useState(0)
    const [learnedWords, setLearnedWords] = useState(0)
    function logout() {
        logoutAxios(setAuth)
        navigate(innerRoutes.login)
    }

    async function changeProfile() {
        if(String(baseLang) !== String(targetLang) &&
            baseLang !== 0 &&
            targetLang !== 0 &&
            baseLang !== '0' &&
            targetLang !== '0') {
            const response = await patch(apiRoutes.profile, {
                    base_language_id: baseLang,
                    target_language_id: targetLang
                },
                {
                    withCredentials: true
                });
        }

    }
    async function clearProgress() {
        const response = await del(apiRoutes.progress,
            {
                withCredentials: true
            });
    }

    useEffect(() => {
        const fetchProfile = async () => {
            try {
                const response = await get(apiRoutes.profile, {}, {withCredentials: true});
                const data = response.data;
                setTargetLang(data.target_language_id)
                setBaseLang(data.base_language_id)
                setNoneWords(data.none_words)
                setLearningWords(data.learning_words)
                setLearnedWords(data.learned_words)
            } catch (error) {
                console.error('Error fetching profile:', error);
            }
        };
        fetchProfile();
    }, []);

    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 flex justify-center p-6">
            <div className="flex flex-col w-full max-w-5xl items-center space-y-6">
                <div className="flex w-full items-center gap-4">
                    <ButtonBack />
                    <h1 className="text-2xl font-bold text-slate-800">Профиль</h1>
                </div>

                <div className="w-full bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-6">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label className="text-sm font-medium text-slate-600 block mb-2">Базовый язык</label>
                            <SelectLanguage setLang={setBaseLang} value={baseLang} />
                        </div>
                        <div>
                            <label className="text-sm font-medium text-slate-600 block mb-2">Язык изучения</label>
                            <SelectLanguage setLang={setTargetLang} value={targetLang} />
                        </div>
                    </div>
                    <button
                        className="mt-4 w-full px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-xl transition-all duration-200 shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/35"
                        onClick={changeProfile}
                    >
                        Изменить
                    </button>
                </div>

                <div className="w-full bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-6">
                    <h2 className="text-sm font-medium text-slate-500 mb-4">Статистика</h2>
                    <div className="space-y-3">
                        <div className="flex items-center justify-between px-4 py-3 bg-slate-50 rounded-xl">
                            <span className="text-slate-700 font-medium">Выучено слов</span>
                            <span className="px-4 py-1 rounded-full bg-emerald-500 text-white font-bold text-sm">
                                {learnedWords}
                            </span>
                        </div>
                        <div className="flex items-center justify-between px-4 py-3 bg-slate-50 rounded-xl">
                            <span className="text-slate-700 font-medium">Слов изучается</span>
                            <span className="px-4 py-1 rounded-full bg-blue-500 text-white font-bold text-sm">
                                {learningWords}
                            </span>
                        </div>
                        <div className="flex items-center justify-between px-4 py-3 bg-slate-50 rounded-xl">
                            <span className="text-slate-700 font-medium">Ещё не изучено</span>
                            <span className="px-4 py-1 rounded-full bg-rose-500 text-white font-bold text-sm">
                                {noneWords}
                            </span>
                        </div>
                    </div>
                </div>

                <div className="flex w-full gap-4">
                    <button
                        className={`flex-1 px-6 py-3 rounded-xl font-medium transition-all duration-200 border-2 ${
                            isHover1
                                ? 'bg-rose-500 border-rose-500 text-white'
                                : 'bg-white border-rose-500 text-rose-500 hover:bg-rose-50'
                        }`}
                        onMouseEnter={() => setHover1(true)}
                        onMouseLeave={() => setHover1(false)}
                        onClick={logout}
                    >
                        Выйти
                    </button>
                    <button
                        className={`flex-1 px-6 py-3 rounded-xl font-medium transition-all duration-200 ${
                            isHover2
                                ? 'bg-rose-700 shadow-lg shadow-rose-500/35'
                                : 'bg-rose-500 shadow-lg shadow-rose-500/25 hover:bg-rose-600'
                        } text-white`}
                        onMouseEnter={() => setHover2(true)}
                        onMouseLeave={() => setHover2(false)}
                        onClick={clearProgress}
                    >
                        Сбросить прогресс
                    </button>
                </div>
            </div>
        </main>
    );
}