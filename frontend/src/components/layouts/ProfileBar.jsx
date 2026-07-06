import { useNavigate } from "react-router-dom";
import { innerRoutes } from "../../plugins/routes.js";

export default function ProfileBar({ isAuth }) {
    const navigate = useNavigate();

    function goProfile() {
        navigate(innerRoutes.profile);
    }

    const username = localStorage.getItem('username') || 'Гость';
    const role = localStorage.getItem('role') || '';

    const roleColors = {
        admin: 'bg-purple-100 text-purple-700',
        user: 'bg-blue-100 text-blue-700',
        moderator: 'bg-orange-100 text-orange-700',
    };

    const roleClass = roleColors[role.toLowerCase()] || 'bg-slate-100 text-slate-700';

    return (
        <div
            className="flex items-center gap-3 px-3 py-2 rounded-xl bg-white/50 hover:bg-white border border-slate-200/50 hover:border-slate-300 shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer"
            onClick={goProfile}
        >
            <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white font-semibold text-sm shadow-md shadow-blue-500/20">
                {isAuth ? username.charAt(0).toUpperCase() : '👤'}
            </div>
            <div className="flex flex-col items-start">
                <span className="text-sm font-semibold text-slate-700">
                    {isAuth ? username : 'Профиль'}
                </span>
                {isAuth && (
                    <span className={`text-xs px-2 py-0.5 rounded-full ${roleClass}`}>
                        {role}
                    </span>
                )}
            </div>
        </div>
    );
}