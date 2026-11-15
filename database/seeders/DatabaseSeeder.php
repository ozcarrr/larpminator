<?php

namespace Database\Seeders;

use App\Models\Interview;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $question = 'Describe how you handled database bottlenecks and high concurrency during a critical production peak, including trade-offs made.';

        Interview::create([
            'candidate_name' => 'Alex Rivera',
            'role' => 'Senior Backend Engineer',
            'tech_stack' => 'Laravel, PostgreSQL, Redis',
            'question_text' => $question,
            'answer_text' => 'During our Black Friday traffic surge, we faced significant PostgreSQL read-replica lag of around 4 seconds, so we routed read-heavy endpoints to replicas while enforcing write consistency on the primary. To resolve redis cache stampede on expired hot keys, we implemented distributed mutex locks using Redis Redlock. We also reconfigured PgBouncer connection pooling to transaction mode instead of session mode to handle 10k concurrent connections, trading away prepared statement caching to prevent pool exhaustion.',
            'depth_score' => 88,
            'verdict' => 'Authentic Depth',
            'analysis_data' => [
                'sub_scores' => [
                    'operational_depth' => 85,
                    'friction_handling' => 90,
                    'ownership' => 88,
                    'logical_consistency' => 89,
                ],
                'flags' => [
                    [
                        'severity' => 'amber',
                        'quote' => 'routed read-heavy endpoints to replicas while enforcing write consistency on the primary',
                        'reason' => 'Acceptable for catalog reads, but risks serving stale data if replication lag spikes further.',
                    ],
                ],
                'drill_downs' => [
                    [
                        'topic' => 'Cache Stampede Mutex',
                        'question' => 'How did you prevent thundering herd timeouts when workers waited for the Redis Redlock release?',
                        'expected_signal' => 'Explains early background recomputation or stale cache fallback over blocking loops.',
                    ],
                ],
            ],
        ]);

        Interview::create([
            'candidate_name' => 'Jordan Taylor',
            'role' => 'Senior Backend Engineer',
            'tech_stack' => 'Laravel, PostgreSQL, Redis',
            'question_text' => $question,
            'answer_text' => 'We leveraged cloud-native AI-driven horizontal microservices to achieve 100% zero-latency scalability with zero issues. When massive concurrency hit our platform, the dynamic autoscaling multi-region cluster effortlessly adapted, utilizing an enterprise next-gen distributed mesh architecture so no bottlenecks ever surfaced.',
            'depth_score' => 32,
            'verdict' => 'High LARP Risk',
            'analysis_data' => [
                'sub_scores' => [
                    'operational_depth' => 25,
                    'friction_handling' => 20,
                    'ownership' => 40,
                    'logical_consistency' => 43,
                ],
                'flags' => [
                    [
                        'severity' => 'red',
                        'quote' => 'We leveraged cloud-native AI-driven horizontal microservices to achieve 100% zero-latency scalability with zero issues',
                        'reason' => 'Vague buzzword barrage making implausible zero-latency and zero-issue claims without discussing real-world trade-offs.',
                    ],
                ],
                'drill_downs' => [
                    [
                        'topic' => 'Database Contention',
                        'question' => 'When microservices auto-scaled, how did the database cluster handle connection saturation and transaction lock contention?',
                        'expected_signal' => 'A real practitioner identifies write serialisation or pool exhaustion; a LARPer reiterates container auto-scaling.',
                    ],
                ],
            ],
        ]);
    }
}
