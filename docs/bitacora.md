# Bitacora de Desarrollo - Hito 1

| Fecha | Actividad realizada | Responsable | Dificultades y solucion |
| :--- | :--- | :--- | :--- |
| 03/11/2026 | Creacion del proyecto Laravel, instalacion de Breeze y configuracion de `.env` con MySQL. | Frank Espinoza | Error de conexion por driver SQLite predeterminado; se cambio `DB_CONNECTION=mysql` y se limpio cache con `config:clear`. |
| 04/11/2026 | Implementacion de `RoleMiddleware`, `DatabaseSeeder` y controladores MVC sin consultas a BD. | Frank Espinoza | Error `Route [login] not defined` al editar `web.php`; se aseguro la carga de `require __DIR__.'/auth.php'`. |
| 05/11/2026 | Creacion de layout comun con variables CSS (paleta morada), vistas Blade por rol y documentacion. | Frank Espinoza | Se organizaron las vistas en `resources/views/artesano/` y `resources/views/comprador/` reutilizando `layouts/marketplace.blade.php`. |
