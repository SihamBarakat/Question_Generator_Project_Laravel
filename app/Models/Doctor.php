<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='doctors';
    protected $primaryKey='doctor_id';

    protected $fillable = [
        'doctor_name',
        'doctor_email',
        'doctor_phone',
        'doctor_password',
    ];
    /*public function subjects()
    {
        return $this->hasMany('App\Models\Subject');
    }
    public function classrooms()  //بدالو حطي تبع الامتحان
    { 
        return $this->belongsToMany(Classroom::class, 'subjects', 'teacher_id', 'classroom_id');
    }*/
    protected $hidden = [
        'doctor_password',
        'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
