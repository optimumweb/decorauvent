<?php

require_once __DIR__ . '/vendor/autoload.php';

$site = site();

$request = request();
$requestData = $request->all();

if (isset($requestData['free_estimate'])) {
    $freeEstimateData = $requestData['free_estimate'];

    try {
        $freeEstimateNotify = $site->theme->setting('free_estimate_notify');

        if (isset($freeEstimateNotify)) {
            $freeEstimateNotify = array_map('trim', explode(',', $freeEstimateNotify));

            \Illuminate\Support\Facades\Mail::to($freeEstimateNotify)
                ->send(new \Theme\Mailables\FreeEstimateRequest($freeEstimateData));
        }
    } catch (\Exception $e) {
        \Sentry\captureException($e);
    }

    try {
        $pipedriveApiToken = $site->theme->setting('pipedrive_api_token');
        $pipedrivePostalAddressFieldToken = $site->theme->setting('pipedrive_postal_address_field_token');

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
                        foreach ($freeEstimateData['files'] as $file) {
                            $filePath = $file->getRealPath();
                            $fileDir = dirname($filePath);
                            $fileName = basename($filePath);
                            $fileOriginalName = $file->getClientOriginalName();
                            $newFilePath = "{$fileDir}/{$fileOriginalName}";

                            $pipedriveFile = [
                                'file' => copy($filePath, $newFilePath) ? $newFilePath : $filePath,
                                'dealId' => $pipedriveDealId,
                            ];

                            $addFileResponse = $pipedriveClient->getFiles()->addFile($pipedriveFile);
                        }
                    }
                } else {
                    throw new \Exception("Could not create Pipedrive Deal");
                }
            } else {
                throw new \Exception("Could not create Pipedrive Person");
            }
        }
    } catch (\Exception $e) {
        \Sentry\captureException($e);
    }
}
