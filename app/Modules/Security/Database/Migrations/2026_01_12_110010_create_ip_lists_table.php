<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection;

    public function __construct()
    {
        $this->connection = config(
            'security.drivers.database.connection',
            config('database.default')
        );
    }

    public function up(): void
    {
        /* ==========================================================
         | IP Intelligence & Reputation
         |==========================================================*/
        Schema::connection($this->connection)->create('ip_lists', function (Blueprint $table): void {
            $table->id();

            // IP & Network
            $table->string('ip_address', 45)
                ->comment('IPv4 / IPv6 address');

            $table->string('ip_type', 10)
                ->default('ipv4')
                ->comment('ipv4 | ipv6');

            $table->string('cidr', 50)
                ->nullable()
                ->comment('Optional CIDR block');

            // Reputation
            $table->string('status', 20)
                ->default('whitelist')
                ->comment('whitelist | blocklist | suspicious');

            $table->unsignedTinyInteger('risk_score')
                ->default(0)
                ->comment('0–100 risk score');

            $table->string('threat_type', 50)
                ->nullable()
                ->comment('phishing | bot | tor | proxy | malware');

            $table->boolean('is_tor')->default(false);
            $table->boolean('is_proxy')->default(false);
            $table->boolean('is_vpn')->default(false);

            // Geo & ASN
            $table->string('country_code', 2)->nullable();
            $table->string('asn', 20)->nullable()->comment('Autonomous System Number');
            $table->string('isp', 100)->nullable();

            // Audit
            $table->string('remarks', 150)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->unique(['ip_address', 'ip_type']);
            $table->index(['status', 'risk_score']);
            $table->index('country_code');
        });

        /* ==========================================================
         | Security Activity Logs (Append-Only)
         |==========================================================*/
        Schema::connection($this->connection)->create('security_activity_logs', function (Blueprint $table): void {
            $table->id();

            // User Context
            $table->foreignId('user_id')->nullable()->index();
            $table->string('session_id', 100)->nullable();

            // Network & Device
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->string('device_fingerprint', 100)->nullable();

            // Geo
            $table->string('country_code', 2)->nullable();
            $table->string('city', 100)->nullable();

            // Activity
            $table->string('event_type', 50)
                ->comment('login_attempt | login_failed | password_reset | api_call');

            $table->string('endpoint', 150)->nullable();
            $table->string('method', 10)->nullable();

            // Risk
            $table->unsignedTinyInteger('risk_score')->default(0);
            $table->boolean('is_anomalous')->default(false);

            $table->json('metadata')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'created_at']);
            $table->index(['event_type', 'created_at']);
            $table->index('is_anomalous');
        });

        /* ==========================================================
         | Risk Flags (Investigations)
         |==========================================================*/
        Schema::connection($this->connection)->create('security_risk_flags', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')->nullable()->index();

            $table->string('flag_type', 50)
                ->comment('phishing | impossible_travel | device_change');

            $table->string('severity', 20)
                ->comment('low | medium | high | critical');

            $table->text('reason');
            $table->json('evidence')->nullable();

            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['severity', 'resolved_at']);
        });

        /* ==========================================================
         | 4-Eyes Approval Workflow
         |==========================================================*/
        Schema::connection($this->connection)->create('security_approvals', function (Blueprint $table): void {
            $table->id();

            $table->string('action_type', 50)
                ->comment('unblock_user | reset_risk');

            $table->unsignedBigInteger('target_id');
            $table->unsignedBigInteger('requested_by');
            $table->unsignedBigInteger('approved_by')->nullable();

            $table->string('status', 20)
                ->default('pending')
                ->comment('pending | approved | rejected');

            $table->text('reason')->nullable();

            $table->timestamps();

            $table->index(['action_type', 'status']);
            $table->index('requested_by');
            $table->index('approved_by');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('security_approvals');
        Schema::connection($this->connection)->dropIfExists('security_risk_flags');
        Schema::connection($this->connection)->dropIfExists('security_activity_logs');
        Schema::connection($this->connection)->dropIfExists('ip_lists');
    }
};
