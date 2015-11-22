# Framework Studio 1.0.0
**Framework Studio (FStudio)** es la línea base que se propone para trabajar los proyectos formativos desarrollados en PHP en el SENA (CDTI - Valle) en sus programas ADSI, TADSI y TPS.

## Características
Cuando se decidió crear FStudio, pensamos en:
  - Código fácil de comprender y por ende una curva de aprendizaje bastante rápida.
  - Estandarización de la enseñanza y código PHP.
  - Implementación del patrón de arquitectura de software [modelo, vista, controlador (MVC)].
  - Acceso a datos mediante la [librería PDO] e implementando un componente similar a [DAO].
  - Flexibilidad del framework por medio de [plug-ins].

> *Los **plug-ins** son una herramienta sumamente poderosa, la cual le permitirá a los aprendices e instructores implementar comportamientos no concebidos inicialmente en FStudio como por ejemplo implementar el componente DAO para el manejo del acceso a los datos o extender la funcionalidad de FStudio.*

## Requerimientos
  - [Apache 2].
  - [PHP 5.5] o superior.
  - [MySQL 5], [PostgreSQL 9] o cualquier base de datos soportada por la [librería PDO].

> *Recuerde que existen paquetes que en una sola instalación, el cual reúnen todo lo necesario para empezar a programar en PHP como por ejemplo: [WAMP], [XAMPP], [MAMP], entre otros.*

## Instalación
Para la puesta en marcha de **FStudio** hay que seguir los siguientes pasos:
  1. Descargar la [última versión estable].
  2. Descomprimir el archivo descargado.
  3. Cambiar el nombre a la carpeta descomprimida por el nombre de su proyecto.
  4. Mover la carpeta a la carpeta raíz del servidor Web.
  5. Editar el archivo ***config.php*** ubicado en la carpeta ***config***.
  6. [paso opcional] Configurar un host virtual para el proyecto.
  7. Ejecutar el proyecto.

> Recuerde que la única puerta de entrada al proyecto es por el archivo ***index.php*** ubicado en la carpeta ***web***.

## Documentación oficial
***FStudio*** está documentado en todos sus aspecto y día a día se irá construyendo más documentación al respecto el cual puedes [ver aquí].

## Historial de cambios - Changelog

#### 1.0.0
  - Estructura inicial de carpetas.
  - Implementación del núcleo (MVC).
  - Implementación del controlador frontal y su despachador.
  - Implementación de la configuración estándar y la extensión de dicha configuración.
  - Creación del **SQL** inicial que acompaña a **FStudio**.
  - Implementación del sistema de [plug-ins].

## Equipo inicial de desarrollo
El equipo inicial de desarrollo intelectual y material está compuesto por todos los instructores del SENA CDTI regional Valle presentes a finales del 2015.

  1. Andres Fernando Sanchez
  2. David Barona
  3. Edwin Sanchez
  4. Jesus Alejandro Yepes
  5. Jose Fredy Tenorio
  6. Julian Andres Lasso
  7. Julieth Chavez
  8. Maria Doneya Restrepo
  9. Victor Gabriel Quijano

## Licencia
**FStudio** es publicado bajo licencia [GNU GPL 2].

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does its job. There is no need to format nicely because it shouldn't be seen. Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)
  [modelo, vista, controlador (MVC)]: <https://es.wikipedia.org/wiki/Modelo%E2%80%93vista%E2%80%93controlado>
  [GNU GPL 2]: <https://raw.githubusercontent.com/FrameworkStudio/FStudio/master/LICENSE>
  [librería PDO]: <http://php.net/manual/es/book.pdo.php>
  [DAO]: <https://es.wikipedia.org/wiki/Data_Access_Object>
  [plug-ins]: <https://es.wikipedia.org/wiki/Complemento_%28inform%C3%A1tica%29>
  [Apache 2]: <https://httpd.apache.org/>
  [PHP 5.5]: <http://php.net/>
  [MySQL 5]: <https://www.mysql.com/>
  [PostgreSQL 9]: <http://www.postgresql.org/>
  [WAMP]: <http://www.wampserver.com/>
  [XAMPP]: <https://www.apachefriends.org/>
  [MAMP]: <https://www.mamp.info/>
  [última versión estable]: <https://github.com/FrameworkStudio/FStudio/releases>
  [ver aquí]: <https://github.com/FrameworkStudio/FStudio/wiki>
