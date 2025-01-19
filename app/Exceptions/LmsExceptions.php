<?php

namespace App\Exceptions;

use app\Shared\Constants\MessageResponse;
use App\Enums\MySQLExceptions;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

trait LmsExceptionsTrait
{
    private function jsonResponse($status, $statusCode, $message, $data = null)
    {
        $response = [
            'response' => [
                'status'      => $status,
                'status_code' => $statusCode,
                'message'     => $message,
            ]
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }


    private function errorResponse($status, $statusCode, $message, $errorDetails = null)
    {
        $response = [
            'response' => [
                'status'      => $status,
                'status_code' => $statusCode,
                'error'     => [
                    'message'   => $message,
                    'timestamp' => Carbon::now(),
                ],
            ]
        ];
        if ($errorDetails !== null) {
            $response['response']['error']['details'] = $errorDetails;
        }
        return $response;
    }


    private function recordNotFoundResponse($exception)
    {
        return $this->errorResponse(MySQLExceptions::ERROR, Response::HTTP_NOT_FOUND, MessageResponse::NO_QUERY_RESULTS, 'Record id ' . $exception->getIds()[0] . ' is invalid');
    }

    private function serverErrorResponse()
    {
        return $this->errorResponse(MySQLExceptions::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR, MessageResponse::INTERNAL_SERVER_ERROR_MESSAGE);
    }

    private function invalidIdDataTypeResponse()
    {
        return $this->errorResponse(MySQLExceptions::ERROR, Response::HTTP_BAD_REQUEST, MessageResponse::NON_NUMERIC_ID, 'Please provide a numeric id');
    }

    private function queryExceptionResponse($exception)
    {
        $errorCode = $exception->errorInfo[1];
        if ($errorCode == MySQLExceptions::ER_DUP_ENTRY) {
            return $this->jsonResponse(MySQLExceptions::ERROR, Response::HTTP_INTERNAL_SERVER_ERROR, $exception->errorInfo[2]);
        }
    }

    private function forbiddenAccessResponse()
    {
        return $this->errorResponse(MySQLExceptions::ERROR, Response::HTTP_FORBIDDEN, MessageResponse::FORBIDDEN);
    }

    private function unauthorizedResponse()
    {
        return $this->errorResponse(MySQLExceptions::ERROR, Response::HTTP_UNAUTHORIZED, MessageResponse::UNAUTHORIZED);
    }

    private function logoutResponse()
    {
        return $this->jsonResponse(MySQLExceptions::SUCCESS, Response::HTTP_OK, MessageResponse::LOGGED_OUT_SUCCESSFULLY);
    }

    private function preparedResponse($actionName)
    {
        $actions = [
            'index'   => [MySQLExceptions::SUCCESS, Response::HTTP_OK, MessageResponse::RETRIEVED_SUCCESSFULLY],
            'store'   => [MySQLExceptions::SUCCESS, Response::HTTP_CREATED, MessageResponse::CREATED_SUCCESSFULLY],
            'show'    => [MySQLExceptions::SUCCESS, Response::HTTP_OK, MessageResponse::FETCHED_SUCCESSFULLY],
            'update'  => [MySQLExceptions::SUCCESS, Response::HTTP_OK, MessageResponse::UPDATED_SUCCESSFULLY],
            'destroy' => [MySQLExceptions::SUCCESS, Response::HTTP_OK, MessageResponse::DELETED_SUCCESSFULLY]
        ];

        if (array_key_exists($actionName, $actions)) {
            return [
                'response' => [
                    'status'      => $actions[$actionName][0],
                    'status_code' => $actions[$actionName][1],
                    'message'     => $actions[$actionName][2]
                ]
            ];
        }
    }

    private function recordException($e)
    {
        Log::error($e->getMessage() . ' in file ' . $e->getFile() . ' at line ' . $e->getLine());
    }

    private function JWTCustomResponse($message)
    {
        $response = [
            'response' => [
                'status'      => MySQLExceptions::ERROR,
                'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'error'     => [
                    'message'   => $message,
                    'timestamp' => Carbon::now(),
                ],
            ]
        ];

        return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
