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
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: auto;
            text-align: center;
        }

        #countdown {
            font-size: 1.5em;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Scan QR Code untuk Verifikasi</h1>
        <img src="{{ $qrCodeDataUri }}" alt="QR Code">
        <p>Kode berlaku selama:</p>
        <p id="countdown"></p>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inisialisasi Pusher
            Pusher.logToConsole = true;
            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
            });
            pusher.connection.bind('error', function(error) {
                console.error('Pusher Error: ', error);
            });
            var channel = pusher.subscribe('barcode-channel');
            console.log(channel.bind('QrCodeScanned'));
            channel.bind('QrCodeScanned', function(data) {
                console.log('Event QrCodeScanned berhasil di-bind.');
                console.log('Data yang diterima:', data);

                alert(`QR Code ${data.code} berhasil diverifikasi!`);
                window.location.href = "{{ route('admin.recipient.index') }}";
            });

            // Countdown timer
            const expiration = new Date("{{ $expiration->toIso8601String() }}");
            setInterval(() => {
                const now = new Date();
                const timeLeft = expiration - now;
                if (timeLeft <= 0) {
                    document.getElementById('countdown').innerText = "00:00";
                } else {
                    const minutes = Math.floor(timeLeft / 60000);
                    const seconds = Math.floor((timeLeft % 60000) / 1000);
                    document.getElementById('countdown').innerText =
                        `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                }
            }, 1000);
        });
    </script>
</body>

</html>
