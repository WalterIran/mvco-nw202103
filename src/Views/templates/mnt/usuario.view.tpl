<h1>{{mode_dsc}}</h1>
<section>
  <form action="index.php?page=mnt_usuario&mode={{mode}}&usercod={{usercod}}"
    method="POST" >
    <section class="my-2">
        <label for='usercod' class="me-2">ID</label>
        <input type="hidden" id='usercod' name='usercod' value="{{usercod}}"/>
        <input type="hidden" id="mode" name="mode" value="{{mode}}">
        <input type="text" readonly name='usercoddummy' value="{{usercod}}"/>
    </section>
    <section class="my-2">
        <label for='useremail' class="me-2">Correo</label>
        <input type="email" {{readonly}} name='useremail' value="{{useremail}}" maxlength="45" placeholder='Correo electrónico'/>
    </section>
    <section class="my-2">
        <label for='username' class="me-2">Nombre de usuario</label>
        <input type="text" {{readonly}} name='username' value="{{username}}" maxlength="45" placeholder='Nombre de usuario'/>
    </section>
    {{if readonly}}
    <section class="my-2">
        <label class="me-2" for='userfching'>Fecha de creación</label>
        <input type="datetime-local" {{readonly}} name='userfching' value="{{userfching}}"/>
    </section>
    {{endif readonly}}
    {{ifnot readonly}}<!-- If not DSP mode then show -->
    {{ifnot chgpswd}} <!-- If INS mode hide change password checkbox | Always show password and repeat password -->
    <section class="form-check my-2">
      <input class="form-check-input" type="checkbox" id="chgPswd" name="chgPswd">
      <label class="me-2" class="form-check-label" for="chgPswd">
        Cambiar contraseña
      </label>
    </section>
    {{endifnot chgpswd}}
    <div id="pswd_field" {{ifnot chgpswd}}class="d-none"{{endifnot chgpswd}}>
      <section class="my-2">
        <label class="me-2" for='userpswd'>Contraseña</label>
        <input type="password" {{readonly}} name='userpswd' value="" maxlength="45" placeholder='Contraseña'/>
      </section>
      <section class="my-2">
        <label class="me-2" for='userpswdrpt'>Repetir Contraseña</label>
        <input type="password" {{readonly}} name='userpswdrpt' value="" placeholder='Repetir Contraseña'/>
      </section>
    </div>
    {{endifnot readonly}}
    <section class="my-2">
        <label class="me-2" for='userpswdest'>Estado de la contraseña</label>
        {{if readonly}}
        <input type="hidden" {{readonly}} name='userpswdestDummy' value="" />
        {{endif readonly}}
        <select name="userpswdest" id="userpswdest" {{if readonly}}disabled{{endif readonly}} >
          <option value="ACT" {{userpswdest_ACT}}>Activo</option>
          <option value="INA" {{userpswdest_INA}}>Inactivo</option>
          <option value="SUS" {{userpswdest_SUS}}>Suspendido</option>
          <option value="BLQ" {{userpswdest_BLQ}}>Bloqueado</option>
        </select>
    </section>
    <section class="my-2">
        <label class="me-2" for='userpswdexp'>Fecha de expiración de contraseña</label>
        <input type="datetime-local" {{readonly}} name='userpswdexp' value="{{userpswdexp}}"/>
    </section>
    <section class="my-2">
        <label class="me-2" for='userest'>Estado del Usuario</label>
        {{if readonly}}
        <input type="hidden" {{readonly}} name='userestDummy' value="" />
        {{endif readonly}}
        <select name="userest" id="userest" {{if readonly}}disabled{{endif readonly}} >
          <option value="ACT" {{userest_ACT}}>Activo</option>
          <option value="INA" {{userest_INA}}>Inactivo</option>
          <option value="SUS" {{userest_SUS}}>Suspendido</option>
          <option value="BLQ" {{userest_BLQ}}>Bloqueado</option>
        </select>
    </section>
    <section class="my-2">
        <label class="me-2" for='usertipo'>Tipo de Usuario</label>
        {{if readonly}}
        <input type="hidden" {{readonly}} name='usertipoDummy' value="" />
        {{endif readonly}}
        <select name="usertipo" id="usertipo" {{if readonly}}disabled{{endif readonly}} >
          <option value="PBL" {{usertipo_PBL}}>Público</option>
          <option value="ADM" {{usertipo_ADM}}>Administrador</option>
          <option value="AUD" {{usertipo_AUD}}>Auditor</option>
        </select>
    </section >
    {{if readonly}}
    <section class="border my-2">
      <p class="fw-bolder">Roles del usuario</p>
      <ul>
        {{foreach userroles}}
        <li>{{rolescod}}</li>
        {{endfor userroles}}
      </ul>
    </section>
    {{endif readonly}}
    {{ifnot readonly}}
    <section>
        <table class="table table-bordered">
          <thead>
            <tr class="table-dark">
              <th colspan="3">Roles de usuario</th>
            </tr>
            <tr class="table-light">
              <th>Listado de roles</th>
              <th>Mover</th>
              <th>Roles asignados</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <select class="form-select" multiple aria-label="Listado de roles" name="listrol" id="listrol">
                  {{foreach avaroles}}
                  <option value="{{rolescod}}">{{rolescod}}</option>
                  {{endfor avaroles}}
                </select>
              </td>
              <td class="d-flex flex-column justify-content-center">
                <button type="button" id="move_right" class="btn btn-success">>></button>
                <br>
                <button type="button" id="move_left" class="btn btn-warning"><<</button>
              </td>
              <td>
                <input type="hidden" id="userAssignRoles" name="userAssignRoles" value="">
                <select class="form-select" multiple aria-label="Listado de roles" name="userroles" id="userroles">
                  {{foreach userroles}}
                  <option value="{{rolescod}}">{{rolescod}}</option>
                  {{endfor userroles}}
                </select>
              </td>
            </tr>
          </tbody>
        </table>
    </section>
    {{endifnot readonly}}
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
    let rolesArr;
    let rolesInput;
    try {
      
      rolesArr = document.getElementById("userroles");
      rolesInput = document.getElementById("userAssignRoles");
      rolesArr = Array.apply(null, rolesArr.options);
      rolesArr = rolesArr.map((opt) => opt.value);
      rolesInput.value = rolesArr.join(",");
    } catch (error) {
      
    }
    
      document.getElementById("btnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_usuarios");
      });
      const chgPswd = document.getElementById("chgPswd");
      chgPswd.addEventListener("click", function(e){
        const pswdField = document.getElementById("pswd_field");
        if(chgPswd.checked){
          pswdField.classList.add("d-block");
          pswdField.classList.remove("d-none");
        }else{
          pswdField.classList.add("d-none");
          pswdField.classList.remove("d-block");
        }
      });
      document.getElementById("move_right").addEventListener("click", function(e){
        e.preventDefault();
        listbox_moveacross("listrol","userroles");
      });
      document.getElementById("move_left").addEventListener("click", function(e){
        e.preventDefault();
        listbox_moveacross("userroles","listrol")
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
              if(destID === 'userroles'){
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