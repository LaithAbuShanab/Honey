<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct(protected ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        try {
            $products = $this->productRepository->all();
            return ApiResponse::sendResponse(200, __('app.success'), $products);
        } catch (\Exception $e) {
            return ApiResponse::sendResponseError(401, $e->getMessage());
        }
    }

    public function updatePrice(Request $request, $slug)
    {
        $validator = Validator::make(
            ['slug' => $slug, 'color' => $request->color, 'weight' => $request->weight],
            ['slug' => 'required|exists:products,slug', 'color' => 'nullable', 'weight' => 'nullable']
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return ApiResponse::sendResponseError(Response::HTTP_BAD_REQUEST,  $errors);
        }

        try {
            $products = $this->productRepository->updatePrice($request->all(), $slug);
            return ApiResponse::sendResponse(200, __('app.success'), $products);
        } catch (\Exception $e) {
            return ApiResponse::sendResponseError(401, $e->getMessage());
        }
    }
}
