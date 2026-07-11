import { innerRoutes } from "../../plugins/routes.js";
import {useRedirect} from "../../hooks/useRedirect.js";

export default function Logo() {
    const {redirectIfAuth} = useRedirect();

    function goHome() {
        redirectIfAuth(innerRoutes.home);
    }

    return (
        <div
            className="flex items-center gap-2 cursor-pointer transition-all duration-300 hover:scale-105" onClick={goHome}>
            <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/25 flex items-center justify-center">
                <span className="text-white font-bold text-lg">L</span>
            </div>
            <span className="text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent tracking-tight">
                LingCard
            </span>
        </div>
    );
}