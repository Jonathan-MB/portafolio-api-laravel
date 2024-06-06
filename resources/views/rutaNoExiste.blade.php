<!-- 
    Ruta no existente revisea tu metodo Http

cuando la ruta o metodo  no sean correctos se te devolvera esta vista


                    ********************************************************
                    *** Guia de uso en herramientas similares a (Postman)***
                    ********************************************************

                    
                    *********  Si eres nuevo **********


            1) Registrate en la ruta (POST) api/register :

                    {
                        "name" : "ingrese nombre maximo 45 caracteres",
                        "email" : "ingrese un email unico  max 45 caracteres",
                        "password" : "contraseña minimo 5 caracteres / maximo 45"
                    }

            2) Te retornara  un Json como el siguiente

                {
                    "status": true,
                    "message": "Usuario creado exitosamente",
                    "token": "1|qMbdmEr4LNDiz1QUADqsHuR3WsaCzbDu0iaREWOg50cb544",
                    "typeToken": "Bearer",
                    "UserInfo":{
                                "name": "nombre",
                                "email": "email@ejemplo.com"
                                }
                }

            3) Ingresa en Postman , en la pestaña Authorization selecciona la opcion (Bearer Token)


            4) se habilitara el campo Token , copia el token que te devolvio  al registrarte (completo sin comillas) y pega el  token que te devolvio  al registrarte (completo sin comillas)

                Ejemplo
                
                    1|qMbdmEr4LNDiz1QUADqsHuR3WsaCzbDu0iaREWOg50cb544

            ________________________________________________________________________________________________________
            |                                                                                                       |
            |   Con este token tendras una hora de  actividad  luego  deberas loguearte para acceder a uno nuevo    |
            |_______________________________________________________________________________________________________|    





                        *********  Si ya estas registrado *************** 



            1) Registrate en la ruta (POST) api/login :

                    {
                        "email" : "ingrese un email unico  max 45 caracteres",
                        "password" : "contraseña minimo 5 caracteres / maximo 45"
                    }

            2) Te retornara  un Json como el siguiente

                {
                    "status": true,
                    "message": "Usuario creado exitosamente",
                    "token": "2|WHcRx1nJXCLzemrE5l3JMSPtKflmWIvwhK7IOEMf3986264",
                    "typeToken": "Bearer",
                    "UserInfo": {
                                "name": "nombre",
                                "email": "email@ejemplo.com",
                                    "rol": "Administrador"
                                }
                }

            3) Ingresa en Postman , en la pestaña Authorization selecciona la opcion (Bearer Token)


            4) se habilitara el campo Token , copia el token que te devolvio  al registrarte (completo sin comillas) y pega el  token que te devolvio  al registrarte (completo sin comillas)

                Ejemplo
                
                    2|WHcRx1nJXCLzemrE5l3JMSPtKflmWIvwhK7IOEMf3986264

            _______________________________________________________________________________________________________
            |                                                                                                       |
            |   Con este token tendras una hora de  actividad  luego  deberas loguearte nuevamente                  |
            |_______________________________________________________________________________________________________|    








 a continuiacion una lista de rutas que  te puede ayudar


  POST            api/login .............................................................. api\AuthController@login
  GET|HEAD        api/note .................................................. note.index › api\NoteController@index
  POST            api/note .................................................. note.store › api\NoteController@store
  GET|HEAD        api/note/create ......................................... note.create › api\NoteController@create
  GET|HEAD        api/note/{note} ............................................. note.show › api\NoteController@show
  PUT|PATCH       api/note/{note} ......................................... note.update › api\NoteController@update
  DELETE          api/note/{note} ....................................... note.destroy › api\NoteController@destroy
  GET|HEAD        api/note/{note}/edit ........................................ note.edit › api\NoteController@edit
  GET|HEAD        api/noteAll .......................................................... api\NoteController@noteAll
  GET|HEAD        api/notePublic .................................................... api\NoteController@publicNote
  POST            api/register ........................................................... api\AuthController@store
  GET|HEAD        api/rol ..................................................... rol.index › api\RolController@index
  POST            api/rol ..................................................... rol.store › api\RolController@store
  GET|HEAD        api/rol/create ............................................ rol.create › api\RolController@create
  GET|HEAD        api/rol/{rol} ................................................. rol.show › api\RolController@show
  PUT|PATCH       api/rol/{rol} ............................................. rol.update › api\RolController@update
  DELETE          api/rol/{rol} ........................................... rol.destroy › api\RolController@destroy
  GET|HEAD        api/rol/{rol}/edit ............................................ rol.edit › api\RolController@edit
  GET|HEAD        api/state ............................................... state.index › api\StateController@index
  POST            api/state ............................................... state.store › api\StateController@store
  GET|HEAD        api/state/create ...................................... state.create › api\StateController@create
  GET|HEAD        api/state/{state} ......................................... state.show › api\StateController@show
  PUT|PATCH       api/state/{state} ..................................... state.update › api\StateController@update
  DELETE          api/state/{state} ................................... state.destroy › api\StateController@destroy
  GET|HEAD        api/state/{state}/edit .................................... state.edit › api\StateController@edit
  GET|HEAD        api/user .................................................. user.index › api\UserController@index
  POST            api/user .................................................. user.store › api\UserController@store
  GET|HEAD        api/user/create ......................................... user.create › api\UserController@create
  GET|HEAD        api/user/{user} ............................................. user.show › api\UserController@show
  PUT|PATCH       api/user/{user} ......................................... user.update › api\UserController@update
  DELETE          api/user/{user} ....................................... user.destroy › api\UserController@destroy
  GET|HEAD        api/user/{user}/edit ........................................ user.edit › api\UserController@edit
  PUT             api/userAdmin/{user} ............................................. api\UserController@updateAdmin
  DELETE          api/userAdmin/{user} ............................................ api\UserController@destroyAdmin
  GET|HEAD        api/visibility ................................ visibility.index › api\VisibilityController@index
  POST            api/visibility ................................ visibility.store › api\VisibilityController@store
  GET|HEAD        api/visibility/create ....................... visibility.create › api\VisibilityController@create
  GET|HEAD        api/visibility/{visibility} ..................... visibility.show › api\VisibilityController@show
  PUT|PATCH       api/visibility/{visibility} ................. visibility.update › api\VisibilityController@update
  DELETE          api/visibility/{visibility} ............... visibility.destroy › api\VisibilityController@destroy
  GET|HEAD        api/visibility/{visibility}/edit ................ visibility.edit › api\VisibilityController@edit

-->


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guía de Uso - API</title>
 <link rel="stylesheet" href="{{asset('css/rutaNoExiste.css')}}">
</head>
<body>
    <div class="container">
        <h2>Ruta no existente, revise su método HTTP</h2>
        <p>Cuando la ruta o método no sean correctos, se te devolverá esta vista.</p>

        <div class="note">
            <h3>Guía de uso en herramientas similares a (Postman)</h3>
        </div>

        <h3>Si eres nuevo</h3>
        <ol>
            <li>Regístrate en la ruta <strong>(POST)</strong> <code>api/register</code>:
                <div class="code">
                    <pre>{
    "name": "ingrese nombre máximo 45 caracteres",
    "email": "ingrese un email único max 45 caracteres",
    "password": "contraseña mínimo 5 caracteres / máximo 45"
}</pre>
                </div>
            </li>
            <li>Te retornará un JSON como el siguiente:
                <div class="code">
                    <pre>{
    "status": true,
    "message": "Usuario creado exitosamente",
    "token": "1|qMbdmEr4LNDiz1QUADqsHuR3WsaCzbDu0iaREWOg50cb544",
    "typeToken": "Bearer",
    "UserInfo": {
        "name": "nombre",
        "email": "email@ejemplo.com"
    }
}</pre>
                </div>
            </li>
            <li>Ingresa en Postman, en la pestaña Authorization selecciona la opción <strong>(Bearer Token)</strong></li>
            <li>Se habilitará el campo Token, copia el token que te devolvió al registrarte (completo sin comillas) y pégalo en el campo Token.
                <div class="code">
                    <pre>Ejemplo: 1|qMbdmEr4LNDiz1QUADqsHuR3WsaCzbDu0iaREWOg50cb544</pre>
                </div>
            </li>
        </ol>
        <div class="note">
            <p>
                Con este token tendrás una hora de actividad, luego deberás loguearte para acceder a uno nuevo.
            </p>
        </div>

        <h3>Si ya estás registrado</h3>
        <ol>
            <li>Inicia sesión en la ruta <strong>(POST)</strong> <code>api/login</code>:
                <div class="code">
                    <pre>{
    "email": "ingrese un email único max 45 caracteres",
    "password": "contraseña mínimo 5 caracteres / máximo 45"
}</pre>
                </div>
            </li>
            <li>Te retornará un JSON como el siguiente:
                <div class="code">
                    <pre>{
    "status": true,
    "message": "Usuario creado exitosamente",
    "token": "2|WHcRx1nJXCLzemrE5l3JMSPtKflmWIvwhK7IOEMf3986264",
    "typeToken": "Bearer",
    "UserInfo": {
        "name": "nombre",
        "email": "email@ejemplo.com",
        "rol": "Administrador"
    }
}</pre>
                </div>
            </li>
            <li>Ingresa en Postman, en la pestaña Authorization selecciona la opción <strong>(Bearer Token)</strong></li>
            <li>Se habilitará el campo Token, copia el token que te devolvió al registrarte (completo sin comillas) y pégalo en el campo Token.
                <div class="code">
                    <pre>Ejemplo: 2|WHcRx1nJXCLzemrE5l3JMSPtKflmWIvwhK7IOEMf3986264</pre>
                </div>
            </li>
        </ol>
        <div class="note">
            <p>
                Con este token tendrás una hora de actividad, luego deberás loguearte nuevamente.
            </p>
        </div>

        <h3>Lista de rutas que te pueden ayudar</h3>
        <table>
            <thead>
                <tr>
                    <th>Método</th>
                    <th>Ruta</th>
                    <th>Controlador</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>POST</td>
                    <td>api/login</td>
                    <td>api\AuthController@login</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/note</td>
                    <td>note.index › api\NoteController@index</td>
                </tr>
                <tr>
                    <td>POST</td>
                    <td>api/note</td>
                    <td>note.store › api\NoteController@store</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/note/create</td>
                    <td>note.create › api\NoteController@create</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/note/{note}</td>
                    <td>note.show › api\NoteController@show</td>
                </tr>
                <tr>
                    <td>PUT|PATCH</td>
                    <td>api/note/{note}</td>
                    <td>note.update › api\NoteController@update</td>
                </tr>
                <tr>
                    <td>DELETE</td>
                    <td>api/note/{note}</td>
                    <td>note.destroy › api\NoteController@destroy</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/note/{note}/edit</td>
                    <td>note.edit › api\NoteController@edit</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/noteAll</td>
                    <td>api\NoteController@noteAll</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/notePublic</td>
                    <td>api\NoteController@publicNote</td>
                </tr>
                <tr>
                    <td>POST</td>
                    <td>api/register</td>
                    <td>api\AuthController@store</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/rol</td>
                    <td>rol.index › api\RolController@index</td>
                </tr>
                <tr>
                    <td>POST</td>
                    <td>api/rol</td>
                    <td>rol.store › api\RolController@store</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/rol/create</td>
                    <td>rol.create › api\RolController@create</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/rol/{rol}</td>
                    <td>rol.show › api\RolController@show</td>
                </tr>
                <tr>
                    <td>PUT|PATCH</td>
                    <td>api/rol/{rol}</td>
                    <td>rol.update › api\RolController@update</td>
                </tr>
                <tr>
                    <td>DELETE</td>
                    <td>api/rol/{rol}</td>
                    <td>rol.destroy › api\RolController@destroy</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/rol/{rol}/edit</td>
                    <td>rol.edit › api\RolController@edit</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/state</td>
                    <td>state.index › api\StateController@index</td>
                </tr>
                <tr>
                    <td>POST</td>
                    <td>api/state</td>
                    <td>state.store › api\StateController@store</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/state/create</td>
                    <td>state.create › api\StateController@create</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/state/{state}</td>
                    <td>state.show › api\StateController@show</td>
                </tr>
                <tr>
                    <td>PUT|PATCH</td>
                    <td>api/state/{state}</td>
                    <td>state.update › api\StateController@update</td>
                </tr>
                <tr>
                    <td>DELETE</td>
                    <td>api/state/{state}</td>
                    <td>state.destroy › api\StateController@destroy</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/state/{state}/edit</td>
                    <td>state.edit › api\StateController@edit</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/user</td>
                    <td>user.index › api\UserController@index</td>
                </tr>
                <tr>
                    <td>POST</td>
                    <td>api/user</td>
                    <td>user.store › api\UserController@store</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/user/create</td>
                    <td>user.create › api\UserController@create</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/user/{user}</td>
                    <td>user.show › api\UserController@show</td>
                </tr>
                <tr>
                    <td>PUT|PATCH</td>
                    <td>api/user/{user}</td>
                    <td>user.update › api\UserController@update</td>
                </tr>
                <tr>
                    <td>DELETE</td>
                    <td>api/user/{user}</td>
                    <td>user.destroy › api\UserController@destroy</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/user/{user}/edit</td>
                    <td>user.edit › api\UserController@edit</td>
                </tr>
                <tr>
                    <td>PUT</td>
                    <td>api/userAdmin/{user}</td>
                    <td>api\UserController@updateAdmin</td>
                </tr>
                <tr>
                    <td>DELETE</td>
                    <td>api/userAdmin/{user}</td>
                    <td>api\UserController@destroyAdmin</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/visibility</td>
                    <td>visibility.index › api\VisibilityController@index</td>
                </tr>
                <tr>
                    <td>POST</td>
                    <td>api/visibility</td>
                    <td>visibility.store › api\VisibilityController@store</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/visibility/create</td>
                    <td>visibility.create › api\VisibilityController@create</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/visibility/{visibility}</td>
                    <td>visibility.show › api\VisibilityController@show</td>
                </tr>
                <tr>
                    <td>PUT|PATCH</td>
                    <td>api/visibility/{visibility}</td>
                    <td>visibility.update › api\VisibilityController@update</td>
                </tr>
                <tr>
                    <td>DELETE</td>
                    <td>api/visibility/{visibility}</td>
                    <td>visibility.destroy › api\VisibilityController@destroy</td>
                </tr>
                <tr>
                    <td>GET|HEAD</td>
                    <td>api/visibility/{visibility}/edit</td>
                    <td>visibility.edit › api\VisibilityController@edit</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
