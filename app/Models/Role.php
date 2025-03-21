<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', // Example: 'employee', 'admin', etc.
    ];

    /**
     * Define the relationship with the User model.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
