import Logo from "./Logo.jsx";
import ProfileBar from "./ProfileBar.jsx";

export default function Navbar({ isAuth }) {
    return (
        <nav className="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-slate-200/50 shadow-sm">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex justify-between items-center h-16 md:h-20">
                    <Logo />
                    <ProfileBar isAuth={isAuth} />
                </div>
            </div>
        </nav>
    );
}