<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Tenant extends \Spatie\Multitenancy\Models\Tenant
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'database'
    ];

    protected static function booted()
    {
        static::creating(fn(Tenant $model) => $model->createDatabase());
        static::created(fn(Tenant $model) => $model->migrateDatabase());
    }

    /**
     * Create new database with domain for tenant
     *
     * @return void
     */
    private function createDatabase(): void
    {
        $charset   = 'utf8mb4';
        $collation = 'utf8mb4_unicode_ci';
        $query     = "CREATE DATABASE IF NOT EXISTS {$this->database} CHARACTER SET {$charset} COLLATE {$collation};";
        DB::statement($query);
    }

    /**
     * Run migrate for tenant
     *
     * @return void
     */
    private function migrateDatabase(): void
    {
        Artisan::call('tenants:artisan "migrate --database=tenant"');
    }
}
