var modify = false;
var actId = 0;

$().ready(function(){
    $('.icon').on('load', function(){
        var t = $(this).attr('tp') / $('#addScene').innerHeight();
        var l = $(this).attr('lft') / $('#addScene').innerWidth();
        $(this).css('top', t + '%');
        $(this).css('left', l + '%');
        alert($(this).css('top'));
        alert($(this).css('left'));
    });

    $(".scenepoint").hover(function(){
        modify = true;
        $(this).attr('src', $('#urlhover').val());
    }, function(){
        if(!($(this).hasClass('selected'))){
            $(this).attr('src', $('#url').val());
        }
        modify = false;
    });

    /*FUNCION PARA MODIFICAR LA INFORMACIÓN DE UNA ESCENA*/
    $('.scenepoint').mouseup(function(){
        $('.scenepoint').attr('src', $('#url').val());
        $('.scenepoint').removeClass('selected');
        $(this).addClass('selected');
        //Recojo el id del punto al que se ha hecho click
        var pointId = $(this).attr('id');
        //Escondo el punto que se muestra al hacer click en la capa de la zona
        $('#zoneicon').css('display', 'none');
        //Saco el id de la escena que corresponde a ese punto
        var sceneId = parseInt(pointId.substr(5));
        $('#editActualScene').attr('value', sceneId);
        var formAction = routeUpdate.replace('req_id', sceneId);
        $('#formUpdateScene').attr('action', formAction);
        $('#actualScene').attr('value', sceneId);
        sceneInfo(sceneId).done(function(result){
            $('#updateSceneName').val(result.name);
            $('#sceneId').val(result.id);
            $('#topUpdate').attr('value', result.top);
            $('#leftUpdate').attr('value', result.left);
            $('#menuModalAddScene').hide();
            $('.menuModalUpdateScene').css('display', 'block');
        });

        /* SACAR LA INFO DE LAS ESCENAS SECUNDARIAS */
        s_sceneInfo(sceneId).done(function(result){
            var div = document.getElementById('infosscene');
            while (div.firstChild) {
                div.removeChild(div.firstChild);
            }
            //Recorrer todas las escenas secundarias
            for(var i=0; i<result.length; i++){
                var url = routeEditSecondart.replace("id", result[i].id);
                $('#infosscene').append(
                    "<div class='col33 mPadding'>"+
                        "<span class='titlePreviewSS col100'>"+result[i].name+"</span>"+
                        "<span class='datePreviewSS col100'>"+result[i].date+"</span>"+
                        `<div id="previewSS`+result[i].id+`" class="previewSS col100 relative" style="height:170px">
                            <div id="pano" class="relative l1"></div>
                        </div>`+
                        "<button id="+result[i].id+" class='delete sMarginTop'>Eliminar</button>"+
                        "<button id="+result[i].id+" class='update right sMarginTop sMarginLeft'>Modificar</button>"+
                        "<a href='"+url+"'><button class='bBlack right sMarginTop'>Hotspots</button></a>"+
                    "</div>");
                //Llamada al metodo para mostrar la preview
                loadScenePreview(result[i], "previewSS"+result[i].id);
            }
            //Si no hay resultados
            if(result.length==0){
                $('#infosscene').append(`
                    <span class="col100 centerT xlMarginTop">No hay escenas secundarias</span>
                `);
            }

            $(".delete").click(function(){
                elementoD = $(this);
                id=elementoD.attr("id");
                $('#confirmDelete').css('width', '20%');
                $('#modalWindow').show();
                $('#modalWindow:nth-child(2)').css('display', 'none');
                $('#confirmDelete').show();
                $("#aceptDelete").click(function(){
                    $("#confirmDelete").css("display", "none");
                    $("#modalWindow").css("display", "none"); 
                    $.get(direccion+'/secondaryscenes/delete/'+id, function(respuesta){
                    $(elementoD).parent().remove();
                    $('.previewResource').empty();
                });
                });
                $("#cancelDelete").click(function(){
                    $('#modalWindow').hide();
                    $('#Sscene').hide();
                    $('#upSscene').hide();
                    $('#confirmDelete').hide();
                });
            });
            $(".update").click(open_update);
        });
        /*FUNCIÓN PARA ELIMINAR PUNTO Y ESCENA*/
        $('#deleteScene').click(function(){
            //Recupero el id de la escena para hacer las comprobaciones
            var sceneId = $('#editActualScene').attr('value');
            //Compruebo que la escena no tenga hotspots
            checkHotspot(sceneId).done(function(result){
                //Si no tiene hotspots
                if(result['num'] == 0){
                    //Compruebo que no tenga escenas secundarias
                    checkSecondaryScenes(sceneId).done(function(result){
                        //si no tiene escenas secundarias
                        if(result['num'] == 0){
                            //Modifico el tamaño de la modal a mostrar
                            $('#confirmDelete').css('width', '20%');
                            $('#modalWindow').show();
                            $('#modalWindow:nth-child(2)').css('display', 'none');
                            //Muestro la modal de confirmación
                            $('#confirmDelete').show();
                            //Click del botón de aceptar borrar escena
                            $('#aceptDelete').click(function(){
                                //Ejecuto la función de eliminar escena
                                deleteScenePoint($('#sceneId').val()).done(function(result){
                                    //Escondo la modal
                                    $('#modalWindow').hide();
                                    $('#confirmDelete').hide();
                                    //Si se ha borrado correctamente
                                    if(result){
                                        //Vacío la capa donde se muestra la previsualización de la escena eliminada
                                        $('#pano').empty();
                                        //Escondo el punto de la escena eliminada
                                        $('#scene'+ $('#sceneId').val()).hide();
                                        //Escondo el menú de modificación de escena
                                        $('.menuModalUpdateScene').css('display', 'none');
                                    }
                                });
                            });
                            $('#cancelDelete').click(function(){
                                $('#modalWindow').hide();
                                $('#Sscene').hide();
                                $('#upSscene').hide();
                                $('#confirmDelete').hide();
                            });
                        //Si tiene escenas secundarias
                        }else{
                            //Ajusto el tamaño de la modal de información y la muestro
                            $('#cancelDeleteSs').css('width', '40%');
                            $('#modalWindow').css('display', 'block');
                            $('#cancelDeleteSs').css('display', 'block');
                        }
                    });
                //Si tiene hotspots
                }else{
                    //Ajusto el tamaño de la modal de información y la muestro
                    $('#cancelDeleteHotspots').css('width', '40%');
                    $('#modalWindow').css('display', 'block');
                    $('#cancelDeleteHotspots').css('display', 'block');
                }
            });
        });

        //Click del botón Aceptar de las modales de información
        $('#aceptCondition').click(function(){
            $('#modalWindow').hide();
            $('#cancelDeleteSs').hide();
            $('#cancelDeleteHotspots').hide();
        });


        /* CERRAR VENTANA DE UPDATE */
        $('#closeMenuUpdateScene').click(function(){
            $('.menuModalUpdateScene').hide();
        });

        $('.closeModal').click(function(){
            $('#modalWindow').hide();
            $('#Sscene').hide();
            $('#upSscene').hide();
            $('#confirmDelete').hide();
        });
    });

    $('#editActualScene').click(function(){
        window.location.href = routeEdit.replace('id', $(this).attr('value'));
    });

    //------------------------------------------------------------------------------------

    /**
     * FUNCIÓN PARA AÑADIR PUNTO 
     */
    $('#addScene').click(function(e){
        //Compruebo que no haya ya un icono puesto
        var iconoDisplay = $('#zoneicon').css('display');
        //Si no hay un icono, lo 'coloco'
        if(iconoDisplay == 'none' && !modify){
            $('.scenepoint').removeClass('selected');
            $('.scenepoint').attr('src', $('#url').val());
            var capa = document.getElementById("addScene");
            var posicion = capa.getBoundingClientRect();
            var mousex = e.clientX;
            var mousey = e.clientY;
            var alto = (mousey - posicion.top); //posición en píxeles
            var ancho = (mousex - posicion.left); //posición en píxeles
            var top = ((alto * 100) / ($('#zoneimg').innerHeight()) -1.55 );
            var left = ((ancho * 100) / ($('#zoneimg').innerWidth()) -1.1 );
            $('#zoneicon').css('top' , top + "%");
            $('#zoneicon').css('left', left + "%");
            $('#zoneicon').css('display', 'block');
            $('#top').attr('value', top);
            $('#left').attr('value', left);
            $('.menuModalUpdateScene').css('display', 'none');
            $('#menuModalAddScene').css('display', 'block');
        }else{
            //Si ya hay un icono, lo muevo
            var capa = document.getElementById("addScene");
            var posicion = capa.getBoundingClientRect();
            var mousex = e.clientX;
            var mousey = e.clientY;
            var alto = (mousey - posicion.top); //posición en píxeles
            var ancho = (mousex - posicion.left); //posición en píxeles
            var top = ((alto * 100) / ($('#zoneimg').innerHeight()) -1.55 );
            var left = ((ancho * 100) / ($('#zoneimg').innerWidth()) -1.1 );
            $('#zoneicon').css('top' , top + "%");
            $('#zoneicon').css('left', left + "%");
            $('#top').attr('value', top);
            $('#left').attr('value', left);
        }
    });

    //VALIDACIÓN DE FORMULARIO DE MODIFICAR ZONA ANTES DEL SUBMIT
    $('#editZoneForm').submit(function(event){
        var name = document.getElementById('zoneName').value;
        var image = document.getElementById('zoneImage');
        //Comprobamos que el nobre no esté vacío
        if(name != ""){
            //Comprobamos que el nombre solo contenga letras, numeros y espacios en blanco
            var test = (/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]+$/.test(name));
            console.log(test);
            if(!test){
                event.preventDefault();
                $('#errorMessagge > span').text('El nombre solo puede contener letras, números y espacios');
                $('#zoneName').css('border', '1.5px solid red');
            //Si el nombre pasa las comprobaciones, comprobamos que se haya seleccionado una imagen
            }else{
                //Si se ha seleccionado una imagen, se comprueba que sea correcta
                if(image.value != "" || image.value != null || image.value != undefined){
                    var name = image.files[0].name;
                    var pointPosition = name.indexOf('.');
                    var extension = name.substr(pointPosition);
                    if(extension != ".jpg" && extension != ".JPG" && extension != ".png" && extension != ".jpeg"){
                        event.preventDefault()
                        $('#errorMessagge > span').text('Tiene que seleccionar un archivo válido de imagen');
                        $('#zoneName').css('border', '1px solid black');
                    }else{
                        $('#loadUploadScene').show();
                    }
                }
            }
        //Si el nombre estuviese vacío, se detiene el evento submit y se lanza un mensaje de error
        }else{
            event.preventDefault();
            $('#errorMessagge > span').text('Por favor, rellene todos los campos');
            $('#zoneName').css('border', '1.5px solid red');
        }
    });

    //VALIDACIÓN DE FORMULARIO DE AÑADIR ESCENA ANTES DEL SUBMIT
    $('#formAddScene').submit(function(event){
        var name = document.getElementById('newSceneName').value;
        var image = document.getElementById('newSceneImg');
        //Comprobamos que el nobre no esté vacío
        if(name != ""){
            //Comprobamos que el nombre solo contenga letras, numeros y espacios en blanco
            var test = (/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]+$/.test(name));
            console.log(test);
            if(!test){
                event.preventDefault();
                $('#errorMessaggeNewScene > span').text('El nombre solo puede contener letras, números y espacios');
                $('#newSceneName').css('border', '1.5px solid red');
            //Si el nombre pasa las comprobaciones, comprobamos que se haya seleccionado una imagen
            }else{
                //Si se ha seleccionado una imagen, se comprueba que sea correcta
                if(image.value != "" || image.value != null || image.value != undefined){
                    var name = image.files[0].name;
                    var pointPosition = name.indexOf('.');
                    var extension = name.substr(pointPosition);
                    if(extension != ".jpg" && extension != ".JPG" && extension != ".png" && extension != ".jpeg"){
                        event.preventDefault()
                        $('#errorMessaggeNewScene > span').text('Tiene que seleccionar un archivo válido de imagen');
                        $('#newSceneName').css('border', '1px solid black');
                    }else{
                        $('#loadUploadScene').show();
                    }
                //si no se ha seleccionado ninguna imagen, se detiene el submit
                }else{
                    event.preventDefault();
                    $('#errorMessaggeNewScene > span').text('Tiene que seleccionar una imagen');
                    $('#newSceneName').css('border', '1px solid black');
                }
            }
        //Si el nombre estuviese vacío, se detiene el evento submit y se lanza un mensaje de error
        }else{
            event.preventDefault();
            $('#errorMessaggeNewScene > span').text('Por favor, rellene todos los campos');
            $('#newSceneName').css('border', '1.5px solid red');
        }
    });

    //VALIDACIÓN DE FORMULARIO DE MODIFICAR ESCENA ANTES DEL SUBMIT
    $('#formUpdateScene').submit(function(event){
        var name = document.getElementById('updateSceneName').value;
        var image = document.getElementById('updateSceneImg');
        //Comprobamos que el nobre no esté vacío
        if(name != ""){
            //Comprobamos que el nombre solo contenga letras, numeros y espacios en blanco
            var test = (/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]+$/.test(name));
            if(!test){
                event.preventDefault();
                $('#errorMessaggeUpdateScene > span').text('El nombre solo puede contener letras, números y espacios');
                $('#updateSceneName').css('border', '1.5px solid red');
            //Si el nombre pasa las comprobaciones, comprobamos que se haya seleccionado una imagen
            }else{
                //Si se ha seleccionado una imagen, se comprueba que sea correcta
                if(image.value != "" || image.value != null || image.value != undefined){
                    var name = image.files[0].name;
                    var pointPosition = name.indexOf('.');
                    var extension = name.substr(pointPosition);
                    if(extension != ".jpg" && extension != ".JPG" && extension != ".png" && extension != ".jpeg"){
                        event.preventDefault()
                        $('#errorMessaggeUpdateScene > span').text('Tiene que seleccionar un archivo válido de imagen');
                        $('#updateSceneName').css('border', '1px solid black');
                    }else{
                        $("#formUpdateSceneContainer").hide();
                        $('#loadUploadSceneUpdate').show();
                    }
                }else{
                    $("#formUpdateSceneContainer").hide();
                    $('#loadUploadSceneUpdate').show();
                }
            }
        //Si el nombre estuviese vacío, se detiene el evento submit y se lanza un mensaje de error
        }else{
            event.preventDefault();
            $('#errorMessaggeUpdateScene > span').text('Por favor, rellene todos los campos');
            $('#updateSceneName').css('border', '1.5px solid red');
        }
    });

    //VALIDACIÓN DEL FORMULARIO DE AÑADIR ESCENA SECUNDARIA ANTES DEL SUBMIT
    $('#añadirSceneS').submit(function(event){
        var name = document.getElementById('newSecondarySceneName').value;
        var date = document.getElementById('newSecondarySceneDate').value;
        var image = document.getElementById('newSecondarySceneImg');
        //Comprobamos que el nobre no esté vacío
        if(name != "" && date != ""){
            //Comprobamos que el nombre solo contenga letras, numeros y espacios en blanco
            var test = (/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]+$/.test(name));
            if(!test){
                event.preventDefault();
                $('#errorMessageNewSecondaryScene > span').text('El nombre solo puede contener letras, números y espacios');
                $('#newSecondarySceneName').css('border', '1.5px solid red');
                $('#newSecondarySceneDate').css('border', '1px solid black');
            //Si el nombre pasa las comprobaciones, comprobamos que la fecha sea correcta
            }else{
                var testDate = (/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/.test(date));
                if(!testDate){
                    event.preventDefault();
                    $('#errorMessageNewSecondaryScene > span').text('Por favor, escriba una fecha válida');
                    $('#newSecondarySceneName').css('border', '1px solid black');
                    $('#newSecondarySceneDate').css('border', '1.5px solid red');
                }else{
                    //Si se ha seleccionado una imagen, se comprueba que sea correcta
                    if(image.value != "" || image.value != null || image.value != undefined){
                        var name = image.files[0].name;
                        var pointPosition = name.indexOf('.');
                        var extension = name.substr(pointPosition);
                        if(extension != ".jpg" && extension != ".JPG" && extension != ".png" && extension != ".jpeg"){
                            event.preventDefault()
                            $('#errorMessageNewSecondaryScene > span').text('Tiene que seleccionar un archivo válido de imagen');
                            $('#newSecondarySceneName').css('border', '1px solid black');
                            $('#newSecondarySceneDate').css('border', '1px solid black');
                        }
                    //si no se ha seleccionado ninguna imagen, se detiene el submit
                    }else{
                        event.preventDefault();
                        $('#errorMessageNewSecondaryScene > span').text('Tiene que seleccionar una imagen');
                        $('#newSecondarySceneName').css('border', '1px solid black');
                        $('#newSecondarySceneDate').css('border', '1px solid black');
                    }
                }
            }
        //Si el nombre estuviese vacío, se detiene el evento submit y se lanza un mensaje de error
        }else{
            event.preventDefault();
            $('#errorMessageNewSecondaryScene > span').text('Por favor, rellene todos los campos');
            if(name == "") $('#newSecondarySceneName').css('border', '1.5px solid red'); else $('#newSecondarySceneName').css('border', '1px solid black');
            if(date == "") $('#newSecondarySceneDate').css('border', '1.5px solid red'); else $('#newSecondarySceneDate').css('border', '1px solid black');
        }
    });

    //VALIDACIÓN DEL FORMULARIO DE MODIFICAR ESCENA SECUNDARIA ANTES DEL SUBMIT
    //AÚN ES LA COPIA DEL DE ARRIBA!!!
    $('#updateSceneS').submit(function(event){
        var name = document.getElementById('upSceneName').value;
        var date = document.getElementById('upSceneDate').value;
        var image = document.getElementById('updateSecondarySceneImg');
        //Comprobamos que el nobre no esté vacío
        if(name != "" && date != ""){
            //Comprobamos que el nombre solo contenga letras, numeros y espacios en blanco
            var test = (/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]+$/.test(name));
            if(!test){
                event.preventDefault();
                $('#errorMessageUpdateSecondaryScene > span').text('El nombre solo puede contener letras, números y espacios');
                $('#upSceneName').css('border', '1.5px solid red');
                $('#upSceneDate').css('border', '1px solid black');
            //Si el nombre pasa las comprobaciones, comprobamos que la fecha sea correcta
            }else{
                var testDate = (/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/.test(date));
                if(!testDate){
                    console.log('fecha mal');
                    event.preventDefault();
                    $('#errorMessageUpdateSecondaryScene > span').text('Por favor, escriba una fecha válida');
                    $('#upSceneName').css('border', '1px solid black');
                    $('#upSceneDate').css('border', '1.5px solid red');
                }else{
                    //Si se ha seleccionado una imagen, se comprueba que sea correcta
                    if(image.value != "" || image.value != null || image.value != undefined){
                        var name = image.files[0].name;
                        var pointPosition = name.indexOf('.');
                        var extension = name.substr(pointPosition);
                        if(extension != ".jpg" && extension != ".JPG" && extension != ".png" && extension != ".jpeg"){
                            event.preventDefault()
                            $('#errorMessageUpdateSecondaryScene > span').text('Tiene que seleccionar un archivo válido de imagen');
                            $('#upSceneName').css('border', '1px solid black');
                            $('#upSceneDate').css('border', '1px solid black');
                        }
                    }
                }
            }
        //Si el nombre estuviese vacío, se detiene el evento submit y se lanza un mensaje de error
        }else{
            event.preventDefault();
            $('#errorMessageUpdateSecondaryScene > span').text('Por favor, rellene todos los campos');
            if(name == "") $('#upSceneName').css('border', '1.5px solid red'); else $('#newSecondarySceneName').css('border', '1px solid black');
            if(date == "") $('#upSceneDate').css('border', '1.5px solid red'); else $('#newSecondarySceneDate').css('border', '1px solid black');
        }
    });

    //CÓDIGO PARA QUE LAS MODALES SE CIERREN AL PINCHAR FUERA DE ELLAS
    var dentro = false;
    $('.window').on({
        mouseenter: function(){
            dentro = true;
        },
        mouseleave: function(){
            dentro = false;
        }
    });
    $('#modalWindow').click(function(){
        if(!dentro){
            $('#modalWindow, .window').hide();
        }
    });


});

    //------------------------------------------------------------------------------------

    /**
     * FUNCIÓN PARA ABRIR LA MODAL DE MODIFICAR ESCENA SECUNDARIA
     */
    function open_update(){
        var s_scenId = $(this).attr('id');
        seconInfo(s_scenId).done(function(result){
            $('#upSceneName').val(result.name);
            $('#upSceneDate').val(result.date);
            $('#ids').val(s_scenId);
        }).fail(function(){
            // alert("Hay un problema ");
        });
        $("#modalWindow").css("display", "block");
        $("#upSscene").css("display", "block");
    }

    //------------------------------------------------------------------------------------

    /**
     * METODO PARA PREVISUALIZAR UNA ESCENA SECUNDARIA
     */
    function loadScenePreview(sceneDestination, containerPreview){     
        'use strict';
        //1. VISOR DE IMAGENES
        var parent = document.getElementById(containerPreview);
        var panoElement = parent.firstElementChild;

        /* Progresive controla que los niveles de resolución se cargan en orden, de menor 
        a mayor, para conseguir una carga mas fluida. */
        var viewer =  new Marzipano.Viewer(panoElement, {stage: {progressive: true}}); 

        //2. RECURSO
        var source = Marzipano.ImageUrlSource.fromString(
            marzipanoTiles.replace('dn', sceneDestination.directory_name),
        //Establecer imagen de previsualizacion para optimizar su carga 
        //(bdflru para establecer el orden de la capas de la imagen de preview)
        {cubeMapPreviewUrl: marzipanoPreview.replace('dn', sceneDestination.directory_name), 
        cubeMapPreviewFaceOrder: 'lfrbud'});

        //3. GEOMETRIA 
        var geometry = new Marzipano.CubeGeometry([
        { tileSize: 256, size: 256, fallbackOnly: true  },
        { tileSize: 512, size: 512 },
        { tileSize: 512, size: 1024 },
        { tileSize: 512, size: 2048},
        ]);

        //4. VISTA
        //Limitadores de zoom min y max para vista vertical y horizontal
        var limiter = Marzipano.util.compose(
            Marzipano.RectilinearView.limit.vfov(0.698131111111111, 2.09439333333333),
            Marzipano.RectilinearView.limit.hfov(0.698131111111111, 2.09439333333333)
        );
        //Establecer estado inicial de la vista con el primer parametro
        var view = new Marzipano.RectilinearView({yaw: sceneDestination.yaw, pitch: sceneDestination.pitch, roll: 0, fov: Math.PI}, limiter);

        //5. ESCENA SOBRE EL VISOR
        var scene = viewer.createScene({
        source: source,
        geometry: geometry,
        view: view,
        pinFirstLevel: true
        });

        //6.MOSTAR
        scene.switchTo({ transitionDuration: 1000 });
    }

