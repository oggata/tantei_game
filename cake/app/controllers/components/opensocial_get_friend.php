<?php
//require_once('./OAuth.php');
require_once(BASE_DIR.'/cake/app/controllers/components/OAuth.php');

//銀行用のKEYです。
define(_CONSUMER_KEY_, '3080f8688f6624390eae');
define(_CONSUMER_SECRET_, 'c504a7539d5f09797af89b70eaf76e9c9bbf4924');

class TestRestfulAPI
{
   private $_base_feed  = NULL;
   private $_consumer  = NULL;
   private $_viewer_id   = NULL;

   public function __construct($viewer_id=NULL)
   {
       if (!$viewer_id && is_null($viewer_id)) return false;
       $this->_viewer_id  = $viewer_id;
       $this->_base_feed = sprintf('http://api.mixi-platform.com/os/0.8/people/%s/@friends', $this->_viewer_id);
   }

   public function get()
   {
       try{
//          $params = array('xoauth_requestor_id' => $this->_viewer_id);
      $params = array(
          'xoauth_requestor_id' => $this->_viewer_id,
          'filterBy'            => 'hasApp',
          'count'               => 100
      );

           $this->_consumer = new OAuthConsumer(_CONSUMER_KEY_, _CONSUMER_SECRET_, NULL);
           $request = OAuthRequest::from_consumer_and_token(
               $this->_consumer, NULL, 'GET', $this->_base_feed, $params);

           // Sign the constructed OAuth request using HMAC-SHA1
           $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(),
                                   $this->_consumer, NULL);

           // Make signed OAuth request to the Contacts API server
           $url  = $this->_base_feed . '?' . $this->implode_assoc('=', '&', $params);
           $curl = curl_init($url);
           curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($curl, CURLOPT_FAILONERROR, false);
           curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
           $auth_header = $request->to_header();
           if ($auth_header) {
               curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header));
           }

           $response = curl_exec($curl);
           if (!$response) {
               $response = curl_error($curl);
           }
           curl_close($curl);
       } catch (Exception $e) {
           //var_dump($e);
           return false;
       }
       return $response;
   }

   function implode_assoc($inner_glue, $outer_glue, $array, $skip_empty=false)
   {
       $output=array();
       foreach ($array as $key => $item) {
           if (!$skip_empty || $item) {
               $output[] = $key. $inner_glue. urlencode($item);
           }
       }
       return implode($outer_glue, $output);
   }
}

?>
