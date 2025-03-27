<!-- Add Truck Modal -->
<div class="modal fade" id="addTruckModal" tabindex="-1" aria-labelledby="addTruckModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTruckModalLabel">Add New Truck</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.truckdetails.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="cr_number">Certificate of Registration No.</label>
                                <input type="text" class="form-control" id="cr_number" name="cr_number" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="mv_file_number">MV File Number</label>
                                <input type="text" class="form-control" id="mv_file_number" name="mv_file_number" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="plate_number">Plate Number</label>
                                <input type="text" class="form-control" id="plate_number" name="plate_number" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="engine_number">Engine Number</label>
                                <input type="text" class="form-control" id="engine_number" name="engine_number" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="chassis_number">Chassis Number</label>
                                <input type="text" class="form-control" id="chassis_number" name="chassis_number" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="denomination">Denomination</label>
                                <input type="text" class="form-control" id="denomination" name="denomination" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="piston_displacement">Piston Displacement</label>
                                <input type="text" class="form-control" id="piston_displacement" name="piston_displacement" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="number_of_cylinders">Number of Cylinders</label>
                                <input type="text" class="form-control" id="number_of_cylinders" name="number_of_cylinders" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="fuel">Fuel</label>
                                <input type="text" class="form-control" id="fuel" name="fuel" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="make">Make</label>
                                <input type="text" class="form-control" id="make" name="make" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="series">Series</label>
                                <input type="text" class="form-control" id="series" name="series" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="body_type">Body Type</label>
                                <input type="text" class="form-control" id="body_type" name="body_type" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="body_number">Body Number</label>
                                <input type="text" class="form-control" id="body_number" name="body_number" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="year_model">Year Model</label>
                                <input type="text" class="form-control" id="year_model" name="year_model" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="gross_weight">Gross Weight</label>
                                <input type="text" class="form-control" id="gross_weight" name="gross_weight" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="net_weight">Net Weight</label>
                                <input type="text" class="form-control" id="net_weight" name="net_weight" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="shipping_weight">Shipping Weight</label>
                                <input type="text" class="form-control" id="shipping_weight" name="shipping_weight" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="net_capacity">Net Capacity</label>
                                <input type="text" class="form-control" id="net_capacity" name="net_capacity" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="owner_name">Owner Name</label>
                                <input type="text" class="form-control" id="owner_name" name="owner_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group mb-3">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                        </div>
                        <!-- Empty column to maintain layout -->
                        <div class="form-col"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Truck</button>
                </div>
            </form>
        </div>
    </div>
</div>