import {useNavigate} from "react-router-dom";

export default function ButtonBack() {

    const navigate = useNavigate()
    function goBack() {
        navigate(-1)
    }
    return (
        <div className={"flex rounded-2xl bg-white justify-center items-center cursor-pointer"} onClick={goBack}>
            <div className={'p-2'}>Назад</div>
        </div>
    )
}