<?php

/**
 * Generic API Handling Class
 * 
 * @author Derrick Austin <derrick.austin@interworks.com>
 **/
class api
{
    private $_base = 'http://api.eia.gov/';
    private $_api_key = '[API_KEY_HERE]';
    
    /**
     * Instantiates this class and returns an API object.
     * 
     * @return api
     */
    public static function factory()
    {
        return new self();
    }
    
    /**
     * Sends the request and returns the decoded result.
     * 
     * @return string
     */
    private function _send($path = null, $args = array())
    {
        $args['api_key'] = $this->_api_key;
        $url = $this->_build_url($path, $args);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $resp = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($resp);
    }
    
    /**
     * Returns the url to call.
     * 
     * @return string
     */
    private function _build_url($path = null, $args = array())
    {
        $url = $this->_base . $path;
        if (!empty($args)) {
            $i = 0;
            foreach ($args as $key => $val) {
                $url .= ($i) ? '&' : '?'; 
                $url .= $key . '=' . urlencode($val);
                $i++;
            }
        }
        
        return $url;
    }
    
    /**
     * Magic function that converts our API call to whatever type we want.
     * 
     * @return array
     */
    public function __call($func, $args)
    {
        $params = array();
        if (!empty($args[0])) {
            $params = $args[0];
        }
        
        return $this->_send(
            str_replace('_', '/', $func) . '/',
            $params
        );
    }
}

function dar($x) {
    echo "<pre>";
    print_r($x);
    echo "</pre>";
}