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
    async function handleSearch() {
        if (lang1 !== 0 && lang2 !== 0 && lang1 !== lang2) {
            const response = await get(apiDictionary(lang1, lang2), null, {withCredentials: true})
            const data = await response.data;
            setWords(data)
        }
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
                                <button onClick={handleSearch}
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
                                <Word key={e.id} word={e.text} translation={e.translation} level={e.level} />
                            ))
                        }

                    </div>
                </div>
            </div>
        </main>
    )
}