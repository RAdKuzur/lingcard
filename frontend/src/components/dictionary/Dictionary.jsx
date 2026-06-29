import Word from "../layouts/Word.jsx";
import SelectLanguage from "../layouts/SelectLanguage.jsx";

export default function Dictionary() {
    function handleSearch(){

    }
    return (
        <main className="flex h-screen bg-gray-200 justify-center">
            <div className="flex flex-col w-full h-full items-center">
                <div className="flex flex-col w-2/5 h-1/16 rounded-2xl text-center bg-white mt-8">
                    <div className={'flex h-1/3 w-full pt-2'}>
                        <div className={'w-2/5 h-full ml-3 text-start'}>
                            Язык 1
                        </div>
                        <div className={'w-2/5 h-full text-start'}>
                            Язык 2
                        </div>
                    </div>
                    <div className={'flex h-2/3 w-full gap-3 justify-start items-center'}>
                        <div className={'w-2/5 h-4/5 ml-3'}>
                            <SelectLanguage/>
                        </div>
                        <div className={'w-2/5 h-4/5'}>
                            <SelectLanguage/>
                        </div>
                        <div className={'mr-3 w-1/5'}>
                            <button
                                className={'p-2 w-full bg-orange-400 font-bold text-white rounded-2xl cursor-pointer'}
                                onClick={handleSearch}>Найти
                            </button>
                        </div>
                    </div>
                </div>
                <div className={`flex flex-col w-4/5 h-4/5 rounded-2xl text-center bg-white mt-8`}>
                    <div className={'font-bold m-3 h-1/20'}>Слова</div>
                    <div className={`flex flex-col h-14/15 gap-4 justify-center items-center`}>
                        <Word/>
                        <Word/>
                        <Word/>
                        <Word/>
                        <Word/>
                        <Word/>
                        <Word/>
                    </div>
                </div>
            </div>
        </main>
    )
}