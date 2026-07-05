import {useNavigate} from "react-router-dom";
import {useState} from "react";

export default function ButtonBack() {

    const navigate = useNavigate()
    const [hover, setHover] = useState(false)
    function goBack() {
        navigate(-1)
    }
    return (
        <div className={`flex rounded-2xl justify-center items-center cursor-pointer ${hover ? 'bg-gray-100' : 'bg-white'}`} onClick={goBack}
            onMouseEnter={() => setHover(true)}
            onMouseLeave={() => setHover(false)}
        >
            <div className={'p-2'}>Назад</div>
        </div>
    )
}