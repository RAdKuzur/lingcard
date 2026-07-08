import { useState } from "react";
import { loginAxios as loginAxios } from "../../plugins/auth.js";
import { useNavigate } from "react-router-dom";
import { innerRoutes } from "../../plugins/routes.js";
import { useRedirect } from "../../hooks/useRedirect.js";

export default function Login({ setAuth }) {
    const { redirect } = useRedirect();
    const navigate = useNavigate();
    const [isHover, setHover] = useState(false);
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    function signIn() {
        loginAxios(email, password, setAuth, redirect);
    }

    function goToRegister() {
        redirect(innerRoutes.register);
    }

    return (
        <main className="flex flex-1 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 items-center justify-center p-4">
            <div className="flex flex-col w-96 min-h-96 bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl shadow-indigo-500/10 text-center justify-between p-8 border border-white/50">
                <div className="font-bold text-2xl text-slate-800 mt-2">
                    Вход в систему
                </div>
                <div className="space-y-4">
                    <div>
                        <div className="text-sm font-medium text-slate-600 mb-1.5 text-left">Эл. почта</div>
                        <input
                            className="w-full rounded-xl px-4 py-3 border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 outline-none transition-all duration-200 bg-white/50 focus:bg-white"
                            placeholder="e-mail"
                            onInput={(e) => setEmail(e.target.value)}
                        />
                    </div>
                    <div>
                        <div className="text-sm font-medium text-slate-600 mb-1.5 text-left">Пароль</div>
                        <input
                            className="w-full rounded-xl px-4 py-3 border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 outline-none transition-all duration-200 bg-white/50 focus:bg-white"
                            placeholder="password"
                            type="password"
                            onInput={(e) => setPassword(e.target.value)}
                        />
                    </div>
                </div>
                <div className="mt-4 space-y-3">
                    <button
                        className={`w-full py-3.5 rounded-xl bg-gradient-to-r cursor-pointer from-indigo-500 to-purple-600 text-white font-bold transition-all duration-200 shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:scale-[1.02] active:scale-[0.98] ${isHover ? 'from-indigo-600 to-purple-700' : ''}`}
                        onClick={signIn}
                        onMouseEnter={() => setHover(true)}
                        onMouseLeave={() => setHover(false)}
                    >
                        Войти
                    </button>
                    <div className="text-sm text-slate-600">
                        Нет аккаунта?{' '}
                        <button
                            onClick={goToRegister}
                            className="text-indigo-600 font-semibold hover:text-indigo-800 hover:underline transition-all duration-200 cursor-pointer"
                        >
                            Зарегистрироваться
                        </button>
                    </div>
                </div>
            </div>
        </main>
    );
}