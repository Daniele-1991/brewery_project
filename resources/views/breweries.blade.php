<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Breweries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="path/to/your/index.css" rel="stylesheet"> <!-- Assicurati che il percorso sia corretto -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
</head>
<body>
    <div class="container mt-5">
        <div id="loader" class="loader"></div> <!-- Loader Element -->
        <div id="content" class="content"> <!-- Wrapper for the content -->
            <h1>Breweries</h1>
            <button id="logout" class="btn btn-danger mb-3">Logout</button> <!-- Logout Button -->
            <div id="breweries-list" class="row"></div>
            <nav>
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" id="prev-page">Previous</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" id="next-page">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <script>
    // Setup AJAX with CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let page = 1;
    const token = localStorage.getItem('auth_token');

    console.log('Token:', token);

    if (!token) {
        alert('Token non disponibile. Effettua il login.');
        window.location.href = '/login';
    }

    function fetchBreweries() {
        $('#loader').show(); // Show loader
        $('#content').addClass('hidden-content'); // Hide content
        $.ajax({
            url: '/api/breweries',
            method: 'GET',
            data: { page: page },
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(data) {
                $('#loader').hide(); // Hide loader on success
                $('#content').removeClass('hidden-content'); // Show content
                $('#breweries-list').empty();
                data.forEach(function(brewery) {
                    const breweryCard = `
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">${brewery.name}</h5>
                                    <p class="card-text">
                                        <strong>Tipo:</strong> ${brewery.brewery_type}<br>
                                        <strong>Indirizzo:</strong> ${brewery.street}<br>
                                        <strong>Città:</strong> ${brewery.city}<br>
                                        <strong>Provincia:</strong> ${brewery.state}<br>
                                        <strong>Paese:</strong> ${brewery.country}<br>
                                        <strong>Telefono:</strong> ${brewery.phone ? brewery.phone : 'N/A'}<br>
                                        <strong>Sito web:</strong> <a href="${brewery.website_url}" target="_blank">${brewery.website_url}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#breweries-list').append(breweryCard);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#loader').hide(); // Hide loader on error
                $('#content').removeClass('hidden-content'); // Show content
                console.error('Errore nel recupero delle birrerie:', textStatus, errorThrown);
                alert('Errore nel recupero delle birrerie.');
            }
        });
    }

    $(document).ready(function() {
        fetchBreweries();

        $('#next-page').click(function(e) {
            e.preventDefault();
            page++;
            fetchBreweries();
        });

        $('#prev-page').click(function(e) {
            e.preventDefault();
            if (page > 1) {
                page--;
                fetchBreweries();
            }
        });

        $('#logout').click(function() {
            $.ajax({
                url: '/logout',
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function() {
                    localStorage.removeItem('auth_token'); // Remove the token
                    window.location.href = '/login'; // Redirect to login page
                },
                error: function() {
                    alert('Errore nel logout. Riprova.');
                }
            });
        });
    });
</script>

</body>
</html>
