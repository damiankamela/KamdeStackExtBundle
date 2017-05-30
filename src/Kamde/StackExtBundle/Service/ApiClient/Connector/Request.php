<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Connector;

class Request
{
    /** @var string */
    protected $method;

    /** @var string */
    protected $uri;

    /** @var array */
    protected $parameters;

    /**
     * @param string $method
     * @param string $uri
     * @param array  $parameters
     */
    public function __construct(string $method, string $uri, array $parameters = [])
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->parameters = $parameters;
        $this->build();
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return Request
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        $this->build();

        return $this;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return Request
     */
    public function setUri(string $uri): Request
    {
        $this->uri = $uri;
        $this->build();

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     * @return Request
     */
    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;
        $this->build();

        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return Request
     */
    public function setParameter(string $name, string $value): self
    {
        $this->parameters[$name] = $value;
        $this->build();

        return $this;
    }

    protected function build()
    {
        if ('GET' === strtoupper($this->method)) {
            $this->uri = $this->normalizeUrl($this->uri, $this->parameters);
            $this->parameters = [];
        }
    }

    /**
     * @param string $url
     * @param array  $parameters
     * @return string
     */
    protected function normalizeUrl(string $url, array $parameters)
    {
        $normalizedUrl = $url;

        if (!empty($parameters)) {
            $normalizedUrl .= (false !== strpos($url, '?') ? '&' : '?') . http_build_query($parameters, '', '&');
        }

        return $normalizedUrl;
    }
}