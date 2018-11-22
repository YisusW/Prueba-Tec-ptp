<?php

namespace PlaceToPay;

use Illuminate\Database\Eloquent\Model;

class TypePerson extends Model
{
    //
    protected $table = "type_person";

    protected $fillable = [
    'description',
    'status'
    ];
}
