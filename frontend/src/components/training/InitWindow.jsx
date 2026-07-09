import {post} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import {useRedirect} from "../../hooks/useRedirect.js";
import {innerRoutes} from "../../plugins/routes.js";

export default function InitWindow({countryCode, setTraining}) {
    async function handleInit() {
        const response = await post(apiRoutes.progress, {}, {withCredentials: true})
        const data = await response.data
        setTraining(data.status)
    }
    return (
        <div className="flex flex-col items-center gap-8 w-96 p-10 bg-white/90 backdrop-blur-sm rounded-3xl shadow-xl border border-white/50">
            <div className="flex flex-col items-center gap-3">
                <div className="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center p-4 shadow-inner">
                    <img
                        src={`/flags/${countryCode}.svg`}
                        alt={countryCode}
                        className="w-full h-full object-contain rounded-full"
                    />
                </div>
                <h2 className="text-2xl font-light text-slate-700 tracking-wide">
                    <p className={'font-bold'}>0
                        {countryCode.toUpperCase()}
                    </p>
                </h2>
            </div>

            <button
                className="w-full py-3.5 px-6 bg-gradient-to-r from-indigo-500 to-purple-500
                       hover:from-indigo-600 hover:to-purple-600
                       text-white text-base font-medium rounded-2xl
                       transition-all duration-300 shadow-lg shadow-indigo-500/25
                       hover:shadow-indigo-500/40 hover:scale-[1.02] active:scale-[0.98]
                       cursor-pointer"
                onClick={handleInit}
            >
                Начать обучение
            </button>
        </div>
    );
}