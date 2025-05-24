@foreach($trucks as $truck)
<!-- Edit Truck Modal -->
<div class="modal fade" id="editTruckModal{{ $truck->id }}" tabindex="-1" aria-labelledby="editTruckModalLabel{{ $truck->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTruckModalLabel{{ $truck->id }}">Edit Truck - {{ $truck->plate_number }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.truckdetails.update', $truck->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Image Editing Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="current-image mb-3 text-center">
                                @if($truck->image_path)
                                    <img src="{{ $truck->image_url }}" 
                                         alt="Current Truck Image"
                                         class="img-fluid rounded mb-2"
                                         style="max-height: 200px;">
                                @else
                                    <div class="bg-light p-4 text-center rounded">
                                        <i class="fas fa-truck fa-3x text-muted mb-2"></i>
                                        <p class="mb-0">No current image</p>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="editImage{{ $truck->id }}" class="form-label">Change Image</label>
                                <input type="file" 
                                       class="form-control" 
                                       id="editImage{{ $truck->id }}" 
                                       name="image"
                                       accept="image/*">
                                <small class="text-muted">Leave blank to keep current image (Max 2MB, JPEG/PNG/JPG)</small>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="removeImage{{ $truck->id }}" name="remove_image">
                                <label class="form-check-label" for="removeImage{{ $truck->id }}">
                                    Remove current image
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="image-preview text-center" style="display: none;">
                                <p class="text-muted">New Image Preview</p>
                                <img id="imagePreview{{ $truck->id }}" 
                                     src="#" 
                                     alt="Preview" 
                                     class="img-fluid rounded"
                                     style="max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <!-- Rest of the form fields (maintained exactly as you had them) -->
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="cr_number">Certificate of Registration No.</label>
                                <input type="text" class="form-control" id="cr_number" name="cr_number" value="{{ $truck->cr_number }}" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ $truck->date ? $truck->date->format('Y-m-d') : '' }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="mv_file_number">MV File Number</label>
                                <input type="text" class="form-control" id="mv_file_number" name="mv_file_number" value="{{ $truck->mv_file_number }}" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="plate_number">Plate Number</label>
                                <input type="text" class="form-control" id="plate_number" name="plate_number" value="{{ $truck->plate_number }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="engine_number">Engine Number</label>
                                <input type="text" class="form-control" id="engine_number" name="engine_number" value="{{ $truck->engine_number }}" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="chassis_number">Chassis Number</label>
                                <input type="text" class="form-control" id="chassis_number" name="chassis_number" value="{{ $truck->chassis_number }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="denomination">Denomination</label>
                                <input type="text" class="form-control" id="denomination" name="denomination" value="{{ $truck->denomination }}" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="piston_displacement">Piston Displacement</label>
                                <input type="text" class="form-control" id="piston_displacement" name="piston_displacement" value="{{ $truck->piston_displacement }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="number_of_cylinders">Number of Cylinders</label>
                                <input type="text" class="form-control" id="number_of_cylinders" name="number_of_cylinders" value="{{ $truck->number_of_cylinders }}" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="fuel">Fuel</label>
                                <input type="text" class="form-control" id="fuel" name="fuel" value="{{ $truck->fuel }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="make">Make</label>
                                <input type="text" class="form-control" id="make" name="make" value="{{ $truck->make }}" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="series">Series</label>
                                <input type="text" class="form-control" id="series" name="series" value="{{ $truck->series }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="body_type">Body Type</label>
                                <input type="text" class="form-control" id="body_type" name="body_type" value="{{ $truck->body_type }}" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="body_number">Body Number</label>
                                <input type="text" class="form-control" id="body_number" name="body_number" value="{{ $truck->body_number }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="year_model">Year Model</label>
                                <input type="text" class="form-control" id="year_model" name="year_model" value="{{ $truck->year_model }}" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="gross_weight">Gross Weight</label>
                                <input type="text" class="form-control" id="gross_weight" name="gross_weight" value="{{ $truck->gross_weight }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="net_weight">Net Weight</label>
                                <input type="text" class="form-control" id="net_weight" name="net_weight" value="{{ $truck->net_weight }}" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="shipping_weight">Shipping Weight</label>
                                <input type="text" class="form-control" id="shipping_weight" name="shipping_weight" value="{{ $truck->shipping_weight }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="net_capacity">Net Capacity</label>
                                <input type="text" class="form-control" id="net_capacity" name="net_capacity" value="{{ $truck->net_capacity }}" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="owner_name">Owner Name</label>
                                <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ $truck->owner_name }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ $truck->address }}" required>
                            </div>
                        </div>
                        <div class="form-col"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Truck</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Image preview for edit form
    document.getElementById('editImage{{ $truck->id }}')?.addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview{{ $truck->id }}');
        const previewContainer = document.querySelector('#editTruckModal{{ $truck->id }} .image-preview');
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });
</script>
@endforeach