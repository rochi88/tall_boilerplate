<?php

declare(strict_types=1);

namespace App\Modules\Security\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

final class SecuritySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $connection = config(
            'security.drivers.database.connection',
            config('database.default')
        );

        /* ==========================================================
         | IP Intelligence Seed
         |==========================================================*/
        $ipLists = [
            [
                'ip_address'   => '127.0.0.1',
                'ip_type'      => 'ipv4',
                'status'       => 'whitelist',
                'risk_score'   => 0,
                'remarks'      => 'Localhost IPv4',
            ],
            [
                'ip_address'   => '::1',
                'ip_type'      => 'ipv6',
                'status'       => 'whitelist',
                'risk_score'   => 0,
                'remarks'      => 'Localhost IPv6',
            ],
            [
                'ip_address'   => '185.220.101.1',
                'ip_type'      => 'ipv4',
                'status'       => 'blocklist',
                'risk_score'   => 95,
                'threat_type'  => 'tor',
                'is_tor'       => true,
                'remarks'      => 'Known TOR exit node',
            ],
            [
                'ip_address'   => '45.61.184.12',
                'ip_type'      => 'ipv4',
                'status'       => 'suspicious',
                'risk_score'   => 70,
                'threat_type'  => 'bot',
                'is_proxy'     => true,
                'remarks'      => 'Automated bot traffic',
            ],
        ];

        foreach ($ipLists as $ip) {
            DB::connection($connection)->table('ip_lists')->updateOrInsert(
                [
                    'ip_address' => $ip['ip_address'],
                    'ip_type'    => $ip['ip_type'],
                ],
                array_merge(
                    [
                        'cidr'         => null,
                        'country_code' => null,
                        'asn'          => null,
                        'isp'          => null,
                        'is_vpn'       => false,
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ],
                    $ip
                )
            );
        }

        /* ==========================================================
         | Example Security Activity Logs (Demo / Testing)
         |==========================================================*/
        DB::connection($connection)->table('security_activity_logs')->insert([
            [
                'user_id'          => null,
                'session_id'       => 'seed-session-1',
                'ip_address'       => '185.220.101.1',
                'user_agent'       => 'Mozilla/5.0',
                'device_fingerprint' => 'seed-device-1',
                'country_code'     => 'DE',
                'city'             => 'Frankfurt',
                'event_type'       => 'login_attempt',
                'endpoint'         => '/login',
                'method'           => 'POST',
                'risk_score'       => 90,
                'is_anomalous'     => true,
                'metadata'         => json_encode([
                    'reason' => 'TOR exit node detected',
                ]),
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
        ]);

        /* ==========================================================
         | Example Risk Flag
         |==========================================================*/
        DB::connection($connection)->table('security_risk_flags')->insert([
            [
                'user_id'     => null,
                'flag_type'   => 'phishing',
                'severity'    => 'high',
                'reason'      => 'Login attempt from high-risk TOR network',
                'evidence'    => json_encode([
                    'ip' => '185.220.101.1',
                    'risk_score' => 95,
                ]),
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);

        /* ==========================================================
         | Example 4-Eyes Approval (Pending)
         |==========================================================*/
        DB::connection($connection)->table('security_approvals')->insert([
            [
                'action_type' => 'unblock_user',
                'target_id'   => 1,
                'requested_by' => 1,
                'approved_by' => null,
                'status'      => 'pending',
                'reason'      => 'False positive TOR classification',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);
    }
}
