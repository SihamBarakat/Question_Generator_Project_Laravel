<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table='subjects';
    protected $primaryKey='subject_id';

    protected $fillable = [
        'subject_name',
        'subject_Description',
        'subject_semester',
        
        
        
    ];
    /*public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom');
    }
    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }*/

   
    protected $hidden = [
        
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
