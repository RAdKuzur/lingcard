import {useEffect, useState} from "react";
import Word from "../layouts/Word.jsx";
import ButtonBack from "../layouts/ButtonBack.jsx";
import {get} from "../../plugins/request.js";
import {apiDictionary, apiRoutes} from "../../plugins/apiRoutes.js";

export default function Progress() {
    const [isHover1, setHover1] = useState(true)
    const [isHover2, setHover2] = useState(false)
    const [isHover3, setHover3] = useState(false)
    const [words, setWords] = useState([])
    useEffect(() => {hover1()}, [])
    function hover1() {
        setHover1(true)
        setHover2(false)
        setHover3(false)
        handleProgress(1)
    }
    function hover2() {
        setHover1(false)
        setHover2(true)
        setHover3(false)
        handleProgress(2)
    }
    function hover3() {
        setHover1(false)
        setHover2(false)
        setHover3(true)
        handleProgress(3)
    }

    async function handleProgress(status) {
        const response = await get(apiRoutes.progress + '/' + status, null, {withCredentials: true})
        const data = await response.data;
        setWords(data)
    }

    return (
        <main className="flex h-screen bg-gray-200 justify-center">
            <div className="flex flex-col w-full h-full items-center">
                <div className={'flex w-4/5 h-1/18 mt-8'}>
                    <div className={'flex w-1/10 h-full'}>
                        <ButtonBack></ButtonBack>
                    </div>
                    <div className={'w-1/5 h-full'}>
                    </div>
                    <div className="flex w-2/5 h-full rounded-2xl text-center bg-white justify-between items-center">
                        <div
                            className={`flex h-4/5 w-3/10 cursor-pointer bg-red-100 rounded-2xl ml-3 text-center justify-center items-center ${isHover1 ? 'bg-red-300' : ''}`}
                            onClick={() => hover1()}>Новые слова
                        </div>
                        <div
                            className={`flex h-4/5 w-3/10 cursor-pointer bg-yellow-100 rounded-2xl text-center justify-center items-center ${isHover2 ? 'bg-yellow-300' : ''}`}
                            onClick={() => hover2()}>Выученные слова
                        </div>
                        <div
                            className={`flex h-4/5 w-3/10 cursor-pointer bg-green-100 rounded-2xl mr-3 text-center justify-center items-center ${isHover3 ? 'bg-green-300' : ''}`}
                            onClick={() => hover3()}>Изученные
                        </div>
                    </div>
                </div>
                <div className={`flex flex-col w-4/5 h-4/5 rounded-2xl text-center bg-white mt-8 ${isHover1 ? '' : 'hidden'}`}>
                    <div className={'font-bold m-3 h-1/20'}>Слова</div>
                    <div className={`flex flex-col h-14/15 gap-4 items-center overflow-y-auto`}>
                        {
                            words.map((e) => (
                                <Word key={e.id} word={e.text} translation={e.translation} level={e.level} repeat={e.repeat_time}/>
                            ))
                        }
                    </div>

                </div>
                <div
                    className={`flex flex-col w-4/5 h-4/5 rounded-2xl text-center bg-white mt-8 ${isHover2 ? '' : 'hidden'}`}>
                    <div className={'font-bold m-3'}>Слова</div>
                    <div className={`flex flex-col h-14/15 gap-4 items-center overflow-y-auto`}>
                        {
                            words.map((e) => (
                                <Word key={e.id} word={e.text} translation={e.translation} level={e.level}
                                      repeat={e.repeat_time}/>
                            ))
                        }
                    </div>
                </div>
                <div
                    className={`flex flex-col w-4/5 h-4/5 rounded-2xl text-center bg-white mt-8 ${isHover3 ? '' : 'hidden'}`}>
                    <div className={'font-bold m-3'}>Слова</div>
                    <div className={`flex flex-col h-14/15 gap-4 items-center overflow-y-auto`}>
                        {
                            words.map((e) => (
                                <Word key={e.id} word={e.text} translation={e.translation} level={e.level}
                                      repeat={e.repeat_time}/>
                            ))
                        }
                    </div>
                </div>
            </div>
        </main>
    )
}//