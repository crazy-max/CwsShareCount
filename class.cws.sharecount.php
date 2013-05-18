<?php

/**
 * CwsShareCount
 *
 * CwsShareCount is a PHP class to get social share count for Delicious, Facebook,
 * Google+, Linkedin, Pinterest, Reddit, StumbleUpon and Twitter.
 * 
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option)
 * any later version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * Please see the GNU General Public License at http://www.gnu.org/licenses/.
 * 
 * @package CwsShareCount
 * @author Cr@zy
 * @copyright 2013, Cr@zy
 * @license GPL licensed
 * @version 1.0
 * @link https://github.com/crazy-max/CwsShareCount
 *
 */

define('CWSSC_VERBOSE_QUIET',     0); // means no output at all.
define('CWSSC_VERBOSE_SIMPLE',    1); // means only output simple report.
define('CWSSC_VERBOSE_REPORT',    2); // means output a detail report.
define('CWSSC_VERBOSE_DEBUG',     3); // means output detail report as well as debug info.

define('CWSSC_SN_DELICIOUS',      'Delicious');
define('CWSSC_SN_FACEBOOK',       'Facebook');
define('CWSSC_SN_GOOGLEPLUS',     'Google+');
define('CWSSC_SN_LINKEDIN',       'LinkedIn');
define('CWSSC_SN_PINTEREST',      'Pinterest');
define('CWSSC_SN_REDDIT',         'Reddit');
define('CWSSC_SN_STUMBLEUPON',    'StumbleUpon');
define('CWSSC_SN_TWITTER',        'Twitter');

class CwsShareCount
{
    /**
     * CwsShareCount version.
     * @var string
     */
    public $version = "1.0";
    
    /**
     * Control the debug output.
     * default CWSSC_VERBOSE_SIMPLE
     * @var int
     */
    public $debug_verbose = CWSSC_VERBOSE_SIMPLE;
    
    /**
     * The last error message.
     * @var string
     */
    public $error_msg;
    
    /**
     * List of available socials networks.
     * @var array
     */
    private $_socials_networks = array(
        CWSSC_SN_DELICIOUS,
        CWSSC_SN_FACEBOOK,
        CWSSC_SN_GOOGLEPLUS,
        CWSSC_SN_LINKEDIN,
        CWSSC_SN_PINTEREST,
        CWSSC_SN_REDDIT,
        CWSSC_SN_STUMBLEUPON,
        CWSSC_SN_TWITTER,
    );
    
    /**
     * Defines new line ending.
     * @var string
     */
    private $_newline = "<br />\n";
    
    /**
     * Output additional msg for debug.
     * @param string $msg : if not given, output the last error msg.
     * @param int $verbose_level : the output level of this message.
     * @param boolean $newline : insert new line or not.
     * @param boolean $code : is code or not.
     */
    private function output($msg=false, $verbose_level=CWSSC_VERBOSE_SIMPLE, $newline=true, $code=false)
    {
        if ($this->debug_verbose >= $verbose_level) {
            if (empty($msg) && !$code) {
                echo $this->_newline . '<strong>ERROR :</strong> ' . $this->error_msg;
            } else {
                if ($code) {
                    echo '<textarea style="width:100%;height:300px;">';
                    print_r($msg);
                    echo '</textarea>';
                } else {
                    echo $msg;
                }
            }
            if ($newline) {
                echo $this->_newline;
            }
        }
    }
    
    /**
     * Get all social share count.
     * @param string $url
     */
    public function getAll($url)
    {
        $result = array();
        
        foreach ($this->_socials_networks as $social_network) {
            $result[$social_network] = $this->getCount($url, $social_network);
        }
        
        return $result;
    }
    
    /**
     * Get social share count.
     * @param string $url
     * @param string $social_network
     */
    public function getCount($url, $social_network)
    {
        if (!in_array($social_network, $this->_socials_networks)) {
            $this->error_msg = "Social network is not valid...";
            $this->output();
            exit();
        } elseif (!$this->isValidUrl($url)) {
            $this->error_msg = "URL is not valid...";
            $this->output();
            exit();
        }
        
        $this->output('<h2>get ' . $social_network . ' count</h2>', CWSSC_VERBOSE_SIMPLE, false);
        $this->output('<strong>URL : </strong>' . $url, CWSSC_VERBOSE_SIMPLE);
        
        $cwsCurl = new CwsCurl();
        $cwsCurl->setDebugVerbose(CWSCURL_VERBOSE_QUIET);
        $cwsCurl->addOption(CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        
        $api_url = null;
        switch ($social_network) {
            case CWSSC_SN_DELICIOUS:
                $api_url = "http://feeds.delicious.com/v2/json/urlinfo/data?url=" . urlencode($url);
                break;
            case CWSSC_SN_FACEBOOK:
                $api_url = "http://api.ak.facebook.com/restserver.php?v=1.0&method=links.getStats&urls=" . urlencode($url) . "&format=json";
                break;
            case CWSSC_SN_GOOGLEPLUS:
                $api_url = "https://clients6.google.com/rpc?key=AIzaSyCKSbrvQasunBoV16zDH9R33D88CeLr9gQ";
                $cwsCurl->setMethod(CWSCURL_METHOD_POST);
                $cwsCurl->addOption(CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
                break;
            case CWSSC_SN_LINKEDIN:
                $api_url = "http://www.linkedin.com/countserv/count/share?url=" . urlencode($url);
                break;
            case CWSSC_SN_PINTEREST:
                $api_url = "http://api.pinterest.com/v1/urls/count.json?callback=receiveCount&url=" . urlencode($url);
                break;
            case CWSSC_SN_REDDIT:
                $api_url = "http://buttons.reddit.com/button_info.json?url=" . urlencode($url);
                break;
            case CWSSC_SN_STUMBLEUPON:
                $api_url = "http://www.stumbleupon.com/services/1.01/badge.getinfo?url=" . urlencode($url);
                break;
            case CWSSC_SN_TWITTER:
                $api_url = "http://urls.api.twitter.com/1/urls/count.json?url=" . urlencode($url);
                break;
        }
        
        $this->output('<strong>API URL : </strong>' . $api_url, CWSSC_VERBOSE_REPORT);
        
        $cwsCurl->setUrl($api_url);
        $cwsCurl->process();
        
        if ($cwsCurl->getErrorMsg()) {
            $this->error_msg = $cwsCurl->getErrorMsg();
            $this->output();
            return false;
        }
        
        $content = $cwsCurl->getContent();
        $content = str_replace("\n", "", $content);
        $content = str_replace(" ", "", $content);
        
        $this->output('<strong>Content fetched</strong>', CWSSC_VERBOSE_DEBUG);
        $this->output($content, CWSSC_VERBOSE_DEBUG, false, true);
        
        $json = $cwsCurl->getContent();
        switch ($social_network) {
            case CWSSC_SN_DELICIOUS:
                if ($json == '[]') {
                    $json = '[{"total_posts": 0}]';
                }
            case CWSSC_SN_LINKEDIN:
                $json = str_replace("IN.Tags.Share.handleCount(", "", $json);
                $json = str_replace(");", "", $json);
                break;
            case CWSSC_SN_PINTEREST:
                $json = str_replace("receiveCount(", "", $json);
                $json = substr($json, 0, -1);
                break;
        }
        
        $json = json_decode($json, true);
        
        if ($json == null || $json === false) {
            $this->error_msg = "Invalid Json...";
            $this->output();
            return false;
        }
        
        $this->output('<strong>Json</strong>', CWSSC_VERBOSE_REPORT);
        $this->output($json, CWSSC_VERBOSE_REPORT, false, true);
        
        $result = false;
        switch ($social_network) {
            case CWSSC_SN_DELICIOUS:
                if (isset($json[0]['total_posts'])) {
                    $result = intval($json[0]['total_posts']);
                }
                break;
            case CWSSC_SN_FACEBOOK:
                if (isset($json[0]['total_count'])) {
                    $result = intval($json[0]['total_count']);
                }
                break;
            case CWSSC_SN_GOOGLEPLUS:
                if (isset($json[0]['result']['metadata']['globalCounts']['count'])) {
                    $result = intval($json[0]['result']['metadata']['globalCounts']['count']);
                }
                break;
            case CWSSC_SN_LINKEDIN:
                if (isset($json['count'])) {
                    $result = intval($json['count']);
                }
                break;
            case CWSSC_SN_PINTEREST:
                if (isset($json['count'])) {
                    $result = intval($json['count']);
                }
                break;
            case CWSSC_SN_REDDIT:
                if (isset($json['data']['children'][0]['data']['score'])) {
                    $result = intval($json['data']['children'][0]['data']['score']);
                }
                break;
            case CWSSC_SN_STUMBLEUPON:
                if (isset($json['result']['views'])) {
                    $result = intval($json['result']['views']);
                }
                break;
            case CWSSC_SN_TWITTER:
                if (isset($json['count'])) {
                    $result = intval($json['count']);
                }
                break;
        }
        
        $this->output('<strong>Count : </strong>' . $result, CWSSC_VERBOSE_SIMPLE);
        
        return $result;
    }
    
    private static function isValidUrl($url)
    {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url) 
            || filter_var(filter_var($url, FILTER_SANITIZE_URL), FILTER_VALIDATE_URL);
    }
}

?>