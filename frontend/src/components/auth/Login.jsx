import {useState} from "react";

export default function Login() {
    const [isHover, setHover] = useState(false);
    function login() {

    }
    return (
        <div className="flex flex-col min-w-192 min-h-96 bg-white rounded-2xl text-center justify-between">
            <div className={'font-bold h-1/6 mt-3'}>
                Вход в систему
            </div>
            <div>
                <div className={'h-1/4 m-3'}>
                    <div className={"m-1"}>Эл. почта</div>
                    <input className={'rounded-2xl p-2 w-2/5 border'} placeholder="e-mail"/>
                </div>
                <div className={'h-1/4 m-3'}>
                    <div className={"m-1"}>Пароль</div>
                    <input className={'rounded-2xl p-2 w-2/5 border'} placeholder="password" type="password"/>
                </div>
            </div>
            <div className={'h-1/6 mb-3'}>
                <button className={`p-2 bg-green-400 text-white font-bold rounded-2xl w-1/5 cursor-pointer ${isHover ? 'bg-green-600' : ''}` }
                        onClick={login}
                        onMouseEnter={() => setHover(true)}
                        onMouseLeave={() => setHover(false)}
                >
                    Войти
                </button>
            </div>
        </div>
    )
}