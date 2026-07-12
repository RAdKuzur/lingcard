import ButtonBack from "../layouts/ButtonBack.jsx";
import {getText, lang} from "../../lang/lang.js";
import {useEffect, useState} from "react";

export default function About() {
    const countries = [
        { name: 'Қазақша', flag: '/flags/kz.svg' },
        { name: 'Русский', flag: '/flags/ru.svg' },
        // { name: 'Грузия', flag: '/flags/ge.svg' },
        // { name: 'Армения', flag: '/flags/am.svg' },
        // { name: 'Китай', flag: '/flags/cn.svg' }
    ];
    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="flex max-w-5xl mx-auto justify-start mb-6">
                <ButtonBack />
            </div>
            <div className="max-w-5xl mx-auto space-y-8">
                <div className="bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-8 transition-all hover:shadow-xl hover:shadow-slate-300/50">
                    <div className="flex items-center gap-3 mb-4">
                        <h1 className="text-2xl font-bold text-slate-800">{getText(lang.about.me)}</h1>
                    </div>
                    <p className="text-slate-600 leading-relaxed text-lg">
                        {getText(lang.about.mission)}
                    </p>
                </div>
                <div className="bg-white rounded-2xl shadow-lg shadow-slate-200/50 p-8 transition-all hover:shadow-xl hover:shadow-slate-300/50">
                    <div className="flex items-center gap-3 mb-4">
                        <h1 className="text-2xl font-bold text-slate-800">{getText(lang.about.contacts)}</h1>
                    </div>
                    <div className="space-y-3">
                        <a
                            href="mailto:drive16052003@gmail.com"
                            className="flex items-center gap-3 text-slate-600 hover:text-blue-600 transition-colors group"
                        >
                            <span className="text-lg group-hover:underline">
                            drive16052003@gmail.com
                        </span>
                        </a>
                    </div>
                </div>
                <div>
                    <div className="flex items-center gap-3 mb-6 justify-center">
                        <h1 className="text-2xl font-bold text-slate-800">{getText(lang.about.languages)}</h1>
                    </div>
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        {countries.map((country, index) => (
                            <div
                                key={index}
                                className="group bg-white rounded-2xl shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300 hover:scale-105 cursor-pointer p-6 flex flex-col items-center justify-center"
                            >
                                <div className="w-30 h-30 mb-3 group-hover:scale-110 transition-transform duration-300 rounded-lg overflow-hidden shadow-md">
                                    <img
                                        src={country.flag}
                                        alt={country.name}
                                        className="w-full h-full object-cover"
                                    />
                                </div>
                                <span className="text-lg font-semibold text-slate-700">
                                {country.name}
                            </span>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </main>
    );
}