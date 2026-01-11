<?php
/**
 * Voice Call API Integration
 * Uses environment variable for API token (secure)
 */
date_default_timezone_set("Asia/Kolkata");

function make_voice_call($audio, $mobile)
{
    // Get API token from environment variable
    $apiToken = getenv('VOICE_API_TOKEN') ?: ($_ENV['VOICE_API_TOKEN'] ?? null);
    
    if (empty($apiToken)) {
        error_log("VOICE_API_TOKEN not configured. Set the VOICE_API_TOKEN environment variable.");
        return ["result" => "failed", "msg" => "Voice call service not configured. Contact administrator."];
    }
    
    $startTime = "09:00:00";
    $endTime = "21:00:00";
    
    if (time() >= strtotime($startTime) && time() <= strtotime($endTime)) {
        // Get caller ID from environment or use default
        $callerId = getenv('VOICE_CALLER_ID') ?: ($_ENV['VOICE_CALLER_ID'] ?? '7977993616');
        
        // Sanitize and validate mobile number
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        if (strlen($mobile) === 13 && substr($mobile, 0, 2) === '91') {
            $mobile = substr($mobile, 2);
        } elseif (strlen($mobile) === 12 && substr($mobile, 0, 2) === '91') {
            $mobile = substr($mobile, 2);
        }
        
        // Validate mobile number format
        if (strlen($mobile) !== 10 || !preg_match('/^[6-9][0-9]{9}$/', $mobile)) {
            return ["result" => "failed", "msg" => "Invalid mobile number format"];
        }
        
        // Sanitize audio file name
        $audio = preg_replace('/[^a-zA-Z0-9_.-]/', '', basename($audio));
        
        $dateTime = date('Y-m-d H:i:s');
        $curl = curl_init();

        $postFields = http_build_query([
            'caller_id' => $callerId,
            'voice_file' => $audio,
            'mobile' => $mobile,
            'posting_time' => $dateTime,
            'is_conversation' => 1
        ]);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://voicecall.nutsms.com/api_v2/voice-call/campaign",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $apiToken,
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if ($err) {
            error_log("Voice call API error: " . $err);
            return ["result" => "failed", "msg" => "Voice call service temporarily unavailable"];
        }
        
        $result = json_decode($response, TRUE);
        
        if (!empty($result['success']) && $result['success'] == true) {
            $returnArray = ["result" => "success", "msg" => "Successfully Call(s) Sent."];
        } else if (empty($result['success']) || $result['success'] == false) {
            $errorMsg = isset($result['error']) ? $result['error'] : 'Unknown error';
            error_log("Voice call failed: " . $errorMsg);
            $returnArray = ["result" => "failed", "msg" => "Call failed. Please try again later."];
        } else {
            $returnArray = ["result" => "failed", "msg" => "Something went wrong. Please try again."];
        }
    } else {
        $returnArray = ["result" => "failed", "msg" => "You can only send calls from 09:00 AM to 09:00 PM"];
    }
    
    return $returnArray;
}
