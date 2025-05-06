<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Status;
use App\Http\Requests\StoreApprovalStageRequest;

use App\Models\Approver;
use Tests\TestCase;

class ExpenseApprovalTest extends TestCase
{
    use RefreshDatabase;
    public function test_full_approval_workflow()
    {
        // 1. Setup: Buat status yang diperlukan
        Status::create(['id' => Status::PENDING, 'name' => 'Pending']);
        Status::create(['id' => Status::APPROVED, 'name' => 'Approved']);

        // 2. Setup: Buat 3 approver
        $ana = Approver::create(['name' => 'Ana']);
        $ani = Approver::create(['name' => 'Ani']);
        $ina = Approver::create(['name' => 'Ina']);

        // 3. Setup: Buat 3 tahap approval (harus urut dan sesuai dengan approver)
        $this->postJson('/api/approval-stages', ['approver_id' => $ana->id])->assertStatus(201);
        $this->postJson('/api/approval-stages', ['approver_id' => $ani->id])->assertStatus(201);
        $this->postJson('/api/approval-stages', ['approver_id' => $ina->id])->assertStatus(201);

        // 4. Setup: Buat 4 pengeluaran
        $expense1 = $this->postJson('/api/expenses', ['amount' => 1000])->assertStatus(201);
        $expense2 = $this->postJson('/api/expenses', ['amount' => 2000])->assertStatus(201);
        $expense3 = $this->postJson('/api/expenses', ['amount' => 3000])->assertStatus(201);
        $expense4 = $this->postJson('/api/expenses', ['amount' => 4000])->assertStatus(201);

        $id1 = $expense1->json('data.id');
        $id2 = $expense2->json('data.id');
        $id3 = $expense3->json('data.id');
        $id4 = $expense4->json('data.id');

        // 5. Approve Expense 1 oleh 3 approver → Harus jadi APPROVED
        $this->patchJson("/api/expenses/{$id1}/approve", ['approver_id' => $ana->id])->assertStatus(200);
        $this->patchJson("/api/expenses/{$id1}/approve", ['approver_id' => $ani->id])->assertStatus(200);
        $this->patchJson("/api/expenses/{$id1}/approve", ['approver_id' => $ina->id])->assertStatus(200);

        $response1 = $this->getJson("/api/expenses/detail/{$id1}")->assertStatus(200);
        $this->assertEquals(Status::APPROVED, $response1->json('data.status.id'));

        // 6. Approve Expense 2 oleh Ana dan Ani → Masih PENDING
        $this->patchJson("/api/expenses/{$id2}/approve", ['approver_id' => $ana->id])->assertStatus(200);
        $this->patchJson("/api/expenses/{$id2}/approve", ['approver_id' => $ani->id])->assertStatus(200);

        $response2 = $this->getJson("/api/expenses/detail/{$id2}")->assertStatus(200);
        $this->assertEquals(Status::PENDING, $response2->json('data.status.id'));

        // 7. Approve Expense 3 oleh Ana saja → Masih PENDING
        $this->patchJson("/api/expenses/{$id3}/approve", ['approver_id' => $ana->id])->assertStatus(200);

        $response3 = $this->getJson("/api/expenses/detail/{$id3}")->assertStatus(200);
        $this->assertEquals(Status::PENDING, $response3->json('data.status.id'));

        // 8. Expense 4 belum di-approve sama sekali → Masih PENDING
        $response4 = $this->getJson("/api/expenses/detail/{$id4}")->assertStatus(200);
        $this->assertEquals(Status::PENDING, $response4->json('data.status.id'));
    }
}
