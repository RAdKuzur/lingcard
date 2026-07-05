import SelectLanguage from "../layouts/SelectLanguage.jsx";
import {useEffect, useState} from "react";
import ButtonBack from "../layouts/ButtonBack.jsx";
import {logoutAxios} from "../../plugins/auth.js";
import {useNavigate} from "react-router-dom";
import {innerRoutes} from "../../plugins/routes.js";
import {patch, get, del} from "./../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";

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
        <main className="flex h-screen bg-gray-200 justify-center">
            <div className="flex flex-col w-full h-full items-center">
                <div className="flex w-4/5 h-1/12 rounded-2xl text-center mt-8 pb-2 gap-5  items-center">
                    <div className={'flex flex-col mt-8 items-center'}>
                        <ButtonBack></ButtonBack>
                    </div>
                    <div className={'flex flex-col mt-8 w-1/5 h-full'}>

                    </div>
                    <div className="flex flex-col w-2/5 h-full rounded-2xl text-center bg-white mt-8 pb-2">
                        <div className={'flex h-1/3 w-full pt-2 mb-2'}>
                            <div className={'w-2/5 h-full ml-3 text-start'}>
                                Язык изучения
                            </div>
                            <div className={'w-2/5 h-full text-start'}>
                                Базовый язык
                            </div>
                        </div>
                        <div className={'flex h-2/3 w-full gap-3 justify-start items-center'}>
                            <div className={'w-2/5 h-4/5 ml-3'}>
                                <SelectLanguage setLang={setBaseLang} value={baseLang}/>
                            </div>
                            <div className={'w-2/5 h-4/5'}>
                                <SelectLanguage setLang={setTargetLang} value={targetLang}/>
                            </div>
                            <div className={'mr-3 w-1/5'}>
                                <button
                                    className={'p-2 w-full bg-green-400 font-bold text-white rounded-2xl cursor-pointer'} onClick={changeProfile}>
                                    Изменить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div className={`flex flex-col w-4/5 h-3/5 rounded-2xl text-center bg-white mt-8`}>
                    <div className={'font-bold m-3 h-1/20'}>Статистика</div>
                    <div className={`flex flex-col h-14/15 gap-4 justify-center items-center`}>
                        <div className={'flex w-9/10 h-3/10 border rounded-2xl justify-between items-center'}>
                            <div className={"flex w-3/10 h-5/10 ml-5 items-center"}>
                                <div className={"text-2xl"}>Выучено слов</div>
                            </div>

                            <div className={"flex w-1/10 h-5/10 ml-5 items-center bg-green-400 mr-10 rounded-2xl items-center justify-center"}>
                                <div className={"flex text-2xl text-white font-bold text-center"}>{noneWords}</div>
                            </div>
                        </div>
                        <div className={'flex w-9/10 h-3/10 border rounded-2xl justify-between items-center'}>
                            <div className={"flex w-3/10 h-5/10 ml-5 items-center"}>
                                <div className={"text-2xl"}>Слов изучается</div>
                            </div>
                            <div className={"flex w-1/10 h-5/10 ml-5 items-center bg-blue-400 mr-10 rounded-2xl items-center justify-center"}>
                                <div className={"flex text-2xl text-white font-bold text-center"}>{learningWords}</div>
                            </div>
                        </div>
                        <div className={'flex w-9/10 h-3/10 border rounded-2xl justify-between items-center'}>
                            <div className={"flex w-3/10 h-5/10 ml-5 items-center"}>
                                <div className={"text-2xl"}>Ещё не изучено</div>
                            </div>
                            <div
                                className={"flex w-1/10 h-5/10 ml-5 items-center bg-red-400 mr-10 rounded-2xl items-center justify-center"}>
                                <div className={"flex text-2xl text-white font-bold text-center"}>{learnedWords}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className={`flex h-1/16 w-2/5 bg-white mt-5 rounded-2xl border justify-center gap-8 items-center`}>
                    <div className={`flex w-3/10 h-6/10 border border-red-500 rounded-2xl items-center justify-center cursor-pointer ${isHover1 ? 'bg-red-500' : ''}`}
                        onMouseLeave={() => setHover1(false)}
                        onMouseEnter={() => setHover1(true)}
                        onClick={logout}>
                        <div className={"font-bold"}>
                            Выйти
                        </div>
                    </div>
                    <div className={`flex w-3/10 h-6/10 rounded-2xl items-center justify-center bg-red-500 cursor-pointer ${isHover2 ? 'bg-red-700' : ''}`}
                         onMouseLeave={() => setHover2(false)}
                         onMouseEnter={() => setHover2(true)}
                         onClick={clearProgress}
                    >
                        <div className={"text-white font-bold"}>
                            Сбросить прогресс
                        </div>
                    </div>
                </div>
            </div>
        </main>
    )
}