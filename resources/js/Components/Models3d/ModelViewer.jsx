import React, { Suspense } from 'react'
import { Canvas } from '@react-three/fiber'
import { OrbitControls, useSTLLoader } from '@react-three/drei'

function Model({ url }) {
  const geometry = useSTLLoader(url)
  return (
    <mesh geometry={geometry}>
      <meshStandardMaterial color="#FF8C00" />
    </mesh>
  )
}

export default function ModelViewer({ url }) {
  return (
    <div className="w-full h-64">
      <Canvas camera={{ position: [0, 0, 50], fov: 45 }}>
        <ambientLight intensity={0.5} />
        <directionalLight position={[0, 0, 50]} />
        <Suspense fallback={null}>
          <Model url={url} />
        </Suspense>
        <OrbitControls />
      </Canvas>
    </div>
  )
}
