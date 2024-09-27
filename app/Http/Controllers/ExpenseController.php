<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreExpenseRequest;
use app\Models\Expense;
use App\Models\Approver;
use App\Models\Approval;
use App\Http\Requests\ApproveExpenseRequest;
use App\Repositories\Interfaces\ExpenseRepository;
use Illuminate\Http\JsonResponse;


use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    protected $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }
        /**
     * @OA\Post(
     *     path="/api/expense",
     *     summary="Buat pengeluaran baru",
     *     tags={"Expense"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="amount", type="integer", example=100000, description="Jumlah pengeluaran")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pengeluaran berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="amount", type="integer", example=100000),
     *             @OA\Property(property="status_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Jumlah pengeluaran harus berupa angka")
     *         )
     *     )
     * )
     */

    public function store(StoreExpenseRequest $request): JsonResponse
    {
        try {
            $expense = $this->expenseRepository->create($request->validated());
            return response()->json($expense, 201);
        } catch (\Throwable $th) {
            return response()->json(['Terjadi kesalahan saat menambah pengeluaran.'], 500);
        }
    }
        /**
     * @OA\Patch(
     *     path="/api/expense/{id}/approve",
     *     summary="Setujui pengeluaran",
     *     tags={"Expense"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID pengeluaran yang akan disetujui",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="approver_id", type="integer", example=1, description="ID approver")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pengeluaran berhasil disetujui",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="amount", type="integer", example=100000),
     *             @OA\Property(property="status_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Approver ini tidak diizinkan")
     *         )
     *     )
     * )
     */
    public function approve(ApproveExpenseRequest $request, $id): JsonResponse
    {
        try {
            $expense = $this->expenseRepository->approve($id, $request->approver_id);
            return response()->json($expense);
        } catch (\Throwable $th) {
            return response()->json(['Terjadi kesalahan saat menyetujui pengeluaran.'], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/expense/{id}",
     *     summary="Ambil detail pengeluaran",
     *     tags={"Expense"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID pengeluaran",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail pengeluaran",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="amount", type="integer", example=100000),
     *             @OA\Property(property="status", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Menunggu Persetujuan")
     *             ),
     *             @OA\Property(property="approvals", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="approver", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Ana")
     *                     ),
     *                     @OA\Property(property="status", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Disetujui")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pengeluaran tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Pengeluaran tidak ditemukan")
     *         )
     *     )
     * )
     */

    public function show($id): JsonResponse
    {
        try {
            $expense = $this->expenseRepository->find($id);
            return response()->json($expense);
        } catch (\Throwable $th) {
            return response()->json(['Terjadi kesalahan saat menampilkan pengeluaran.'], 500);
        }

    }

}
