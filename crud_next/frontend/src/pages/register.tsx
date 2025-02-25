// src/pages/register.js
import { useState } from 'react';
import { useRouter } from 'next/router';
import '@/app/globals.css'
import api from '@/utils/api';
import axios from 'axios';

const Register = () => {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  // const [adminKey, setAdminKey] = useState("");
  const [message, setMessage] = useState("");

    const handleRegister = async(e) => {
      e.preventDefault()

      try {
        const response = await axios.post("http://localhost/seu-projeto-backend/register.php", {
          name,
          email,
          password
        })
        setMessage(response.data.message || "Usuario registrado com sucesso")
      } catch(err) {
        setMessage("Erro ao criar usuario")
      }
    }
  

  return (
    <div>
      
      <div className="min-h-screen flex items-center justify-center bg-gray-100">
        <div className="bg-white p-8 rounded-lg shadow-md w-96">
          <h2 className="text-2xl font-bold mb-6 text-center">Registrar usuario</h2>
          <form onSubmit={handleRegister}>
            <div className="mb-4">
              <label className="block text-gray-700">Nome</label>
              <input
                type="text"
                value={name}
                onChange={(e) => setName(e.target.value)}
                className=" text-gray-700 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
            </div>
            <div className="mb-4">
              <label className="block text-gray-700">Email</label>
              <input
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                className="text-gray-700 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
            </div>
            <div className="mb-4">
              <label className="block text-gray-700">Senha</label>
              <input
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                className="text-gray-700 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
            </div>
            {/* <div className="mb-6">
              <label className="block text-gray-700">Chave de Admin (opcional)</label>
              <input
                type="text"
                value={adminKey}
                onChange={(e) => setAdminKey(e.target.value)}
                className="text-gray-700 w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
            </div> */}
            <button
              type="submit"
              className="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300"
            >
              Registrar
            </button>
          </form>

        </div>
      </div>
    </div>
  );
};

export default Register;