<?php

namespace PlaceToPay;

use Illuminate\Database\Eloquent\Model;

class TypeClient extends Model
{
    protected $table = "type_client";

    protected $fillable = [
    'description',
    'status'
    ];
}
