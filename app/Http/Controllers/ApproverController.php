<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ApproverRepository;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApproverRequest;

class ApproverController extends Controller
{
    protected $approverRepo;

    public function __construct(ApproverRepository $approverRepo)
    {
        $this->approverRepo = $approverRepo;
    }

        /**
     * @OA\Post(
     *     path="/api/approvers",
     *     summary="Tambahkan approver baru",
     *     tags={"Approver"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Ana", description="Nama approver")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Approver berhasil dibuat",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Ana")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Nama approver harus unik")
     *         )
     *     )
     * )
     */
    public function store(StoreApproverRequest $request)
    {
        try {
            $approver = $this->approverRepo->create($request->validated());
            return response()->json($approver, 201);
        } catch (\Throwable $th) {
            return response()->json(['Terjadi kesalahan saat menambah approver.'], 500);

        }
    }

}

