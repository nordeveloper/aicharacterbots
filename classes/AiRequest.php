<?php
namespace classes;

use Exception;

class AiRequest
{
    private array $headers;
    private int $timeout = 30;
    private object $stream_method;

    public const ORIGIN = 'https://openrouter.ai/api/v1';
    public const API_VERSION = '';
    public const AI_URL = self::ORIGIN . "/chat/completions";


    public function __construct($API_KEY)
    {
        $this->headers = [
            'Content-Type: application/json',
            "HTTP-Referer: https://".$_SERVER['HTTP_HOST'],
            "Authorization: Bearer $API_KEY",
        ];
    }


    /**
     * @param        $opts
     * @param  null  $stream
     * @return bool|string
     * @throws Exception
     */
    public function chat($opts)
    {
        return $this->sendRequest(self::AI_URL, 'POST', $opts);  
    }


    /**
     * @param  string  $url
     * @param  string  $method
     * @param  array   $opts
     * @return bool|string
     */
    public function sendRequest(string $url, string $method, array $opts = [])
    {
        $post_fields = json_encode($opts);

        $curl_info = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_POSTFIELDS     => $post_fields,
            CURLOPT_HTTPHEADER     => $this->headers,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0
        ];

        if ($opts == []) {
            unset($curl_info[CURLOPT_POSTFIELDS]);
        }

        if (array_key_exists('stream', $opts) && $opts['stream']) {
            $curl_info[CURLOPT_WRITEFUNCTION] = $this->stream_method;
        }

        $curl = curl_init();

        curl_setopt_array($curl, $curl_info);
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $response = curl_getinfo($curl);
        }

        curl_close($curl);

        return $response;
    }

}
