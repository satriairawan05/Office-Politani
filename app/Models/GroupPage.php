<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupPage extends Model
{
    use HasFactory;

    protected $table = 'group_pages';

    protected $primaryKey = 'gp_id';
}
