<?php

    class Request {

          const VERSION = '1.0.0';
          
          const GET    = 'GET';
          const PUT    = 'PUT';
          const POST   = 'POST';
          const DELETE = 'DELETE';
          const HEAD   = 'HEAD';

          /**
           *  Fetches an HTTP resource
           *
           *  @param String $url     The request URL
           *  @param String $params  The request parameters
           *  @param String $headers The request http headers
           *  @param String $method  The request HTTP method (GET, POST, PUT, DELETE, HEAD)
           *  @param String $post    The request body
           *  @param String $options The request options.    
           *  @return Array http
           */
          public function fetch($method=self::GET, $url, $params, $headers=array(), $post=null, $options=array()) {
               
              $options = array_merge(array(
                'timeout'         => '10', 
                'connect_timeout' => '10', 
                'compression'     => true, 
                'debug'           => 'debug', 
                'log'             => sys_get_temp_dir() . '/curl_debug.log'
              ),$options);  

              if(!empty($params)) {
                  $url = $url.'?'. http_build_query($params);
              }  

              $ch = curl_init($url);

              //return headers
              curl_setopt($ch, CURLOPT_HEADER, true);

              //return body
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

              //set headers
              curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

              //handle http methods
              switch($method) {
 
                  case 'POST':
                  curl_setopt($ch, CURLOPT_POST, true);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                  break;

                  case 'PUT':
                  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                  break;

                  case 'HEAD':
                  case 'DELETE':
                  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                  break;

              }  

              //set user agent  
              curl_setopt($ch, CURLOPT_USERAGENT, sprintf('thinkphp (%s) / PHP (%s)', self::VERSION, phpversion()));

              //handle redirects
              curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

              //handle http compression
              curl_setopt($ch, CURLOPT_ENCODING, '');

              //timeouts
              curl_setopt($ch, CURLOPT_TIMEOUT, $options['timeout']);
              curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $options['timeout']);

              // be nice to dev ssl certs
              curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
              curl_setopt($ch, CURLOPT_FAILONERROR, false);


              if($options['debug']){
                 curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                 curl_setopt($ch, CURLOPT_VERBOSE, true);
              }

              $http = array();

              $response = curl_exec($ch);

              if($response === false) {
                 //something bad happeneed (timeout,dns failure,???)
                 error_log(curl_error($ch));
                 return false;   
              }

              //process response
              $http = array_merge($http, curl_getinfo($ch));
 
              //process status code + headers
              list($http['response_header'],$http['response_body']) = explode("\r\n\r\n", $response, 2);

              $response_header_lines = explode("\r\n", $http['response_header']); 
              $http_response_line    = array_shift($response_header_lines); 


              if (preg_match('@^HTTP/[0-9]\.[0-9] ([0-9]{3})@', $http_response_line, $matches)) {
                  $http['response_code'] = $matches[1];
              } 

              $http['response_headers'] = array();
              foreach($response_header_lines as $line) {
                      list($header,$value) = explode(":", $line, 2);
                      $http['response_headers'][$header] = $value;
              }              

              if($options['debug']) {
                 error_log(sprintf('Fetching %s, method=%s, headers=%s, response=%s',$url, $method, var_export($headers, true), var_export($http, true)));
              }

             //curl close
             curl_close($ch);

            return $http;
         } 

    }//end class 

/*
    #example
    $obj = new Request();
    echo"<pre>"; 
    print_r($obj->fetch("GET","https://api.github.com/users/thinkphp/gists",null));  
    echo"</pre>";
*/
?>
