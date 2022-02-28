# api-recargas
link api: https://api-recargas.herokuapp.com/

##Documentacion

###Seccion Usuario

* crear Usuario

para crear un usuario se usa la siguiente ruta:
```
api/create-account
```
Al ser una ruta post en el body del request se debe de agregar en formato JSON el siguiente campo
```
{
    "name": "nombre de la cuenta"
}
```
* Consulta del balance de una cuenta

para la consulta del balance se usa la siguiente ruta 
```
api/balance
```
Es necesario usar la siguiente request para la consulta
```
{
    "name": "nombre de la cuenta"
}
```
* Realizar deposito de creditos 

La ruta para realizar el deposito de creditos es la siguiente:.
```
api/deposit
```
El request debe de contener los siquientes parametros 
```
{
    "name": "nombre de la cuenta",
    "creditos": (cantidad de creditos a depositar, en numero y sin comillas)
}
```
###Seccion Recarga
* Realizar recarga

En la siguiente ruta es la que se usa para realizar la recarga:
```
api/recarga
```
El request debe de contener los siquientes campos
```
{
    "numero": "numero telefonico a la que se realiza la recarga",
    "creditos": (cantidad de la que se realiza la recarga, sin comillas),
    "name": "nombre de la cuenta"
}
```



    
