<section class="depth-1">
  <h1>Trabajar con Usuarios</h1>
</section>
<section class="WWList">
  <table >
    <thead>
      <tr>
      <th>Código</th>
      <th>Correo</th>
      <th>Estado</th>
      <th>
        {{if CanInsert}}
        <a href="index.php?page=mnt_usuario&mode=INS&usercod=0">Nuevo</a>
        {{endif CanInsert}}
      </th>
      </tr>
    </thead>
    <tbody>
      {{foreach Usuarios}}
      <tr>
        <td>{{usercod}}</td>
        <td>
          {{if ~CanView}}
          <a href="index.php?page=mnt_usuario&mode=DSP&usercod={{usercod}}">{{useremail}}</a>
          {{endif ~CanView}}

          {{ifnot ~CanView}}
              {{useremail}}
          {{endifnot ~CanView}}
        </td>
        <td>{{userest}}</td>
        <td>
          {{if ~CanUpdate}}
          <a href="index.php?page=mnt_usuario&mode=UPD&usercod={{usercod}}"
            class="btn depth-1 w48" title="Editar">
            <i class="bi bi-pencil"></i>
          </a>
          {{endif ~CanUpdate}}
          &nbsp;
          {{if ~CanDelete}}
          <a href="index.php?page=mnt_usuario&mode=DEL&usercod={{usercod}}"
            class="btn depth-1 w48" title="Eliminar">
            <i class="bi bi-person-x"></i>
          </a>
          {{endif ~CanDelete}}
        </td>
      </tr>
      {{endfor Usuarios}}
    </tbody>
  </table>
</section>