import Word from "../layouts/Word.jsx";
import SelectLanguage from "../layouts/SelectLanguage.jsx";
import ButtonBack from "../layouts/ButtonBack.jsx";
import {useState} from "react";
import {get} from "../../plugins/request.js";
import {apiDictionary} from "../../plugins/apiRoutes.js";

export default function Dictionary() {
    const [lang1, setLang1] = useState(0);
    const [lang2, setLang2] = useState(0);
    const [words, setWords] = useState([])
    const [page, setPage] = useState(1)
    const [limit, setLimit] = useState(10)
    const [amountWords, setAmountWords] = useState(1);
    const [isPaginator, setPaginator] = useState(false)

    async function handleSearch(page = 1, limit = 10) {
        if (lang1 !== 0 && lang2 !== 0 && lang1 !== lang2) {
            console.log(page)
            const response = await get(apiDictionary(lang1, lang2, page, limit), null, {withCredentials: true})
            const data = await response.data;
            setPaginator(true)
            setAmountWords(await response.amountWords)
            setWords(data)
        }
    }

    function nextPage() {
        if(page !== totalPages()) {
            const newPage = page + 1;
            setPage(newPage);
            handleSearch(newPage, limit)
        }
    }

    function prevPage() {
        if(page > 1) {
            const newPage = page - 1;
            setPage(newPage)
            handleSearch(newPage, limit)
        }
    }

    function totalPages() {
        return Math.floor((amountWords + limit - 1) / limit);
    }

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
                                Язык 1
                            </div>
                            <div className={'w-2/5 h-full text-start'}>
                                Язык 2
                            </div>
                        </div>
                        <div className={'flex h-2/3 w-full gap-3 justify-start items-center'}>
                            <div className={'w-2/5 h-4/5 ml-3'}>
                                <SelectLanguage setLang={setLang1} value={lang1}/>
                            </div>
                            <div className={'w-2/5 h-4/5'}>
                                <SelectLanguage setLang={setLang2} value={lang2}/>
                            </div>
                            <div className={'mr-3 w-1/5'}>
                                <button onClick={() => handleSearch(page, limit)}
                                        className={'p-2 w-full bg-orange-400 font-bold text-white rounded-2xl cursor-pointer'}>
                                    Показать
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div className={`flex flex-col w-4/5 h-4/5 rounded-2xl text-center bg-white mt-8`}>
                    <div className={'font-bold m-3 h-1/20'}>Слова</div>
                    <div className={`flex flex-col h-14/15 gap-4 items-center overflow-y-auto`}>
                        {
                            words.map((e) => (
                                <Word key={e.id} word={e.text} translation={e.translation} level={e.level}/>
                            ))
                        }

                    </div>
                </div>
                <div className={`flex w-1/5 h-1/20 bg-white mt-6 mb-6 rounded-2xl justify-center items-center ${!isPaginator ? 'hidden' : ''}`}>
                    <div className={`flex w-9/10 h-full justify-between items-center`}>
                        <div className={`flex w-1/4 h-4/5 bg-red-300 rounded-2xl ${page === 1 ? 'hidden' : ''}`}>
                            <button className={'w-full h-full cursor-pointer'}
                                    onClick={() => prevPage()}>Пред.
                            </button>
                        </div>
                        <div className={`flex w-1/4 h-4/5 rounded-2xl ${page === 1 ? '' : 'hidden'}`}>
                        </div>
                        <div
                            className={`flex w-1/4 h-4/5 bg-gray-100 text-center justify-center items-center rounded-2xl`}>
                            {page}/{totalPages()}
                        </div>
                        <div
                            className={`flex w-1/4 h-4/5 bg-green-300  rounded-2xl ${page === totalPages() ? 'hidden' : ''}`}>
                            <button className={'w-full h-full cursor-pointer'}
                                    onClick={() => nextPage()}>След.
                            </button>
                        </div>
                        <div
                            className={`flex w-1/4 h-4/5 rounded-2xl ${page === totalPages() ? '' : 'hidden'}`}>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    )
}