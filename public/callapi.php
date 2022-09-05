<?php
header('Content-type: application/xml');

$curl = curl_init();

curl_setopt_array($curl, array(
    // CURLOPT_URL => 'https://sandbox.api.sap.com/s4hanacloud/sap/opu/odata/sap/API_MATERIAL_STOCK_SRV/A_MaterialStock',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => 'application/xml; charset=utf-8',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    // CURLOPT_HTTPHEADER => array(
    //     'apikey: zHuLOdpGLCocHTGAxbteTnCxoKFRAZLe'
    // ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
