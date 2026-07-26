import {innerRoutes} from "../../plugins/routes.js";
import {useEffect, useRef, useState} from "react";
import {get} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import {getText, lang} from "../../lang/lang.js";
import {useRedirect} from "../../hooks/useRedirect.js";

export default function Home() {
    const {redirect} = useRedirect()
    const [language, setLanguage] = useState('')
    const [languagePost, setLanguagePost] = useState(localStorage.getItem('lang') ?? 'ru')
    const [posts, setPosts] = useState([])
    const [isLanguageDropdownOpen, setIsLanguageDropdownOpen] = useState(false);
    const languageDropdownRef = useRef(null);

    const languageOptions = [
        { name: 'Қазақша', flag: '/flags/kz.svg', value: 'kz' },
        { name: 'Русский', flag: '/flags/ru.svg', value: 'ru' },
        { name: 'English', flag: '/flags/en.svg', value: 'en' }
    ];
    useEffect(() => {
        const fetchPosts = async () => {
            try {
                const lang1 = languagePost;
                const response = await get(apiRoutes.posts + '/' + lang1, {}, {withCredentials: true});
                const data = await response.data;
                setPosts(data);
                setLanguage(lang1);
            } catch (error) {
                console.error('Error fetching posts:', error);
            }
        };
        fetchPosts();
    }, [languagePost]);

    useEffect(() => {
        const handleClickOutside = (e) => {
            if (languageDropdownRef.current && !languageDropdownRef.current.contains(e.target)) {
                setIsLanguageDropdownOpen(false);
            }
        };
        document.addEventListener('click', handleClickOutside);
        return () => document.removeEventListener('click', handleClickOutside);
    }, []);

    function goToArticle(id) {
        redirect(innerRoutes.article + '/' + id);
    }

    const handleLanguageChange = (value) => {
        setLanguagePost(value);
        setIsLanguageDropdownOpen(false);
    };

    const selectedLanguage = languageOptions.find(l => l.value === languagePost);

    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="max-w-5xl mx-auto space-y-8">
                <div>
                    <div className={"flex justify-between items-center"}>
                        <div className="flex items-center gap-3 mb-4 pl-4">
                            <h1 className="text-2xl font-bold text-slate-800">{getText(lang.home.news)}</h1>
                        </div>
                        <div className="flex items-center gap-2 sm:gap-4">
                            <div className="relative" ref={languageDropdownRef}>
                                <button
                                    onClick={() => setIsLanguageDropdownOpen(!isLanguageDropdownOpen)}
                                    className="flex items-center gap-2 border border-slate-200 rounded-lg
                                                 pl-2 sm:pl-2 pr-2 sm:pr-2 py-1 sm:py-1.5
                                                 text-xs sm:text-sm font-medium text-slate-700
                                                 hover:border-indigo-400 focus:outline-none focus:ring-2
                                                 focus:ring-indigo-500/20 focus:border-indigo-500
                                                 transition-all duration-200 cursor-pointer
                                                 min-w-[60px] sm:min-w-[80px] md:min-w-[120px]
                                                 bg-transparent bg-white"
                                >
                                    <img
                                        src={selectedLanguage?.flag}
                                        alt={selectedLanguage?.name}
                                        className="w-4 h-4 sm:w-5 sm:h-5 rounded-sm object-cover"
                                    />
                                    <span className="hidden md:inline">{selectedLanguage?.name}</span>
                                    <svg className="w-3 h-3 sm:w-4 sm:h-4 text-slate-400 ml-auto" fill="none"
                                         stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                              d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                {isLanguageDropdownOpen && (
                                    <div className="absolute left-0 mt-1 min-w-[160px] bg-white
                                                  border border-slate-200 rounded-lg shadow-lg
                                                  py-1 z-50 animate-fadeIn">
                                        {languageOptions.map((lang) => (
                                            <button
                                                key={lang.value}
                                                onClick={() => handleLanguageChange(lang.value)}
                                                className="w-full flex items-center gap-3 px-4 py-2
                                                         text-sm text-slate-700 hover:bg-indigo-50
                                                         transition-colors duration-150"
                                            >
                                                <img
                                                    src={lang.flag}
                                                    alt={lang.name}
                                                    className="w-5 h-5 rounded-sm object-cover"
                                                />
                                                <span>{lang.name}</span>
                                                {lang.value === languagePost && (
                                                    <svg className="w-4 h-4 text-indigo-600 ml-auto" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                                                    </svg>
                                                )}
                                            </button>
                                        ))}
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                    {posts.length > 0 ? (
                        posts.map((e) => (
                            <div key={e.id}
                                 className="cursor-pointer bg-white items-center gap-3 mb-4 shadow rounded-3xl p-8 transition-all"
                                 onClick={() => goToArticle(e.id)}>
                                <div className={'flex justify-between items-start'}>
                                    <div className="flex items-center gap-3 mb-4">
                                        <h1 className="text-xl font-bold text-slate-800">{e.title}</h1>
                                    </div>
                                    <div className="flex items-center gap-2 mb-4">
                                        <img
                                            src={`/flags/${language}.svg`}
                                            alt={language}
                                            className="w-6 h-6 rounded-sm object-cover"
                                            onError={(e) => {
                                                e.target.style.display = 'none';
                                            }}
                                        />
                                        <span className="text-sm font-medium text-slate-700">
                                            {language}
                                        </span>
                                        <span className="text-sm text-slate-500 ml-1">
                                            {e.date}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <p className="text-slate-600 leading-relaxed text-lg">
                                        {e.content}
                                    </p>
                                </div>
                                <div className="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
                                    <div className="flex items-center gap-2">
                                        <span className="text-sm text-slate-600 font-medium">
                                            Автор: {e.username}
                                        </span>
                                    </div>
                                    <div className="flex items-center gap-2">
                                        <svg className="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2"
                                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span className="text-sm text-slate-500">
                                            {e.address}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <div className="text-center py-12">
                            <p className="text-slate-500 text-lg">{getText(lang.home.noNews)}</p>
                        </div>
                    )}
                </div>
            </div>
        </main>
    );
}