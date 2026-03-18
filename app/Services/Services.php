<?php
namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class Services
{

    /**
     * setResponse
     *
     * @param  mixed $data
     * @param  mixed $statusCode
     * @param  mixed $errorMessage
     * @return JsonResponse
     */
    public function setResponse($data = array() , $statusCode = 200 , $errorMessage = array()): JsonResponse
    {
        try {
            if($statusCode !== 200){
                throw new \Exception($errorMessage, $statusCode);
            }
            return $this->setSuccessResponse(
                $this->filterResponse($data,$statusCode , $errorMessage)
            ,$statusCode);
        } catch (\Throwable $th) {
            return $this->setErrorResponse($th->getMessage(),500);
        }
    }


    /**
     * setErrorResponse
     *
     * @param  mixed $data
     * @param  mixed $statusCode
     * @return JsonResponse
     */
    protected function setErrorResponse($data = [ 'message' => 'Failed' ] , $statusCode = 500): JsonResponse
    {

        return response()->json(
            self::filterResponse([] , $statusCode , $data )
        ,$statusCode);
    }

    /**
     * setSuccessResponse
     *
     * @param  mixed $data
     * @param  mixed $statusCode
     * @return JsonResponse
     */
    protected function setSuccessResponse($data = [ 'message' => 'Success' ] , $statusCode = 200): JsonResponse
    {
        return response()->json($data,$statusCode);
    }

    /**
     * filterResponse
     *
     * @param  mixed $response
     * @return array
     */
    protected function filterResponse($response = array(),$statusCode = 200 , $error = array()): array
    {
        return [
            'data' => $response,
            'status' => $statusCode,
            'error' => $error
        ];
    }
}
