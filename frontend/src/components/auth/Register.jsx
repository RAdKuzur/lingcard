import SelectLanguage from "../layouts/SelectLanguage.jsx";
import {useState} from "react";
import axios from "axios";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import {useRedirect} from "../../hooks/useRedirect.js";
import {innerRoutes} from "../../plugins/routes.js";
import {getText, lang as langauge} from "../../lang/lang.js";

export default function Register() {
    const {redirect} = useRedirect()
    const [isHover, setHover] = useState(false);
    const [email, setEmail] = useState('');
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [lang, setLang] = useState(0)
    const [targetLang, setTargetLang] = useState(0)
    const [message, setMessage] = useState('')
    const [isSuccess, setIsSuccess] = useState(false)

    async function signUp() {
        setMessage('')
        setIsSuccess(false)

        try {
            const response = await axios.post(
                apiRoutes.register,
                {
                    email: email,
                    password: password,
                    base_language_id: lang,
                    target_language_id: targetLang,
                    name: username
                },
                {
                    withCredentials: true,
                    headers: {
                        'Content-Type': 'application/json',
                    }
                }
            );

            const successRegister = response.data.data.status;

            if(successRegister) {
                setIsSuccess(true)
                setMessage(getText(langauge.register.success))
                setTimeout(() => {
                    redirect(innerRoutes.login)
                }, 5000)
            } else {
                setMessage(getText(langauge.register.failed))
                setIsSuccess(false)
            }
        } catch (error) {
            setMessage(getText(langauge.register.failed))
            setIsSuccess(false)
        }
    }

    return (
        <main
            className="flex flex-1 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 items-center justify-center p-4">
            <div
                className="flex flex-col w-96 min-h-96 bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl shadow-indigo-500/10 text-center justify-between p-8 border border-white/50">
                <div className="font-bold text-2xl text-slate-800 mt-2">
                    {getText(langauge.register.registerLabel)}
                </div>

                {message && (
                    <div className={`px-4 py-3 rounded-xl text-sm ${isSuccess ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-red-50 border border-red-200 text-red-700'}`}>
                        {message}
                    </div>
                )}

                <div className="space-y-4">
                    <div>
                        <div className="text-sm font-medium text-slate-600 mb-1.5 text-left">{getText(langauge.register.email)}</div>
                        <input
                            className="w-full rounded-xl px-4 py-3 border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 outline-none transition-all duration-200 bg-white/50 focus:bg-white"
                            onInput={(e) => setEmail(e.target.value)}
                        />
                    </div>

                    <div>
                        <div className="text-sm font-medium text-slate-600 mb-1.5 text-left">{getText(langauge.register.username)}</div>
                        <input
                            className="w-full rounded-xl px-4 py-3 border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 outline-none transition-all duration-200 bg-white/50 focus:bg-white"
                            onInput={(e) => setUsername(e.target.value)}
                        />
                    </div>

                    <div>
                        <div className="text-sm font-medium text-slate-600 mb-1.5 text-left">{getText(langauge.register.password)}</div>
                        <input
                            className="w-full rounded-xl px-4 py-3 border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 outline-none transition-all duration-200 bg-white/50 focus:bg-white"
                            type="password"
                            onInput={(e) => setPassword(e.target.value)}
                        />
                    </div>
                    <div>
                        <div className="text-sm font-medium text-slate-600 mb-1.5 text-left">{getText(langauge.register.baseLang)}</div>
                        <SelectLanguage setLang={setLang} value={lang} extraEmptyField={true}/>
                    </div>
                    <div>
                        <div className="text-sm font-medium text-slate-600 mb-1.5 text-left">{getText(langauge.register.targetLang)}</div>
                        <SelectLanguage setLang={setTargetLang} value={targetLang} exceptId={lang} extraEmptyField={true}/>
                    </div>
                </div>
                <div className="mt-4">
                    <button
                        className={`w-full py-3.5 rounded-xl bg-gradient-to-r from-green-500 to-green-600 text-white font-bold transition-all duration-200 shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 cursor-pointer hover:scale-[1.02] active:scale-[0.98] ${isHover ? 'from-green-600 to-green-700' : ''}`}
                        onClick={signUp}
                        onMouseEnter={() => setHover(true)}
                        onMouseLeave={() => setHover(false)}
                    >
                        {getText(langauge.register.createAccount)}
                    </button>
                </div>
            </div>
        </main>
    )
}