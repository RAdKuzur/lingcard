import { useState } from "react";
import axios from "axios";
import { apiRoutes } from "../../plugins/apiRoutes.js";
import { getText, lang as language } from "../../lang/lang.js";
import SelectLanguage from "../layouts/SelectLanguage.jsx";
import ConfirmRegister from "./ConfirmRegister.jsx";
export default function Register() {
    const [step, setStep] = useState(1);
    const [lang, setLang] = useState(0);
    const [targetLang, setTargetLang] = useState(0);
    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [message, setMessage] = useState('');
    const [isSuccess, setIsSuccess] = useState(false);

    const isStepValid = () => {
        if (step === 1) return lang !== 0;
        if (step === 2) return targetLang !== 0 && targetLang !== lang;
        if (step === 3) return username.length >= 3 && password.length >= 6;
        return false;
    };

    const nextStep = () => {
        if (isStepValid()) {
            setStep(step + 1);
            setMessage('');
        } else {
            if (step === 1) setMessage(getText(language.home.chooseBaseLang));
            if (step === 2) setMessage(getText(language.home.chooseTargetLang));
            if (step === 3) setMessage(getText(language.home.inputUsername));
        }
    };

    const prevStep = () => {
        if (step > 1) {
            setStep(step - 1);
            setMessage('');
        }
    };

    async function signUp() {
        setMessage('');
        setIsSuccess(false);

        try {
            const response = await axios.post(
                apiRoutes.register,
                {
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

            if (successRegister) {
                setIsSuccess(true);
            } else {
                setMessage(getText(language.register.failed));
                setIsSuccess(false);
            }
        } catch (error) {
            setMessage(getText(language.register.failed));
            setIsSuccess(false);
        }
    }

    if (isSuccess) {
        return <ConfirmRegister />;
    }

    return (
        <main className="flex flex-1 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 items-center justify-center p-4">
            <div className="flex flex-col w-96 min-h-96 bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl shadow-indigo-500/10 p-8 border border-white/50">
                <div className="flex justify-center gap-2 mb-6">
                    {[1, 2, 3].map((i) => (
                        <div
                            key={i}
                            className={`h-2 rounded-full transition-all duration-300 ${
                                i === step ? 'w-12 bg-indigo-600' :
                                    i < step ? 'w-8 bg-green-500' : 'w-8 bg-slate-200'
                            }`}
                        />
                    ))}
                </div>

                <div className="text-center mb-6">
                    <h2 className="font-bold text-2xl text-slate-800">
                        {step === 1 && getText(language.register.mainLabelStep1)}
                        {step === 2 && getText(language.register.mainLabelStep2)}
                        {step === 3 && getText(language.register.mainLabelStep3)}
                    </h2>
                    <p className="text-sm text-slate-500 mt-1">
                        {step === 1 && getText(language.register.hintLabelStep1)}
                        {step === 2 && getText(language.register.hintLabelStep1)}
                        {step === 3 && getText(language.register.hintLabelStep1)}
                    </p>
                </div>

                {message && (
                    <div className="px-4 py-3 mb-4 rounded-xl text-sm bg-red-50 border border-red-200 text-red-700">
                        {message}
                    </div>
                )}

                <div className="flex-1">
                    {step === 1 && (
                        <div>
                            <div className="text-sm font-medium text-slate-600 mb-1.5">
                                {getText(language.register.yourLang)}
                            </div>
                            <SelectLanguage
                                setLang={setLang}
                                value={lang}
                                extraEmptyField={true}
                                placeholder="Выберите язык обучения"
                            />
                        </div>
                    )}

                    {step === 2 && (
                        <div>
                            <div className="text-sm font-medium text-slate-600 mb-1.5">
                                {getText(language.register.targetLang)}
                            </div>
                            <SelectLanguage
                                setLang={setTargetLang}
                                value={targetLang}
                                exceptId={lang}
                                extraEmptyField={true}
                                placeholder="Выберите язык для изучения"
                            />
                        </div>
                    )}

                    {step === 3 && (
                        <div className="space-y-4">
                            <div>
                                <div className="text-sm font-medium text-slate-600 mb-1.5">
                                    {getText(language.register.username)}
                                </div>
                                <input
                                    className="w-full rounded-xl px-4 py-3 border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 outline-none transition-all duration-200 bg-white/50 focus:bg-white"
                                    onInput={(e) => {
                                        const latinAndNumbers = e.target.value.replace(/[^a-zA-Z0-9]/g, '');
                                        e.target.value = latinAndNumbers;
                                        setUsername(latinAndNumbers);
                                    }}
                                    value={username}
                                />
                            </div>
                            <div>
                                <div className="text-sm font-medium text-slate-600 mb-1.5">
                                    {getText(language.register.password)}
                                </div>
                                <input
                                    className="w-full rounded-xl px-4 py-3 border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 outline-none transition-all duration-200 bg-white/50 focus:bg-white"
                                    type="password"
                                    onInput={(e) => setPassword(e.target.value)}
                                />
                            </div>
                        </div>
                    )}
                </div>


                <div className="flex gap-3 mt-6">
                    {step > 1 && (
                        <button
                            onClick={prevStep}
                            className="flex-1 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition-all duration-200 cursor-pointer hover:scale-[1.02] active:scale-[0.98]"
                        >
                            {getText(language.register.back)}
                        </button>
                    )}

                    {step < 3 ? (
                        <button
                            onClick={nextStep}
                            className={`flex-1 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-500 text-white font-bold transition-all duration-200 shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 cursor-pointer hover:scale-[1.02] active:scale-[0.98] ${
                                step === 1 ? 'flex-1' : ''
                            }`}
                        >
                            {getText(language.register.next)}
                        </button>
                    ) : (
                        <button
                            onClick={signUp}
                            className="flex-1 py-3 rounded-xl bg-gradient-to-r from-green-500 to-green-600 text-white font-bold transition-all duration-200 shadow-lg shadow-green-500/25 hover:shadow-green-500/40 cursor-pointer hover:scale-[1.02] active:scale-[0.98]"
                        >
                            {getText(language.register.createAccount)}
                        </button>
                    )}
                </div>
            </div>
        </main>
    );
}