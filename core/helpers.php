<?php

function grecaptchaVerify(string $token, string $secret = null)
{
    $secret ??= site()->theme()->setting('grecaptcha_secret_key');

    $client = new GuzzleHttp\Client([
        'base_uri' => 'https://www.google.com/recaptcha/api/',
    ]);

    $response = $client->post('siteverify', [
        'form_params' => [
            'secret' => $secret,
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR'],
        ],
    ]);

    $body = $response->getBody()->getContents();

    return json_decode($body, true);
}

function mkfile(string $base64)
{
    if (str_contains($base64, ';base64,')) {
        $data = explode(';base64,', $base64, 2);
        $base64 = $data[1];
    }
    $content = base64_decode($base64);
    $filename = tempnam(sys_get_temp_dir(), 'mkfile_');
    if (file_put_contents($filename, $content) === false) {
        throw new \Exception("Cannot write to file: {$filename}");
    }
    return $filename;
}
