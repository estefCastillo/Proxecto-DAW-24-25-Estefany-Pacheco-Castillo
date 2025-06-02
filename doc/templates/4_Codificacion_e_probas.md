# FASE DE CODIFICACIÓN E PROBAS

- [FASE DE CODIFICACIÓN E PROBAS](#fase-de-codificación-e-probas)
  - [1- Codificación](#1--codificación)
  - [2- Prototipos](#2--prototipos)
  - [3- Innovación](#3--innovación)
  - [4- Probas](#4--probas)



## 1- Codificación

[Sambo](../../sambo/)

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

También tuve problemas al validar que los usuarios no pudieran realizar reservas en fechas pasadas, por ello añadí una validación en JavaScript.

## 2- Prototipos

[Prototipo](https://www.figma.com/design/33aaDwk6hJCFWibN3ECjLV/Sambo?node-id=0-1&t=9BBikmzGAufljyMd-1)

## 3- Innovación

No se han utilizado nuevas tecnologías.

## 4- Probas

- **Carga de la página inicial**: Al principio, al no haber mucho contenido, el pie de página no se mantenía en su lugar. 

- **Iniciar sesión**: Funciona correctamente.

- **Registrarse**: Se validan los inputs del formulario. Si algún valor es incorrecto, se muestra un mensaje al usuario mediante "alerts". Si todos los valores son correctos, el registro se realiza sin problemas.

- **Buscar**: Permite buscar por nombre correctamente. Si no hay coincidencias, se muestra un mensaje informativo. El pie de página se mantiene en su lugar aunque haya poco contenido.

- **Filtrar por categoría**: Se muestran los servicios filtrados según la categoría seleccionada.

- **Cerrar sesión**: Al pulsar en “Cerrar sesión”, se elimina el usuario del "localStorage" y se destruye la sesión en el servidor.

- **Ver favoritos**: Si no hay favoritos guardados, se muestra un mensaje. Si los hay, se muestran correctamente. No se puede acceder a esta página sin sesión iniciada.

- **Ver mi perfil de usuario**: Se muestra el nombre del usuario y las reservas realizadas. También permite eliminar la cuenta con confirmación.

- **Iniciar sesión como empresa**: Funciona correctamente. Redirige al perfil de empresa.

- **Modificar servicios**: Permite editar los servicios añadidos por la empresa.

- **Añadir servicios**: Se pueden añadir nuevos servicios desde el perfil de empresa.

- **Ver reservas**: Se muestran todas las reservas de los servicios creados por la empresa y su estado.

- **Iniciar sesión como administrador**: Redirige correctamente al panel de administración.

- **Visualizar usuarios**: Muestra una lista de usuarios.

- **Eliminar usuarios**: Se pueden eliminar usuarios correctamente.

- **Añadir usuarios**: Permite añadir nuevos usuarios.

- **Editar usuarios**: Permite modificar la información de usuarios.

- **Visualizar empresas**: Se muestra un listado de empresas.

- **Eliminar empresa**: Se pueden eliminar empresas.

- **Añadir empresa**: Funciona correctamente.

- **Editar empresa**: Permite editar la información de las empresas.


[**<-Anterior**](../../README.md)
