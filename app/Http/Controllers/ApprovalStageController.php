<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ApprovalStageRepository;
use App\Http\Requests\StoreApprovalStageRequest;
use App\Http\Requests\UpdateApprovalStageRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ApprovalStageController extends Controller
{
    protected $approvalStageRepo;

    public function __construct(ApprovalStageRepository $approvalStageRepo)
    {
        $this->approvalStageRepo = $approvalStageRepo;
    }

    /**
     * @OA\Post(
     *     path="/api/approval-stages",
     *     summary="Tambahkan tahap approval baru",
     *     tags={"Approval Stage"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="approver_id", type="integer", example=1, description="ID dari approver")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tahap approval berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="approver_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Approver ID sudah ada di tahap lain")
     *         )
     *     )
     * )
     */
    public function store(StoreApprovalStageRequest $request)
    {
        try {
            $approvalStage = $this->approvalStageRepo->create($request->validated());
            return response()->json($approvalStage, 201);
        } catch (\Throwable $th) {
            return response()->json(['Terjadi kesalahan saat membuat tahap approval.'], 500);
        }
    }
    /**
     * @OA\Put(
     *     path="/api/approval-stages/{id}",
     *     summary="Ubah tahap approval",
     *     tags={"Approval Stage"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID tahap approval",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="approver_id", type="integer", example=2, description="ID approver baru")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tahap approval berhasil diubah",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="approver_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tahap approval tidak ditemukan",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Tahap approval tidak ditemukan")
     *         )
     *     )
     * )
     */
    public function update(UpdateApprovalStageRequest $request, $id)
    {
        try {
            $approvalStage = $this->approvalStageRepo->update($id, $request->validated());
            return response()->json($approvalStage, 200);
        } catch (\Throwable $th) {
            return response()->json(['Terjadi kesalahan saat meng-update tahap approval.'], 500);
        }
    }

}

