import Link from "next/link"



export default function NavBar() {
    return (
        <div className="bg-blue-700 text-white p-4 w-60 absolute top-[90px] fixed left-0 top-0 h-full">
            <h2 className="text-xl">Navegação</h2>
            <ul className="mt-4">
                
                <Link href={"/"}>
                    <li className="mb-4">Inicio</li>
                </Link>
                <Link href={"/"}>
                    <li className="mb-4">Cadastrar um funcionario</li>
                </Link>
                <Link href={"/"}>
                    <li className="mb-4">Gerenciar usuarios</li>
                </Link>

               
            </ul>
        </div>
    )
}