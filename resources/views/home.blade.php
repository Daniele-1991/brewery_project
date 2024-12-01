<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Benvenuto</h1>
        <p>Il tuo token di autenticazione:</p>
        <pre id="token">{{ $token }}</pre>
        <a href="#" id="brewery-link" class="btn btn-primary">Vai alle Birrerie</a>
    </div>

    <script>
        $(document).ready(function() {
            // Salva il token nel localStorage
            const token = "{{ $token }}";
            if (token) {
                localStorage.setItem('auth_token', token);
                $('#token').text(token);
                $('#brewery-link').attr('href', '/breweries-view?token=' + token);
            } else {
                $('#token').text('Token non disponibile');
                $('#brewery-link').attr('href', '#').attr('disabled', true);
            }
        });
    </script>
</body>
</html>
