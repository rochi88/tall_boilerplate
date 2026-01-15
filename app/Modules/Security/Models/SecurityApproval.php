<?php

declare(strict_types=1);

namespace App\Modules\Security\Models;

use Illuminate\Database\Eloquent\Model;

final class SecurityApproval extends Model
{
    protected $fillable = [
        'action_type',
        'target_id',
        'requested_by',
        'approved_by',
        'status',
        'reason',
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

    public function approve(int $approverId): void
    {
        abort_if($this->requested_by === $approverId, 403);

        $this->update([
            'approved_by' => $approverId,
            'status' => 'approved',
        ]);
    }
}
