import {useState} from "react";
import Word from "../layouts/Word.jsx";

export default function Progress() {
    const [isHover1, setHover1] = useState(true)
    const [isHover2, setHover2] = useState(false)
    const [isHover3, setHover3] = useState(false)

    function hover1() {
        setHover1(true)
        setHover2(false)
        setHover3(false)
    }
    function hover2() {
        setHover1(false)
        setHover2(true)
        setHover3(false)
    }
    function hover3() {
        setHover1(false)
        setHover2(false)
        setHover3(true)
    }

    return (
        <main className="flex h-screen bg-gray-200 justify-center">
            <div className="flex flex-col w-full h-full items-center">
                <div className="flex w-2/5 h-1/24 rounded-2xl text-center bg-white mt-8 justify-between items-center">
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
                <div className={`flex flex-col w-4/5 h-4/5 rounded-2xl text-center bg-white mt-8 ${isHover1 ? '' : 'hidden'}`}>
                    <div className={'font-bold m-3 h-1/20'}>Слова</div>
                    <div className={`flex flex-col h-14/15 gap-4 justify-center items-center`}>
                        <Word/>
                        <Word/>
                        <Word/>
                        <Word/>
                        <Word/>
                        <Word/>
                        <Word/>
                    </div>

                </div>
                <div className={`flex flex-col w-4/5 h-4/5 rounded-2xl text-center bg-white mt-8 ${isHover2 ? '' : 'hidden'}`}>
                    <div className={'font-bold m-3'}>Слова</div>
                </div>
                <div className={`flex flex-col w-4/5 h-4/5 rounded-2xl text-center bg-white mt-8 ${isHover3 ? '' : 'hidden'}`}>
                    <div className={'font-bold m-3'}>Слова</div>
                </div>
            </div>
        </main>
    )
}//