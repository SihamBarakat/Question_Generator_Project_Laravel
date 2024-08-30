<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='exams';
    protected $primaryKey='exam_id';

    protected $fillable = [
        'name',
        'duration',
        'subject_id',
        
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
        
        'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
