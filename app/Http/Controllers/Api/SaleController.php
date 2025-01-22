<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Services\SaleService;
use App\Traits\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class SaleController extends Controller
{
    use ApiResponse;

    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function store(SaleRequest $request)
    {
        try {
            $sale = $this->saleService->createSale($request->validated());
            return $this->success($sale, "Sale created successfully.");
        } catch (ValidationException $e) {
            return $this->error(
                'Validation error: ' . implode(', ', $e->errors()),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (QueryException $e) {
            return $this->error(
                'Database error: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } catch (Exception $e) {
            return $this->error(
                'An unexpected error occurred: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
