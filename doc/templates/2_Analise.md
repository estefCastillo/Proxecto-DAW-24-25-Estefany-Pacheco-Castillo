# Requerimientos do sistema

- [Requerimientos do sistema](#requerimientos-do-sistema)
  - [1- Descrición Xeral](#1--descrición-xeral)
  - [2- Funcionalidades](#2--funcionalidades)
  - [3- Tipos de usuarios](#3--tipos-de-usuarios)
  - [4- Contorno operacional](#4--contorno-operacional)
  - [5- Normativa](#5--normativa)
  - [6- Melloras futuras](#6--melloras-futuras)


## 1- Descrición Xeral
Sambo es una plataforma web que muestra múltiples negocios y recursos disponibles para la organización de eventos y fiestas en Galicia. Fue creada con el objetivo de reducir el tiempo y esfuerzo que supone planificar un evento.

## 2- Funcionalidades


| Actor   | Acción                          | Descripción                                                                 |
|---------|----------------------------------|-----------------------------------------------------------------------------|
| Usuario | Alta de usuario                 | Dar de alta a un usuario en la base de datos.                              |
| Usuario | Visualizar servicios            | Se mostrarán todos los servicios.                                          |
| Usuario | Buscar un servicio en una categoría | Se mostrarán los servicios de una categoría específica.                |
| Usuario | Añadir a favoritos              | Guarda los servicios o negocios en una tabla asociada al usuario.          |
| Usuario | Borrar favoritos                | Elimina un servicio o negocio de la tabla de favoritos del usuario.        |


Las empresas no se dan de alta por sí solos de alta, son los administradores quienes les dan el alta.

| Actor   | Acción              | Descripción                                                                |
|---------|---------------------|----------------------------------------------------------------------------|
| Empresa | Modificar empresa   | Modificación de la información de un empresa en la base de datos.         |
| Empresa | Añadir un servicio  | Dar de alta un servicio.                                                  |
| Empresa | Modificar servicio  | Modifica la información de un servcio en la base de datos.               |
| Empresa | Eliminar servicio   | Elimina un servicio de la base de datos.                                  |

| Actor        | Acción                            | Descripción                                                                    |
|--------------|-----------------------------------|--------------------------------------------------------------------------------|
| Administrador | Alta de empresa/usuario | Dar de a una empresa, usuario o servicio en la base de datos.               |
| Administrador | Modificar empresa/usuario | Modificación de la información de una empresa, usuario o servicio.             |
| Administrador | Eliminar empresa/usuario | Elimina una empresa, usuario o servicio de la base de datos.                   |


## 3- Tipos de usuarios

Sambo tendrá cuatro tipos de usuario:
| Tipo de usuario      | Descripción                                                                                      |
|----------------------|--------------------------------------------------------------------------------------------------|
| Usuario anónimo      | Puede acceder a la plataforma sin registrarse. Puede visualizar servicios, pero no añadir ni modificar, ni guardar favoritos. |
| Usuario registrado   | Se divide en dos categorías:                                                                     |
| ├─ Usuario normal     | Puede crear una cuenta, iniciar sesión, visualizar servicios y guardarlos como favoritos. |
| └─ Usuario cliente    | Puede visualizar y modificar su perfil, y también añadir, modificar o eliminar servicios.        |
| Administrador        | Tiene control total del sistema. Puede dar de alta, modificar y eliminar usuarios o servicios.   |


## 4- Contorno operacional

Para acceder a la plataforma, el usuario únicamente necesitará una conexión a internet y un navegador web actualizado ( como Google Chrome o Mozilla Firefox).

## 5- Normativa

Sambo está centrado únicamente en Galicia, por lo que debe regirse según las normativas autonómicas, nacionales y europeas.

- **Ley Orgánica 3/2018, de 5 de diciembre, de Protección de Datos Personales y garantía de los derechos digitales (LOPDPGDD)**: regula el tratamiento de los datos personales y garantiza los derechos digitales de los usuarios dentro del territorio español. Asegura la transparencia, confidencialidad y seguridad en la gestión de la información personal.

- **Reglamento (UE) 2016/679 del Parlamento Europeo y del Consejo, de 27 de abril de 2016 (GDPR)**: norma de aplicación obligatoria en toda la Unión Europea. Se centra en la protección de las personas físicas en lo que respecta al tratamiento de datos personales y la circulación de éstos.

Para cumplir con ambas normativas, Sambo contará con un aviso legal, así como las políticas de privacidad y de cookies. Aquí, se informará al usuario quien es la persona responsable del tratamiento de los datos, así como los fines específicos para los que se recopilan.

El responsable del tratamiento de los datos es Estefany Pacheco Castillo. Éstos datos serán almacenadas en bases de datos, gestionadas por Sambo. Se recogerán información relevante como: nombre, correo electrónico y teléfono.

Por supuesto, los usuarios podrán hacer cualquier solicitud de modificación como de cancelación poniéndose en contacto con nosotros.

## 6- Melloras futuras
 Se podría mejorar la plataforma añadiendo un sistema de valoración de los usuarios, así como filtros más detallados para facilitar la búsqueda de productos o servicios según la localización y precios.

[**<-Anterior**](../../README.md)
