<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Http\Requests\TransferFilterRequest;
use App\Services\TransferService;
use App\Traits\ApiResponse;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class TransferController extends Controller
{
    use ApiResponse;

    protected TransferService $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    /**
     * Handle a stock transfer request.
     */
    public function store(TransferRequest $request)
    {
        try {
            $transfer = $this->transferService->transfer(
                $request->from_type,
                $request->from_id,
                $request->to_type,
                $request->to_id,
                $request->product_id,
                $request->quantity
            );

            return $this->success(
                $transfer,
                'Transfer completed successfully.',
                Response::HTTP_CREATED
            );

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

        } catch (HttpException $e) {
            return $this->error(
                $e->getMessage(),
                $e->getStatusCode()
            );

        } catch (Exception $e) {
            return $this->error(
                'An unexpected error occurred: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function index(TransferFilterRequest $request)
    {
        try {
            $filters = $request->validated();

            $transfers = $this->transferService->filter($filters);

            return $this->success(
                $transfers,
                'Transfers retrieved successfully.'
            );

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

        } catch (HttpException $e) {
            return $this->error(
                $e->getMessage(),
                $e->getStatusCode()
            );

        } catch (Exception $e) {
            return $this->error(
                'An unexpected error occurred: ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
