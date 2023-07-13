<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/core/helpers.php';

$site = site();

$request = request();
$requestData = $request->all();

if (isset($requestData['google_recaptcha_token'])) {
    try {
        $googleRecaptchaAssessment = assessGoogleRecaptcha($requestData['google_recaptcha_token']);
    } catch (\Throwable $e) {
        \Sentry\captureException($e);
    }
}

if (isset($requestData['free_estimate'])) {
    $freeEstimateData = $requestData['free_estimate'];

    if (isset($googleRecaptchaAssessment) && $googleRecaptchaAssessment === true) {
        try {
            $freeEstimateNotify = $site->theme()->setting('free_estimate_notify');

            if (isset($freeEstimateNotify)) {
                $freeEstimateNotify = array_map('trim', explode(',', $freeEstimateNotify));
                $freeEstimateCc = array_map('trim', explode(',', $site->theme()->setting('free_estimate_cc')));

                \Illuminate\Support\Facades\Mail::to($freeEstimateNotify)
                    ->cc($freeEstimateCc)
                    ->send(new \Theme\Mailables\FreeEstimateRequest($freeEstimateData));
            } else {
                throw new \Exception("Setting 'free_estimate_notify' not defined");
            }
        } catch (\Throwable $e) {
            \Sentry\captureException($e);
        }

        try {
            $pipedriveApiToken = $site->theme()->setting('pipedrive_api_token');
            $pipedrivePostalAddressFieldToken = $site->theme()->setting('pipedrive_postal_address_field_token');

            if (isset($pipedriveApiToken)) {
                $pipedriveClient = new \Pipedrive\Client(
                    apiToken: $pipedriveApiToken,
                );

                $pipedrivePerson = [
                    'name' => $freeEstimateData['name']['value'] ?? '???',
                    'visible_to' => 3, // 3 = entire company
                ];

                if (isset($pipedrivePostalAddressFieldToken)) {
                    $pipedrivePerson[$pipedrivePostalAddressFieldToken] = "{$freeEstimateData['city']['value']}, {$freeEstimateData['postal_code']['value']}";
                }

                if (isset($freeEstimateData['tel']['value'])) {
                    $pipedrivePerson['phone'] = [
                        'value' => $freeEstimateData['tel']['value'],
                        'primary' => true,
                        'label' => "form",
                    ];
                }

                if (isset($freeEstimateData['email']['value'])) {
                    $pipedrivePerson['email'] = [
                        'value' => $freeEstimateData['email']['value'],
                        'primary' => true,
                        'label' => "form",
                    ];
                }

                $addAPersonResponse = $pipedriveClient->getPersons()->addAPerson($pipedrivePerson);

                if ($addAPersonResponse->success && isset($addAPersonResponse->data->id)) {
                    $pipedrivePersonId = $addAPersonResponse->data->id;

                    $pipedriveDeal = [
                        'title' => $freeEstimateData['name']['value'],
                        'person_id' => $pipedrivePersonId,
                    ];

                    $addADealResponse = $pipedriveClient->getDeals()->addADeal($pipedriveDeal);

                    if ($addADealResponse->success && isset($addADealResponse->data->id)) {
                        $pipedriveDealId = $addADealResponse->data->id;

                        if (isset($freeEstimateData['comments']['value'])) {
                            $pipedriveNote = [
                                'content' => $freeEstimateData['comments']['value'],
                                'dealId' => $pipedriveDealId,
                            ];

                            $addANoteResponse = $pipedriveClient->getNotes()->addANote($pipedriveNote);

                            if (! $addANoteResponse->success) {
                                throw new \Exception("Could not create Pipedrive Note");
                            }
                        }

                        if (isset($freeEstimateData['files'])) {
                            if (function_exists('curl_file_create')) {
                                foreach ($freeEstimateData['files'] as $file) {
                                    if (isset($file['name'], $file['content'])) {
                                        try {
                                            $filepath = mkfile($file['content']);

                                            $pipedriveFile = [
                                                'file' => $filepath,
                                                'dealId' => $pipedriveDealId,
                                            ];

                                            $addFileResponse = $pipedriveClient->getFiles()->addFile($pipedriveFile);
                                        } catch (\Throwable $e) {
                                            \Sentry\captureException($e);
                                        }
                                    } else {
                                        \Sentry\captureMessage("Invalid file for Pipedrive: " . print_r($file, true));
                                    }
                                }
                            }
                        }
                    } else {
                        throw new \Exception("Could not create Pipedrive Deal");
                    }
                } else {
                    throw new \Exception("Could not create Pipedrive Person");
                }
            } else {
                throw new \Exception("Setting 'pipedrive_api_token' not defined");
            }
        } catch (\Throwable $e) {
            \Sentry\captureException($e);
        }
    }
}
