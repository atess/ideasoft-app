<?php

namespace Base\Concretes;

use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BaseException extends Exception implements Responsable
{
    public int $status = Response::HTTP_BAD_REQUEST;

    public array $additional = [];

    public array $headers = [];

    final public function __construct($message = null, $code = null, Throwable $previous = null)
    {
        $message = $message ?? $this->defaultMessage();
        $code = $code ?? $this->defaultCode();

        parent::__construct($message, $code, $previous);
    }

    protected function defaultMessage(): string
    {
        return __('Unknown error');
    }

    protected function defaultCode(): int
    {
        return 500;
    }

    public function status(int $status): self
    {
        $this->status = $status;

        return $this;
    }


    public function headers(array $headers = []): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function additional(array $additional): self
    {
        $this->additional = $additional;

        return $this;
    }

    public static function withStatus(int $status, $message = null, $headers = []): self
    {
        return (new static($message))
            ->status($status)
            ->headers($headers);
    }

    public function toResponse($request): JsonResponse|Response
    {
        $response = config('app.debug') ? [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'exception' => get_class($this),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'trace' => collect($this->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ] : [
            'message' => $this->getMessage()
        ];

        if (count($this->additional)) {
            $response = $response + $this->additional;
        }

        return response()->json($response, $this->status)->withHeaders($this->headers);
    }
}
