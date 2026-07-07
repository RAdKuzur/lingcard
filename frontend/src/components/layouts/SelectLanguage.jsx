import React, { useState, useEffect } from 'react';
import { apiRoutes } from "../../plugins/apiRoutes.js";
import { get } from "./../../plugins/request.js";

export default function SelectLanguage({setLang, value = 0}) {
    const [languages, setLanguages] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        get(apiRoutes.languages, null, { withCredentials: true })
            .then(data => {
                if (Array.isArray(data)) {
                    setLanguages(data);
                }
                else if (data?.data && Array.isArray(data.data)) {
                    setLanguages(data.data);
                }
                else if (data?.languages && Array.isArray(data.languages)) {
                    setLanguages(data.languages);
                }
                setLoading(false);
            })
            .catch(err => {
                console.error('Ошибка загрузки языков:', err);
                setError(err.message);
                setLoading(false);
            });
    }, []);

    if (loading) {
        return (
            <select className="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-400 cursor-not-allowed" disabled>
                <option>Загрузка...</option>
            </select>
        );
    }

    if (error) {
        return (
            <select className="w-full px-4 py-2.5 rounded-xl border border-rose-200 bg-rose-50 text-rose-500 cursor-not-allowed" disabled>
                <option>Ошибка загрузки</option>
            </select>
        );
    }

    return (
        <select
            className="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:border-slate-300 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400/20 outline-none transition-all duration-200 text-slate-700 cursor-pointer appearance-none"
            value={value}
            onChange={(e) => setLang(e.target.value)}
        >
            <option value={0}>Выберите язык...</option>
            {languages.map(lang => (
                <option key={lang.id} value={lang.id}>
                    {lang.name}
                </option>
            ))}
        </select>
    );
}