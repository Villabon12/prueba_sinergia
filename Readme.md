# 🚀 Sistema de Gestión Logística - Backend

Este proyecto implementa una API RESTful para la gestión de logística terrestre y marítima.  
Está desarrollado en **Laravel**, con autenticación mediante **Sanctum**, base de datos en **MySQL** y documentación con **Swagger**.

---

## **📌 Tecnologías Utilizadas**
- ✅ **Laravel 10** - Framework PHP para desarrollo backend.
- ✅ **Sanctum** - Autenticación segura con tokens.
- ✅ **MySQL** - Base de datos relacional.
- ✅ **Eloquent ORM** - Manipulación eficiente de datos.
- ✅ **Swagger (OpenAPI)** - Documentación de la API.
- ✅ **Git & GitHub** - Control de versiones y colaboración.
- ✅ **PHPUnit** - Pruebas unitarias.

---

## **📌 Instalación y Configuración**

### **1️⃣ Clonar el Repositorio**

git clone https://github.com/Villabon12/prueba_sinergia.git
cd prueba_sinergia

2️⃣ Instalar Dependencias

composer install

3️⃣ Configurar Variables de Entorno
Copia el archivo .env.example y renómbralo a .env:

cp .env.example .env

Configura la conexión a la base de datos en .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_bd
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña


4️⃣ Generar la Clave de la Aplicación

php artisan key:generate

5️⃣ Ejecutar Migraciones y Seeders

php artisan migrate --seed

6️⃣ Iniciar el Servidor

php artisan serve
La API estará disponible en http://127.0.0.1:8000.

📌 Endpoints de la API
📄 La API está documentada con Swagger.
Para ver la documentación, inicia el servidor y accede a:
👉 http://127.0.0.1:8000/api/documentation

Endpoints Principales
POST /api/login → Iniciar sesión.
POST /api/register → Registro de usuario.
GET /api/customers → Obtener clientes.
GET /api/products → Listar productos.
POST /api/shipments/terrestrial → Registrar envío terrestre.
POST /api/shipments/maritime → Registrar envío marítimo.

📌 Autor
💡 Desarrollado por: Villabon12 🚀



# 🚀 Sistema de Gestión Logística - Frontend

Este es el frontend del sistema de gestión logística, desarrollado en **Angular** y desplegado en **GitHub Pages**.

---

## **📌 Tecnologías Utilizadas**
- ✅ **Angular 17** - Framework de desarrollo frontend.
- ✅ **TypeScript** - Lenguaje de programación tipado.
- ✅ **Bootstrap/Tailwind** - Estilos responsivos.
- ✅ **Axios/HttpClient** - Para consumir la API.
- ✅ **GitHub Pages** - Para el despliegue.

---

## **📌 Instalación y Ejecución**

### **1️⃣ Clonar el Repositorio**

git clone https://github.com/Villabon12/prueba_sinergia.git
cd prueba_sinergia/frontend-logistica

2️⃣ Instalar Dependencias

npm install

3️⃣ Configurar Variables de Entorno

En src/environments/environment.ts, define la URL del backend:

export const environment = {
  production: false,
  apiUrl: 'https://tu-servidor/api'
};

4️⃣ Ejecutar el Servidor

ng serve
