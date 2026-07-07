export default function Word({ word, translation, level = null, repeat = null }) {
    return (
        <div className="flex items-center gap-4 w-full px-5 py-3 bg-white rounded-xl border border-slate-200 hover:border-slate-300 hover:shadow-md transition-all duration-200">
            <div className="flex-1 min-w-0">
                <div className="font-semibold text-slate-800 truncate">{word}</div>
                <div className="text-slate-500 text-sm truncate">{translation}</div>
            </div>
            <div className="flex items-center gap-2 flex-shrink-0">
                {repeat !== null && (
                    <span className="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-xs font-medium whitespace-nowrap">
                        {repeat}
                    </span>
                )}
                {level !== null && (
                    <span className="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-medium whitespace-nowrap">
                        {level}
                    </span>
                )}
            </div>
        </div>
    );
}