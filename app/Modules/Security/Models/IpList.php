<?php

declare(strict_types=1);

namespace App\Modules\Security\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class IpList extends Model
{
    use SoftDeletes;

    protected $table = 'ip_lists';

    protected $fillable = [
        'ip_address',
        'ip_type',
        'cidr',
        'status',
        'risk_score',
        'threat_type',
        'is_tor',
        'is_proxy',
        'is_vpn',
        'country_code',
        'asn',
        'isp',
        'remarks',
    ];

    /**
     * Specify the connection, since this implements multitenant solution
     * Called via constructor to faciliate testing
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setConnection(config('security.drivers.database.connection', config('database.default')));
    }

    /* -------------------------------------------------
     | Scopes (Fast lookups for middleware)
     |-------------------------------------------------*/

    public function scopeBlocked($query)
    {
        return $query->where('status', 'blocklist');
    }

    public function scopeSuspicious($query)
    {
        return $query->where('status', 'suspicious');
    }

    public function scopeByIp($query, string $ip)
    {
        return $query->where('ip_address', $ip);
    }

    /* -------------------------------------------------
     | Domain helpers
     |-------------------------------------------------*/

    public function isHighRisk(): bool
    {
        return $this->risk_score >= 70;
    }

    protected function casts(): array
    {
        return [
            'is_tor' => 'boolean',
            'is_proxy' => 'boolean',
            'is_vpn' => 'boolean',
            'risk_score' => 'integer',
        ];
    }
}
