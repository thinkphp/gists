<?php

    require_once('api.class.php');

    class Gist extends Api {

         /**
          * constants for available Gist types 
          */
          const GIST_TYPE_PUBLIC  = 'public'; 
          const GIST_TYPE_PRIVATE = 'private';
          const GIST_TYPE_STARRED = 'starred';

         /**
          * List gists
          * 
          * @param String $username  username GitHub username.
          * @param String $gistType  Gist type.    
          * @param String $page      paginated page to get. 
          * @param String $pageSize  size of paginated page. max 100.
          * @return array|bool       list of gists of False if request failed.
          */
          public function all($username=null, $gistType=self::GIST_TYPE_PUBLIC, $page=1, $pageSize=self::DEFAULT_PAGE_SIZE) {
 
                 if(is_null($username)) {

                    //do stuff

                 } else {

                   $url = "users/$username/gists";
                 }

                 return $this->processResponse($this->requestGet($url, $this->buildPageParams($page, $pageSize))); 
          } 

          public function get($id) {
          }

          public function create($id) {
          }

          public function update($id) {
          }

          public function star($id) {
          }

          public function unstar($id) {
          }

          public function isStarred($id) {
          }

          public function fork($id) {
          }

          public function delete($id) {
          }
    }
?>
