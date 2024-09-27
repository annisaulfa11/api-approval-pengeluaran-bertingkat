<?php

namespace Tests\Unit;

use App\Models\Expense;
use App\Models\Status;
use App\Models\Approver;
use App\Models\ApprovalStage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateExpense()
    {
        $statusWaiting = Status::create(['name' => 'menunggu persetujuan']);
        $statusApproved = Status::create(['name' => 'disetujui']);
        $approver = Approver::create(['name' => 'Ana']);
        $stage = ApprovalStage::create(['approver_id' => $approver->id]);

        $response = $this->post('/api/expense', [
            'amount' => 500,
            'status_id' => $statusWaiting->id
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('expenses', [
            'amount' => 500,
            'status_id' => $statusWaiting->id
        ]);
    }

    public function testGetExpense()
    {
        $statusWaiting = Status::create(['name' => 'menunggu persetujuan']);
        $statusApproved = Status::create(['name' => 'disetujui']);

        $expense = Expense::create(['amount' => 500, 'status_id' => $statusWaiting->id]);

        $response = $this->get("/api/expense/{$expense->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'amount' => 500,
            'status_id' => $statusWaiting->id
        ]);
    }

}

