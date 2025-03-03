<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargo QR Code</title>
    <link rel="stylesheet" href="{{ asset('css/cargo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/deliverynav.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<body>

        <aside class="sidebar">
            <h2>SYA TRUCKING SERVICES</h2>
            <p>Since 2020</p>
            <nav>
                <ul>
                    <x-drivernavbar />
                </ul>
            </nav>
        </aside>

    <h2>Generate Cargo QR Code</h2>
    <form id="cargoForm">
        <input type="text" name="plate_no" placeholder="Plate No" required>
        <input type="text" name="eir_no" placeholder="EIR No" required>
        <input type="text" name="container_van_no" placeholder="Container Van No" required>
        <input type="text" name="size" placeholder="Size" required>
        <input type="text" name="shipper_consignee" placeholder="Shipper/Consignee" required>
        <input type="text" name="voyage_vessel" placeholder="Voyage Vessel" required>
        <input type="text" name="voyage_no" placeholder="Voyage Number" required>
        <input type="text" name="pickup_location" placeholder="Pickup Location" required>
        <input type="text" name="delivery_location" placeholder="Delivery Location" required>
        <button type="submit">Generate QR Code</button>
    </form>

    <h2>QR Code:</h2>
    <div id="qrCodeContainer"></div> <!-- QR Code Will Be Shown Here -->

    <script>
document.getElementById("cargoForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let formData = new FormData(this);

    axios.get("{{ url('/cargo/qrcode') }}", { params: Object.fromEntries(formData) })
        .then(response => {
            // Insert the SVG QR code as HTML
            document.getElementById('qrCodeContainer').innerHTML = response.data;
        })
        .catch(error => console.log(error));
});
</script>
</body>
</html>
