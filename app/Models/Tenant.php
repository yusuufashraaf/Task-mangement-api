<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
        use HasFactory;

        protected $fillable = ['company_name', 'subdomain'];
    //
        public function users() {
        return $this->hasMany(User::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}