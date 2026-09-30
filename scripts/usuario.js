
const db = require('../db'); 

exports.getUsers = async (req, res) => {
  try {

    const query = `
      SELECT id, name, email, role, status, created_at 
      FROM users 
      ORDER BY name ASC
    `;
    
    const { rows } = await db.query(query);

    return res.status(200).json({
      success: true,
      count: rows.length,
      data: rows
    });

  } catch (error) {

    console.error('Erro ao buscar usuários:', error.message);
    return res.status(500).json({
      success: false,
      message: 'Ocorreu um erro ao carregar a lista de usuários. Tente novamente mais tarde.'
    });
  }
};