<?php
namespace Tests\Feature;

use App\Models\Expense;
use App\Models\Status;
use App\Models\Approver;
use App\Models\ApprovalStage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseApprovalTest extends TestCase
{
    use RefreshDatabase;

    private $approvers;
    private $expenses;

    public function setUp(): void
    {
        parent::setUp();

        $statusWaiting = Status::create(['name' => 'menunggu persetujuan']);
        $statusApproved = Status::create(['name' => 'disetujui']);

        $this->approvers = [
            $this->post('/api/approvers', ['name' => 'Ana'])->json('id'),
            $this->post('/api/approvers', ['name' => 'Ani'])->json('id'),
            $this->post('/api/approvers', ['name' => 'Ina'])->json('id'),
        ];

        foreach ($this->approvers as $approverId) {
            $this->post('/api/approval-stages', ['approver_id' => $approverId]);
        }

        $this->expenses = [
            $this->post('/api/expense', ['amount' => 100000, 'status_id' => $statusWaiting->id])->json('id'),
            $this->post('/api/expense', ['amount' => 200000, 'status_id' => $statusWaiting->id])->json('id'),
            $this->post('/api/expense', ['amount' => 300000, 'status_id' => $statusWaiting->id])->json('id'),
            $this->post('/api/expense', ['amount' => 400000, 'status_id' => $statusWaiting->id])->json('id')
        ];
    }

    public function testExpenseApprovalWorkflow()
    {
        // Pengeluaran pertama: disetujui semua approver
        foreach ($this->approvers as $approverId) {
            $response = $this->patchJson("/api/expense/{$this->expenses[0]}/approve", ['approver_id' => $approverId]);
            $response->assertStatus(200);
        }

        $statusApproved = Status::where('name', 'disetujui')->first();
        $this->assertDatabaseHas('expenses', [
            'id' => $this->expenses[0],
            'status_id' => $statusApproved->id
        ]);

        // Pengeluaran kedua: disetujui dua approver
        foreach (array_slice($this->approvers, 0, 2) as $approverId) {
            $response = $this->patchJson("/api/expense/{$this->expenses[1]}/approve", ['approver_id' => $approverId]);
            $response->assertStatus(200);
        }

        $statusWaiting = Status::where('name', 'menunggu persetujuan')->first();
        $this->assertDatabaseHas('expenses', [
            'id' => $this->expenses[1],
            'status_id' => $statusWaiting->id
        ]);

        // Pengeluaran ketiga: disetujui satu approver
        $response = $this->patchJson("/api/expense/{$this->expenses[2]}/approve", ['approver_id' => $this->approvers[0]]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('expenses', [
            'id' => $this->expenses[2],
            'status_id' => $statusWaiting->id
        ]);

        // Pengeluaran keempat: belum disetujui
        $this->assertDatabaseHas('expenses', [
            'id' => $this->expenses[3],
            'status_id' => $statusWaiting->id
        ]);
    }
}
