import {useEffect, useState} from "react";
import ButtonBack from "../layouts/ButtonBack.jsx";
import {get, patch} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";

export default function Training() {
    const [word, setWord] = useState(true)
    const [isHoverNo, setHoverNo] = useState(false)
    const [isHoverShow, setHoverShow] = useState(false)
    const [isHoverYes, setHoverYes] = useState(false)
    const [direction, setDirection] = useState('')
    const [opacityCard, setOpacityCard] = useState(true)
    const [opacityTranslation, setOpacityTranslation] = useState(false)

    const [cardId, setCardId] = useState(0)
    const [text, setText] = useState('')
    const [translation, setTranslation] = useState('')
    const [level, setLevel] = useState('')

    function show() {
        setWord(!word);
        setOpacityTranslation(!opacityTranslation)
        return word ? 'Слово' : 'Перевод'
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
        }, 1500)
        setTimeout(() => {
            setOpacityCard(true)
        }, 2500)
    }
    useEffect(() => {
        newWord()
    }, [])

    async function newWord() {
        const response = await get(apiRoutes.training, null, {withCredentials: true});
        const data = await response.data;
        if(data) {
            setCardId(data.id)
            setText(data.text)
            setTranslation(data.translation)
            setLevel(data.level)
        }
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
                        <div className={'font-bold text-xl'}>{level}</div>
                    </div>
                    <div className={'flex flex-col  h-5/6'}>
                        <div className={'flex flex-col h-1/3 items-center justify-center'}>
                            <div className={'font-bold text-center text-3xl'}>{text}</div>
                        </div>
                        <div className={'flex flex-col h-1/3 items-center justify-center'}>
                            <div className={`font-bold text-center duration-600 ${opacityTranslation ? 'opacity-100' : 'opacity-0'}`}>{translation}</div>
                        </div>
                    </div>
                </div>
                <div className={'flex h-1/8 justify-between m-3'}>
                    <button className={`cursor-pointer p-2 bg-red-400 w-1/4 rounded-3xl font-sans ${isHoverNo ? 'bg-red-600' : ''}`}
                        onMouseEnter={() => setHoverNo(true)}
                        onMouseLeave={() => setHoverNo(false)}
                        onClick={() => swipe('left')}
                    >Не знаю</button>
                    <button className={`cursor-pointer p-2 bg-cyan-400 w-1/4  rounded-3xl ${isHoverShow ? 'bg-cyan-600' : ''}`}
                            onMouseEnter={() => setHoverShow(true)}
                            onMouseLeave={() => setHoverShow(false)}
                            onClick={show}>{word ? 'Показать' : 'Убрать'}</button>
                    <button className={`cursor-pointer p-2 bg-green-400 w-1/4 rounded-3xl font-sans ${isHoverYes ? 'bg-green-600' : ''}`}
                            onMouseEnter={() => setHoverYes(true)}
                            onMouseLeave={() => setHoverYes(false)}
                            onClick={() => swipe('right')}
                    >Знаю</button>
                </div>
            </div>
        </main>
    )
}