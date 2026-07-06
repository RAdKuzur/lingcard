import {useState} from "react";
import {useNavigate} from "react-router-dom";

export default function PanelHome({title, link}) {
    const [isHover, setHover] = useState(false)
    const navigate = useNavigate()

    function redirect() {
        navigate(link)
    }
    return (
        <div
            className={`group relative h-64 bg-white rounded-2xl shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 flex flex-col items-center justify-center cursor-pointer transition-all duration-300 ${isHover ? 'scale-105 -translate-y-1' : 'scale-100'}`}
            onMouseEnter={() => setHover(true)}
            onMouseLeave={() => setHover(false)}
            onClick={redirect}
        >
            <div className="font-bold text-lg text-slate-700 group-hover:text-indigo-600 transition-colors duration-300">
                {title}
            </div>
            <div className="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-b-2xl transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300" />
        </div>
    );
}