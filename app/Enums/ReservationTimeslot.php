<?php

namespace App\Enums;

enum ReservationTimeslot: string
{
    case TIMESLOT1 = '09:00-11:00';
    case TIMESLOT2 = '11:00-13:00';
    case TIMESLOT3 = '13:00-15:00';
    case TIMESLOT4 = '15:00-17:00';
}
