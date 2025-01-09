<?php

declare(strict_types = 1);

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class IPList extends Model
{
    use Filterable;
    use HasFactory;

    protected $table = 'ip_lists';

    protected $fillable = ['ip_address', 'status', 'ip_type', 'remarks'];

    protected $perPage = 10;

    protected static $filterable = ['ip_address' => 'ip_address', 'status' => 'status', 'ip_type' => 'ip_type'];
}
