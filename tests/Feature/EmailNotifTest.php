<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class EmailNotifTest extends TestCase
{
    use RefreshDatabase;

    public function testEmailNotif()
    {
        $currentTime = Carbon::now();

        // Set the initial time
        Carbon::setTestNow($currentTime);

        // Your mock data here
        $dummyData = [
            [
                'id_materialbom' => 'RTB1990',
                'nama_materialbom' => 'Material ABC',
                'supplier' => 'Impor', // Replace with the actual supplier value
                'usage_material' => 10,
                // Add other fields as needed
            ],
            // Add more data as needed
        ];

        // Mock your model (Detailbom in this case)
        $detailbomMock = Mockery::mock('alias:Detailbom');
        $detailbomMock->shouldReceive('where')->once()->andReturnSelf();
        $detailbomMock->shouldReceive('get')->once()->andReturn(collect($dummyData));

        // Simulate 2 days later
        Carbon::setTestNow($currentTime->copy()->addDays(2));

        $idBom = 'BOM123123';

        // Panggil method emailNotif
        $response = $this->post('/send-email-notif', [
            'idBom' => $idBom,
        ]);

        // Assertions and other test logic here

        // Simulate 5 more days later (total of 7 days)
        Carbon::setTestNow($currentTime->copy()->addDays(5));

        // Panggil method emailNotif again
        $response = $this->post('/send-email-notif', [
            'idBom' => $idBom,
        ]);

        // Assertions and other test logic here

        // Reset time to current time
        Carbon::setTestNow();
    }
}
