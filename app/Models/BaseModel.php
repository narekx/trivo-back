<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    public function createdAtFormatted(): Attribute
    {
        return Attribute::get(fn() => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->longRelativeDiffForHumans());
    }

    public function updatedAtFormatted(): Attribute
    {
        return Attribute::get(fn() => Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->longRelativeDiffForHumans());
    }
}
