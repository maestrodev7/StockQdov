<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Services\SaleService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
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
            return $this->success($sale, "Sale created successfully.", Response::HTTP_CREATED);
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

    public function show(int $id)
    {
        try {
            $sale = $this->saleService->getSaleById($id);
            return $this->success($sale, "Sale retrieved successfully.");
        } catch (Exception $e) {
            return $this->error(
                'Error retrieving sale: ' . $e->getMessage(),
                Response::HTTP_NOT_FOUND
            );
        }
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only([
                'start_date',
                'end_date',
                'client_id',
                'product_id',
                'min_total_price',
                'max_total_price'
            ]);
            $sales = $this->saleService->filterSales($filters);
            return $this->success($sales, "Sales retrieved successfully.");
        } catch (Exception $e) {
            return $this->error(
                'Error retrieving sales: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(SaleRequest $request, int $id)
    {
        try {
            $sale = $this->saleService->updateSale($id, $request->validated());
            return $this->success($sale, "Sale updated successfully.");
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

    public function destroy(int $id)
    {
        try {
            $result = $this->saleService->deleteSale($id);
            if ($result) {
                return $this->success(null, "Sale deleted successfully.");
            }
            return $this->error("Sale deletion failed.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
