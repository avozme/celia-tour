<!--
Vista a la que se llega a través de la función 'map' del ZoneController.
zone/{id}/zonemap
Muestra el mapa de la zona con las escenas que esta tenga.
El id de la escena se encuenta en el id de cada punto del mapa el cual
está formado de la siguiente forma: scene{id_scene}.
-->

@isset($zones)
    
<div class="closeModalButton">
   <img src="{{ url('img/icons/close.png') }}" alt="close" width="100%">
</div>
   <div id="changeZone" style="position: absolute">
    <div id="buttonsFloorCont" class="col100 xlMarginBottom">
        <div id="floorUp">
            <svg width="100%" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	  viewBox="0 0 481.721 481.721" style="enable-background:new 0 0 481.721 481.721;"
	 xml:space="preserve">
<g>
	<g>
		<path d="M10.467,146.589l198.857,252.903c17.418,30.532,45.661,30.532,63.079,0l198.839-252.866
			c3.88-5.533,8.072-15.41,8.923-22.118c2.735-21.738,4.908-65.178-21.444-65.178H23.013c-26.353,0-24.192,43.416-21.463,65.147
			C2.395,131.185,6.587,141.051,10.467,146.589z"/>
	</g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>                         
        </div>
        <div id="floorDown">
            <svg width="100%" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 292.362 292.361" style="enable-background:new 0 0 292.362 292.361;"
	 xml:space="preserve">
<g>
	<path d="M286.935,197.287L159.028,69.381c-3.613-3.617-7.895-5.424-12.847-5.424s-9.233,1.807-12.85,5.424L5.424,197.287
		C1.807,200.904,0,205.186,0,210.134s1.807,9.233,5.424,12.847c3.621,3.617,7.902,5.425,12.85,5.425h255.813
		c4.949,0,9.233-1.808,12.848-5.425c3.613-3.613,5.427-7.898,5.427-12.847S290.548,200.904,286.935,197.287z"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
                          
        </div>
    </div>
   </div>
   <input id="totalZones" type="hidden" name="totalZones" value="{{ count($zones) }}">
   <input id="actualZone" type="hidden" value="{{ $firstZoneId }}">
   @php
       $i = 1;
   @endphp
   @foreach ($zones as $z)
       @if ($z->id == $firstZoneId)
       <div id="zone{{ $i }}" class="addScene" style="display: block">
       @else
       <div id="zone{{ $i }}" class="addScene" style="display: none">
       @endif
           <div id="zoneicon" class="icon zoneicon" style="display: none">
               <img class="." src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
           </div>
           @php
               $scenes = $z->scenes()->get();
           @endphp
           <input id="url" type="hidden" value="{{ url('img/zones/icon-zone.png') }}">
           <input id="urlhover" type="hidden" value="{{ url('img/zones/icon-zone-hover.png') }}">
           <div id="zoneImage">
                @if ($scenes != null)
                    @foreach ($scenes as $scene)
                        <div class="icon" style="top: {{ $scene->top }}%; left: {{ $scene->left }}%;">
                            <img id="scene{{ $scene->id }}" class="scenepoint" src="{{ url('img/zones/icon-zone.png') }}" alt="icon" width="100%" >
                        </div>
                    @endforeach
                @endif
               <img id="zoneimg" width="100%" src="{{ url('img/zones/images/'.$z->file_image) }}" alt="">
           </div>
       </div>
       @php
           $i++;
       @endphp
   @endforeach
@endisset

@isset($zone)
<div class="closeModalButton">
    <img src="{{ url('img/icons/close.png') }}" alt="close" width="100%">
</div>
<div id="addScene" class="addScene">
    <div id="zoneicon" class="icon zoneicon" style="display: none">
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
    
@endisset

