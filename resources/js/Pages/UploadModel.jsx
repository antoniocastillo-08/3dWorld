import React, { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';

export default function UploadModel() {
  const { data, setData, post, errors } = useForm({
    name: '',
    description: '',
    image: null,
    file: null,
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/models3d'); // Ruta para enviar el formulario al backend
  };

  return (
    <div className="p-6 bg-gray-100 min-h-screen flex flex-col items-center">
      <Head title="Subir Modelo 3D" />
      <h1 className="text-3xl font-bold mb-6">Subir Modelo 3D</h1>
      <form
        onSubmit={handleSubmit}
        className="bg-white p-6 rounded-lg shadow-md w-full max-w-lg"
      >
        <div className="mb-4">
          <label className="block text-gray-700 font-bold mb-2">Nombre</label>
          <input
            type="text"
            value={data.name}
            onChange={(e) => setData('name', e.target.value)}
            className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          {errors.name && <p className="text-red-500 text-sm mt-1">{errors.name}</p>}
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 font-bold mb-2">Descripción</label>
          <textarea
            value={data.description}
            onChange={(e) => setData('description', e.target.value)}
            className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          {errors.description && (
            <p className="text-red-500 text-sm mt-1">{errors.description}</p>
          )}
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 font-bold mb-2">Imagen</label>
          <input
            type="file"
            accept=".jpg,.jpeg,.png,.gif" // Solo permite imágenes en formato jpg, png o gif
            onChange={(e) => setData('image', e.target.files[0])}
            className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          {errors.image && <p className="text-red-500 text-sm mt-1">{errors.image}</p>}
        </div>
        <div className="mb-4">
          <label className="block text-gray-700 font-bold mb-2">Archivo STL</label>
          <input
            type="file"
            accept=".stl" // Solo permite archivos en formato STL
            onChange={(e) => setData('file', e.target.files[0])}
            className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          {errors.file && <p className="text-red-500 text-sm mt-1">{errors.file}</p>}
        </div>
        <button
          type="submit"
          className="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition"
          disabled={processing}
        >
          Subir Model
        </button>
      </form>
    </div>
  );
}