<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            color: #343a40;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        #countdown {
            font-size: 1.5em;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }

        img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Scan QR Code untuk Verifikasi</h1>

        <img src="{{ $qrCodeDataUri }}" alt="QR Code">
        <p class="text-center">Kode berlaku selama:</p>
        <p id="countdown"></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(document).ready(function() {
            function initPusher() {
                Pusher.logToConsole = true;

                // Inisialisasi Pusher
                var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                    cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
                });

                // Berlangganan channel dan mendengarkan event
                var channel = pusher.subscribe('qr-scanned');

                // Mendengarkan event qr-code-scanned
                channel.bind('qr-code-scanned', function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'QR Code Dipindai',
                        text: 'QR Code ini berhasil dipindai!',
                    }).then(() => {
                        window.location.href = '{{ route('admin.recipient.index') }}';
                    });
                });
            }

            const expirationTime = new Date("{{ \Carbon\Carbon::parse($expiration)->toIso8601String() }}");

            function startCountdown() {
                const countdownElement = document.getElementById('countdown');

                const interval = setInterval(() => {
                    const now = new Date();
                    const timeLeft = expirationTime - now;

                    if (timeLeft <= 0) {
                        countdownElement.innerText = "00:00";
                        clearInterval(interval);
                        Swal.fire({
                            icon: 'error',
                            title: 'QR Code Kadaluarsa',
                            text: 'Waktu pemindaian telah habis. Silakan generate ulang QR code.',
                        });
                        return;
                    }

                    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                    countdownElement.innerText = String(minutes).padStart(2, '0') + ":" + String(seconds)
                        .padStart(2, '0');
                }, 1000);
            }

            initPusher();
            startCountdown();
        });
    </script>
</body>

</html>
