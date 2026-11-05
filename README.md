# 4. Marketplace de Productos Artesanales - Hito 1

Sistema web en Laravel para conectar artesanos y pequenos productores locales con compradores.

## 1. Instalacion y Ejecucion
1. Instalar dependencias: `composer install && npm install && npm run build`
2. Configurar `.env` con la base de datos `marketplace_artesanias` y ejecutar: `php artisan key:generate`
3. Ejecutar migraciones y seeders: `php artisan migrate:fresh --seed`
4. Iniciar servidor: `php artisan serve`

## 2. Credenciales de Prueba (Seccion 3.1)
| Rol | Correo Electronico | Contrasena |
| :--- | :--- | :--- |
| **Artesano (Vendedor)** | `artesano@marketplace.pe` | `password123` |
| **Comprador (Cliente)** | `comprador@marketplace.pe` | `password123` |

## 3. Matriz de Navegacion por Tipo de Usuario (Seccion 3.3)
| Ruta / Vista | URL | Invitado | Artesano | Comprador |
| :--- | :--- | :---: | :---: | :---: |
| Bienvenida | `/` | Acceso | Acceso | Acceso |
| Login / Registro | `/login`, `/register` | Acceso | Redirige | Redirige |
| Panel de Metricas y Pedidos | `/artesano/metricas` | Login | Acceso | Error 403 |
| Inventario de Productos | `/artesano/productos` | Login | Acceso | Error 403 |
| Publicar Producto / Tienda | `/artesano/productos/crear` | Login | Acceso | Error 403 |
| Explorar Catalogo y Carrito | `/comprador/catalogo` | Login | Error 403 | Acceso |
| Checkout y Valoracion | `/comprador/checkout-valoracion` | Login | Error 403 | Acceso |

## 4. Avances de Branding (Paleta de Colores)
| Rol del Color | Escala | Codigo HEX |
| :--- | :--- | :--- |
| **Primario** |  `#75329F` |
| **Secundario** |  `#421C59` |
| **Acento** |  `#CBA6E3` |
| **Fondo** |  `#F4ECF9` |
| **Texto** | `#281136` |
