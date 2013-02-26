<?php
    require_once('request.class.php'); 
 
    class Api{

          //URL endpoint GitHub
          const endpoint = 'https://api.github.com/';

          //constants for available API REST response formats. Defaults to json
          const JSON_FORMAT  =  'json';
          const RAW_FORMAT   =  'raw';
          const TEXT_FORMAT  =  'text';
          const HTML_FORMAT  =  'html';
          const FULL_FORMAT  =  'full';

          //constants for HTTP status return codes
          const HTTP_STATUS_OK                    = 200;
          const HTTP_STATUS_CREATED               = 201;
          const HTTP_STATUS_NO_CONTENT            = 204;
          const HTTP_STATUS_BAD_REQUEST           = 400;
          const HTTP_STATUS_UNAUTHORIZED          = 401;
          const HTTP_STATUS_NOT_FOUND             = 404;
          const HTTP_STATUS_UNPROCESSABLE_ENTITY  = 422;

          //constant for default pagination size on paginate request
          const DEFAULT_PAGE_SIZE = 10;

          //transport layer
          protected $transport = NULL;

          //constructor of class
          public function __construct() {

                 $this->request = new Request();
          }

          public function getTransport() {

                 return $this->request; 
          } 

          public function requestGet($url, $params = array(), $headers = array()) {

                 return $this->doRequest('GET', self::endpoint . $url, $params, $headers);
          }

          public function doRequest($method, $url, $params, $headers) {

               return $this->request->fetch($method, $url, $params, $headers); 
          }

          public function processResponse($response) {

                 switch($response['http_code']) {

                        case self::HTTP_STATUS_OK:
                        case self::HTTP_STATUS_CREATED:
                             return $response['response_body'];
                             break;
                        default: 
                             return $response;
                 }
          } 

          public function buildPageParams($page, $pageSize) {

                 return array('page'=>$page, 'per_page'=>$pageSize);
          } 

          public function buildParams($rawParams) {

                 $params = array(); 

                 foreach($rawParams as $key=>$value) {

                         if(false === is_null($value)) {

                            $params[$key] = $value; 
                         }
                 } 

            return $params;

          }
    }

?>