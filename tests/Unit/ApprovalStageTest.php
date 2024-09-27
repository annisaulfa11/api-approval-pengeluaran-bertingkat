<?php
namespace Tests\Unit;

use App\Models\ApprovalStage;
use App\Models\Approver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApprovalStageTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateApprovalStage()
    {
        $approver = Approver::create(['name' => 'Andi']);

        $response = $this->post('/api/approval-stages', [
            'approver_id' => $approver->id
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('approval_stages', [
            'approver_id' => $approver->id
        ]);
    }

    public function testUpdateApprovalStage()
    {
        $approver1 = Approver::create(['name' => 'Ana']);
        $approver2 = Approver::create(['name' => 'Ani']);
        $stage = ApprovalStage::create(['approver_id' => $approver1->id]);

        $stage = $this->put("/api/approval-stages/{$stage->id}", [
            'approver_id' => $approver2->id
        ]);

        $stage->assertStatus(200);

        $this->assertDatabaseHas('approval_stages', [
            'approver_id' => $approver2->id
        ]);

        $this->assertDatabaseMissing('approval_stages', [
            'approver_id' => $approver1->id
        ]);
    }
}
