$().ready(function(){

    //BOTÓN DE ELIMINAR USUARIO
    $('#btnEliminar').click(function(){
        $('#newUserModal').hide();
        $('#modifyUserModal').hide();
        $('#modalDelete').show();
        $('#modalWindow').show();
    });

    //BOTÓN CANCELAR DE MODAL DE CONFIRMACIÓN
    $("#btnNo").click(function(){
        $("#modalWindow").css("display", "none");
        $("#ventanaModal").css("display", "none");
    });

    //CIERRE DE VENTANA MODAL
    $('.closeModal').click(function(){
        $('#modalWindow').hide();
        $('modalDelete').hide();
        $('#newUserModal').hide();
        $('#modifyUserModal').hide();
    });

    //BOTÓN DE AÑADIR NUEVO USUARIO
    $('#addNewUser').click(function(){
        $('#modalDelete').hide();
        $('#modifyUserModal').hide();
        $('#newUserModal').show();
        $('#modalWindow').show();
    });

    //SUBMIT DEL FORMULARIO DE AÑADIR NUEVO USUARIO
    $('#addNewUserForm').submit(function(event){
        var name = document.getElementById('name').value;
        var pass1 = document.getElementById("password").value;
        var pass2 = document.getElementById("password2").value;
        var email = document.getElementById("email").value;
        
        //Comprobamos que todos los campos estén rellenos
        if(name != "" && pass1 != "" && pass2 != "" && email != ""){
            //Comprobamos que la contraseña cumpla los requisitos mínimos
            if(/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/.test(pass1)){
                //Comprobamos que las contraseñas coincidan
                if(pass1 != pass2){
                    //Si no coinciden, detenemos el evento submit
                    event.preventDefault();
                    $('#errorMesagge').text('Las contraseñas no coinciden');
                    $('#password').css('border', '1.5px solid red');
                    $('#password2').css('border', '1.5px solid red');
                //Si las contraseñas coinciden, testeamos el email
                }else{
                    $('#password').css('border', '1px solid black');
                    $('#password2').css('border', '1px solid black');
                    if(!(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+[gmail.com|gmail.es|yahoo.com|yahoo.es|hotmail.com|hotmail.es]+$/.test(email))){
                        event.preventDefault();
                        $('#errorMesagge').text('El email no es correcto');
                        $('#email').css('border', '1.5px solid red');
                    }
                }
            //Si la contraseña no cumple los requisítos mínimos, detenemos el submit
            }else{
                event.preventDefault();
                $('#errorMesagge').text('La contraseña debe incluir 8 caracteres con mayúsculas, minúsculas, números y caracteres especiales');
                $('#password').css('border', '1.5px solid red');
                $('#password2').css('border', '1.5px solid red');
    
            }
        //Si hay algún campo vacío, detenemos el submit
        }else{
            event.preventDefault();
            $('#errorMesagge').text('Por favor, rellene todos los campos');
            if(name == "") $('#name').css('border', '1.5px solid red'); else $('#name').css('border', '1px solid black');
            if(pass1 == "") $('#password').css('border', '1.5px solid red'); else $('#password').css('border', '1px solid black');
            if(pass2 == "") $('#password2').css('border', '1.5px solid red'); else $('#password2').css('border', '1px solid black');
            if(email == "") $('#email').css('border', '1.5px solid red'); else $('#email').css('border', '1px solid black');
        }
    });

    //BOTÓN DE MODIFICAR USUARIO
    $('.modify').click(function(){
        userId = $(this).attr('id');
        $('#updateUserForm').attr('action', updateUserRoute.replace('req_id', userId));
        var route = getInfoRoute.replace('req_id', userId);
        $.ajax({
            url: route,
            type: 'POST',
            data: {
                '_token': token,
            },
            success: function(result){
                user = result['user'];
                console.log(user);
                $('#nameUpdate').attr('value', user.name);
                $('#emailUpdate').attr('value', user.email);
                $('#typeUpdate > option[value="' + user.type + '"]').select();
                $('#newUserModal').hide();
                $('#modalDelete').hide();
                $('#modifyUserModal').show();
                $('#modalWindow').show();
            },
            error: function(){
                alert('Error AJAX al intentar recuperar el usuario');
            }
        });
    });

    //BOTÓN DE CAMBIAR CONTRASEÑA DE LA MODAL DE MODIFICAR
    $('#changePasswordButton').click(function(){
        $(this).hide(700);
        $(this).fadeOut(700, function(){
            $('#changePassword').show(700);
            $('#changePassword').fadeIn(700);
        });
    });

    //SUBMIT DEL FORMULARIO DE MODIFICAR USUARIO
    $('#updateUserForm').submit(function(){
        var name = document.getElementById('nameUpdate').value;
        var pass1 = document.getElementById("passwordUpdate").value;
        var pass2 = document.getElementById("password2Update").value;
        var email = document.getElementById("emailUpdate").value;
        
        //Comprobamos que todos los campos estén rellenos
        if(name != "" && email != ""){
            //Compruebo que el email está formado correctamente
            if(!(/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.([a-zA-Z]{2,4})+[gmail.com|gmail.es|yahoo.com|yahoo.es|hotmail.com|hotmail.es]+$/.test(email))){
                event.preventDefault();
                $('#errorMesaggeUpdate').text('El email no es correcto');
                $('#email').css('border', '1.5px solid red');
            }
            //Si se modifica la contraseña
            if(pass1 != "" && pass2 != ""){
                //Comprobamos que la contraseña cumpla los requisitos mínimos
                if(/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/.test(pass1)){
                    //Comprobamos que las contraseñas coincidan
                    if(pass1 != pass2){
                        //Si no coinciden, detenemos el evento submit
                        event.preventDefault();
                        $('#errorMesaggeUpdate').text('Las contraseñas no coinciden');
                        $('#password').css('border', '1.5px solid red');
                        $('#password2').css('border', '1.5px solid red');
                    //Si las contraseñas coinciden, testeamos el email
                    }else{
                        $('#password').css('border', '1px solid black');
                        $('#password2').css('border', '1px solid black');
                    }
                //Si la contraseña no cumple los requisítos mínimos, detenemos el submit
                }else{
                    event.preventDefault();
                    $('#errorMesaggeUpdate').text('La contraseña debe incluir 8 caracteres con mayúsculas, minúsculas, números y caracteres especiales');
                    $('#passwordUpdate').css('border', '1.5px solid red');
                    $('#password2Update').css('border', '1.5px solid red');
                }
            }
        //Si hay algún campo vacío, detenemos el submit
        }else{
            event.preventDefault();
            $('#errorMesaggeUpdate').text('Por favor, rellene todos los campos');
            if(name == "") $('#name').css('border', '1.5px solid red'); else $('#name').css('border', '1px solid black');
            if(email == "") $('#email').css('border', '1.5px solid red'); else $('#email').css('border', '1px solid black');
        }
    });

});