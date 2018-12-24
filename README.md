Formulario con CRUD
===================

Formulario con CRUD para Drupal.

Instrucciones
-------------

Formulario con CRUD para efectuar operaciones en la... **Base de Datos!**

Descomprimir en la carpeta *modules* (actualmente en la raíz de tu instalación de Drupal 8) 
y habilitar en `/admin/modules`.

Coloque el bloque de *Agregar usuarios a la BD* en la región de su tema donde desee visualizar el formulario.

Para ver los datos almacenados en la base de datos, visite la ruta `/br-user-form-crud`
Los datos serán mostrados en una tabla, con las operaciones de *Borrar* y *Editar* correspondientes.

Para editar una fila de la base de datos, utilice la ruta `/br-user-form-crud/form/datos?num={num}` , 
dónde *{num}* corresponde al número de ID de la fila correspondiente.

Para eliminar una fila de la base de datos, utilice la ruta `/br-user-form-crud/form/delete/{cid}` , 
dónde *{cid}* corresponde al número de ID de la fila correspondiente.