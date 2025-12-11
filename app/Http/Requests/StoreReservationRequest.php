<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ReservationTimeslot;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "reservation_date" => ["required", "date", "after_or_equal:today"],
            "reservation_timeslot" => ["required", "string", "in:" . implode(',', array_map(fn($slot) => $slot->value, ReservationTimeslot::cases())),],
            
            "firstname1" => ["required", "string", "max:255"],
            "lastname1" => ["required", "string", "max:255"],
            "subscription_number1" => ["nullable", "string", "regex:/^\d{4}-\d{4}-\d{2}$/"],
            
            "firstname2" => ["nullable", "string", "max:255"],
            "lastname2" => ["nullable", "string", "max:255"],
            "subscription_number2" => ["nullable", "string", "regex:/^\d{4}-\d{4}-\d{2}$/"],
            
            "firstname3" => ["nullable", "string", "max:255"],
            "lastname3" => ["nullable", "string", "max:255"],
            "subscription_number3" => ["nullable", "string", "regex:/^\d{4}-\d{4}-\d{2}$/"],
        ];
    }

    public function messages(): array
    {
        return [
            "reservation_date.required" => "Je moet een datum kiezen voor je bezoek.",
            "reservation_date.after_or_equal" => "De datum moet vandaag of later zijn.",
            "reservation_timeslot.required" => "Je moet een tijdslot selecteren.",
            "firstname1.required" => "Voornaam is verplicht.",
            "lastname1.required" => "Achternaam is verplicht.",
            "subscription_number1.regex" => "Het abonnementsnummer moet het formaat XXXX-XXXX-XX hebben.",
        ];
    }

    // Function automatically called after the default validation rules
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Loop over the different subscription number fields
            for ($i = 1; $i <= 3; $i++) {
                // Get the subscription number value
                $field = "subscription_number{$i}";
                $value = $this->input($field);

                if ($value) {
                    // Remove dashes
                    $digits = str_replace('-', '', $value);
                    // Isolate first 8 digits
                    $first8 = substr($digits, 0, 8);
                    // Isolate last 2 digits (checksum)
                    $checksum = substr($digits, 8, 2);

                    // If the first 8 digits mod 97 does not equal the checksum, show error
                    if ((int)$first8 % 97 !== (int)$checksum) {
                        $validator->errors()->add(
                            $field,
                            "Het abonnementsnummer is ongeldig."
                        );
                    }
                }
            }
        });
    }
}
