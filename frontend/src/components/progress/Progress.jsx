import {useEffect, useState} from "react";
import Word from "../layouts/Word.jsx";
import ButtonBack from "../layouts/ButtonBack.jsx";
import {get} from "../../plugins/request.js";
import {apiDictionary, apiRoutes} from "../../plugins/apiRoutes.js";

export default function Progress() {
    const [isHover1, setHover1] = useState(true)
    const [isHover2, setHover2] = useState(false)
    const [isHover3, setHover3] = useState(false)
    const [activeTab, setActiveTab] = useState(1)
    const [page, setPage] = useState(1)
    const [limit, setLimit] = useState(10)
    const [words, setWords] = useState([])
    const [amountWords, setAmountWords] = useState(1);

    useEffect(() => {hover1()}, [])
    function hover1() {
        setHover1(true)
        setHover2(false)
        setHover3(false)
        setActiveTab(1)
        handleProgress(1 , 1, 10)

    }
    function hover2() {
        setHover1(false)
        setHover2(true)
        setHover3(false)
        setActiveTab(2)
        handleProgress(2, 1, 10)
    }
    function hover3() {
        setHover1(false)
        setHover2(false)
        setHover3(true)
        setActiveTab(3)
        handleProgress(3, 1, 10)
    }

    function nextPage(status) {
        if(page !== totalPages()) {
            const newPage = page + 1;
            setPage(newPage);
            handleProgress(status, newPage, limit);
        }
    }

    function prevPage(status) {
        if(page > 1) {
            const newPage = page - 1;
            setPage(newPage)
            handleProgress(status, newPage, limit)
        }
    }
    async function handleProgress(status, page = 1, limit = 10) {
        setPage(page)
        const response = await get(
            `${apiRoutes.progress}/${status}?page=${page}&limit=${limit}`,
            null,
            { withCredentials: true }
        );
        const data = await response.data;
        setAmountWords(await response.amountWords)
        setWords(data);
    }

    function totalPages() {
        return Math.floor((amountWords + limit - 1) / limit);
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
                            onClick={() => hover2()}>Изучаемые слова
                        </div>
                        <div
                            className={`flex h-4/5 w-3/10 cursor-pointer bg-green-100 rounded-2xl mr-3 text-center justify-center items-center ${isHover3 ? 'bg-green-300' : ''}`}
                            onClick={() => hover3()}>Изученные слова
                        </div>
                    </div>
                </div>
                <div
                    className={`flex flex-col w-4/5 h-4/5 rounded-2xl text-center bg-white mt-8 ${isHover1 ? '' : 'hidden'}`}>
                    <div className={'font-bold m-3 h-1/20'}>Слова</div>
                    <div className={`flex flex-col h-14/15 gap-4 items-center overflow-y-auto`}>
                        {
                            isHover1 ? words.map((e) => (
                                <Word key={e.id} word={e.text} translation={e.translation} level={e.level}
                                      repeat={e.repeat_time}/>
                            )) : ''
                        }
                    </div>

                </div>
                <div
                    className={`flex flex-col w-4/5 h-4/5 rounded-2xl text-center bg-white mt-8 ${isHover2 ? '' : 'hidden'}`}>
                    <div className={'font-bold m-3'}>Слова</div>
                    <div className={`flex flex-col h-14/15 gap-4 items-center overflow-y-auto`}>
                        {
                            isHover2 ? words.map((e) => (
                                <Word key={e.id} word={e.text} translation={e.translation} level={e.level}
                                      repeat={e.repeat_time}/>
                            )) : ''
                        }
                    </div>
                </div>
                <div
                    className={`flex flex-col w-4/5 h-4/5 rounded-2xl text-center bg-white mt-8 ${isHover3 ? '' : 'hidden'}`}>
                    <div className={'font-bold m-3'}>Слова</div>
                    <div className={`flex flex-col h-14/15 gap-4 items-center overflow-y-auto`}>
                        {
                            isHover3 ? words.map((e) => (
                                <Word key={e.id} word={e.text} translation={e.translation} level={e.level}
                                      repeat={e.repeat_time}/>
                            )) : ''
                        }
                    </div>
                </div>
                <div className={`flex w-1/5 h-1/20 bg-white mt-6 rounded-2xl justify-center items-center`}>
                    <div className={`flex w-9/10 h-full justify-between items-center`}>
                        <div className={`flex w-1/4 h-4/5 bg-red-300 rounded-2xl ${page === 1 ? 'hidden' : ''}`}>
                            <button className={'w-full h-full cursor-pointer'} onClick={() => prevPage(activeTab)}>Пред.</button>
                        </div>
                        <div className={`flex w-1/4 h-4/5 rounded-2xl ${page === 1 ? '' : 'hidden'}`}>
                        </div>
                        <div
                            className={`flex w-1/4 h-4/5 bg-gray-100 text-center justify-center items-center rounded-2xl`}>
                            {page}/{totalPages()}
                        </div>
                        <div
                            className={`flex w-1/4 h-4/5 bg-green-300  rounded-2xl ${page === totalPages() ? 'hidden' : ''}`}>
                            <button className={'w-full h-full cursor-pointer'} onClick={() => nextPage(activeTab)}>След.</button>
                        </div>
                        <div
                            className={`flex w-1/4 h-4/5 rounded-2xl ${page === totalPages() ? '' : 'hidden'}`}>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    )
}//