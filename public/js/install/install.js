$().ready(function(){
    //COMPROBACIÓN DEL FORMULARIO DE INSTALL EN LA PARTE DE USUARIO ANTES DEL SUBMIT
    $('#sendForm').click(function(){
        var name = document.getElementById('userName').value;
        var DBname = document.getElementById('bName').value;
        var pass1 = document.getElementById("userPass1").value;
        var pass2 = document.getElementById("userPass2").value;
        var pass2 = document.getElementById("userPass2").value;
        
        //Comprobamos que todos los campos estén rellenos
        if(name != "" && pass1 != "" && pass2 != "" && DBname != "" && ($('#radioWindows').prop('checked') == true || $('#radioLinux').prop('checked') == true)){
            var test = (/^[A-Za-z0-9Ññ]+$/.test(name));
            //Si el nombre de usuario no cumple los requisitos
            if(!test){
                event.preventDefault();
                $('#errorMsgUser > span').text('El nombre de usuario solo puede contener mayúsculas, minúsculas y números');
                if($('#errorMsgUser').css('display') == 'none')
                    $('#errorMsgUser').slideDown(450);
                $('#userName').css('border', '1.5px solid red');
            }else{
                $('#userName').css('border', '1px solid gray');
                //Comprobamos que la contraseña cumpla los requisitos mínimos
                if(/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!¡%*#?¿&()])[A-Za-z\d@$!¡%*#?¿&()]{8,}$/.test(pass1)){
                    //Comprobamos que las contraseñas coincidan
                    if(pass1 != pass2){
                        //Si no coinciden, detenemos el evento submit
                        event.preventDefault();
                        $('#errorMsgUser > span').text('Las contraseñas no coinciden');
                        if($('#errorMsgUser').css('display') == 'none')
                            $('#errorMsgUser').slideDown(450);
                        $('#userPass1').css('border', '1.5px solid red');
                        $('#userPass2').css('border', '1.5px solid red');
                    }else{
                        $('#userPass1').css('border', '1px solid gray');
                        $('#userPass2').css('border', '1px solid gray');
                        var route = formRoute;
                        $.ajax({
                            url: route,
                            type: 'post',
                            data: {
                                "_token": token,
                                'SName': $('input[name="SName"]').val(),
                                'UName': $('input[name="UName"]').val(),
                                'PName': $('input[name="PName"]').val(),
                                'BDName': $('input[name="BDName"]').val(),
                                'Sys': $('input[name="Sys"]').val(),
                                'Name': $('input[name="Name"]').val(),
                                'Pass': $('input[name="Pass"]').val(),
                            },
                            success: function(result){
                                if(result['satus']){
                                    $('#submitButton').click();
                                }else{
                                    $('#controllerError').fadeIn(700);
                                }
                            }
                        });
                    }
                //Si la contraseña no cumple los requisítos mínimos, detenemos el submit
                }else{
                    event.preventDefault();
                    $('#errorMsgUser > span').text('La contraseña debe incluir 8 caracteres con mayúsculas, minúsculas, números y caracteres especiales');
                    if($('#errorMsgUser').css('display') == 'none')
                        $('#errorMsgUser').slideDown(450);
                    $('#userPass1').css('border', '1.5px solid red');
                    $('#userPass2').css('border', '1.5px solid red');
                }
            }
            
        //Si hay algún campo vacío, detenemos el submit
        }else{
            event.preventDefault();
            $('#errorMsgUser > span').text('Por favor, rellene todos los campos');
            if($('#errorMsgUser').css('display') == 'none') $('#errorMsgUser').slideDown(500);
            if(name == "") $('#userName').css('border', '1.5px solid red'); else $('#userName').css('border', '1px solid gray');
            if(DBname == "") $('#bName').css('border', '1.5px solid red'); else $('#bName').css('border', '1px solid gray');
            if(pass1 == "") $('#userPass1').css('border', '1.5px solid red'); else $('#userPass1').css('border', '1px solid gray');
            if(pass2 == "") $('#userPass2').css('border', '1.5px solid red'); else $('#userPass2').css('border', '1px solid gray');
            if($('#radioWindows').prop('checked') == false && $('#radioLinux').prop('checked') == false) $('#radio').css('border', '1.5px solid red'); else $('#radio').css('border', '1px solid gray');
             
        }
    });

});