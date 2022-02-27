<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use Spatie\Activitylog\Traits\CausesActivity;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use LaratrustUserTrait;
    use HasFactory, Notifiable, SoftDeletes;

    protected $table        = 'users';
    protected $primaryKey   = 'user_id';

    protected $fillable     = [
        'employee_id',
        'email',
        'username',
        'password',
        'user_full_name',
        'user_need_change_password',
        'user_status',
        'user_type',
        'user_active_date',
        'user_inactive_date',
        'user_last_login',
        'user_last_lock',
        'user_last_reset_password',
        'user_last_change_password',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public static function fetch($args = [])
    {
        $i = new static;

        return self::select(
            $i->table . '.*',
            'b.role_id',
            'c.display_name as role_name',
            DB::raw("CONCAT(d.employee_first_name, ' ', IFNULL(d.employee_last_name, '')) AS employee_full_name")
        )
            ->distinct()
            ->leftJoin('role_user AS b', $i->table . '.user_id', '=', 'b.user_id')
            ->join('roles AS c', 'b.role_id', '=', 'c.id')
            ->leftJoin('employees AS d', $i->table . '.employee_id', '=', 'd.employee_id')
            ->where($args)
            ->get();
    }
}
