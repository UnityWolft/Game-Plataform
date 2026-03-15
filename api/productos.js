export default function handler(req, res) {
    let productos = [
        { id: 1, nombre: "Juego A", precio: 20 },
        { id: 2, nombre: "Juego B", precio: 40 },
        { id: 3, nombre: "Juego C", precio: 30 }
    ];

    if (req.method === 'GET') {
        return res.status(200).json({ success: true, data: productos });
    }

    if (req.method === 'POST') {
        const { nombre, precio } = req.body;
        const nuevoProducto = { id: productos.length + 1, nombre, precio };
        productos.push(nuevoProducto);
        return res.status(201).json({ success: true, data: nuevoProducto });
    }

    return res.status(405).json({ success: false, message: 'Método no permitido' });
}
