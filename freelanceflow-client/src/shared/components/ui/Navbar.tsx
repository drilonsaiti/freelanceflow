import {Bell, Search, UserIcon} from 'lucide-react';

export default function Navbar() {
    return (
        <div className="bg-gray-200 border-b-2 border-gray-300 h-14">
            <div className="flex h-full align-start justify-end p-2 gap-2  ">
                <Search/>
                <Bell />
                <UserIcon />

            </div>

        </div>
    );
}
