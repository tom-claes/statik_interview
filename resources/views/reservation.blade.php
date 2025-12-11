<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserveer je bezoek aan de Zoo!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <div class="card shadow-sm p-4">
        <!-- Titel -->
        <h1 class="mb-4 text-center">Reserveer je bezoek aan de Zoo!</h1>

        <!-- Error at top of page for none input field errors -->
        @if ($errors->has('main_error'))
            <div class="alert alert-danger">
                {{ $errors->first('main_error') }}
            </div>
        @endif


        <!-- Form to make a reservation -->
        <form action="{{ route('reservation.submit') }}" method="POST">
            @csrf

            <!-- Date field -->
            <div class="mb-3">
                <label for="reservation_date" class="form-label">Datum van bezoek:</label>
                <input type="date" id="reservation_date" name="reservation_date"
                       value="{{ old('reservation_date') }}"
                       class="form-control" required>
            </div>

            <!-- Timeslot field -->
            <div class="mb-3">
                <label for="reservation_timeslot" class="form-label">Tijdslot:</label>
                <select id="reservation_timeslot" name="reservation_timeslot"
                        class="form-select @error('reservation_timeslot') is-invalid @enderror" required>
                    <option value="">-- Kies een tijdslot --</option>
                    <!-- Get the values from the enum -->
                    @foreach(\App\Enums\ReservationTimeslot::cases() as $slot)
                        <option value="{{ $slot->value }}" {{ old('reservation_timeslot') == $slot->value ? 'selected' : '' }}>
                            {{ $slot->value }}
                        </option>
                    @endforeach
                </select>
                <!-- Display field error -->
                @error('reservation_timeslot')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <!-- Loop to display 3 user input forms -->
            @for ($i = 1; $i <= 3; $i++)
            <div class="card p-3 mb-4">
                <div class="card-body">
                    <!-- Title -->
                    <h5 class="card-title mb-3">Persoonlijke informatie</h5>

                    <!-- Firstname field -->
                    <div class="mb-3">
                        <label for="firstname{{ $i }}" class="form-label">Voornaam:</label>
                        <input type="text" id="firstname{{ $i }}" name="firstname{{ $i }}"
                               value="{{ old('firstname'.$i) }}"
                               class="form-control @error('firstname'.$i) is-invalid @enderror"
                               {{ $i === 1 ? 'required' : '' }}>
                        <!-- Display field error -->
                        @error('firstname'.$i)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lastname field -->
                    <div class="mb-3">
                        <label for="lastname{{ $i }}" class="form-label">Achternaam:</label>
                        <input type="text" id="lastname{{ $i }}" name="lastname{{ $i }}"
                               value="{{ old('lastname'.$i) }}"
                               class="form-control @error('lastname'.$i) is-invalid @enderror"
                               {{ $i === 1 ? 'required' : '' }}>
                        <!-- Display field error -->
                        @error('lastname'.$i)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Subscription number field -->
                    <div class="mb-3">
                        <label for="subscription_number{{ $i }}" class="form-label">Abonnementsnummer (optioneel):</label>
                        <input type="text" id="subscription_number{{ $i }}" name="subscription_number{{ $i }}"
                               value="{{ old('subscription_number'.$i) }}"
                               class="form-control @error('subscription_number'.$i) is-invalid @enderror">
                        <!-- Display field error -->
                        @error('subscription_number'.$i)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            @endfor

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Reserveer</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
