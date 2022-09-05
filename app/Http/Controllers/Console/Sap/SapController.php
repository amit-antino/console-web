<?php

namespace App\Http\Controllers\Console\Sap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SapController extends Controller
{
    public function store(Request $request)
    {
        header('Content-type: application/xml');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request->connurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => 'application/xml; charset=utf-8',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'apikey: ' . $request->api_key
            ),
        ));
        $response = curl_exec($curl);
        $file = './sapdata/tempfile.xml';
        file_put_contents($file, $response);
        echo "S4HANA Cloud Connected and Processed Data Successfully";
    }

    public function show()
    {
        // http://schemas.microsoft.com/ado/2007/08/dataservices
        $xml = file_get_contents("./sapdata/tempfile.xml");
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->loadXML($xml);
        $items = $dom->getElementsByTagName('entry');
        foreach ($items as $key => $item) {
            if ($key == 0) {
                continue;
            } else {
                $cnt = $item->getElementsByTagNameNS("", "*")->count();
                for ($m = 0; $m < $cnt; $m++) {
                    $var1 = $item->getElementsByTagNameNS("", "*")->item($m)->nodeName;
                    $aaa[$key][$var1] = $item->getElementsByTagNameNS("", "*")->item($m)->nodeValue;
                }
            }
        }
        $data['saparr'] = $aaa;
        return view('pages.console.sap_cloud.showdata', $data);
    }

    public function index(Type $var = null)
    {
        return view('pages.console.sap_cloud.index');
    }
}
