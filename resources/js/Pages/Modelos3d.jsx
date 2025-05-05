import React from 'react';
import Card from '../Components/Card';

export default function Modelos3D({ models }) {
  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold mb-4">Modelos 3D</h1>
      <div className="flex flex-wrap gap-4">
        {models.map((model) => (
          <Card key={model.id} name={model.name} image={model.image} />
        ))}
      </div>
    </div>
  );
}