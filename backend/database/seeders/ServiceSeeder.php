<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            ['name' => 'Airtime', 'icon' => 'phone', 'screen' => 'Airtime', 'disabled' => false],
            ['name' => 'Intl Airtime', 'icon' => 'phone', 'screen' => 'InternationalAirtime', 'disabled' => true],
            ['name' => 'Data', 'icon' => 'server', 'screen' => 'Data', 'disabled' => false],
            ['name' => 'Electricity', 'icon' => 'sun', 'screen' => 'Electricity', 'disabled' => false],
            ['name' => 'Cable TV', 'icon' => 'tv', 'screen' => 'CableTv', 'disabled' => false],
            ['name' => 'Education', 'icon' => 'help-circle', 'screen' => 'Education', 'disabled' => false],
            ['name' => 'Jamb', 'icon' => 'help-circle', 'screen' => 'Jamb', 'disabled' => false],
            ['name' => 'Betting', 'icon' => 'crosshair', 'screen' => 'Betting', 'disabled' => false],
            ['name' => 'Flight Booking', 'icon' => 'chevrons-up', 'screen' => 'Electricity', 'disabled' => true],
            ['name' => 'Events Ticket', 'icon' => 'calendar', 'screen' => 'Events', 'disabled' => true],
            ['name' => 'Pay Remita', 'icon' => 'file', 'screen' => 'RemitaRRR', 'disabled' => false],
            ['name' => 'Airtime to Cash', 'icon' => 'target', 'screen' => 'AirtimeToCash', 'disabled' => false],
            ['name' => 'View RRR Receipts', 'icon' => 'file-text', 'screen' => 'Receipt', 'disabled' => false],
            ['name' => 'TSA & Tax', 'icon' => 'file-minus', 'screen' => 'TSAAndStates', 'disabled' => true],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['name' => $service['name']], $service);
        }
    }
}
