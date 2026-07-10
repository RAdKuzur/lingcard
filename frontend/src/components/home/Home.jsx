import PanelHome from "./PanelHome.jsx";
import {innerRoutes} from "../../plugins/routes.js";

export default function Home() {
    return (
        <main className="flex flex-1 bg-gradient-to-br from-slate-50 to-slate-100 items-center justify-center p-6">
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl w-full">
                <PanelHome title={'Начать тренировку'} link={innerRoutes.training} />
                <PanelHome title={'Прогресс'} link={innerRoutes.progress} />
                <PanelHome title={'Словарь'} link={innerRoutes.dictionary} />
                <PanelHome title={'О нас'} link={innerRoutes.about} />
            </div>
        </main>
    );
}