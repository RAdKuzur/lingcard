import GraduationCap from "../svg/GraduationCap.jsx";

export default function ButtonToggle({ on, setOn }) {
    return (
        <button
            type="button"
            role="switch"
            aria-checked={on}
            onClick={() => setOn(!on)}
            className={`relative inline-flex flex-shrink-0 h-8 w-12 items-center rounded-full
                transition-colors duration-200 cursor-pointer
                ${on ? 'bg-indigo-600' : 'bg-slate-300'}`}
        >
            <span
                className={`inline-flex items-center justify-center h-4 w-4 rounded-full bg-white shadow-sm
                            transform transition-transform duration-200
                            ${on ? 'translate-x-7' : 'translate-x-1'}`}
            >
                <GraduationCap
                    className={`w-3 h-3 transition-colors duration-200
                                ${on ? 'text-indigo-600' : 'text-slate-400'}`}
                />
            </span>
        </button>
    );
}