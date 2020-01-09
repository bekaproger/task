<?php

namespace Lil\Http;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Lil\Session\SessionInterface;

class Request extends SymfonyRequest
{
    /**
     * @var SessionInterface
     */
    protected $session;

    public function uri()
    {
        return rtrim(preg_replace('/\?.*/', '', $this->getUri()), '/');
    }

    public function ajax()
    {
        return $this->isXmlHttpRequest();
    }

    public function path()
    {
        $pattern = trim($this->getPathInfo(), '/');

        return $pattern;
    }

    public function fullUrl()
    {
        $query = $this->getQueryString();

        $question = '/' === $this->getBaseUrl().$this->getPathInfo() ? '/?' : '?';

        return $query ? $this->uri().$question.$query : $this->uri();
    }

    public function getSession(): SessionInterface
    {
        return $this->session;
    }

    public function setRequestSessionData(int $count = 1, $data = null)
    {
        if (!$data) {
            return;
        }

        $this->session->set('session_request_data', ['count' => $count, 'data' => $data]);
    }

    public function removeRequestSessionData()
    {
        $this->session->remove('session_request_data');
    }

    public function decrementRequestSessionData()
    {
        $data = $this->session->get('session_request_data', null);
        if (!$data || empty($data)) {
            return;
        }

        if ($data['count'] <= 0) {
            $this->removeRequestSessionData();
        } else {
            $this->setRequestSessionData($data['count'] - 1, $data['data']);
        }
    }

    public function getRequestSessionData($key, $default = null)
    {
        return $this->session->get('session_request_data')['data'][$key] ?? $default;
    }

    public function validationErrors()
    {
        return $this->getRequestSessionData('errors', []);
    }

    public function setValidationErrors(array $errors)
    {
        $this->setRequestSessionData(1, ['errors' => $errors]);
    }

    public function getRequestSessionAlerts()
    {
        return $this->getRequestSessionData('alerts', []);
    }

    public function setRequestSessionAlerts(array $alerts)
    {
        $this->setRequestSessionData(1, ['alerts' => $alerts]);
    }
}
