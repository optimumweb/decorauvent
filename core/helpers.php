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
