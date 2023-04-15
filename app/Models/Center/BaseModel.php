<?php

namespace App\Models\Center;

use App\Models\UuidTrait;
use  Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;
    use UuidTrait;

    public $timestamps = false;

    public $connection = 'station_base';
}
