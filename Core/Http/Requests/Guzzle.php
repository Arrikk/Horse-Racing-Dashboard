<?php

namespace Core\Http\Requests;

use App\Config;
use Core\Http\Requests\BaseReq;
use Core\Http\Res;
use GuzzleHttp;
use GuzzleHttp\Utils;

abstract class Guzzle extends BaseReq
{

    public $config = [];
    public $params;

    public $req;
    public $withBool = false;

    public function __construct($params = [], $header = [])
    {
        $this->req = new GuzzleHttp\Client([
            'base_uri' => Config::BASE_URL_REQUESTS
        ]);
        $this->params = GuzzleHttp\Psr7\Utils::streamFor(json_encode($params));
        $this->setConfig();
    }

    public function post($url = '', $useDefault = false)
    {
        try {
            $resp = $this->req->request('POST', $url, $this->config);
            Res::json($resp->getBody());
            return $resp->getBody(); 
        } catch (GuzzleHttp\Exception\ClientException $th) {
            $message = json_decode($th->getResponse()->getBody()->getContents());
            Res::status($th->getCode())->json($message);
        }
    }

    public function put($url = '', $useDefault = false)
    {
    }

    public function get($url, $useDefault = false)
    {
        try {
            $resp = $this->req->request('GET', $url, $this->config);
            return $resp->getBody();
        } catch (GuzzleHttp\Exception\ClientException $th) {
            $message = json_decode($th->getResponse()->getBody()->getContents());
            Res::status($th->getCode())->json($message);
        }
    }

    protected function setConfig(array $header = [])
    {
    }

    public function withBool()
    {
        $this->withBool = true;
        return $this;
    }
}
