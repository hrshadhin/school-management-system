<?php
 namespace App\Http\Helpers;

 use GuzzleHttp\Client;
 use GuzzleHttp\Exception\RequestException;
 use Illuminate\Support\Facades\App;
 use Illuminate\Support\Facades\Cache;

 class AppHelper
{

    public static function getUserSessionHash()
    {
        /**
         * Get file sha1 hash for copyright protection check
         */
        $path = base_path() . '/resources/views/backend/partial/footer.blade.php';
        $contents = file_get_contents($path);
        $c_sha1 = sha1($contents);
        return substr($c_sha1, 0, 7);
    }

    public static function getShortName($phrase)
    {
        /**
         * Acronyms generator of a phrase
         */
        return preg_replace('~\b(\w)|.~', '$1', $phrase);
    }

    public static function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function getJwtAssertion($private_key_file)
    {

        $json_file = file_get_contents($private_key_file);
        $info = json_decode($json_file);
        $private_key = $info->{'private_key'};

        //{Base64url encoded JSON header}
        $jwtHeader = self::base64url_encode(json_encode(array(
            "alg" => "RS256",
            "typ" => "JWT"
        )));

        //{Base64url encoded JSON claim set}
        $now = time();
        $jwtClaim = self::base64url_encode(json_encode(array(
            "iss" => $info->{'client_email'},
            "scope" => "https://www.googleapis.com/auth/analytics.readonly",
            "aud" => "https://www.googleapis.com/oauth2/v4/token",
            "exp" => $now + 3600,
            "iat" => $now
        )));

        $data = $jwtHeader.".".$jwtClaim;

        // Signature
        $Sig = '';
        openssl_sign($data,$Sig,$private_key,'SHA256');
        $jwtSign = self::base64url_encode($Sig);

        //{Base64url encoded JSON header}.{Base64url encoded JSON claim set}.{Base64url encoded signature}
        $jwtAssertion = $data.".".$jwtSign;
        return $jwtAssertion;
    }

    public static function getGoogleAccessToken($private_key_file)
    {

        $result = [
            'success' => false,
            'message' => '',
            'token' => null
        ];

        if (Cache::has('google_token')) {
            $result['token'] = Cache::get('google_token');
            $result['success'] = true;
            return $result;
        }

        if(!file_exists($private_key_file)){
            $result['message'] = 'Google json key file missing!';
            return $result;

        }

        $jwtAssertion = self::getJwtAssertion($private_key_file);

        try {

            $client = new Client([
                'base_uri' => 'https://www.googleapis.com',
            ]);
            $payload = [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwtAssertion
            ];

            $response = $client->request('POST', 'oauth2/v4/token', [
                'form_params' => $payload
            ]);

            $data = json_decode($response->getBody());
            $result['token'] = $data->access_token;
            $result['success'] = true;

            $expiresAt = now()->addMinutes(58);
            Cache::put('google_token', $result['token'], $expiresAt);

        } catch (RequestException $e) {
              $result['message'] = $e->getMessage();
        }


        return $result;

    }

     /**
      *
      *    Input any number in Bengali and the following function will return the English number.
      *
      */

     public static function en2bnNumber ($number)
     {
         $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
         $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
         $en_number = str_replace($search_array, $replace_array, $number);

         return $en_number;
     }
     /**
      *
      *    Translate number according to application locale
      *
      */
     public static function translateNumber($text)
     {
         $locale = App::getLocale();
         if($locale == "bn"){
             $transText = '';
             foreach (str_split($text) as $letter){
                 $transText .= self::en2bnNumber($letter);
             }
             return $transText;
         }
         return $text;
     }

}