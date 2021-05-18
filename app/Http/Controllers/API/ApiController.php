<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ApiController extends BaseController
{
    use  DispatchesJobs, ValidatesRequests;

    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_NO_CONTENT = 204;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_NOT_FOUND = 404;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_UNPROCESSABLE_ENTITY = 422;
    const HTTP_ERROR = 500;

    const MESSAGE_SUCCESS = 1;
    const MESSAGE_VALIDATION_ERROR = 2;
    const MESSAGE_UNKNOWN_ERROR = 3;
    const MESSAGE_NOT_FOUND = 4;

    protected $paginationLimit = 15;
    protected $getLimit = 6;

    /**
     * Generate Json Response.
     *
     * @param $data
     * @param $status
     * @param $message
     * @param array $error
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonResponse($status, $message, $data, $error = [])
    {
        $response = [
            'meta' => [
                'error' => $error,
                'message' => $this->responseMessage($message)
            ],
            'body' => $data
        ];

        return response()->json($response, $status);
    }

    /**
     * Generate Response Message for Json Responses.
     *
     * @param $code
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    protected function responseMessage($code)
    {
        switch ($code) {
            case static::MESSAGE_SUCCESS:
                return trans('messages.success');

            case static::MESSAGE_VALIDATION_ERROR:
                return trans('messages.not_valid_input');

            case static::MESSAGE_UNKNOWN_ERROR:
                return trans('messages.unknown_error');

            case static::MESSAGE_NOT_FOUND:
                return trans('messages.not_found');

            default:
                return trans($code);
        }
    }
}
