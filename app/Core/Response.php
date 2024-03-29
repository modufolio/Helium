<?php

namespace App\Core;

use App\Throwable;

class Response
{
    /**
     * Store for all registered headers,
     * which will be sent with the response
     *
     * @var array
     */
    protected $headers = [];

    /**
     * The response body
     *
     * @var string
     */
    protected $body;

    /**
     * The HTTP response code
     *
     * @var int
     */
    protected $code;

    /**
     * The content type for the response
     *
     * @var string
     */
    protected $type;

    /**
     * The content type charset
     *
     * @var string
     */
    protected $charset = 'UTF-8';

    /**
     * Creates a new response object
     *
     * @param string $body
     * @param string $type
     * @param int $code
     * @param array $headers
     * @param string $charset
     */
    public function __construct($body = '', ?string $type = null, ?int $code = null, ?array $headers = null, ?string $charset = null)
    {
        // array construction
        if (is_array($body) === true) {
            $params = $body;
            $body = $params['body'] ?? '';
            $type = $params['type'] ?? $type;
            $code = $params['code'] ?? $code;
            $headers = $params['headers'] ?? $headers;
            $charset = $params['charset'] ?? $charset;
        }

        // regular construction
        $this->body = $body;
        $this->type = $type ?? 'text/html';
        $this->code = $code ?? 200;
        $this->headers = $headers ?? [];
        $this->charset = $charset ?? 'UTF-8';

    }

    /**
     * Improved `var_dump` output
     *
     * @return array
     */
    public function __debugInfo(): array
    {
        return $this->toArray();
    }

    /**
     * Makes it possible to convert the
     * entire response object to a string
     * to send the headers and print the body
     *
     * @return string
     */
    public function __toString(): string
    {
        try {
            return $this->send();
        } catch (Throwable $e) {
            return '';
        }
    }

    /**
     * Getter for the body
     *
     * @return string
     */
    public function body(): string
    {
        return $this->body;
    }

    /**
     * Getter for the content type charset
     *
     * @return string
     */
    public function charset(): string
    {
        return $this->charset;
    }

    /**
     * Getter for the HTTP status code
     *
     * @return int
     */
    public function code(): int
    {
        return $this->code;
    }



    /**
     * Getter for single headers
     *
     * @param string $key Name of the header
     * @return string|null
     */
    public function header(string $key): ?string
    {
        return $this->headers[$key] ?? null;
    }

    /**
     * Getter for all headers
     *
     * @return array
     */
    public function headers(): array
    {
        return $this->headers;
    }

    /**
     * Creates a json response with appropriate
     * header and automatic conversion of arrays.
     *
     * @param string|array $body
     * @param int $code
     * @param bool $pretty
     * @param array $headers
     * @return static
     */
    public static function json($body = '', ?int $code = null, ?bool $pretty = null, array $headers = []): Response
    {
        if (is_array($body) === true) {
            $body = json_encode($body, $pretty === true ? JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES : 0);
        }

        return new static([
            'body' => $body,
            'code' => $code,
            'type' => 'application/json',
            'headers' => $headers
        ]);
    }



    /**
     * Sends all registered headers and
     * returns the response body
     *
     * @return string
     */
    public function send(): string
    {
        // send the status response code
        http_response_code($this->code());

        // send all custom headers
        foreach ($this->headers() as $key => $value) {
            header($key . ': ' . $value);
        }

        // send the content type header
        header('Content-Type:' . $this->type() . '; charset=' . $this->charset());

        // print the response body
        return $this->body();
    }

    /**
     * Converts all relevant response attributes
     * to an associative array for debugging,
     * testing or whatever.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type(),
            'charset' => $this->charset(),
            'code' => $this->code(),
            'headers' => $this->headers(),
            'body' => $this->body()
        ];
    }

    /**
     * Getter for the content type
     *
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }
}

