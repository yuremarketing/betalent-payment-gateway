<?php
namespace Database\Seeders;
use App\Models\Gateway;
use Illuminate\Database\Seeder;

class GatewaySeeder extends Seeder {
    public function run(): void {
        Gateway::updateOrCreate(['name' => 'Gateway A'], ['api_url' => 'http://gateways-mock:3001', 'priority' => 1]);
        Gateway::updateOrCreate(['name' => 'Gateway B'], ['api_url' => 'http://gateways-mock:3002', 'priority' => 2]);
    }
}
