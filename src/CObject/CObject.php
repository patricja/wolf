<?php
/**
* Holding a instance of CWolf to enable use of $this in subclasses and provide some helpers.
*
* @package WolfCore
*/
class CObject {

        /**
         * Members
         */
        protected $wo;
        protected $config;
        protected $request;
        protected $data;
        protected $db;
        protected $views;
        protected $session;
        protected $user;


        /**
         * Constructor, can be instantiated by sending in the $wo reference.
         */
        protected function __construct($wo=null) {
         if(!$wo) {
         $wo = CWolf::Instance();
         }
         $this->wo = &$wo;
    $this->config = &$wo->config;
    $this->request = &$wo->request;
    $this->data = &$wo->data;
    $this->db = &$wo->db;
    $this->views = &$wo->views;
    $this->session = &$wo->session;
    $this->user = &$wo->user;
        }


        /**
         * Wrapper for same method in CWolf. See there for documentation.
         */
        protected function RedirectTo($urlOrController=null, $method=null, $arguments=null) {
    $this->wo->RedirectTo($urlOrController, $method, $arguments);
  }


        /**
         * Wrapper for same method in CWolf. See there for documentation.
         */
        protected function RedirectToController($method=null, $arguments=null) {
    $this->wo->RedirectToController($method, $arguments);
  }


        /**
         * Wrapper for same method in CWolf. See there for documentation.
         */
        protected function RedirectToControllerMethod($controller=null, $method=null, $arguments=null) {
    $this->wo->RedirectToControllerMethod($controller, $method, $arguments);
  }


        /**
         * Wrapper for same method in CWolf. See there for documentation.
         */
  protected function AddMessage($type, $message, $alternative=null) {
    return $this->wo->AddMessage($type, $message, $alternative);
  }


        /**
         * Wrapper for same method in CWolf. See there for documentation.
         */
        protected function CreateUrl($urlOrController=null, $method=null, $arguments=null) {
    return $this->wo->CreateUrl($urlOrController, $method, $arguments);
  }


}
