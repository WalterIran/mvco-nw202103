<h1>{{mode_dsc}}</h1>
<section>
  <form action="index.php?page=mnt_score&mode={{mode}}&scoreid={{scoreid}}"
    method="POST" >
    <section>
    <label for="scoreid">Código</label>
    <input type="hidden" id="scoreid" name="scoreid" value="{{scoreid}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
    <input type="text" readonly name="scriddummy" value="{{scoreid}}"/>
    </section>
    <section>
      <label for="scoredsc">Descripcion</label>
      <input type="text" {{readonly}} name="scoredsc" value="{{scoredsc}}" maxlength="45" placeholder="Descripcion"/>
    </section>

    <section>
      <label for="scoreauthor">Autor</label>
      <input type="text" {{readonly}} name="scoreauthor" value="{{scoreauthor}}" maxlength="45" placeholder="Autor"/>
    </section>

    <section>
      <label for="scoregenre">Genero</label>
      <input type="text" {{readonly}} name="scoregenre" value="{{scoregenre}}" maxlength="45" placeholder="Genero"/>
    </section>

    <section>
      <label for="scoreyear">Año</label>
      <input type="text" {{readonly}} name="scoreyear" value="{{scoreyear}}" maxlength="45" placeholder="Año"/>
    </section>

    <section>
      <label for="scoresales">Venta</label>
      <input type="text" {{readonly}} name="scoresales" value="{{scoresales}}" maxlength="45" placeholder="Precio Adquisicion"/>
    </section>

    <section>
      <label for="scoreprice">Precio</label>
      <input type="text" {{readonly}} name="scoreprice" value="{{scoreprice}}" maxlength="45" placeholder="Precio Venta"/>
    </section>
    <section>
      <label for="scoredocurl">URL</label>
      <input type="text" {{readonly}} name="scoredocurl" value="{{scoredocurl}}" maxlength="45" placeholder="URL"/>
    </section>
    


    <section>
      <label for="scoreest">Estado</label>
      {{if readonly}}
      <input type ="hidden" id="scoreestdum" name="scoreest" value=""/>
      {{endif readonly}}
      <select id="scoreest" name="scoreest" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{screst_ACT}}>Activo</option>
        <option value="INA" {{screst_INA}}>Inactivo</option>
        <option value="PLN" {{screst_PLN}}>Planificación</option>
      </select>
    </section>
    {{if hasErrors}}
        <section>
          <ul>
            {{foreach aErrors}}
                <li>{{this}}</li>
            {{endfor aErrors}}
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
        window.location.assign("index.php?page=mnt_scores");
      });
  });
</script>
