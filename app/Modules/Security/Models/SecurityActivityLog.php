<?php

declare(strict_types=1);

namespace App\Modules\Security\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class SecurityActivityLog extends Model
{
    protected $table = 'security_activity_logs';

    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'device_fingerprint',
        'country_code',
        'city',
        'event_type',
        'endpoint',
        'method',
        'risk_score',
        'is_anomalous',
        'metadata',
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
     | Relationships
     |-------------------------------------------------*/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* -------------------------------------------------
     | Scopes
     |-------------------------------------------------*/

    public function scopeAnomalous($query)
    {
        return $query->where('is_anomalous', true);
    }

    public function scopeRecent($query, int $minutes = 15)
    {
        return $query->where(
            'created_at',
            '>=',
            now()->subMinutes($minutes),
        );
    }

    /* -------------------------------------------------
     | Domain helpers
     |-------------------------------------------------*/

    public function exceedsRisk(int $threshold = 50): bool
    {
        return $this->risk_score >= $threshold;
    }

    protected function casts(): array
    {
        return [
            'risk_score' => 'integer',
            'is_anomalous' => 'boolean',
            'metadata' => 'array',
        ];
    }
}
