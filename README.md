# Resolución de las Tareas

> Acá les dejo un resumen de cómo encaré cada tarea. Traté de aplicar buena lógica de programación leyendo documentación y viendo videos de Laravel para que el código quede lo más prolijo posible y con buenas prácticas, intenté respetar lo más posible el framework.

---

### Tarea 1: Bug en el formulario de edición `[Resuelta]`

* **El problema:** Cuando querías editar, el formulario cargaba todo en blanco. Revisando el código, me di cuenta de que el error no estaba en la vista, sino en el método `edit` del `SolicitudController`. Básicamente, le estaban pasando una "s" de más en el `compact('solicitudes')`, cuando la vista de Blade esperaba la variable en singular (`$solicitud`).
* **La solución:** Corregí la variable paramétrica ahí mismo en el controlador para solucionar el problema de raíz y no tocar la vista.

---

### Tarea 2: Aislamiento de solicitudes y listado vacío `[Resuelta]`

* **Listado:** Para mostrar solo las solicitudes del usuario logueado, en primera instancia había armado un `where` común, pero investigando un poco cómo manejarme con Eloquent y ya sabiendo SQL usé la relación de Eloquent `auth()->user()->solicitudes()`, que me pareció bastante más limpia que meter queries a mansalva.
* **Empty State:** Toqué un poco la vista (`index.blade.php`), cambiando el típico `@foreach` por la directiva `@forelse`. Vino joya porque te permite usar `@empty` y mostrar el cartelito de que no hay solicitudes de forma directa y nativa, ahorrando meter ifs anidados o cosas raras adicionales.

---

### Tarea 3: Filtro por estado `[Resuelta]`

* **La vista:** Armé un formulario común por `GET` que manda el estado por la URL (con Query String como se pidió). Para que el `<select>` no se reinicie al recargar y se acuerde de la opción que elegiste, usé el helper `request('estado')`.
* **El controlador:** Le metí un `$request->filled('estado')`. Se asegura de que estás mandando un filtro válido, lo concatene al `where` de la consulta principal, me costó un poquito no romper el filtro de la Tarea 2 pero lo solventé (así cada usuario ve únicamente lo suyo).

---

### Tarea 4: Resumen con Eloquent `[Resuelta]`

* **Solución:** Completé el método `resumen()` en el `ReporteController` sin meter SQL crudo.
* Aprovechando la misma relación del usuario (`$user->solicitudes()`), dejé que la base de datos haga el trabajo pesado usando los métodos del Query Builder de Eloquent: metí un `count()` para el total, un `selectRaw('estado, count(*) as total')` agrupado con `groupBy()` para sacar las métricas por estado, y un `latest()->first()` rapidito para traerme la última solicitud.

---

### Tarea 5: Mejora Libre — Opción B: Form Request `[Resuelta]`

* **Decisión:** Elegí ir por la creación del `SolicitudRequest`. Leyendo el código del controlador de Solicitudes me di cuenta que estaría muy bueno simplificar la validación de datos parametrizando la función, ayudando a mantener el controlador limpio y sacándole responsabilidad y lógica de encima que es mejor tenerla aislada a futuro para modificarla sin leer tanto código.
