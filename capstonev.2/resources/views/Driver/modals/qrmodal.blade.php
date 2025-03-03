<!-- filepath: /c:/Users/john carlo cervantes/Downloads/capstone.2/capstonev.2/resources/views/Driver/modals/qrmodal.blade.php -->
<div id="qrModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>QR CODE</h2>
        <div id="qrCodeContainer" style="margin-left: 70px"></div>
    </div>
</div>
<style>
    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        width: 28vw;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .modal-content img {
        width: 250px;
        height: 250px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById("qrModal");
        var btn = document.getElementById("generateQrBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            // Generate QR code logic here
            var qrCodeContainer = document.getElementById("qrCodeContainer");
            qrCodeContainer.innerHTML = ""; // Clear previous QR code
            var qr = new QRCode(qrCodeContainer, {
                text: "Cargo Details:\nDate: 31/10/2024\nPlate No.: N88 7212\nEIR No.: LKJUIGJHB324356\nContainer Van No.: WRDFHGV46576 | 20DC\nSize: 20DC\nShipper/Consignee: Century Pacific Food\nVoyage Vessel: LCDM\nNo.: 2345\nPickup Location: CYVTA\nDelivery location: MNLP16\nStatus: In Transit",
                width: 300,  // Increased width
                height: 300  // Increased height
            });
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });
</script>