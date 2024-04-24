<!-- Modal -->
<div class="modal fade" id="editUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edicion del Usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form autocomplete="off" novalidate id="frm-edit">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" name="nombreEdit" id="nombreEdit" class="form-control" placeholder="Ingrese el nombre" aria-describedby="nombre">
              <!-- <small id="helpId" class="text-muted">Help text</small> -->
            </div>
            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text" name="apellidosEdit" id="apellidosEdit" class="form-control" placeholder="Ingrese apellidos" aria-describedby="apellidos">
              <!-- <small id="helpId" class="text-muted">Help text</small> -->
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" name="emailEdit" id="emailEdit" class="form-control" placeholder="Ingrese email" aria-describedby="email">
              <!-- <small id="helpId" class="text-muted">Help text</small> -->
            </div>
            <div class="mb-3 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>