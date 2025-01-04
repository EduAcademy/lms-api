<?php

namespace App\Enums;

enum RoleType: string
{
    case Admin = 'admin';
    case Instructor = 'instructor';
    case Student = 'student';

    public function toString(): string {
        return $this->value;
    }
}
