<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table      = 'employees';
    protected $primaryKey = 'employee_id';
    protected $fillable   = [
        'group_id',
        'employee_code',
        'employee_first_name',
        'employee_last_name',
        'employee_birth_date',
        'employee_email_private',
        'employee_basic_salary',
        'employee_description',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'employee_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public static function fetch($args = [])
    {
        $i = new static;

        return self::select(
            $i->table . '.*',
            'group.group_name',
            DB::raw("CONCAT($i->table.employee_first_name, ' ', IFNULL($i->table.employee_last_name, '')) AS employee_full_name")
        )
            ->join('groups AS group', $i->table . '.group_id', '=', 'group.group_id')
            ->where($args)
            ->get();
    }

    public static function searchListEmpName($words)
    {
        return self::where(DB::raw("CONCAT_WS('',employee_first_name, ' ', employee_last_name)"), 'LIKE', '%' . $words . '%')
            ->get();
    }
}
