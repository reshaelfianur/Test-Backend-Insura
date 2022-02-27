<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table        = 'groups';
    protected $primaryKey   = 'group_id';
    protected $fillable     = [
        'group_code',
        'group_name',
    ];

    public function employee()
    {
        return $this->hasMany(Sub_module::class, 'group_id');
    }
}
