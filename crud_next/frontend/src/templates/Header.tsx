'use client'

import Button from "../components/Button"
import { jwtDecode } from 'jwt-decode';
import Link from "next/link"
import { useEffect, useState } from "react"
import api from '../utils/api.js'
import '@/app/globals.css'

export default function Header({ onNavToggle }) {
    const [user, setUser] = useState(null)

    useEffect(() => {
        const fetchUser = async () => {
            try {
                const token = localStorage.getItem("token");

                if (token) {
                    // Verificando se o token expirou
                  
                    // Se o token for válido, fazer a requisição
                    const response = await api.get("/api/user", {
                        headers: { Authorization: `Bearer ${token}` },
                    });

                    setUser(response.data);
                }
            } catch (error) {
                console.error("Erro ao buscar usuário", error);
                setUser(null); // Em caso de erro, garantir que o estado do usuário seja null
            }
        };

        fetchUser();
    }, []);

    return (
        <header className="bg-blue-400 text-white h-[90px] top-0 left-0 relative flex items-center p-4">
            <div className="flex w-full justify-between items-center justify-center">
                <div className="flex items-end space-x-4">
                    <Button text="Nav" color="bg-blue-700" className="bg-blue-600 px-4 py-2 rounded" onClick={onNavToggle} />
                </div>

                <div className="flex items-end ml-auto gap-4">
                    {user ? (
                        <span className="mr-4">Olá, {user.name}</span>
                    ) : (
                        <>
                            <Link href="/login">
                                <Button text="Login" color="bg-blue-700" className="bg-blue-600 px-4 py-2 rounded" />
                            </Link>
                            <Link href="/register">
                                <Button text="Registrar" color="bg-blue-700" className="bg-blue-600 px-4 py-2 rounded" />
                            </Link>
                        </>
                    )}
                </div>
            </div>
        </header>
    );
}
