import React from 'react';
import Card from '../Components/Models3d/Card';
import { Head, Link } from '@inertiajs/react'; // Importa Link para navegación

export default function Modelos3D({ models }) {
  return (
    <div className="p-4">
      <Head title="Modelos 3D" />
      <div className="flex justify-between items-center mb-4">
        <h1 className="text-2xl font-bold">Modelos 3D</h1>
        <div className="flex items-center gap-4">
          {/* Botón para redirigir al formulario de subida */}
          <Link
            href="/models3d/upload"
            className="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
          >
            Subir Modelo
          </Link>
          {/* Botón de login */}
          <Link
            href="/login"
            className="px-5 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition"
          >
            Login
          </Link>
          {/* Botón de registrarse */}
          <Link
            href="/register"
            className="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition"
          >
            Registrarse
          </Link>
        </div>
      </div>
      <div className="flex flex-wrap gap-4">
        {models.map((model) => (
          <Card
            key={model.id}
            name={model.name}
            image={model.image}
            stlFile={model.file}
            url={`/models3d/${model.id}`} // Ruta dinámica
          />
        ))}
      </div>
    </div>
  );
}