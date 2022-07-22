<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:make
                            {--name= : name of tenant}
                            {--domain= : domain of tenant}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a tenant';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tenantName   = $this->option('name');
        $tenantDomain = $this->option('domain');
        if (Tenant::query()->whereDomain($tenantDomain)->exists()) {
            $this->error('Tenant with domain: ' . $tenantDomain . ' is existed');
            return 1;
        }

        try {
            $database = Str::replace(['.', '-'], '_', $tenantDomain);
            $tenant   = Tenant::query()->create([
                'name'     => $tenantName,
                'domain'   => $tenantDomain,
                'database' => $database
            ]);
        } catch (\Exception $exception) {
            $this->error('Create is failed. Error: ' . $exception->getMessage());
        }

        $this->info("Create success tenant $tenantName with domain $tenantDomain");
        return 0;
    }
}
