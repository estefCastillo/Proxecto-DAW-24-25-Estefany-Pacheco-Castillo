# FASE DE IMPLANTACIÓN

- [FASE DE IMPLANTACIÓN](#fase-de-implantación)
  - [1- Manual técnico](#1--manual-técnico)
    - [1.1- Instalación](#11--instalación)
    - [1.2- Administración do sistema](#12--administración-do-sistema)
  - [2- Manual de usuario](#2--manual-de-usuario)
  - [3- Melloras futuras](#3--melloras-futuras)

## 1- Manual técnico

### 1.1- Instalación

Para poder desplegar **Sambo** de manera local, se necesitará:
- 1 CPU
- 2GB de RAM
- 10 GB (podrá variar según el número de empresas y servicios)
- El sistema opertativo debe ser Linux

**Instalación**
1. Clonar el repostitorio: 
  1.1. git clone git@github.com:estefCastillo/Proxecto-DAW-24-25-EPC.git
  1.2. cd sambo
2. Lanzar los contenedores:
  2.1. docker-compose up
3. Subir la base de datos a PhpMyAdmin
  3.1. Accediendo a través http://localhost:8000/ (usuario: root, contraseña: bitnami)
  3.2. Importando la base de datos [sambo.sql](../../sambo/sql/sambo.sql)
4. Acceder a Sambo a través de http://localhost


**Sin ninguna instalación:**
Se podra acceder a sambo a través de este enlace: [Sambo](https://purple-reindeer-599669.hostingersite.com/)

Usuarios de prueba:
- Administrador: admin@admin.admin
- Usuario: estefany@estefany.es
- Empresa: todoflores@gmail.com

Contraseña general: Abc123.;


### 1.2- Administración do sistema

- Las copias de seguridad se realizarán semanalmente
- Los usuarios serán gestionados por los administradores (pueden añadir, modificar o eliminar).
- Con respecto a la seguridad, Sambo está protegido de SQL injection y hace validaciones antes de las insercciones. Además de restricciones según el tipo de usuario. 

## 2- Manual de usuario

Sambo no necesita de formación para poder utilizarla, sin embargo, se debe tener claro las posibles funcionalidades según el usuario registrado:

| Actor   | Acción                          | Descripción                                                                 |
|---------|----------------------------------|-----------------------------------------------------------------------------|
| Usuario | Alta de usuario                 | Dar de alta a un usuario en la base de datos.                              |
| Usuario | Visualizar servicios            | Se mostrarán todos los servicios.                                          |
| Usuario | Buscar un servicio en una categoría | Se mostrarán los servicios de una categoría específica.                |
| Usuario | Añadir a favoritos              | Guarda los servicios o negocios en una tabla asociada al usuario.          |
| Usuario | Borrar favoritos                | Elimina un servicio o negocio de la tabla de favoritos del usuario.        |
|---------|---------------------|----------------------------------------------------------------------------|
| Empresa | Modificar empresa   | Modificación de la información de un empresa en la base de datos.         |
| Empresa | Añadir un servicio  | Dar de alta un servicio.                                                  |
| Empresa | Modificar servicio  | Modifica la información de un servcio en la base de datos.               |
| Empresa | Eliminar servicio   | Elimina un servicio de la base de datos.                                  |
|--------------|-----------------------------------|--------------------------------------------------------------------------------|
| Administrador | Alta de empresa/usuario | Dar de a una empresa, usuario o servicio en la base de datos.               |
| Administrador | Modificar empresa/usuario | Modificación de la información de una empresa, usuario o servicio.             |
| Administrador | Eliminar empresa/usuario | Elimina una empresa, usuario o servicio de la base de datos.                   |

## 3- Melloras futuras

En un futuro me gustaría impelmentar más filtros, como por ejemplo por ciudad o precio. Además de añadir las reseñas de los usuarios. Considero que tmabién sería óptimo añadir un registro por cuenta de **Google** o alguna red social.

[**<-Anterior**](../../README.md)