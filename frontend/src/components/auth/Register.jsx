import SelectLanguage from "../layouts/SelectLanguage.jsx";
import {useState} from "react";
import {post} from "../../plugins/request.js";
import axios from "axios";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import {useRedirect} from "../../hooks/useRedirect.js";
import {innerRoutes} from "../../plugins/routes.js";

export default function Register() {
    const {redirect} = useRedirect()
    const [isHover, setHover] = useState(false);
    const [email, setEmail] = useState('');
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [lang, setLang] = useState(0)
    async function signUp() {
        const response = await axios.post(
            apiRoutes.register,
            {
                email: email,
                password: password,
                target_language_id: lang,
                name: username
            },
            {
                withCredentials: true,
                headers: {
                    'Content-Type': 'application/json',
                }
            }
        );
        const successRegister = await response.data.data.status;
        if(successRegister) {
            redirect(innerRoutes.login)
        }
    }
    return (
        <main
            className="flex flex-1 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 items-center justify-center p-4">
            <div
                className="flex flex-col w-96 min-h-96 bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl shadow-indigo-500/10 text-center justify-between p-8 border border-white/50">
                <div className="font-bold text-2xl text-slate-800 mt-2">
                    Регистрация
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
                        <div className="text-sm font-medium text-slate-600 mb-1.5 text-left">Имя пользователя</div>
                        <input
                            className="w-full rounded-xl px-4 py-3 border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 outline-none transition-all duration-200 bg-white/50 focus:bg-white"
                            placeholder="username"
                            onInput={(e) => setUsername(e.target.value)}
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
                    <div>
                        <div className="text-sm font-medium text-slate-600 mb-1.5 text-left">Язык изучения</div>
                        <SelectLanguage setLang={setLang} value={lang}/>
                    </div>

                </div>
                <div className="mt-4">
                    <button
                        className={`w-full py-3.5 rounded-xl bg-gradient-to-r from-green-500 to-green-600 text-white font-bold transition-all duration-200 shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 cursor-pointer hover:scale-[1.02] active:scale-[0.98] ${isHover ? 'from-green-600 to-green-700' : ''}`}
                        onClick={signUp}
                        onMouseEnter={() => setHover(true)}
                        onMouseLeave={() => setHover(false)}
                    >
                        Создать аккаунт
                    </button>
                </div>
            </div>
        </main>
    )
}