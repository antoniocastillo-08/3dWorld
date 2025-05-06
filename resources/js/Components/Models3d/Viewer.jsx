import React, { Suspense } from 'react';
import { Canvas } from '@react-three/fiber';
import { OrbitControls } from '@react-three/drei';
import { STLLoader } from 'three/examples/jsm/loaders/STLLoader';
import { useLoader } from '@react-three/fiber';

const Viewer = ({ stlFile }) => {
  let geometry;

  try {
    geometry = useLoader(STLLoader, stlFile);
  } catch (error) {
    console.error("Error cargando el archivo STL:", error);
    return <div>Error al cargar el modelo 3D.</div>;
  }

  return (
    <Canvas style={{ height: '500px', width: '50%' }}>
      <Suspense fallback={<div>Cargando modelo...</div>}>
        <ambientLight intensity={0.5} />
        <directionalLight position={[10, 10, 10]} />
        <mesh geometry={geometry}>
          <meshStandardMaterial color="blue" />
        </mesh>
      </Suspense>
      <OrbitControls />
    </Canvas>
  );
};

export default Viewer;