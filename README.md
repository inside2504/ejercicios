# Ejercicio XML
El ejercicio de XML de encuentra en la carpeta soccer y está realizado en PHP puro sin la utilización de algún framework.

#Ejercicio Querys
Se encuentra en la carpeta querys, está realizada bajo Codeigniter para manejar el modelo MVC y hacer uso de las tablas
que fueron proporcionadas para realizar este ejercicio.

Es importante modificar el archivo de configuración de la base de datos que se encuentra en la carpeta
application/config/database.php. Las modificaciones que se deben hacer son las de la conexión debido a que contiene los datos
con los que me conecto a MySQL y hago uso de la base de datos que contiene las tablas con la información.

Las que líneas deben editarse son 52, 53 y 54 y debe contener sus datos para tener conexión con su BD.

- $db['default']['username'] = 'root';
- $db['default'] ['password'] = 'Inside09';
- $db['default']['password'] = 'Matches';
