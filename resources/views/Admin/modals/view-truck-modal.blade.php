@foreach($trucks as $truck)
<!-- View Truck Modal -->
<div class="modal fade" id="viewTruckModal{{ $truck->id }}" tabindex="-1" aria-labelledby="viewTruckModalLabel{{ $truck->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTruckModalLabel{{ $truck->id }}">Truck Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>CR Number:</strong> {{ $truck->cr_number }}</p>
                        <p><strong>Date:</strong> {{ $truck->date ? $truck->date->format('m/d/Y') : 'N/A' }}</p>
                        <p><strong>MV File Number:</strong> {{ $truck->mv_file_number }}</p>
                        <p><strong>Plate Number:</strong> {{ $truck->plate_number }}</p>
                        <p><strong>Engine Number:</strong> {{ $truck->engine_number }}</p>
                        <p><strong>Chassis Number:</strong> {{ $truck->chassis_number }}</p>
                        <p><strong>Denomination:</strong> {{ $truck->denomination }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Piston Displacement:</strong> {{ $truck->piston_displacement }}</p>
                        <p><strong>Number of Cylinders:</strong> {{ $truck->number_of_cylinders }}</p>
                        <p><strong>Fuel:</strong> {{ $truck->fuel }}</p>
                        <p><strong>Make:</strong> {{ $truck->make }}</p>
                        <p><strong>Series:</strong> {{ $truck->series }}</p>
                        <p><strong>Body Type:</strong> {{ $truck->body_type }}</p>
                        <p><strong>Body Number:</strong> {{ $truck->body_number }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p><strong>Year Model:</strong> {{ $truck->year_model }}</p>
                        <p><strong>Gross Weight:</strong> {{ $truck->gross_weight }}</p>
                        <p><strong>Net Weight:</strong> {{ $truck->net_weight }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Shipping Weight:</strong> {{ $truck->shipping_weight }}</p>
                        <p><strong>Net Capacity:</strong> {{ $truck->net_capacity }}</p>
                        <p><strong>Owner Name:</strong> {{ $truck->owner_name }}</p>
                        <p><strong>Address:</strong> {{ $truck->address }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach