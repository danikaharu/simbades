<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Bantuan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .nav-tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .nav-tabs button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .nav-tabs button:hover {
            background-color: #0056b3;
        }

        .nav-tabs button.active {
            background-color: #0056b3;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        #qr-code {
            margin: 20px 0;
        }

        #reader {
            width: 100%;
            height: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #result {
            margin-top: 10px;
            font-weight: bold;
        }

        #loader {
            display: none;
            font-size: 1.2em;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="nav-tabs">
            <button id="btn-tampil" class="active" onclick="toggleTabs('tampil')">Tampil QR Code</button>
            <button id="btn-scan" onclick="toggleTabs('scan')">Scan QR Code</button>
        </div>

        <!-- Tampil QR Code Content -->
        <div id="tab-tampil" class="tab-content active">
            <h1>Tampil QR Code</h1>
            <div id="qr-code">
                <img src="{{ $qrCodeDataUri }}" alt="QR Code" style="max-width: 100%; height: auto;">
                <!-- Menjaga proporsi gambar -->
            </div>
            <p>Kode berlaku selama:</p>
            <p id="countdown" style="font-size: 1.2em; font-weight: bold;"></p>
        </div>

        <!-- Scan QR Code Content -->
        <div id="tab-scan" class="tab-content">
            <h1>Scan QR Code</h1>
            <div id="reader"></div>
            <div id="result"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('template_admin/js/html5-qrcode.min.js') }}"></script>

    <script>
        const expirationTime = new Date("{{ \Carbon\Carbon::parse($expiration)->toIso8601String() }}");

        function startCountdown() {
            const countdownElement = document.getElementById('countdown');

            const interval = setInterval(() => {
                const now = new Date();
                const timeLeft = expirationTime - now;

                if (timeLeft <= 0) {
                    countdownElement.innerText = "00:00";
                    clearInterval(interval);
                    return;
                }

                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                countdownElement.innerText = String(minutes).padStart(2, '0') + ":" + String(seconds).padStart(2,
                    '0');
            }, 1000);
        }

        window.onload = function() {
            startCountdown();
        };

        function toggleTabs(activeTab) {
            ['tampil', 'scan'].forEach(tab => {
                document.getElementById('tab-' + tab).classList.toggle('active', tab === activeTab);
                document.getElementById('btn-' + tab).classList.toggle('active', tab === activeTab);
            });
            if (activeTab === 'scan') {
                startScanner();
            } else {
                stopScanner();
            }
        }

        let html5QrCode = null;

        function startScanner() {
            html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 250
                },
                onScanSuccess,
                onScanError
            );
        }

        function stopScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    console.log("QR code scanner stopped.");
                }).catch(err => {
                    console.log("Unable to stop scanner: " + err);
                });
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('result').innerText = decodedText;
            performAction(decodedText);
            console.log(`Code scanned = ${decodedText}`, decodedResult);
            stopScanner();
        }

        function onScanError(errorMessage) {
            console.log(`Error scanning QR code: ${errorMessage}`);
        }

        function performAction(decodedText) {
            $.ajax({
                url: '/admin/qr-code/verification',
                method: 'POST',
                data: {
                    code: decodedText,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        startPolling(decodedText);
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Info',
                            text: response.message,
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON.message || 'Terjadi kesalahan!',
                    });
                }
            });
        }

        let pollingInterval = null;

        function startPolling(decodedText) {
            pollingInterval = setInterval(() => {
                $.ajax({
                    url: '/admin/qr-code/status',
                    method: 'POST',
                    data: {
                        code: decodedText,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'scanned') {
                            clearInterval(pollingInterval);
                            Swal.fire({
                                icon: 'success',
                                title: 'QR Code Dipindai',
                                text: 'QR Code ini berhasil dipindai oleh perangkat lain!',
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        }
                    },
                    error: function(xhr) {
                        clearInterval(pollingInterval);
                        console.log('Error during polling: ' + xhr.responseText);
                    }
                });
            }, 5000);
        }
    </script>

</body>

</html>
