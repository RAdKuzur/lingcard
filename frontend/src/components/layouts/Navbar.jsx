import Logo from "./Logo.jsx";
import ProfileBar from "./ProfileBar.jsx";

export default function Navbar() {
    return (
        <nav>
            <div className={'flex bg-green-200 justify-between h-20 items-center'}>
                <Logo/>
                <ProfileBar/>
            </div>
        </nav>
    );
}