$().ready(function(){
    $('#installForm').submit(function(event){
        var name = document.getElementById('userName').value;
        var pass1 = document.getElementById("userPass1").value;
        var pass2 = document.getElementById("userPass2").value;
        
        
        //Comprobamos que todos los campos estén rellenos
        if(name != "" && pass1 != "" && pass2 != ""){
            var test = (/^[A-Za-z0-9Ññ]+$/.test(name));
            console.log(test);
            //Si el nombre de usuario no cumple los requisitos
            if(!test){
                event.preventDefault();
                $('#errorMsgUser > span').text('El nombre de usuario solo puede contener mayúsculas, minúsculas y números');
                $('#userName').css('border', '1.5px solid red');
            }else{
                $('#userName').css('border', '1px solid black');
                //Comprobamos que la contraseña cumpla los requisitos mínimos
                if(/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&()])[A-Za-z\d@$!%*#?&]{8,}$/.test(pass1)){
                    //Comprobamos que las contraseñas coincidan
                    if(pass1 != pass2){
                        //Si no coinciden, detenemos el evento submit
                        event.preventDefault();
                        $('#errorMsgUser > span').text('Las contraseñas no coinciden');
                        $('#userPass1').css('border', '1.5px solid red');
                        $('#userPass2').css('border', '1.5px solid red');
                    }else{
                        $('#userPass1').css('border', '1px solid black');
                        $('#userPass2').css('border', '1px solid black');
                    }
                //Si la contraseña no cumple los requisítos mínimos, detenemos el submit
                }else{
                    event.preventDefault();
                    $('#errorMsgUser > span').text('La contraseña debe incluir 8 caracteres con mayúsculas, minúsculas, números y caracteres especiales');
                    $('#userPass1').css('border', '1.5px solid red');
                    $('#userPass2').css('border', '1.5px solid red');
                }
            }
            
        //Si hay algún campo vacío, detenemos el submit
        }else{
            event.preventDefault();
            $('#errorMsgUser > span').text('Por favor, rellene todos los campos');
            if(name == "") $('#userName').css('border', '1.5px solid red'); else $('#userName').css('border', '1px solid black');
            if(pass1 == "") $('#userPass1').css('border', '1.5px solid red'); else $('#userPass1').css('border', '1px solid black');
            if(pass2 == "") $('#userPass2').css('border', '1.5px solid red'); else $('#userPass2').css('border', '1px solid black');
        }
    });
});