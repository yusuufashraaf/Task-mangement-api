<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
        protected $fillable = [
        'title','description','status','due_date','assigned_to','tenant_id','created_by'
    ];

    //
        public function tenant() {
        return $this->belongsTo(Tenant::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee() {
        return $this->belongsTo(User::class, 'assigned_to');
    }

}