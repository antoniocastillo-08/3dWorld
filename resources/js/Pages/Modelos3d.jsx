import React from 'react';
import Card from '../Components/Models3d/Card';
import { Head } from '@inertiajs/react'; // Importa Head para configurar el título


export default function Modelos3D({ models }) {
  return (
    <div className="p-4">
      <Head title="Modelos 3D"/>
      <h1 className="text-2xl font-bold mb-4">Modelos 3D</h1>
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