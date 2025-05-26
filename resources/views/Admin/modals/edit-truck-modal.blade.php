@foreach($trucks as $truck)
<!-- Edit Truck Modal -->
<div class="modal fade" id="editTruckModal{{ $truck->id }}" tabindex="-1" aria-labelledby="editTruckModalLabel{{ $truck->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-dark text-white rounded-top-4">
        <h5 class="modal-title" id="editTruckModalLabel{{ $truck->id }}">
          Edit Truck: <span class="fw-semibold">{{ $truck->plate_number }}</span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.truckdetails.update', $truck->id) }}" method="POST" enctype="multipart/form-data" class="p-4">
        @csrf
        @method('PUT')

        <!-- Image Section -->
        <div class="mb-4 text-center">
          @if($truck->image_path)
            <img src="{{ $truck->image_url }}" alt="Truck Image" class="img-fluid rounded shadow-sm mb-3" style="max-height: 180px; object-fit: contain;">
          @else
            <div class="bg-light rounded shadow-sm p-5 mb-3" style="height: 180px; display: flex; align-items: center; justify-content: center; color: #777;">
              <i class="fas fa-truck fa-3x"></i>
            </div>
          @endif
          <label for="editImage{{ $truck->id }}" class="form-label fw-semibold">Change Image</label>
          <input type="file" class="form-control" id="editImage{{ $truck->id }}" name="image" accept="image/*">
          <small class="text-muted d-block mt-1">Leave empty to keep current image. Max 2MB.</small>
          <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" id="removeImage{{ $truck->id }}" name="remove_image">
            <label class="form-check-label" for="removeImage{{ $truck->id }}">
              Remove current image
            </label>
          </div>
          <div class="image-preview mt-3 d-none" style="min-height: 180px;">
            <p class="fw-semibold text-muted mb-2">New Image Preview</p>
            <img id="imagePreview{{ $truck->id }}" src="#" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 180px; object-fit: contain;">
          </div>
        </div>

        <!-- Two-column inputs container -->
        <div class="row g-3">
          <div class="col-md-6">
            <label for="cr_number" class="form-label fw-semibold">Certificate of Registration No.</label>
            <input type="text" class="form-control form-control-lg" id="cr_number" name="cr_number" value="{{ $truck->cr_number }}" required>
          </div>
          <div class="col-md-6">
            <label for="date" class="form-label fw-semibold">Date</label>
            <input type="date" class="form-control form-control-lg" id="date" name="date" value="{{ $truck->date ? $truck->date->format('Y-m-d') : '' }}" required>
          </div>

          <div class="col-md-6">
            <label for="mv_file_number" class="form-label fw-semibold">MV File Number</label>
            <input type="text" class="form-control form-control-lg" id="mv_file_number" name="mv_file_number" value="{{ $truck->mv_file_number }}" required>
          </div>
          <div class="col-md-6">
            <label for="plate_number" class="form-label fw-semibold">Plate Number</label>
            <input type="text" class="form-control form-control-lg" id="plate_number" name="plate_number" value="{{ $truck->plate_number }}" required>
          </div>

          <div class="col-md-6">
            <label for="engine_number" class="form-label fw-semibold">Engine Number</label>
            <input type="text" class="form-control form-control-lg" id="engine_number" name="engine_number" value="{{ $truck->engine_number }}" required>
          </div>
          <div class="col-md-6">
            <label for="chassis_number" class="form-label fw-semibold">Chassis Number</label>
            <input type="text" class="form-control form-control-lg" id="chassis_number" name="chassis_number" value="{{ $truck->chassis_number }}" required>
          </div>

          <div class="col-md-6">
            <label for="denomination" class="form-label fw-semibold">Denomination</label>
            <input type="text" class="form-control form-control-lg" id="denomination" name="denomination" value="{{ $truck->denomination }}" required>
          </div>
          <div class="col-md-6">
            <label for="piston_displacement" class="form-label fw-semibold">Piston Displacement</label>
            <input type="text" class="form-control form-control-lg" id="piston_displacement" name="piston_displacement" value="{{ $truck->piston_displacement }}" required>
          </div>

          <div class="col-md-6">
            <label for="number_of_cylinders" class="form-label fw-semibold">Number of Cylinders</label>
            <input type="text" class="form-control form-control-lg" id="number_of_cylinders" name="number_of_cylinders" value="{{ $truck->number_of_cylinders }}" required>
          </div>
          <div class="col-md-6">
            <label for="fuel" class="form-label fw-semibold">Fuel</label>
            <input type="text" class="form-control form-control-lg" id="fuel" name="fuel" value="{{ $truck->fuel }}" required>
          </div>

          <div class="col-md-6">
            <label for="make" class="form-label fw-semibold">Make</label>
            <input type="text" class="form-control form-control-lg" id="make" name="make" value="{{ $truck->make }}" required>
          </div>
          <div class="col-md-6">
            <label for="series" class="form-label fw-semibold">Series</label>
            <input type="text" class="form-control form-control-lg" id="series" name="series" value="{{ $truck->series }}" required>
          </div>

          <div class="col-md-6">
            <label for="body_type" class="form-label fw-semibold">Body Type</label>
            <input type="text" class="form-control form-control-lg" id="body_type" name="body_type" value="{{ $truck->body_type }}" required>
          </div>
          <div class="col-md-6">
            <label for="body_number" class="form-label fw-semibold">Body Number</label>
            <input type="text" class="form-control form-control-lg" id="body_number" name="body_number" value="{{ $truck->body_number }}" required>
          </div>

          <div class="col-md-6">
            <label for="year_model" class="form-label fw-semibold">Year Model</label>
            <input type="text" class="form-control form-control-lg" id="year_model" name="year_model" value="{{ $truck->year_model }}" required>
          </div>
          <div class="col-md-6">
            <label for="gross_weight" class="form-label fw-semibold">Gross Weight</label>
            <input type="text" class="form-control form-control-lg" id="gross_weight" name="gross_weight" value="{{ $truck->gross_weight }}" required>
          </div>

          <div class="col-md-6">
            <label for="net_weight" class="form-label fw-semibold">Net Weight</label>
            <input type="text" class="form-control form-control-lg" id="net_weight" name="net_weight" value="{{ $truck->net_weight }}" required>
          </div>
          <div class="col-md-6">
            <label for="shipping_weight" class="form-label fw-semibold">Shipping Weight</label>
            <input type="text" class="form-control form-control-lg" id="shipping_weight" name="shipping_weight" value="{{ $truck->shipping_weight }}" required>
          </div>

          <div class="col-md-6">
            <label for="net_capacity" class="form-label fw-semibold">Net Capacity</label>
            <input type="text" class="form-control form-control-lg" id="net_capacity" name="net_capacity" value="{{ $truck->net_capacity }}" required>
          </div>
          <div class="col-md-6">
            <label for="owner_name" class="form-label fw-semibold">Owner Name</label>
            <input type="text" class="form-control form-control-lg" id="owner_name" name="owner_name" value="{{ $truck->owner_name }}" required>
          </div>

          <div class="col-12">
            <label for="address" class="form-label fw-semibold">Address</label>
            <input type="text" class="form-control form-control-lg" id="address" name="address" value="{{ $truck->address }}" required>
          </div>
        </div>

        <div class="d-flex justify-content-end gap-3 mt-4">
          <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary px-4 rounded-pill">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<script>
  document.querySelectorAll('input[type="file"][id^="editImage"]').forEach(input => {
    input.addEventListener('change', function() {
      const previewContainer = this.closest('form').querySelector('.image-preview');
      const previewImage = this.closest('form').querySelector('img[id^="imagePreview"]');

      if(this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          previewImage.src = e.target.result;
          previewContainer.classList.remove('d-none');
        }
        reader.readAsDataURL(this.files[0]);
      } else {
        previewImage.src = '#';
        previewContainer.classList.add('d-none');
      }
    });
  });
</script>

<style>
  .modal-content {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #fff;
  }

  .form-label {
    color: #222;
  }

  .form-control-lg {
    font-size: 1rem;
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    border: 1px solid #ccc;
    box-shadow: inset 0 1px 3px rgb(0 0 0 / 0.1);
    transition: border-color 0.2s ease;
  }

  .form-control-lg:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 8px rgba(13,110,253,0.5);
    outline: none;
  }

  .btn-primary {
    background-color: #0d6efd;
    border: none;
    border-radius: 50px;
    font-weight: 600;
  }

  .btn-primary:hover {
    background-color: #0a58ca;
  }

  .btn-outline-secondary {
    border-radius: 50px;
    font-weight: 600;
  }

  .img-fluid {
    box-shadow: 0 4px 8px rgb(0 0 0 / 0.1);
  }

  .modal-header {
    border-bottom: none;
  }
</style>
