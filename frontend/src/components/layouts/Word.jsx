export default function Word({ word, translation, level = null, repeat = null }) {
    function setLevelColor(level){
        switch (level) {
            case 'Начальный':
                return 'bg-red-500 hover:bg-red-600 text-white';
            case 'Базовый':
                return 'bg-orange-500 hover:bg-orange-600 text-white';
            case 'Средний':
                return 'bg-yellow-500 hover:bg-yellow-600 text-white';
            case 'Выше среднего':
                return 'bg-green-500 hover:bg-green-600 text-white';
            case 'Продвинутый':
                return 'bg-blue-500 hover:bg-blue-600 text-white';
            case 'Профессиональный':
                return 'bg-purple-500 hover:bg-purple-600 text-white';
            default:
                return 'bg-gray-500 hover:bg-gray-600 text-white';
        }
    }
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
                    <span className={`px-3 py-1 rounded-full text-xs font-medium whitespace-nowrap ${setLevelColor(level)}`}>
                        {level}
                    </span>
                )}
            </div>
        </div>
    );
}