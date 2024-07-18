
  <!-- Modal -->
  <div class="modal fade " id="modalConfirmDelete" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="true"  aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="staticBackdropLabel">{{ trans('general/admin_lang.delete') }}</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modalConfirmDeleteBody">     
          <h4 class="d-flex align-items-center"><span style="font-size: 50px"><i class="fas fa-question-circle me-2 text-primary" ></i></span> <span>{{ trans('general/admin_lang.delete_question') }}</span></h4>
        </div>
        <div class="modal-footer ">
          <button type="button" class="btn btn-info" data-bs-dismiss="modal">{{ trans('general/admin_lang.no') }}</button>
          <button class="btn btn-primary" wire:click.prevent="delete()"  >{{ trans('general/admin_lang.yes_delete') }}</button>
        
        </div>
      </div>
    </div>
  </div>
  
  