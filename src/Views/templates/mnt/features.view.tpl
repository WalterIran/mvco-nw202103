<section class="depth-1">
  <h1>Funciones</h1>
</section>
<section class="WWListFeatures">
  <table class="table">
    <thead>
      <tr>
      <th>Código</th>
      <th>Descripcion</th>
      <th>Estado</th>
      <th>Tipo</th>
      <th>
        {{if CanInsert}}
        <a href="index.php?page=mnt_feature&mode=INS&fncod=AUTOMATIC">Nuevo</a>
        {{endif CanInsert}}
        
      </th>
      </tr>
    </thead>
    <tbody>
      {{foreach Funciones}}
      <tr>
        <td>{{fncod}}</td>
        
        <td><a href="index.php?page=mnt_feature&mode=DSP&fncod={{fncod}}">{{fndsc}}</a></td>
        <td>{{fnest}}</td>
        <td>{{fntyp}}</td>
        <td>
          {{if ~CanUpdate}}
          <a href="index.php?page=mnt_feature&mode=UPD&fncod={{fncod}}"
            class="btn depth-1 w48" title="Editar">
            <i class="bi bi-pencil"></i>
          </a>
          {{endif ~CanUpdate}}
          &nbsp;
          {{if ~CanDelete}}
          <a href="index.php?page=mnt_feature&mode=DEL&fncod={{fncod}}"
            class="btn depth-1 w48" title="Eliminar">
            <i class="bi bi-person-x"></i>
          </a>
          {{endif ~CanDelete}}
        </td>
      </tr>
      {{endfor Funciones}}
    </tbody>
  </table>
</section>