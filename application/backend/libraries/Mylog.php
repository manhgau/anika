<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    require_once APPPATH . 'third_party/ci_log4php/Logger.php';

    class Mylog  {

        protected $logger;
        protected $initialized = false;

        public function __construct() {
            //parent::__construct();

            if ($this->initialized === false) {
                $this->initialized = true;
                $config_file = APPPATH . 'config/log4php.properties';
                if ( defined('ENVIRONMENT') && file_exists( APPPATH . 'config/' . ENVIRONMENT . '/log4php.properties' ) ) {
                    $config_file = APPPATH . 'config/' . ENVIRONMENT . '/log4php.properties';
                }
                Logger::configure($config_file);
                $this->logger = Logger::getRootLogger();
            }
        }

        public function write_log($level = 'error', $msg, $php_error = FALSE) {
            $level = strtoupper($level);
            switch ($level) {
                case 'ERROR':
                    $this->logger->error($msg);
                    break;
                case 'INFO':
                    $this->logger->info($msg);
                    break;
                case 'DEBUG':
                    $this->logger->debug($msg);
                    echo $msg;
                    break;
                default:
                    $this->logger->debug($msg);
                    break;
            }

            return TRUE;
        }
        
        public function add_application_log($msg, $level='info')
        {
            if($this->write_log($level, $msg)) return TRUE;
            return FALSE;
        }
}