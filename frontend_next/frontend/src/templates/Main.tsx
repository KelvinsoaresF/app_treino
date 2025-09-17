'use client'

import Header from "./Header";
// import Button from "../components/Button";
import { useState } from "react";
import NavBar from "./NavBar";
import '@/app/globals.css'

export default function Main() {
    const[showNav, setShowNav] = useState(false)

    const handleClick = () => {
        setShowNav(prev => !prev)
    }

    return (
        <>
        <Header onNavToggle={handleClick}>
            {/* <Button color="red" text="nav" onClick={handleClick} /> */}
        </Header>
        <main className="bg-gray-500 min-h-screen w-full pt-[80px]">
            <div className="container mx-auto flex items-center justify-center">
                <h1>Main</h1>
            </div>
        </main>
        {showNav && (
            <NavBar />
        )}
        </>
    )
}