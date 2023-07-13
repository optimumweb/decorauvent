<?php

use Google\Cloud\RecaptchaEnterprise\V1\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\Event;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\TokenProperties\InvalidReason;

function assessGoogleRecaptcha(string $token, string $projectId = null, string $siteKey = null, float $minimumScore = null)
{
    $projectId ??= site()->theme()->setting('google_project_id');
    $siteKey ??= site()->theme()->setting('google_recaptcha_site_key');
    $minimumScore ??= site()->theme()->setting('google_recaptcha_min_score');

    $client = new RecaptchaEnterpriseServiceClient([
        'credentials' => site()->theme()->path('credentials/google-credentials.json'),
    ]);

    $projectName = $client->projectName($projectId);

    $event = (new Event())
        ->setSiteKey($siteKey)
        ->setToken($token);

    $assessment = (new Assessment())
        ->setEvent($event);

    try {
        $response = $client->createAssessment(
            $projectName,
            $assessment
        );

        if ($response->getTokenProperties()->getValid()) {
            $score = $response->getRiskAnalysis()->getScore();

            if (isset($minimumScore)) {
                $minimumScore = (float) $minimumScore;

                if ($score >= $minimumScore) {
                    return true;
                } else {
                    \Sentry\captureMessage("Google reCAPTCHA Assessment: Score below minimum: {$score} / {$minimumScore}");
                }
            } else {
                return true;
            }
        } else {
            $invalidReason = $response->getTokenProperties()->getInvalidReason();
            $invalidReasonName = InvalidReason::name($invalidReason);
            \Sentry\captureMessage("Google reCAPTCHA Assessment Failed: {$invalidReason} - {$invalidReasonName}");
        }
    } catch (exception $e) {
        \Sentry\captureException($e);
    }

    return false;
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
