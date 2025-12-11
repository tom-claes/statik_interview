<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservering succesvol!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <div class="card shadow-sm p-4">
        <!-- Title -->
        <h1 class="mb-4 text-center text-success">Reservering succesvol!</h1>
        <!-- Subtitle -->
        <p class="lead text-center">Dank je wel! Hier zijn de details van je reservering:</p>

        <!-- Display date info -->
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Datum van bezoek:</strong> {{ $reservationData['reservation_date'] }}</li>
            <li class="list-group-item"><strong>Tijdslot:</strong> {{ $reservationData['reservation_timeslot'] }}</li>
        </ul>

        <!-- Loop over each user -->
        @for ($i = 1; $i <= 3; $i++)
            <!-- Only show box for a full/existing user -->
            @if(!empty($reservationData["firstname{$i}"]) && !empty($reservationData["lastname{$i}"]))
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Bezoeker {{ $i }}</h5>
                    <p class="card-text"><strong>Voornaam:</strong> {{ ucwords(strtolower($reservationData["firstname{$i}"])) }}</p>
                    <p class="card-text"><strong>Achternaam:</strong> {{ ucwords(strtolower($reservationData["lastname{$i}"])) }}</p>
                    <!-- Check if a subscription number is provided before displaying -->
                    @if(!empty($reservationData["subscription_number{$i}"]))
                        <p class="card-text"><strong>Abonnementsnummer:</strong> {{ $reservationData["subscription_number{$i}"] }}</p>
                    @endif
                </div>
            </div>
            @endif
        @endfor

        <div class="text-center mt-4">
            <a href="{{ route('reservation.form') }}" class="btn btn-primary btn-lg">Maak een nieuwe reservering</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
