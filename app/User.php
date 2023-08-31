<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{

    use HasApiTokens, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected function google2faSecret(): Attribute
    // {
    //     return new Attribute(
    //         get: fn ($value) =>  decrypt($value),
    //         set: fn ($value) =>  encrypt($value),
    //     );
    // }

    // public function getGoogle2faSecretAttribute($value)
    // {
    //     if ($value != '' && $value != null) {
    //         if (isset($value)) {
    //             return decrypt($value);
    //         } else {
    //             return '';
    //         }
    //     } else {
    //         return '';
    //     }
    // }
    //
    // public function setGoogle2faSecretAttribute($value)
    // {
    //     if ($value != '' && $value != null) {
    //         if (isset($value)) {
    //             return encrypt($value);
    //         } else {
    //             return '';
    //         }
    //     } else {
    //         return '';
    //     }
    // }

    public function getProfileImageAttribute($value)
    {
        if ($value != '' && $value != null) {
            if (isset($value)) {
                return (url('/resources/uploads/profile/') . '/') . $value;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
    public function getProfilePictureAttribute($value)
    {
        if ($value != '' && $value != null) {
            if (isset($value)) {
                return (url('/resources/uploads/profile/') . '/') . $value;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    public function getDetectedPhotoAttribute($value)
    {
        if ($value != '' && $value != null) {
            if (isset($value)) {
                return (url('/resources/uploads/profile/') . '/') . $value;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    public function countyData()
    {
        return $this->hasOne('App\Country', 'country_id', 'country')->select('country_id', 'name');
    }
    public function stateData()
    {
        return $this->hasOne('App\State', 'state_id', 'state')->select('state_id', 'name');
    }
    public function cityData()
    {
        return $this->hasOne('App\City', 'city_id', 'city')->select('city_id', 'name');
    }
    public static function getAllUsers()
    {
        $user = User::whereHas('roles', function ($q) {$q->where('name', 'user');})->where('user_status', '=', '1')->get();
        return $user;
    }
    public function deviceDetail()
    {
        return $this->hasOne('App\Device', 'id', 'device_id');
    }
    public function deviceRelation()
    {
        return $this->hasOne('App\DeviceRelation', 'user_id', 'id');
    }

    public function doctorHospitalData()
    {
        return $this->hasMany('App\HospitalDoctorRelation', 'doctor_id', 'id')->with('hospitalData');
    }

    public function nurseHospitalData()
    {
        return $this->hasMany('App\HospitalNurseRelation', 'nurse_id', 'id')->with('hospitalData');
    }

    public function hospitalDoctorData()
    {
        return $this->hasMany('App\HospitalDoctorRelation', 'hospital_id', 'id')->with('doctorData');
    }

    public function hospitalNurseData()
    {
        return $this->hasMany('App\HospitalNurseRelation', 'hospital_id', 'id')->with('nurseData');
    }

    public function userHospitalData()
    {
        return $this->hasMany('App\HospitalUserRelation', 'user_id', 'id')->with('hospitalData');
    }

    // Custom method to know if the user is new
    public function isNew()
    {
        if (Carbon::parse($this->attributes['created_at'])->diffInHours(Carbon::now()) <= 12) {
            return true;
        } else {
            return false;
        }
    }
}
