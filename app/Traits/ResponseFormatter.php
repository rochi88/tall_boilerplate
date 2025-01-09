<?php

declare(strict_types = 1);

namespace App\Traits;

trait ResponseFormatter
{
    public function formatResponse(array $responseDetails): array
    {
        $response = $this->createBaseResponse(
            $this->getStatusType($responseDetails['status']),
            $responseDetails['status_code'],
            $responseDetails['message'],
        );

        $response = $this->addOptionalData($response, $responseDetails['data']);

        return $this->addOptionalError($response, $responseDetails['error']);
    }

    private function createBaseResponse(string $statusType, int $statusCode, ?string $message): array
    {
        return [
            'response' => [
                'status'      => $statusType,
                'status_code' => $statusCode,
                'message'     => $message,
            ],
        ];
    }

    private function addOptionalData(array $response, $data): array
    {
        if ($data !== null) {
            $response['data'] = $data;
        }

        return $response;
    }

    private function addOptionalError(array $response, $error): array
    {
        if ($error !== null) {
            $response['response']['error']['details'] = $error;
        }

        return $response;
    }

    private function getStatusType(string $status): string
    {
        return $status === 'success' ? 'success' : 'error';
    }
}
