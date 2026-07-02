import {useState} from "react";
import {loginAxios as loginAxios } from "../../plugins/auth.js";

export default function Login() {
    const [isHover, setHover] = useState(false);
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    function signIn() {
        loginAxios(email, password)
    }
    return (
        <main className="flex flex-1 bg-gray-200 items-center justify-center">
            <div className="flex flex-col min-w-192 min-h-96 bg-white rounded-2xl text-center justify-between">
                <div className={'font-bold h-1/6 mt-3'}>
                    Вход в систему
                </div>
                <div>
                    <div className={'h-1/4 m-3'}>
                        <div className={"m-1"}>Эл. почта</div>
                        <input className={'rounded-2xl p-2 w-2/5 border'} placeholder="e-mail" onInput={(e) => setEmail(e.target.value)}/>
                    </div>
                    <div className={'h-1/4 m-3'}>
                        <div className={"m-1"}>Пароль</div>
                        <input className={'rounded-2xl p-2 w-2/5 border'} placeholder="password" type="password" onInput={(e) => setPassword(e.target.value)}/>
                    </div>
                </div>
                <div className={'h-1/6 mb-3'}>
                    <button className={`p-2 bg-green-400 text-white font-bold rounded-2xl w-1/5 cursor-pointer ${isHover ? 'bg-green-600' : ''}` }
                            onClick={signIn}
                            onMouseEnter={() => setHover(true)}
                            onMouseLeave={() => setHover(false)}
                    >
                        Войти
                    </button>
                </div>
            </div>
        </main>
    )
}