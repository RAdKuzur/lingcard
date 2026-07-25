import {innerRoutes} from "../../plugins/routes.js";
import ButtonBack from "../layouts/ButtonBack.jsx";
import {useState} from "react";
import {get} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import {getText, lang} from "../../lang/lang.js";
import {useRedirect} from "../../hooks/useRedirect.js";

export default function Vote() {
    const {redirect} = useRedirect()
    const [votes, setVotes] = useState([])
    useState(async () => {
        const lang1 = localStorage.getItem('lang') ?? 'ru'
        const response = await get(apiRoutes.votes, {}, {withCredentials: true})
        const data = await response.data
        setVotes(data)
    },[])
    function goToVote(id) {
        redirect(innerRoutes.votes + '/' + id)
    }
    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="max-w-5xl mx-auto space-y-8">
                <div>
                    <div className="flex items-center gap-3 mb-4 pl-4">
                        <h1 className="text-2xl font-bold text-slate-800">{getText(lang.votes.mainLabel)}</h1>
                    </div>
                    {
                        votes.length > 0 ?
                            (votes.map((e) => (
                                <div key={e.id}
                                     className="cursor-pointer bg-white items-center gap-3 mb-4 shadow rounded-3xl p-8 transition-all outline-2 border-black-500"
                                     onClick={() => goToVote(e.id)}>
                                    <div className={'flex flex-col items-start gap-2'}>
                                        <div className="flex items-center gap-3">
                                            <h1 className="text-xl font-bold text-slate-800">{e.title}</h1>
                                        </div>
                                        <p className="text-slate-600 leading-relaxed text-lg">
                                            {e.content}
                                        </p>
                                    </div>
                                </div>
                            )))
                            : ''
                    }
                </div>
            </div>
        </main>
    );
}