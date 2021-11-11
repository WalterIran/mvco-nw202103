<h1>{{mode_dsc}}</h1>
<section>
  {{if isDEL}}
  <div class="alert alert-warning d-flex align-items-center" role="alert">
    <div>
      <i class="bi bi-exclamation-triangle"></i>
      ¡Advertencia!
      <br>
      Está a punto de eliminar un rol de que podría estar ligado un usuario
    </div>
  </div>
  {{endif isDEL}}
  <form action="index.php?page=mnt_rol&mode={{mode}}&rolescod={{rolescod}}"
    method="POST" >
    <section class="my-2">
    <label class="me-2" for="rolescod">Código del Rol</label>
    <input type="hidden" id="rolescod" name="rolescod" value="{{rolescod}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
    <input type="text" {{readonly}} {{ifnot isINS}}readonly{{endifnot isINS}} name="rolescoddummy" value="{{rolescod}}"/>
    </section>
    <section class="my-2">
      <label class="me-2" for="rolesdsc">Descripción del Rol</label>
      <input type="text" {{readonly}} name="rolesdsc" value="{{rolesdsc}}" maxlength="45" placeholder="Descripcion del rol"/>
    </section>
    <section class="my-2">
      <label class="me-2" for="rolesest">Estado del Rol</label>
      {{if readonly}}
      <input type="hidden" id="rolesestdummy" name="rolesest" value=""/>
      {{endif readonly}}
      <select id="rolesest" name="rolesest" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{rolesest_ACT}}>Activo</option>
        <option value="INA" {{rolesest_INA}}>Inactivo</option>
      </select>
    </section>

    {{if readonly}}
    <section class="border my-2">
      <p class="fw-bolder">Funciones del Rol</p>
      <ul>
        {{foreach rolesfunction}}
        <li> {{fncod}}</li>
        {{endfor rolesfunction}}
      </ul>
    </section>
  {{endif readonly}}

  {{ifnot readonly}}
  {{ifnot isINS}}
  
    <section>
        <table class="table table-bordered">
          <thead>
            <tr class="table-dark">
              <th colspan="3">Funciones de Rol</th>
            </tr>
            <tr class="table-light">
              <th>Listado de Funciones</th>
              <th>Mover</th>
              <th>Funciones Aasignados</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <select class="form-select" multiple aria-label="Listado de Funciones" name="listfun" id="listfun">
                  {{foreach avafun}}
                  <option value="{{fncod}}">{{fncod}}</option>
                  {{endfor avafun}}
                </select>
              </td>
              <td class="d-flex flex-column justify-content-center">
                <button type="button" id="move_right" class="btn btn-success">>></button>
                <br>
                <button type="button" id="move_left" class="btn btn-warning"><<</button>
              </td>
              <td>
                <input type="hidden" id="FunctionAssignRoles" name="FunctionAssignRoles" value="">
                <select class="form-select" multiple aria-label="Listado de Funciones" name="funroles" id="funroles">
                  {{foreach rolesfunction}}
                  <option value="{{fncod}}">{{fncod}}</option>
                  {{endfor rolesfunction}}
                </select>
              </td>
            </tr>
          </tbody>
        </table>
    </section>
    {{endifnot isINS}}
    {{endifnot readonly}}
    

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
    let rolesArr;
    let rolesInput;
    try {
      
      rolesArr = document.getElementById("funroles");
      rolesInput = document.getElementById("FunctionAssignRoles");
      rolesArr = Array.apply(null, rolesArr.options);
      rolesArr = rolesArr.map((opt) => opt.value);
      rolesInput.value = rolesArr.join(",");
    } catch (error) {
      
    }
    
      document.getElementById("btnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_roles");
      });
      
      
      document.getElementById("move_right").addEventListener("click", function(e){
        e.preventDefault();
        listbox_moveacross("listfun","funroles");
      });
      document.getElementById("move_left").addEventListener("click", function(e){
        e.preventDefault();
        listbox_moveacross("funroles","listfun")
      });
      function listbox_moveacross(sourceID, destID) {
        var src = document.getElementById(sourceID);
        var dest = document.getElementById(destID);
        for(var count=0; count < src.options.length; count++) {
          if(src.options[count].selected == true) {
              var option = src.options[count];
              var newOption = document.createElement("option");
              newOption.value = option.value;
              newOption.text = option.text;
              newOption.selected = true;
              if(destID === 'funroles'){
                rolesArr.push(option.value);
              }else{
                let index = rolesArr.indexOf(option.value);
                rolesArr.splice(index,1);
              }
              rolesInput.value = rolesArr.join(",");
              try {
                  dest.add(newOption, null); /* Standard */
                  src.remove(count, null);
              }catch(error) {
                  dest.add(newOption);  /* IE only */
                  src.remove(count);
              }
              count--;
          }
        }
      }
      
  });
</script>
