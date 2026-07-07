export default function Knowledge() {
    const countries = [
        { name: 'Казахстан', flag: '/flags/kz.svg' },
        { name: 'Россия', flag: '/flags/ru.svg' },
        { name: 'Грузия', flag: '/flags/ge.svg' },
        { name: 'Армения', flag: '/flags/am.svg' },
        { name: 'Китай', flag: '/flags/cn.svg' }
    ];

    return (
        <main className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-6">
            <div className="max-w-5xl mx-auto">
                <h1 className="text-2xl font-bold text-slate-800 mb-6">Доступные языки</h1>
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    {countries.map((country, index) => (
                        <div
                            key={index}
                            className="group bg-white rounded-2xl shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300 hover:scale-105 cursor-pointer p-6 flex flex-col items-center justify-center"
                        >
                            <div className="w-30 h-30 mb-3 group-hover:scale-110 transition-transform duration-300 rounded-lg overflow-hidden shadow-md">
                                <img
                                    src={country.flag}
                                    alt={country.name}
                                    className="w-full h-full object-cover"
                                />
                            </div>
                            <span className="text-lg font-semibold text-slate-700">
                                {country.name}
                            </span>
                        </div>
                    ))}
                </div>
            </div>
        </main>
    );
}