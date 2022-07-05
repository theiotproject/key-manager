import React from 'react';
import { createRoot } from 'react-dom/client'

export default function Hello() {
    return (
        <div>Reactjs With Laravel Vite</div>
    );
}

if (document.getElementById('Helloreact')) {
    createRoot(document.getElementById('Helloreact')).render(<Hello />)
}
