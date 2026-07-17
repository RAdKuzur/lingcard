import { Link } from 'react-router-dom';
import ProfileBar from "./ProfileBar.jsx";
import Logo from "./Logo.jsx";
import {innerRoutes} from "../../plugins/routes.js";
import {useAuth} from "../../plugins/AuthContext.jsx";
import {useEffect, useState} from "react";
import {getText, lang} from "../../lang/lang.js";

export default function Navbar() {
    const auth = useAuth();
    const [currentLang, setCurrentLang] = useState('ru');

    const menuOptions = {
        training: {
            link: innerRoutes.training,
            label: getText(lang.navbar.options.training)
        },
        progress: {
            link: innerRoutes.progress,
            label: getText(lang.navbar.options.progress)
        },
        dictionary: {
            link: innerRoutes.dictionary,
            label: getText(lang.navbar.options.dictionary)
        },
        about: {
            link: innerRoutes.about,
            label: getText(lang.navbar.options.about)
        }
    }
    useEffect(() => {
        const language = localStorage.getItem('lang') ?? 'ru'
        setCurrentLang(language)
        localStorage.setItem('lang', language)
    }, [])

    const languageOptions = [
        { name: 'Қазақша', flag: '/flags/kz.svg', value: 'kz' },
        { name: 'Русский', flag: '/flags/ru.svg', value: 'ru' }
    ];

    const handleLanguageChange = (e) => {
        const newLang = e.target.value;
        setCurrentLang(newLang);
        localStorage.setItem('lang', newLang)
        window.location.reload();
    };

    return (
        <nav className="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-slate-200/50 shadow-sm">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center h-16 md:h-20">
                    <Logo />
                    <div className="flex items-center gap-8">
                        {auth.isAuthenticated() ? Object.values(menuOptions).map((item) => (
                            <Link
                                key={item.label}
                                to={item.link}
                                className="text-sm font-medium text-slate-700 hover:text-indigo-600
                                         transition-colors duration-200 border-b-2 border-transparent
                                         hover:border-indigo-600 pb-1"
                            >
                                {item.label}
                            </Link>
                        )) : ''}
                    </div>
                    <div className="flex items-center gap-4">
                        <div className="relative">
                            <select
                                value={currentLang}
                                onChange={handleLanguageChange}
                                className="appearance-none bg-transparent border border-slate-200 rounded-lg
                                         pl-9 pr-8 py-1.5 text-sm font-medium text-slate-700
                                         hover:border-indigo-400 focus:outline-none focus:ring-2
                                         focus:ring-indigo-500/20 focus:border-indigo-500
                                         transition-all duration-200 cursor-pointer"
                            >
                                {languageOptions.map((lang) => (
                                    <option key={lang.value} value={lang.value} className="py-1">
                                        {lang.name}
                                    </option>
                                ))}
                            </select>
                            <div className="absolute left-2 top-1/2 -translate-y-1/2 pointer-events-none">
                                <img
                                    src={languageOptions.find(l => l.value === currentLang)?.flag}
                                    alt="flag"
                                    className="w-5 h-5 rounded-sm object-cover"
                                />
                            </div>
                            <div className="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg className="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <ProfileBar />
                    </div>
                </div>
            </div>
        </nav>
    );
}