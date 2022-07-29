<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Tenant extends \Spatie\Multitenancy\Models\Tenant
{
    use HasFactory, AsSource, Filterable;

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
        $this->database = Str::replace(['.', '-'], '_', $this->domain);
        $charset        = 'utf8mb4';
        $collation      = 'utf8mb4_unicode_ci';
        $query          = "CREATE DATABASE IF NOT EXISTS {$this->database} CHARACTER SET {$charset} COLLATE {$collation};";
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
