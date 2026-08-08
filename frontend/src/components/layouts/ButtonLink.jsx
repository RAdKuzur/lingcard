export default function ButtonLink({label, link, color}) {
    const colorMap = {
        red: 'bg-red-500 hover:bg-red-600',
        blue: 'bg-blue-500 hover:bg-blue-600',
        green: 'bg-green-500 hover:bg-green-600',
        orange: 'bg-orange-500 hover:bg-orange-600'
    };

    return (
        <button className={`p-2 cursor-pointer rounded-2xl text-white font-bold ${colorMap[color]}`}>
            <a href={link}>{label}</a>
        </button>
    );
}