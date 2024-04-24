<!-- Modal -->
<div class="modal fade" id="modalusershow" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Informacion del Usuario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" name="nombreShow" id="nombreShow" class="form-control" placeholder="Ingrese el nombre" aria-describedby="nombre" readonly>
              <!-- <small id="helpId" class="text-muted">Help text</small> -->
            </div>
            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text" name="apellidosShow" id="apellidosShow" class="form-control" placeholder="Ingrese apellidos" aria-describedby="apellidos" readonly>
              <!-- <small id="helpId" class="text-muted">Help text</small> -->
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" name="emailShow" id="emailShow" class="form-control" placeholder="Ingrese email" aria-describedby="email" readonly>
              <!-- <small id="helpId" class="text-muted">Help text</small> -->
            </div>
        </form>
      </div>
    </div>
  </div>
</div>