import {useEffect, useState} from "react";
import {get, post} from "../../plugins/request.js";
import {apiRoutes} from "../../plugins/apiRoutes.js";
import ButtonBack from "../layouts/ButtonBack.jsx";
import {getText, lang} from "../../lang/lang.js";
export default function VotePage() {
    const [vote, setVote] = useState([])
    const [voteOptions, setVoteOptions] = useState([])
    const [selectedOptionId, setSelectedOptionId] = useState(null);
    useEffect(() => {
        const fetchVote = async () => {
            const id = window.location.pathname.split('/').pop();
            const response = await get(apiRoutes.votes + '/' + id, {}, { withCredentials: true });
            const data = await response.data;
            setVote(data)
            setVoteOptions(data.vote_options)
            setSelectedOptionId(data.voted)
        };
        fetchVote();
    }, [])

    async function voice(id) {
        const response = await post(apiRoutes.voice + '/' + id, {}, {withCredentials: true})
    }
    async function cancelVoice(id) {
        const response = await post(apiRoutes.cancelVoice + '/' + id, {}, {withCredentials: true})
    }
    function handleVote(optionId) {
        if (selectedOptionId === optionId) {
            cancelVoice(optionId)
            setSelectedOptionId(null)
        }
        else {
            voice(optionId)
            setSelectedOptionId(optionId);
        }
    }

    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="flex max-w-5xl mx-auto justify-start mb-6">
                <ButtonBack/>
            </div>
            <div className="max-w-5xl mx-auto space-y-8">
                <div>
                    <div className="flex items-center gap-3 mb-4 pl-4">
                        <h1 className="text-2xl font-bold text-slate-800">{vote.title}</h1>
                    </div>
                    {
                        voteOptions.length > 0 ?
                            (voteOptions.map((e) => {
                                const isSelected = selectedOptionId === e.id;
                                return (
                                    <div key={e.id}
                                         className={`
                                         cursor-pointer bg-white items-center gap-3 mb-4 shadow rounded-3xl p-8 
                                         transition-all hover:shadow-lg hover:scale-[1.02] active:scale-[0.98]
                                         ${isSelected ? 'ring-4 ring-blue-500 ring-offset-2 bg-blue-50' : ''}
                                     `}
                                         onClick={() => handleVote(e.id)}>
                                        <div className="flex items-center gap-4 justify-between">
                                            <div className="flex items-center gap-4">
                                                <img
                                                    src={(JSON.parse(e.content)).picture}
                                                    alt={(JSON.parse(e.content)).code}
                                                    className="w-12 h-12 rounded-full object-cover border-2 border-slate-200 flex-shrink-0"
                                                />
                                                <h1 className="text-xl font-bold text-slate-800">{e.title}</h1>
                                            </div>
                                            <div className="flex items-center gap-4">
                                                <span className={"text-xl font-bold"}>
                                                    {e.count + (isSelected && vote.voted !== e.id ? 1 : 0) + ( !isSelected && vote.voted === e.id ? -1 : 0 )} {getText(lang.votes.voters)}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                );
                            }))
                            : ''
                    }
                </div>
            </div>
        </main>
    );
}