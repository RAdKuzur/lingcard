import {useNavigate} from "react-router-dom";
import {innerRoutes} from "../../plugins/routes.js";

export default function Logo(){
    const navigate = useNavigate()
    function goHome(){
        navigate(innerRoutes.home)
    }
    return (
        <div className={'circle flex bg-green-500 font-serif rounded-2xl p-3 ml-3 text-center items-center justify-center cursor-pointer'} onClick={goHome}>
            <div className="font-bold text-white/95 tracking-wider">
                Ling
            </div>
        </div>
    );
}