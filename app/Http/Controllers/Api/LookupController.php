<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\LookupRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LookupController extends Controller
{
    public function __construct(protected LookupRepository $lookupRepository)
    {
        $this->lookupRepository = $lookupRepository;
    }

    public function index($slug = null)
    {
        $validator = Validator::make(['slug' => $slug], ['slug' => 'required',]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return ApiResponse::sendResponseError(Response::HTTP_BAD_REQUEST,  $errors);
        }

        try {
            $lookup = $this->lookupRepository->getBySlug($slug);
            return ApiResponse::sendResponse(200, __('app.loginSuccessfully'), $lookup);
        } catch (\Exception $e) {
            return ApiResponse::sendResponseError(401, $e->getMessage());
        }
    }
}
