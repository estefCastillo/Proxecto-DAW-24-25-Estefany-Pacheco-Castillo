# INCIDENCIAS E TAREFAS
- [INCIDENCIAS E TAREFAS](#incidencias-e-tarefas)
  - [1- Incidencias](#1--incidencias)
  - [2- Tarefas](#2--tarefas)

## 1- Incidencias
**Problemas obtenidos:**
Al comenzar con la codificación, decidí empezar por la API, ya que una vez terminada, podría utilizarla en el frontend sin tener que modificar nada.  
Para ello, decidí basarme en la API realizada en clase. Los métodos de los modelos y controladores, inicialmente, eran los mismos, sin embargo, más adelante me di cuenta de que algunos tenían funcionalidades innecesarias.

Al probar la API mediante una [extensión de Google](https://chromewebstore.google.com/detail/talend-api-tester-free-ed/aejoelaoggembcahagimdiliamlcdmfm), siempre que había un error, se devolvía un código 404. Esto se debía a que me basé exactamente en la versión realizada en clase, ya que el método que utilizaba ("sendNotFound") devolvía siempre ese código.  
Para solucionarlo, creé el método "errorMessage", de esta forma puedo personalizar el código HTTP y el mensaje de error.
En mi caso, solo conocía el 404 (Not Found), así que tuve que buscar más información sobre el significado de otros códigos de estado HTTP (toda la información está adjunta en el apartado de [Referencias](./6_Referencias.md)).

Con respecto a los modelos no tuve ningún problema grande, sí que tuve errores pero la mayoría eran ortográficos, pero sí que quiero destacar que un error que se repitió fue hacer que el id (de cualquier modelo) sea null, al insertar o crear una instancia. Este error no lo había tenido nunca ya que con "id_ejemplo=null" bastaba. Lo conseguí mediante el uso de "**?**" en la declaración de la variables, permitiendo así que pueda ser null (ya que el id, es incremental).

Para no reescribir continuamente el "header" y el "footer" en todas las páginas html, decidí crear componentes, sin utilizar ningun framework. En un inicio, hice componentes web mediante JavaScript. Aprendí a crearlos y su uso, sin embargo, yo quería que la cabcera funcionase según la sesión, por lo que tuve que mudar mis componentes a archivos php.

Un error que me costó encontrar el motivo fue el posicionamiento del footer. Mi "body", tenía la misma estructura que siempre realicé en clase, nunca tuve problemas con el uso de "grid-template-rows: auto 1fr auto", sin embargo al no tener mucho contenido, el "footer" no permanecía en el fondo de la página. Descubrí que "grid" no identificaba la cabecera al ser fija. Lo solucioné asignando a "header", "main" y "footer" sus filas correspondientes con "grid-row".

Otro error destacable es que nunca se destruía la sesión, ya que en un inicio no tenía ningun archivo para ello y tampoco destruía la sesión manualmente. Esto lo solucione con los archivos session.php y session.js

También tuve problemas al validar que los usuarios no pudieran realizar reservas en fechas pasadas, por ello añadí una validación en JavaScript
## 2- Tarefas

[**<-Anterior**](../../README.md)
