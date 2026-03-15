export default function handler(req, res) {
    if (req.method === 'POST') {
        const { username, password } = req.body;

        if (username.length < 3) {
            return res.status(400).json({ success: false, error: 'El nombre de usuario debe tener al menos 3 caracteres' });
        }

        if (password.length < 6) {
            return res.status(400).json({ success: false, error: 'La contraseña debe tener al menos 6 caracteres' });
        }

        return res.status(201).json({ success: true, message: 'Usuario registrado exitosamente' });
    }

    return res.status(405).json({ success: false, message: 'Método no permitido' });
}
