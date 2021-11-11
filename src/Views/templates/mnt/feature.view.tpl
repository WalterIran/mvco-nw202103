<h1>{{mode_dsc}}</h1>
<section>
  <form action="index.php?page=mnt_feature&mode={{mode}}&fncod={{fncod}}"
    method="POST" >
    <section class="my-2">
    <label class="me-2" for="fncod">Código de Funcion</label>
    <input type="hidden" id="fncod" name="fncod" value="{{fncod}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
    <input type="text" {{readonly}} {{ifnot isINS}}readonly{{endifnot isINS}} name="funcoddummy" value="{{fncod}}"/>
    </section>
    <section class="my-2">
      <label class="me-2" for="fndsc">Descripción de la Funcion</label>
      <input type="text" {{readonly}} name="fndsc" value="{{fndsc}}" maxlength="45" placeholder="Descripcion de la Funcion"/>
    </section>
    <section class="my-2">
      <label class="me-2" for="fnest">Estado de la Funcion </label>
      {{if readonly}}
      <input type="hidden" id="funestdummy" name="fnest" value=""/>
      {{endif readonly}}
      <select id="fnest" name="fnest" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{fnest_ACT}}>Activo</option>
        <option value="INA" {{fnest_INA}}>Inactivo</option>
      </select>
    </section>

    

    <section class="my-2">
        <label class="me-2" for ="fntyp"> Tipo</label>
        {{if readonly}}
      <input type="hidden" id="funtypdummy" name="fntyp" value=""/>
      {{endif readonly}}
      <select id="fntyp" name="fntyp" {{if readonly}}disabled{{endif readonly}}>
        <option value="CRT" {{fntyp_CRT}}>CRT</option>
        <option value="PCR" {{fntyp_PCR}}>PCR</option>
      </select>

    </section>

      {{if hasErrors}}
        <section>
          <ul>
            {{foreach Errors}}
                <li>{{this}}</li>
            {{endfor Errors}}
          </ul>
        </section>
    {{endif hasErrors}}
    <section>
      {{if showaction}}
      <button type="submit" name="btnGuardar" value="G">Guardar</button>
      {{endif showaction}}
      <button type="button" id="btnCancelar">Cancelar</button>
    </section>
  </form>
</section>


<script>
  document.addEventListener("DOMContentLoaded", function(){
      document.getElementById("btnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_features");
      });
  });
</script>
