<?php

namespace App;

use App\BniEnc;
use Carbon\Carbon;

class VA
{

    protected $client_id;
    protected $secret_key;
    protected $url;

    public function __construct()
    {
        $this->client_id = '01574';
        $this->secret_key = '10e7ce3f502629521625a301f66da3b9';
        $this->url = 'https://apibeta.bni-ecollection.com/';
    }

    public function createVA($trx_id, $amount, $c_name, $c_email = '', $c_phone = '')
    {
        $payload = array(
            'client_id' => $this->client_id,
            'trx_id' => $trx_id,
            'trx_amount' => $amount,
            'billing_type' => 'c',
            'datetime_expired' => Carbon::now()->addDay(1)->format('Y-m-d h:i:s'),
            'virtual_account' => '',
            'customer_name' => $c_name,
            'customer_email' => $c_email,
            'customer_phone' => $c_phone,
            'type' => 'createbilling'
        );

        $data = array(
            'client_id' => $this->client_id,
            'data' => BniEnc::encrypt(
                $payload,
                $this->client_id,
                $this->secret_key
            ),
        );

        $response = $this->get_content($this->url, json_encode($data));
        $response_json = json_decode($response, true);

        if ($response_json['status'] !== '000') {
            return ['error' => 'Gagal membuat pembayaran'];
        } else {
            return BniEnc::decrypt($response_json['data'], $this->client_id, $this->secret_key);
        }
    }

    public function checkBill($trx_id)
    {

        $payload = array(
            'client_id' => $this->client_id,
            'trx_id' => $trx_id,
            'type' => 'inquirybilling'
        );

        $data = array(
            'client_id' => $this->client_id,
            'data' => BniEnc::encrypt(
                $payload,
                $this->client_id,
                $this->secret_key
            ),
        );

        $response = $this->get_content($this->url, json_encode($data));
        $response_json = json_decode($response, true);

        if ($response_json['status'] !== '000') {
            return ['error' => 'Gagal mengecek pembayaran'];
        } else {
            return BniEnc::decrypt($response_json['data'], $this->client_id, $this->secret_key);
        }
    }

    private function get_content($url, $post = '')
    {
        $header[] = 'Content-Type: application/json';
        $header[] = "Accept-Encoding: gzip, deflate";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        // curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");

        if ($post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $rs = curl_exec($ch);

        if (empty($rs)) {
            var_dump($rs, curl_error($ch));
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        return $rs;
    }
}
