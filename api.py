# api.py

from flask import Flask, jsonify
import mysql.connector
from mysql.connector import Error

app = Flask(__name__)

db_config = {
    'host': 'localhost',
    'database': 'tienda',
    'user': 'root',
    'password': '',
    'charset': 'utf8mb4'
}

@app.route('/api/productos', methods=['GET'])
def obtener_productos():
    try:
        connection = mysql.connector.connect(**db_config)

        if connection.is_connected():
            cursor = connection.cursor(dictionary=True)
            cursor.execute("SELECT * FROM productos")
            productos = cursor.fetchall()
            return jsonify(productos), 200

    except Error as e:
        return jsonify({'error': f'Error al consultar los productos: {e}'}), 500

    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

if __name__ == '__main__':
    app.run(debug=True, port=5000)
