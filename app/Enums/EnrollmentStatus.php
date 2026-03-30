<?php

namespace App\Enums;

enum EnrollmentStatus: string
{
    case Promoted = 'promoted';
    case Repeating = 'repeating';
    case Graduated = 'graduated';
}
