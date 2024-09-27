<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Approver;


class ApproverDatabaseTest extends TestCase
{
    use RefreshDatabase;
    protected $approver;

    public function testDatabaseInteraction()
    {
        $approver = Approver::create(['name' => 'Test Approver']);

        $this->assertDatabaseHas('approvers', [
            'name' => 'Test Approver'
        ]);

    }
}
