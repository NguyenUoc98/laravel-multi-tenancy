<?php

namespace App\Console\Commands;

use App\Models\Landlord\Tenant;
use Illuminate\Console\Command;

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
        if (Tenant::query()->whereDomain($tenantDomain)->orWhere('name', $tenantName)->exists()) {
            $this->error('Tenant with domain: ' . $tenantDomain . ' is existed');
            return 1;
        }

        try {
            $tenant = Tenant::query()->create([
                'name'   => $tenantName,
                'domain' => $tenantDomain
            ]);
        } catch (\Exception $exception) {
            $this->error('Create is failed. Error: ' . $exception->getMessage());
        }

        $this->info("Create success tenant $tenantName with domain $tenantDomain");
        return 0;
    }
}
