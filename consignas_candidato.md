# Desafío Técnico — Consignas
## Desarrollador Junior Laravel

**Tiempo estimado:** 3 a 4 horas
**Entrega:** Repositorio en GitHub con README explicando los cambios realizados

---

## Contexto

Vas a trabajar sobre una aplicación web interna que gestiona solicitudes entre empleados. El sistema ya tiene parte del código escrito, pero tiene bugs y funcionalidades incompletas que necesitás resolver, igual que en el trabajo real de soporte y desarrollo.

> No se evalúa perfección. Se evalúa cómo pensás, cómo organizás el código y cómo resolvés problemas reales sobre una base existente.

---

## Tarea 1 — Corregir un bug _(obligatoria)_

Al hacer clic en **Editar** en cualquier solicitud, el formulario carga correctamente pero todos los campos aparecen vacíos, como si fuera un formulario nuevo.

**Lo que tenés que hacer:**
- Identificar dónde está el error
- Corregirlo
- Explicar brevemente en el README qué estaba mal y por qué

---

## Tarea 2 — Completar funcionalidad incompleta _(obligatoria)_

El listado de solicitudes muestra actualmente **todas las solicitudes del sistema**, sin importar quién esté logueado.

**Lo que tenés que hacer:**
- Que el listado muestre **solo las solicitudes del usuario logueado**
- Que estén ordenadas por **fecha de creación, de más reciente a más antigua**
- Que cuando el usuario no tenga solicitudes, se muestre el mensaje: _"Todavía no registraste ninguna solicitud."_

El método del controller ya existe. No es necesario crear nada nuevo, solo completarlo.

---

## Tarea 3 — Agregar un filtro por estado _(obligatoria)_

Agregar la posibilidad de filtrar las solicitudes por estado desde el listado.

**Lo que tenés que hacer:**
- Un `<select>` en la vista con las opciones: Todos / Pendiente / En proceso / Resuelto
- El filtro debe aplicarse mediante query string en la URL (ejemplo: `/solicitudes?estado=pendiente`)
- Si no se selecciona ningún filtro, se muestran todas las solicitudes del usuario
- El `<select>` debe mostrar el valor seleccionado al recargar la página

---

## Tarea 4 — Completar el resumen con Eloquent _(obligatoria)_

En `ReporteController` existe el método `resumen()` que está vacío. La vista correspondiente ya está lista para recibir los datos.

**Lo que tenés que hacer:**
Completar el método para que pase a la vista:
- El **total de solicitudes** del usuario logueado
- La **cantidad de solicitudes por estado** (pendiente / en proceso / resuelto)
- La **solicitud más reciente** del usuario (título, estado y fecha)

**Restricción:** No usar SQL crudo (`DB::select`, `DB::statement`). Usar únicamente Eloquent.

---

## Tarea 5 — Mejora libre _(opcional, suma)_

Elegí **una** de las siguientes opciones e indicá en el README cuál elegiste y por qué:

**Opción A:** Agregar paginación al listado (10 resultados por página), asegurándote de que el filtro de estado se mantenga al cambiar de página.

**Opción B:** Crear un Form Request para validar el alta y edición de solicitudes. `titulo` y `descripcion` son obligatorios; `titulo` no puede superar los 100 caracteres.

**Opción C:** Agregar un campo `resuelto_en` (timestamp, nullable) que se complete automáticamente cuando el estado de una solicitud cambia a `resuelto`. Implementarlo usando un Observer o un evento de modelo.

---

## Criterios de evaluación

| Área | Qué se evalúa |
|---|---|
| Funcionalidad | ¿Las tareas obligatorias funcionan correctamente? |
| Código | ¿Es legible y sigue las convenciones de Laravel? |
| Eloquent | ¿Usa el ORM apropiadamente? |
| Blade | ¿Las vistas están bien estructuradas? |
| Git | ¿Los commits son descriptivos y el proceso se entiende? |
| Criterio propio | ¿Toma decisiones razonables ante lo no especificado? |

---

## Lo que NO se evalúa

- Diseño visual o CSS
- Velocidad de entrega
- El uso de IA como asistente _(podés usarla; lo que se evalúa es si entendés lo que hacés)_

---

*Cualquier consulta sobre el enunciado o el setup, no dudes en escribir.*
