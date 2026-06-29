export default function Word() {
    return(
        <div className={'flex border rounded-2xl w-9/10 h-1/8 justify-between items-center'}>
            <div className={'flex flex-col w-1/10 h-5/6 text-start ml-3 mt-2 mb-2 justify-between'}>
                <div>Слово</div>
                <div>Перевод</div>
            </div>
            <div className={'flex flex-col w-6/10 text-start ml-3 mt-2 mb-2 justify-between'}>
            </div>
            <div className={'flex flex-col w-1/10 ml-3 mt-2 mb-2 items-center'}>
                <div className={'flex h-1/2 rounded-2xl bg-indigo-500 p-2'}>REPEAT</div>
            </div>
            <div className={'flex flex-col w-1/10 ml-3 mt-2 mb-2 items-center'}>
                <div className={'flex h-1/2 rounded-2xl bg-orange-500 p-2'}>LEVEL</div>
            </div>
        </div>
    )
}