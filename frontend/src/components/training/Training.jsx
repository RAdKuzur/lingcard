import {useEffect, useState} from "react";
import ButtonBack from "../layouts/ButtonBack.jsx";
import { get, patch } from "../../plugins/request.js";
import { apiRoutes } from "../../plugins/apiRoutes.js";
import InitWindow from "./InitWindow.jsx";
import {getText, lang} from "../../lang/lang.js";
import {studyStatuses} from "../../plugins/studyStatus.js";
import EndTraining from "./EndTraining.jsx";
import WaitingTraining from "./WaitingTraining.jsx";
import Card from "./Card.jsx";
import Loading from "../layouts/Loading.jsx";
export default function Training() {
    const [isTraining, setTraining] = useState(studyStatuses.none)
    const [isLoading, setIsLoading] = useState(true)
    const [word, setWord] = useState(true)
    const [isHoverNo, setHoverNo] = useState(false)
    const [isHoverShow, setHoverShow] = useState(false)
    const [isHoverYes, setHoverYes] = useState(false)
    const [direction, setDirection] = useState('')
    const [opacityCard, setOpacityCard] = useState(true)
    const [opacityTranslation, setOpacityTranslation] = useState(false)
    const [countryCode, setCountryCode] = useState('')

    const [cardId, setCardId] = useState(0)
    const [text, setText] = useState('')
    const [translation, setTranslation] = useState('')
    const [level, setLevel] = useState('')
    const [status, setStatus] = useState('')
    const [repeat, setRepeat] = useState(0)
    const [transcription, setTranscription] = useState('')

    function show() {
        setWord(!word);
        setOpacityTranslation(!opacityTranslation)
        return word
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
        }, 1000)
        setTimeout(() => {
            setOpacityCard(true)
        }, 1500)
    }

    async function handleCheckTrainingStatus() {
        try {
            const response = await get(apiRoutes.teachable, {}, {withCredentials: true})
            const data = await response.data
            setTraining(response.data.training)
            setCountryCode(response.data.language)
            return response.data.training
        } catch (error) {
            return false
        } finally {
            setIsLoading(false)
        }
    }

    useEffect(() => {
        const fetchData = async () => {
            setIsLoading(true)
            const status = await handleCheckTrainingStatus()
            if (status === studyStatuses.learning) {
                setIsLoading(true)
                newWord()
            }
            setTimeout(() => {
                setIsLoading(false)
            }, 200)
        }
        fetchData()
    }, [])

    async function newWord() {
        const response = await get(apiRoutes.training, null, {withCredentials: true});
        const data = await response.data;
        if(data) {
            setCardId(data.id)
            setText(data.text)
            setTranslation(data.translation)
            setLevel(data.level)
            setStatus(data.status)
            setRepeat(data.repeat)
            setTranscription(data.transcription)
        }
        else {
            setTraining(studyStatuses.waiting)
        }
    }

    function handleSetTraining(status) {
        setIsLoading(true)
        setTimeout(() => {
            newWord()
            setTraining(status)
            setIsLoading(false)
        }, 6000)
    }

    return (
        <main
            className="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 flex flex-col items-center justify-center p-6">
            {isLoading ? (
                <Loading/>
            ) : isTraining === studyStatuses.none ? (
                <InitWindow countryCode={countryCode} setTraining={handleSetTraining}/>
            ) : isTraining === studyStatuses.waiting ? (
                <WaitingTraining />
            ) : isTraining === studyStatuses.learned ? (
                <EndTraining/>
            ) : (
                <Card
                    opacityCard={opacityCard}
                    direction={direction}
                    status={status}
                    repeat={repeat}
                    translation={translation}
                    transcription={transcription}
                    opacityTranslation={opacityTranslation}
                    text={text}
                    isHoverNo={isHoverNo}
                    setHoverNo={setHoverNo}
                    swipe={swipe}
                    isHoverShow={isHoverShow}
                    setHoverShow={setHoverShow}
                    word={word}
                    isHoverYes={isHoverYes}
                    setHoverYes={setHoverYes}
                    show={show}
                />
            )}
        </main>
    );
}