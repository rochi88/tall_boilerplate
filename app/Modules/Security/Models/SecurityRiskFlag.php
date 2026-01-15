<?php

declare(strict_types=1);

namespace App\Modules\Security\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class SecurityRiskFlag extends Model
{
    protected $table = 'security_risk_flags';

    protected $fillable = [
        'user_id',
        'flag_type',
        'severity',
        'reason',
        'evidence',
        'resolved_at',
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

    public function scopeOpen($query)
    {
        return $query->whereNull('resolved_at');
    }

    public function scopeCritical($query)
    {
        return $query->where('severity', 'critical');
    }

    /* -------------------------------------------------
     | Domain helpers
     |-------------------------------------------------*/

    public function resolve(): void
    {
        $this->update([
            'resolved_at' => now(),
        ]);
    }

    public function isResolved(): bool
    {
        return $this->resolved_at !== null;
    }

    protected function casts(): array
    {
        return [
            'evidence' => 'array',
            'resolved_at' => 'datetime',
        ];
    }
}
