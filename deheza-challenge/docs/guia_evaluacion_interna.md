# Guía de Evaluación — Desafío Técnico Laravel Jr
## USO INTERNO — No compartir con el candidato

---

## Qué tiene el proyecto base y por qué

Antes de evaluar, es útil saber exactamente qué bugs fueron plantados y qué se espera en cada tarea.

---

### Tarea 1 — Bug en el formulario de edición

**Dónde está el bug:**
En `SolicitudController@edit`, el método hace:
```php
return view('solicitudes.edit', compact('solicitudes', 'categorias'));
```
Pasa `$solicitudes` (plural) al view, pero la vista usa `$solicitud` (singular). Laravel no lanza un error grave — simplemente la variable no existe y Blade muestra los campos vacíos.

**La corrección esperada:**
```php
return view('solicitudes.edit', compact('solicitud', 'categorias'));
```

**Lo que buscás ver:**
- Que identifique el problema en el controller, no en la vista
- Que explique la causa: variable con nombre incorrecto pasada al view
- Que no "arregle" la vista cambiando los nombres de variables (eso sería tapar el problema en el lugar equivocado)

**Señal de alerta:** Si dice "cambié `$solicitud` por `$solicitudes` en la vista", resolvió el síntoma sin entender la causa.

---

### Tarea 2 — Filtrar solicitudes por usuario y ordenar

**Código original (incompleto):**
```php
$solicitudes = Solicitud::orderBy('created_at', 'desc')->get();
```

**Solución esperada mínima:**
```php
$solicitudes = Solicitud::where('user_id', auth()->id())
    ->orderBy('created_at', 'desc')
    ->get();
```

**Forma más elegante (con relación del modelo):**
```php
$solicitudes = auth()->user()->solicitudes()
    ->orderBy('created_at', 'desc')
    ->get();
```

**Para el mensaje de lista vacía en la vista:**
```blade
@forelse($solicitudes as $solicitud)
    {{-- contenido de la tabla --}}
@empty
    <p>Todavía no registraste ninguna solicitud.</p>
@endforelse
```
O también válido con `@if($solicitudes->isEmpty())`.

**Lo que buscás ver:**
- Que filtre por `user_id` del usuario logueado (no hardcodeado)
- Que use `auth()->id()` o `auth()->user()->id` o la relación del modelo
- Que use `@forelse` / `@empty` o un `@if` equivalente en la vista

**Señal de alerta:** Si filtra por un ID hardcodeado (`where('user_id', 1)`) o si ignora el mensaje de lista vacía.

---

### Tarea 3 — Filtro por estado

**Solución esperada en el controller (dentro de `index`):**
```php
public function index(Request $request)
{
    $query = Solicitud::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc');

    if ($request->filled('estado')) {
        $query->where('estado', $request->estado);
    }

    $solicitudes = $query->get();

    return view('solicitudes.index', compact('solicitudes'));
}
```

**En la vista (select que recuerda el valor):**
```blade
<select name="estado">
    <option value="">Todos</option>
    @foreach(['pendiente', 'en proceso', 'resuelto'] as $e)
        <option value="{{ $e }}" {{ request('estado') === $e ? 'selected' : '' }}>
            {{ ucfirst($e) }}
        </option>
    @endforeach
</select>
```

**Lo que buscás ver:**
- Que el filtro sea opcional (sin filtro = muestra todo)
- Que use `$request->filled()` o un `if` equivalente
- Que el select muestre el valor activo al recargar (usando `request('estado')`)
- Que mantenga el filtro del usuario (no muestre solicitudes de otros)

**Señal de alerta:** Si hace una ruta separada para el filtro en lugar de query string, o si el filtro rompe el filtrado por usuario.

---

### Tarea 4 — Resumen con Eloquent

**Solución esperada:**
```php
public function resumen()
{
    $user = auth()->user();

    $total = $user->solicitudes()->count();

    $porEstado = $user->solicitudes()
        ->selectRaw('estado, count(*) as total')
        ->groupBy('estado')
        ->get();

    $ultima = $user->solicitudes()
        ->latest()
        ->first();

    return view('reportes.resumen', compact('total', 'porEstado', 'ultima'));
}
```

También es válido usar `Solicitud::where('user_id', auth()->id())` en lugar de la relación, siempre que no use SQL crudo.

**Lo que buscás ver:**
- Que use Eloquent (no `DB::select`)
- Que filtre por el usuario logueado en las tres consultas
- Que use `count()`, `groupBy()` y `latest()->first()` o equivalentes
- Que pase las tres variables a la vista

**Señal de alerta:** Si usa `DB::select('SELECT COUNT(*) ...')` o similar, no cumplió la restricción más importante de la tarea.

---

### Tarea 5 — Opcional

Las tres opciones son válidas. Lo que evaluás es:

**Opción A (paginación):**
- Que cambie `->get()` por `->paginate(10)`
- Que agregue `{{ $solicitudes->appends(request()->query())->links() }}` en la vista para mantener el filtro

**Opción B (Form Request):**
- Que cree una clase con `php artisan make:request`
- Que defina las reglas en `rules()` y autorice en `authorize()`
- Que lo inyecte en `store` y `update` en lugar de `Request $request`

**Opción C (Observer / evento):**
- Que el campo `resuelto_en` esté en la migración como `nullable()->timestamp()`
- Que use un Observer con el método `updating()` o `saving()` que detecte el cambio de estado
- Que no lo haga en el controller (eso sería el enfoque incorrecto)

---

## Cómo leer el código entregado

Más allá de si funciona, mirá estas cosas:

**Git:**
- ¿Hay un commit por tarea o todo en un solo commit gigante?
- ¿Los mensajes son descriptivos ("fix: corrige bug en método edit del controller") o vagos ("fix stuff")?

**Estructura del código:**
- ¿Puso lógica de negocio en el controller (correcto para este nivel) o en la vista (señal de alerta)?
- ¿Repitió código o reutilizó lo que ya existía?

**README:**
- ¿Explica qué hizo o solo dice "hice las tareas"?
- ¿Justifica alguna decisión? Eso muestra criterio propio.

---

## Tabla de puntuación sugerida

| Tarea | Peso | Criterio |
|---|---|---|
| Tarea 1 — Bug edit | 20% | Identifica causa real + corrección correcta + explicación |
| Tarea 2 — Index incompleto | 20% | Filtra por usuario + ordena + mensaje vacío |
| Tarea 3 — Filtro estado | 25% | Funciona + query string + select recuerda valor |
| Tarea 4 — Eloquent resumen | 25% | Tres datos correctos + solo Eloquent |
| Tarea 5 — Opcional | 10% | Cualquier opción bien implementada |

**Recomendación de corte para avanzar a segunda instancia:** 65 puntos o más.

---

## Señales positivas independientes del puntaje

- Agrega validación donde no se la pediste
- Usa `@forelse` en lugar de `@if + @foreach` (conoce Blade bien)
- Usa la relación `auth()->user()->solicitudes()` en lugar de `Solicitud::where(...)`
- Los commits muestran un proceso incremental, no todo de una
- El README explica decisiones, no solo describe lo que hizo

## Señales de alerta independientes del puntaje

- Cambia el nombre de variable en la vista en lugar de corregir el controller (Tarea 1)
- Usa `DB::select` o SQL crudo en la Tarea 4
- Hardcodea el `user_id` en lugar de usar `auth()`
- El README está vacío o dice solo "listo"
- Hay un solo commit con todo
