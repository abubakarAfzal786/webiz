
<?php
    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $IPNPost = array();
    foreach ($raw_post_array as $keyval) {
        $keyval = explode ('=', $keyval);
        if (count($keyval) == 2)
            $IPNPost[$keyval[0]] = urldecode($keyval[1]);
    }
 
$postData = array('GroupPrivateToken' => 'c23b6530-ea60-424a-86e2-f55501e4a907',
                        'SaleId'=>$IPNPost['SaleId'],
                        'TotalAmount'=>$IPNPost['TransactionAmount']
                        );
 
 
    $jsonData = json_encode($postData);
    $curlObj = curl_init();
 
    curl_setopt($curlObj, CURLOPT_URL, 'https://testicredit.rivhit.co.il/API/PaymentPageRequest.svc/Verify');
    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curlObj, CURLOPT_HEADER, 0);
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    curl_setopt($curlObj, CURLOPT_POST, 1);
    curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
 
    $response = curl_exec($curlObj);
    //change the response json string to object
    $json = json_decode($response);
    curl_close($curlObj);
 
    // inspect IPN validation result and act accordingly
    if ($json->Status == 'VERIFIED'){
        // Do things after a payment is completed
    }
 
?>