$('#installForm').submit(function(event){
    var name = document.getElementById('userName').value;
    var pass1 = document.getElementById("userPass1").value;
    var pass2 = document.getElementById("userPass2").value;
    
    
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