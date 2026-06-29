import PanelHome from "./PanelHome.jsx";
import {innerRoutes} from "../../plugins/routes.js";

export default function Home() {
    return (
        <main className="flex flex-1 bg-gray-200 items-center justify-center">
            <div className={'flex flex-row gap-10'}>
                <PanelHome title={'Начать тренировку'} link={innerRoutes.training}></PanelHome>
                <PanelHome title={'Прогресс'} link={innerRoutes.progress}></PanelHome>
                <PanelHome title={'Словарь'} link={innerRoutes.dictionary}></PanelHome>
                <PanelHome title={'База знаний'} link={innerRoutes.knowledge}></PanelHome>
            </div>
        </main>
    );
}