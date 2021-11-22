<?php

class SwishPayment {

    private string $root = "../payments/swish/Getswish_Test_Certificates/Swish_TLS_RootCA.pem";

    private string $pem = "../payments/swish/Getswish_Test_Certificates/Swish_Merchant_TestCertificate_1234679304.pem";

    private string $key = "../payments/swish/Getswish_Test_Certificates/Swish_Merchant_TestCertificate_1234679304.key";

    private string $createAddress = "https://mss.cpc.getswish.net/swish-cpcapi/api/v1/paymentrequests";

    private string $getAddress = "https://mss.cpc.getswish.net/swish-cpcapi/api/v1/paymentrequests/";

    private array $testData = array("payeePaymentReference" => "0123456789", "callbackUrl" => "https://example.com/api/swishcb/paymentrequests", "payerAlias" => "4671234768", "payeeAlias" => "1231181189", "amount" => "100", "currency" => "SEK", "message" => "Kingston USB Flash Drive 8 GB");

    public function __construct($database = null, Functions $functions = null){
        $this->db = $database;
        $this->fk = $functions;
    }  

    function createPaymentRequest() {

		$data_string = json_encode($this->testData);

		$header = array(    
			'Content-Type: application/json','Content-Length: ' .strlen($data_string));

		$ch = curl_init();
   
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, $this->createAddress);
		curl_setopt($ch, CURLOPT_URL, $this->createAddress);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		if (substr($this->createAddress, 0, 5) == 'https') { curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); }
		curl_setopt($ch, CURLOPT_SSLCERT, realpath($this->pem));
		curl_setopt($ch, CURLOPT_SSLCERTTYPE,"pem");
		curl_setopt($ch, CURLOPT_SSLCERTPASSWD, 'swish');
		
		curl_setopt($ch, CURLOPT_CAINFO, realpath($this->root));      
        curl_setopt($ch, CURLOPT_SSLKEY, realpath($this->key));
        curl_setopt($ch, CURLOPT_SSLVERSION, 5);
		/*curl_setopt($ch, CURLOPT_HEADERFUNCTION,
	 		function($curl, $header) use (&$headers) {
				// this function is called by curl for each header received
		    	$len = strlen($header);
		    	$header = explode(':', $header, 2);
		    	if (count($header) < 2) {
                    // ignore invalid headers
		      		return $len;
		    	} 

		    	$name = strtolower(trim($header[0]));
		    	echo "[". $name . "] => " . $header[1];

		    	return $len;
		 	 }
		);*/

		/*if(!$response = curl_exec($ch)) { 
	       trigger_error(curl_error($ch)); 
		}*/
		
		$result = curl_exec($ch);
		if ($result === false) {
			echo curl_error($ch);
		}
		$response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if ($response_code == 200 or $response_code == 201) {
			echo 'The request was successfull.'; // Actually you should expect to get 201 in return.
		} else {
			echo 'The request failed. Code: ' . $response_code;
		}

		//curl_close($ch);
	}

    function getPaymentRequest(string $req) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getAddress.$req);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, realpath($this->root));
        curl_setopt($ch, CURLOPT_SSLCERTTYPE,"PEM");
        curl_setopt($ch, CURLOPT_SSLCERT, realpath($this->pem));
        curl_setopt($ch, CURLOPT_SSLCERTPASSWD, 'swish');
        curl_setopt($ch, CURLOPT_SSLKEY, realpath($this->key));
        curl_setopt($ch, CURLOPT_SSLVERSION, 5);
		curl_setopt($ch, CURLOPT_HEADERFUNCTION,
	 		function($curl, $header) use (&$headers) {
				// this function is called by curl for each header received
		    	$len = strlen($header);
		    	$header = explode(':', $header, 2);
		    	if (count($header) < 2) {
		    		// ignore invalid headers
		      		return $len;
		    	} 

		    	$name = strtolower(trim($header[0]));
		    	echo "[". $name . "] => " . $header[1];

		    	return $len;
		 	}
        );                                            

		if(!$response = curl_exec($ch)) { 
	      trigger_error(curl_error($ch)); 
        }

		curl_close($ch);
	}

} ?>