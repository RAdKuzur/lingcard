import {useState} from "react";
import ButtonBack from "../layouts/ButtonBack.jsx";

export default function Training() {
    const [word, setWord] = useState(true)
    const [isHoverNo, setHoverNo] = useState(false)
    const [isHoverShow, setHoverShow] = useState(false)
    const [isHoverYes, setHoverYes] = useState(false)
    const [direction, setDirection] = useState('')
    const [opacityCard, setOpacityCard] = useState(true)
    const [opacityTranslation, setOpacityTranslation] = useState(false)
    function show() {
        setWord(!word);
        setOpacityTranslation(!opacityTranslation)
        return word ? 'Слово' : 'Перевод'
    }

    function swipe(way){
        setDirection(way)
        setOpacityCard(false)

        setTimeout(() => {
            setOpacityTranslation(false)
            setWord(true)
            setDirection('')
        }, 1500)
        setTimeout(() => {
            setOpacityCard(true)
        }, 2500)
    }


    return (
        <main className="flex flex-1 flex-col bg-gray-200 items-center justify-center">
            <div className={'m-4'}>
                <ButtonBack></ButtonBack>
            </div>
            <div className={`flex flex-col w-96 h-96 bg-white rounded-2xl duration-1000 
                ${direction === 'right' ? 'origin-bottom-right rotate-20' : ''}
                ${direction === 'left' ? 'origin-bottom-left -rotate-20' : ''}
                ${opacityCard ? 'opacity-100' : 'opacity-0 pointer-events-none'}
            `}>
                <div className={'flex flex-col h-5/6'}>
                    <div className={'flex m-4 h-1/6'}>
                        <div className={'font-bold'}>Уровень 1</div>
                    </div>
                    <div className={'flex flex-col  h-5/6'}>
                        <div className={'flex flex-col h-1/3 items-center justify-center'}>
                            <div className={'font-bold text-center'}>Слово</div>
                        </div>
                        <div className={'flex flex-col h-1/3 items-center justify-center'}>
                            <div className={`font-bold text-center duration-600 ${opacityTranslation ? 'opacity-100' : 'opacity-0'}`}>Перевод</div>
                        </div>
                    </div>
                </div>
                <div className={'flex h-1/8 justify-between m-3'}>
                    <button className={`cursor-pointer p-2 bg-red-400 w-1/4 rounded-3xl ${isHoverNo ? 'bg-red-600' : ''}`}
                        onMouseEnter={() => setHoverNo(true)}
                        onMouseLeave={() => setHoverNo(false)}
                        onClick={() => swipe('left')}
                    >Не знаю</button>
                    <button className={`cursor-pointer p-2 bg-cyan-400 w-1/4  rounded-3xl ${isHoverShow ? 'bg-cyan-600' : ''}`}
                            onMouseEnter={() => setHoverShow(true)}
                            onMouseLeave={() => setHoverShow(false)}
                            onClick={show}>{word ? 'Показать' : 'Убрать'}</button>
                    <button className={`cursor-pointer p-2 bg-green-400 w-1/4 rounded-3xl ${isHoverYes ? 'bg-green-600' : ''}`}
                            onMouseEnter={() => setHoverYes(true)}
                            onMouseLeave={() => setHoverYes(false)}
                            onClick={() => swipe('right')}
                    >Знаю</button>
                </div>
            </div>
        </main>
    )
}