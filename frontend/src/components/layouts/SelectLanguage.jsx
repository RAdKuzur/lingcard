import React, { useState, useEffect } from 'react';
import axios from 'axios';
import {apiRoutes} from "../../plugins/apiRoutes.js";

export default function SelectLanguage() {
    const [languages, setLanguages] = useState([]);

    useEffect(() => {
        axios.get(apiRoutes.languages, { withCredentials: true })
            .then(res => setLanguages(res.data.data))
            .catch(err => console.log(err));
    }, []);

    return (
        <select className="w-full border rounded-2xl h-full">
            {languages.map(lang => (
                <option key={lang.id} value={lang.id}>
                    {lang.name}
                </option>
            ))}
        </select>
    );
}