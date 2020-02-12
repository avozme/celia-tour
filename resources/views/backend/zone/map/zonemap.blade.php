<!--
Vista a la que se llega a través de la función 'map' del ZoneController.
zone/{id}/zonemap
Muestra el mapa de la zona con las escenas que esta tenga.
El id de la escena se encuenta en el id de cada punto del mapa el cual
está formado de la siguiente forma: scene{id_scene}.
-->
 @if ($zones)
    <div id="changeZone" style="position: absolute">
    @foreach ($zones as $z)
        <div class="oneZone">
            <p>{{ $z->name }}</p>
            <img id="zone{{ $z->id }}" width="5%" src="{{ url('img/zones/images/'.$z->file_image) }}" alt="">
        </div>
        @if ($z->id == $firstZoneId)
            <div class="closeModalButton">
                <img src="{{ url('img/icons/close.png') }}" alt="close" width="100%">
            </div>
            <div id="ajaxZone">
                
            </div>
        <script>
            var route = "{{ route('zone.map', 'id') }}".replace('id', zoneId);
            $.ajax({
                url: route,
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success:function(result){                   
                    $('#ajaxZone'). append();
                },
                error:function() {
                    
                }
            });
        </script>
        @endif
    @endforeach
    </div>
 @else
    <div class="closeModalButton">
        <img src="{{ url('img/icons/close.png') }}" alt="close" width="100%">
    </div>
    <div id="addScene" >
        <div id="zoneicon" class="icon" style="display: none">
            <img class="." src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
        </div>
        @foreach ($scenes as $scene)
            <div class="icon" style="top: {{ $scene->top }}%; left: {{ $scene->left }}%;">
                <img id="scene{{ $scene->id }}" class="scenepoint" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
            </div>
        @endforeach
        <input id="url" type="hidden" value="{{ url('img/zones/icon-zone.png') }}">
        <input id="urlhover" type="hidden" value="{{ url('img/zones/icon-zone-hover.png') }}">
        <input id="actualZone{{ $zone->id}}" type="hidden">
        <img id="zoneimg" width="100%" src="{{ url('img/zones/images/'.$zone->file_image) }}" alt="">
    </div>
 @endif

