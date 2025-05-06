import React, { useState, useEffect } from 'react';
import Viewer from '../Components/Models3d/Viewer';

const Modelo3dIndividual = ({ model }) => {
    const [key, setKey] = useState(0);

    useEffect(() => {
        // Cambia la clave cuando el archivo STL cambie
        setKey((prevKey) => prevKey + 1);
    }, [model.file]);

    console.log(model); // Verifica los datos del modelo

    return (
        <div className="p-4">
            <h1 className="text-2xl font-bold mb-4">{model.name}</h1>
            <img src={`/${model.image}`} alt={model.name} className="mb-4 w-full max-w-md" />
            <p className="mb-4">{model.description}</p>
            <div className="mb-4">
                {/* Viewer con clave única para forzar actualización */}
                <Viewer key={key} stlFile={`/${model.file}`} />
            </div>
            <a href={`/${model.file}`} download className="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Descargar STL
            </a>
        </div>
    );
};

export default Modelo3dIndividual;