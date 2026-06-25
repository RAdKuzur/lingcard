export default function ProfileBar() {
    function goProfile() {

    }
    return(
        <div className={'flex items-center w-1/10 bg-blue-400 mr-5 h-3/5 rounded-2xl cursor-pointer'} onClick={goProfile}>
            <div className={'circle h-5/6 w-1/3 bg-red-400 ml-1 mr-2'}>
            </div>
            <div className={'flex text-center font-bold mr-1'}>
                Профиль
            </div>
        </div>
    )
}