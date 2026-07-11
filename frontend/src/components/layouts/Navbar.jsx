import { Link } from 'react-router-dom';
import ProfileBar from "./ProfileBar.jsx";
import Logo from "./Logo.jsx";
import {innerRoutes} from "../../plugins/routes.js";

export default function Navbar() {
    const menuOptions = {
        training: {
            link: innerRoutes.training,
            label: 'Тренировка'
        },
        progress: {
            link: innerRoutes.progress,
            label: 'Прогресс'
        },
        dictionary: {
            link: innerRoutes.dictionary,
            label: 'Словарь'
        },
        about: {
            link: innerRoutes.about,
            label: 'О нас'
        }
    }

    return (
        <nav className="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-slate-200/50 shadow-sm">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center h-16 md:h-20">
                    <Logo />
                    <div className="flex items-center gap-8">
                        {Object.values(menuOptions).map((item) => (
                            <Link
                                key={item.label}
                                to={item.link}
                                className="text-sm font-medium text-slate-700 hover:text-indigo-600
                                         transition-colors duration-200 border-b-2 border-transparent
                                         hover:border-indigo-600 pb-1"
                            >
                                {item.label}
                            </Link>
                        ))}
                    </div>
                    <ProfileBar />
                </div>
            </div>
        </nav>
    );
}