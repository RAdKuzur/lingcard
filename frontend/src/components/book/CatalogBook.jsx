import {useRedirect} from "../../hooks/useRedirect.js";
import {useEffect, useRef, useState} from "react";
import {get} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import {innerRoutes} from "../../plugins/routes.js";
import {getText, lang} from "../../lang/lang.js";
import ButtonBack from "../layouts/ButtonBack.jsx";

export default function CatalogBook() {
    const {redirect} = useRedirect()
    const [books, setBooks] = useState([])

    useEffect(() => {
        const fetchPosts = async () => {
            try {
                const response = await get(apiRoutes.books, {}, {withCredentials: true});
                const data = await response.data;
                setBooks(data);

            } catch (error) {
                console.error('Error fetching books:', error);
            }
        };
        fetchPosts();
    }, []);
    function goToBook(id) {
        redirect(innerRoutes.books + '/' + id);
    }

    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="max-w-5xl mx-auto space-y-8">
                <div>
                    <div className={"flex justify-between items-center mb-3"}>
                        <div className="flex items-center gap-4">
                            <ButtonBack/>
                            <h1 className="text-2xl font-bold text-slate-800">{getText(lang.books.title)}</h1>
                        </div>
                        <div className={'flex items-center gap-4 justify-between'}>
                        </div>
                    </div>
                    {books.length > 0 ? (
                        books.map((e) => (
                            <div key={e.id}
                                 className="cursor-pointer bg-white items-center gap-3 mb-4 shadow rounded-3xl p-8 transition-all"
                                 onClick={() => goToBook(e.id)}>
                                <div className={'flex justify-between items-start'}>
                                    <div className="flex items-center gap-3 mb-4">
                                        <h1 className="text-xl font-bold text-slate-800">{e.title}</h1>
                                    </div>
                                    <div className="flex items-center gap-2 mb-4">
                                        <img
                                            src={`/flags/${e.language}.svg`}
                                            alt={e.language}
                                            className="w-6 h-6 rounded-sm object-cover"
                                            onError={(e) => {
                                                e.target.style.display = 'none';
                                            }}
                                        />
                                        <span className="text-sm font-medium text-slate-700">
                                            {e.author}
                                        </span>
                                    </div>
                                </div>

                                <div className="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
                                    <div className="flex items-center gap-2">
                                        <span className="text-sm text-slate-600 font-medium">
                                            {e.year}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        ))
                    ) : (
                        <div className="text-center py-12">
                            <p className="text-slate-500 text-lg">{getText(lang.books.noBooks)}</p>
                        </div>
                    )}
                </div>
            </div>
        </main>
    );
}