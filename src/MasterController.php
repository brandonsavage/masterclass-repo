<?php

class MasterController {
    
    private $config;
    
    public function __construct($config) {
        $this->_setupConfig($config);
    }
    
    public function execute() {
        $call = $this->_determineControllers();
        $call_class = $call['call'];
        $class = ucfirst(array_shift($call_class));
        $method = array_shift($call_class);
        $o = new $class($this->config);
        return $o->$method();
    }
    
    private function _determineControllers()
    {
        if (isset($_SERVER['REDIRECT_BASE'])) {
            $rb = $_SERVER['REDIRECT_BASE'];
        } else {
            $rb = '';
        }
        
        $ruri = $_SERVER['REQUEST_URI'];
        $path = str_replace($rb, '', $ruri);
        $return = array();
        
        foreach($this->config['routes'] as $k => $v) {
            $matches = array();
            $pattern = '$' . $k . '$';
            if(preg_match($pattern, $path, $matches))
            {
                $controller_details = $v;
                $path_string = array_shift($matches);
                $arguments = $matches;
                $controller_method = explode('/', $controller_details);
                $return = array('call' => $controller_method);
            }
        }
        
        return $return;
    }
    
    private function _setupConfig($config) {
        $this->config = $config;
    }
    
}