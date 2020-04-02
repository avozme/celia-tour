# **Guía de instalación:**

La instalación de Celia360 implica el despliegue de la aplicación web en un servidor. Este proceso puede entrañar cierta dificultad si usted no está familiarizado con ello, por lo que puede requerir la colaboración de un administrador de sistemas para completarlo con éxito.

Los requerimientos de la aplicación son:

* Un servidor web son soporte para PHP 5.5 o superior. Se recomienda PHP 7.x
* Un servidor MySQL 5.5 o MariaDB 10 o superior.
* Una conexión FTP con su servidor o alguna otra forma para acceder remotamente a los archivos de su servidor.

Los pasos generales para la instalación son los siguientes:
# **Guía de instalación:**

La instalación de Celia360 implica el despliegue de la aplicación web en un servidor. Este proceso puede entrañar cierta dificultad si usted no está familiarizado con ello, por lo que puede requerir la colaboración de un administrador de sistemas para completarlo con éxito.

Los requerimientos de la aplicación son:

* Un servidor web son soporte para PHP 5.5 o superior. Se recomienda PHP 7.x
* Un servidor MySQL 5.5 o MariaDB 10 o superior.
* Una conexión FTP con su servidor o alguna otra forma para acceder remotamente a los archivos de su servidor.

Los pasos generales para la instalación son los siguientes:

1. Copie el código fuente de la aplicación en un directorio de su servidor accesible vía web. Puede obtener la última versión del código fuente del repositorio de [GitHub.](https://github.com/mmarbonillo/celia-tour)
2. Cree una base de datos en su servidor MySQL o MariaDB. Recuerde las credenciales de esta base de datos (nombre de la base de datos, usuario y contraseña). Su usuario debe tener privilegios suficientes para escribir y leer en esa base de datos.
3. Cambie el nombre del archivo *example.env* que encontrará en la raíz del directorio por *.env*
4. Cambie el tamaño de memoria del servidor por 1GB (esto debe ser cambiado desde el archivo de configuración del servidor llamado *php.ini*)
5. Accede a través de la URL de tu servidor al recurso */install* (Ejemplo: miservidor.com/install)
6. Al entrar encontrará a siguiente vista, siga los pasos y rellene los campos que se especifican: 

![Vista de instalación](docs/img/install.png)

     Tenga en cuenta que el nombre de la base de datos junto con el usuario será el mismo que creo previamente. Apunte y guarde el usuario y contraseña puesto en el área del Usuario Administrador pues con ella podrá acceder después al pane de administración de la aplicación. 

7. Una vez introducidos todos los datos, pulse el botón crear. 
8. Si todo era correcto y la instalación ha ido bien aparecerá una pestaña avisándolo de que la aplicación fue instalada correctamente con un botón para poder acceder al login:

![Login](docs/img/login.png)

9. Introduzca el usuario y contraseña del administrador que decidió anteriormente para acceder a su panel de control y empiece a disfrutar de su aplicación.
