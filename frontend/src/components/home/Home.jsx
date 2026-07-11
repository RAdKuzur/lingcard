import PanelHome from "./PanelHome.jsx";
import {innerRoutes} from "../../plugins/routes.js";
import ButtonBack from "../layouts/ButtonBack.jsx";
import {useState} from "react";
import {get} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";

export default function Home() {
    const [news, setNews] = useState([])
    const countries = [
        { name: 'Қазақша', flag: '/flags/kz.svg' },
        { name: 'Русский', flag: '/flags/ru.svg' },
        // { name: 'Грузия', flag: '/flags/ge.svg' },
        // { name: 'Армения', flag: '/flags/am.svg' },
        // { name: 'Китай', flag: '/flags/cn.svg' }
    ];

    useState(async () => {
        const response = await get(apiRoutes.news, {}, {withCredentials: true})
        const data = await response.data
        setNews(data)
    },[])

    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="max-w-5xl mx-auto space-y-8">
                <div>
                    <div className="flex items-center gap-3 mb-4 pl-4">
                        <h1 className="text-2xl font-bold text-slate-800">Новости</h1>
                    </div>
                    {
                        news.length > 0 ?
                            (news.map((e) => (
                                <div id={e.id} className="bg-white items-center gap-3 mb-4 shadow rounded-3xl p-8 transition-all">
                                    <div className={'flex justify-between'}>
                                        <div className="flex items-center gap-3 mb-4">
                                            <h1 className="text-xl font-bold text-slate-800">{e.title}</h1>
                                        </div>
                                        <div className="flex items-center gap-3 mb-4">
                                            <h1 className="text-l text-slate-800">{e.date}</h1>
                                        </div>
                                    </div>

                                    <div>
                                        <p className="text-slate-600 leading-relaxed text-lg">
                                            {e.content}
                                        </p>
                                    </div>
                                </div>
                            ))) : ''
                    }
                </div>
            </div>
        </main>
    );
    // return (
    //     <main className="flex flex-1 bg-gradient-to-br from-slate-50 to-slate-100 items-center justify-center p-6">
    //         <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl w-full">
    //             <PanelHome title={'Начать тренировку'} link={innerRoutes.training} />
    //             <PanelHome title={'Прогресс'} link={innerRoutes.progress} />
    //             <PanelHome title={'Словарь'} link={innerRoutes.dictionary} />
    //             <PanelHome title={'О нас'} link={innerRoutes.about} />
    //         </div>
    //     </main>
    // );
}