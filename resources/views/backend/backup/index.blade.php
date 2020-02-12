@extends('layouts.backend')
@section('content')

   <!-- TITULO -->
   <div id="title" class="col80 xlMarginBottom">
      <span>BACKUP</span>
   </div>

   <!-- CONTENIDO -->
   <div id="content" class="col100 backupIndex">
      <span class="col100 xlMarginBottom">Crea y restaura copias de seguridad de todo el sistema</span>

      <div class="col50 centerH">
         <div class="optionBackup col60">
            <div id="downBackup">
               <a href="{{url('backup/create')}}">Crear una nueva copia de seguridad</a> 
            </div>
         </div>
      </div>

      <div class="col50 centerH">
         <div class="optionBackup col60">
            <div id="upBackup">
               <span>Test</span>
            </div>
         </div>   
      </div>

      <form method="POST" action={{route("backup.restore")}} style="display:none">
         @csrf
         <input type="file" name="nombre" value="">
         <input type="submit" name="cancel" value="Restaurar copia">
      </form>
   </div>

   <script>
      $( document ).ready(function() {
         $('#buton')
      });
   </script>

@endsection