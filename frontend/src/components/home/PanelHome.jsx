import {useState} from "react";
import {useNavigate} from "react-router-dom";

export default function PanelHome({title, link}) {
    const [isHover, setHover] = useState(false)
    const navigate = useNavigate()

    function redirect() {
        navigate(link)
    }
    return (
        <div className={`flex w-96 h-96 bg-white rounded-2xl justify-center items-center duration-500 cursor-pointer ${isHover ? 'scale-110' : ''}`}
                onMouseEnter={() => setHover(true)}
                onMouseLeave={() => setHover(false)}
             onClick={redirect}
        >
            <div className={'font-bold'}>{title}</div>
        </div>
    )

}