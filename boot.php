<?php

namespace Theme;

use Illuminate\Support\Facades\Mail;

require_once 'mailables/FreeEstimate.php';

$request = request();
$requestData = $request->all();

if (isset($requestData['free_estimate'])) {
    $mailable = new FreeEstimate($requestData['free_estimate']);
    Mail::to('jroy@optimumweb.ca')->send($mailable);
}
