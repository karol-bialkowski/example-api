<?php

declare(strict_types=1);

namespace App\Logic;

use Illuminate\Http\JsonResponse;

class ApiRepresentation
{

    /**
     * @var array
     */
    private $payload;
    /**
     * @var bool
     */
    private $status;
    /**
     * @var int
     */
    private $http_code;
    /**
     * @var string
     */
    private $message;

    /**
     * ApiRepresentation constructor.
     * @param array $payload
     * @param bool $status
     * @param int $http_code
     * @param string $message
     */
    public function __construct(array $payload, bool $status, int $http_code, string $message = '')
    {
        $this->payload = $payload;
        $this->status = $status;
        $this->http_code = $http_code;
        $this->message = $message;
    }


    /**
     * @return JsonResponse
     */
    public function getRepresentation(): JsonResponse
    {
        $response = [
            'status' => $this->status,
            'payload' => $this->payload,
        ];

        if (!$this->status) {
            $response['message'] = $this->message;
        }

        return new JsonResponse($response, $this->http_code);
    }


}
