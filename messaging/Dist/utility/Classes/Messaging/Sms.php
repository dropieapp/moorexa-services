<?php
/** @noinspection All */
namespace Messaging;

class Sms
{
	// send sms configuration
	private $smsapi = "https://smartsmssolutions.com/api/json.php?";
	private $token = "oMv6QNJykNdKStcKX8XXlupdjNNT3PFXliyAzK14erZIoHU8wzAxafDfFEMCbZOLDPIu6aKtWp5hF7sdcSDokR75kBImU3042xVB";
    private $senderid = 'DEDA';

	// Send SMS
	public function send(string $message, string $sendto)
	{
        // @var array $build
		$build = [ 
            "sender" => $this->senderid, 
            "to" => $sendto, 
            "message" => $message,
            "type" => '0',
            "routing" => 4,
            'token' => $this->token
        ];

		// send sms;
        $ch = curl_init($this->smsapi);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($build));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);

		// JSON data 
		return $response;
	}

	// Check SMS balance
	public function balance()
	{
		
	}
}