<div class="modal fade" id="uploadFilesModal" tabindex="-1" aria-labelledby="uploadFilesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadFilesModalLabel">Add files</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('backend.filemanager.upload') }}" method="POST" enctype="multipart/form-data"> 
        @csrf
      <!-- Body -->
      <div class="modal-body">
        
        <!-- Dropzone -->
        <div id="attachFilesNewProjectLabel" class="js-dropzone dz-dropzone dz-dropzone-card">
          <div class="dz-message">
            <img class="avatar avatar-xl avatar-4x3 mb-3" src="{{ asset('assets/img/icons')}}/oc-browse.svg" alt="Image Description" data-hs-theme-appearance="default">
            <h5>Drag and drop your file here</h5>

            <p class="mb-2">or</p>

            <span class="btn btn-white btn-sm" id="browse">Browse files</span>
            <input type="file" id='prepare_images' name="file" multiple style="display: none"> 
          </div>
        </div>
        <!-- End Dropzone -->
      </div>
      <!-- End Body -->

      <!-- Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-white" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
    </form>
      <!-- End Footer -->
    </div>
  </div>
</div>
