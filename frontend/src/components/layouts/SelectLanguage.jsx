import React, { useState, useEffect } from 'react';
import { apiRoutes } from "../../plugins/apiRoutes.js";
import { get } from "./../../plugins/request.js";

export default function SelectLanguage() {
    const [languages, setLanguages] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        get(apiRoutes.languages, null, { withCredentials: true })
            .then(data => {
                console.log('Получены языки:', data);
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
        return <select className="w-full border rounded-2xl h-full" disabled>
            <option>Загрузка...</option>
        </select>;
    }
    if (error) {
        return <select className="w-full border rounded-2xl h-full" disabled>
            <option>Ошибка загрузки</option>
        </select>;
    }
    return (
        <select className="w-full border rounded-2xl h-full">
            {languages.length === 0 ? (
                <option>Нет доступных языков</option>
            ) : (
                languages.map(lang => (
                    <option key={lang.id} value={lang.id}>
                        {lang.name}
                    </option>
                ))
            )}
        </select>
    );
}