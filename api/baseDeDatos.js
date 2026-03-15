import { MongoClient } from 'mongodb';

export default async function handler(req, res) {
    const client = new MongoClient(process.env.MONGO_URI, { useNewUrlParser: true, useUnifiedTopology: true });
    await client.connect();

    const db = client.db('steamDB');
    const collection = db.collection('productos');

    if (req.method === 'GET') {
        const productos = await collection.find({}).toArray();
        return res.status(200).json({ success: true, data: productos });
    }

    if (req.method === 'POST') {
        const { nombre, precio } = req.body;
        const nuevoProducto = { nombre, precio };
        await collection.insertOne(nuevoProducto);
        return res.status(201).json({ success: true, data: nuevoProducto });
    }

    client.close();
    return res.status(405).json({ success: false, message: 'Método no permitido' });
}
