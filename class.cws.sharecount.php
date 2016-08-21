<?php

/**
 * CwsShareCount
 *
 * CwsShareCount is a PHP class to get social share count for Delicious, Facebook,
 * Google+, Linkedin, Pinterest, Reddit, StumbleUpon and Twitter.
 * 
 * CwsShareCount is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your option)
 * or (at your option) any later version.
 *
 * CwsShareCount is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License
 * for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see http://www.gnu.org/licenses/.
 * 
 * Related post : http://goo.gl/iKGRT
 * 
 * @package CwsShareCount
 * @author Cr@zy
 * @copyright 2013-2015, Cr@zy
 * @license GNU LESSER GENERAL PUBLIC LICENSE
 * @version 1.3
 * @link https://github.com/crazy-max/CwsShareCount
 *
 */

class CwsShareCount
{
    const SN_DELICIOUS = 'Delicious';
    const SN_FACEBOOK = 'Facebook';
    const SN_GOOGLEPLUS = 'Google+';
    const SN_LINKEDIN = 'LinkedIn';
    const SN_PINTEREST = 'Pinterest';
    const SN_REDDIT = 'Reddit';
    const SN_STUMBLEUPON = 'StumbleUpon';
    const SN_TWITTER = 'Twitter';
    
    /**
     * The last error message.
     * @var string
     */
    private $error;
    
    /**
     * The cws debug instance.
     * @var CwsDebug
     */
    private $cwsDebug;
    
    /**
     * The cws curl instance.
     * @var CwsCurl
     */
    private $cwsCurl;
    
    public function __construct(CwsDebug $cwsDebug, CwsCurl $cwsCurl)
    {
        $this->cwsDebug = $cwsDebug;
        $this->cwsCurl = $cwsCurl;
    }
    
    /**
     * Get all social share count.
     * @param string $url
     * @return array
     */
    public function getAll($url)
    {
        $result = array();
        
        foreach (self::getSocialNetworks() as $socialNetwork) {
            $result[$socialNetwork] = $this->getCount($url, $socialNetwork);
        }
        
        return $result;
    }
    
    /**
     * Get delicious share count.
     * @param string $url
     * @return int
     */
    public function getDeliciousCount($url)
    {
        return $this->getCount($url, self::SN_DELICIOUS);
    }
    
    /**
     * Get facebook share count.
     * @param string $url
     * @return int
     */
    public function getFacebookCount($url)
    {
        return $this->getCount($url, self::SN_FACEBOOK);
    }
    
    /**
     * Get google plus share count.
     * @param string $url
     * @return int
     */
    public function getGooglePlusCount($url)
    {
        return $this->getCount($url, self::SN_GOOGLEPLUS);
    }
    
    /**
     * Get linkedin share count.
     * @param string $url
     * @return int
     */
    public function getLinkedinCount($url)
    {
        return $this->getCount($url, self::SN_LINKEDIN);
    }
    
    /**
     * Get pinterest share count.
     * @param string $url
     * @return int
     */
    public function getPinterestCount($url)
    {
        return $this->getCount($url, self::SN_PINTEREST);
    }
    
    /**
     * Get reddit share count.
     * @param string $url
     * @return int
     */
    public function getRedditCount($url)
    {
        return $this->getCount($url, self::SN_REDDIT);
    }
    
    /**
     * Get stumbleupon share count.
     * @param string $url
     * @return int
     */
    public function getStumbleuponCount($url)
    {
        return $this->getCount($url, self::SN_STUMBLEUPON);
    }
    
    /**
     * Get twitter share count.
     * @param string $url
     * @return int
     */
    public function getTwitterCount($url)
    {
        return $this->getCount($url, self::SN_TWITTER);
    }
    
    /**
     * Get social share count.
     * @param string $url
     * @param string $socialNetwork
     * @return int
     */
    private function getCount($url, $socialNetwork)
    {
        if (!in_array($socialNetwork, self::getSocialNetworks())) {
            $this->error = 'Social network is not valid...';
            $this->cwsDebug->error($this->error);
            exit();
        } elseif (!$this->isValidUrl($url)) {
            $this->error = 'URL is not valid...';
            $this->cwsDebug->error($this->error);
            exit();
        }
        
        $this->cwsDebug->titleH2('get ' . $socialNetwork . ' count');
        $this->cwsDebug->labelValue('URL', $url);
        
        $this->cwsCurl->reset();
        $this->cwsCurl->addOption(CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        
        $apiUrl = null;
        switch ($socialNetwork) {
            case self::SN_DELICIOUS:
                $apiUrl = 'http://feeds.delicious.com/v2/json/urlinfo/data?url=' . urlencode($url);
                break;
            case self::SN_FACEBOOK:
                $apiUrl = "http://graph.facebook.com/?id=" . urlencode($url);
                break;
            case self::SN_GOOGLEPLUS:
                $apiUrl = 'https://clients6.google.com/rpc?key=AIzaSyCKSbrvQasunBoV16zDH9R33D88CeLr9gQ';
                $this->cwsCurl->setPostMethod();
                $this->cwsCurl->addOption(CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
                break;
            case self::SN_LINKEDIN:
                $apiUrl = 'http://www.linkedin.com/countserv/count/share?url=' . urlencode($url);
                break;
            case self::SN_PINTEREST:
                $apiUrl = 'http://api.pinterest.com/v1/urls/count.json?callback=receiveCount&url=' . urlencode($url);
                break;
            case self::SN_REDDIT:
                $apiUrl = 'http://buttons.reddit.com/button_info.json?url=' . urlencode($url);
                break;
            case self::SN_STUMBLEUPON:
                $apiUrl = 'http://www.stumbleupon.com/services/1.01/badge.getinfo?url=' . urlencode($url);
                break;
            case self::SN_TWITTER:
                $apiUrl = 'http://urls.api.twitter.com/1/urls/count.json?url=' . urlencode($url);
                break;
        }
        
        $this->cwsDebug->labelValue('API URL', $apiUrl, CwsDebug::VERBOSE_REPORT);
        
        $this->cwsCurl->setUrl($apiUrl);
        $this->cwsCurl->process();
        
        if ($this->cwsCurl->getError()) {
            $this->error = $this->cwsCurl->getError();
            $this->cwsDebug->error($this->error);
            return false;
        }
        
        $content = str_replace("\n", "", $this->cwsCurl->getContent());
        
        $this->cwsDebug->dump('Content fetched', $content, CwsDebug::VERBOSE_DEBUG);
        
        $json = $this->cwsCurl->getContent();
        switch ($socialNetwork) {
            case self::SN_DELICIOUS:
                if ($json == '[]') {
                    $json = '[{"total_posts": 0}]';
                }
                break;
            case self::SN_LINKEDIN:
                $json = str_replace('IN.Tags.Share.handleCount(', '', $json);
                $json = str_replace(');', '', $json);
                break;
            case self::SN_PINTEREST:
                $json = str_replace('receiveCount(', '', $json);
                $json = substr($json, 0, -1);
                break;
        }
        
        $json = json_decode($json, true);
        if ($json == null || $json === false) {
            $this->error = 'Invalid Json...';
            $this->cwsDebug->error($this->error);
            return false;
        }
        
        $this->cwsDebug->dump('Json', $json, CwsDebug::VERBOSE_REPORT);
        
        $result = false;
        switch ($socialNetwork) {
            case self::SN_DELICIOUS:
                if (isset($json[0]['total_posts'])) {
                    $result = intval($json[0]['total_posts']);
                }
                break;
            case self::SN_FACEBOOK:
                if (isset($json['share']['share_count'])) {
                    $result = intval($json['share']['share_count']);
                }
                break;
            case self::SN_GOOGLEPLUS:
                if (isset($json[0]['result']['metadata']['globalCounts']['count'])) {
                    $result = intval($json[0]['result']['metadata']['globalCounts']['count']);
                }
                break;
            case self::SN_LINKEDIN:
                if (isset($json['count'])) {
                    $result = intval($json['count']);
                }
                break;
            case self::SN_PINTEREST:
                if (isset($json['count'])) {
                    $result = intval($json['count']);
                }
                break;
            case self::SN_REDDIT:
                if (isset($json['data']['children'])) {
                    if (empty($json['data']['children'])) {
                        $result = 0;
                    } elseif (isset($json['data']['children'][0]['data']['score'])) {
                        $result = intval($json['data']['children'][0]['data']['score']);
                    }
                }
                break;
            case self::SN_STUMBLEUPON:
                if (isset($json['result']['views'])) {
                    $result = intval($json['result']['views']);
                }
                break;
            case self::SN_TWITTER:
                if (isset($json['count'])) {
                    $result = intval($json['count']);
                }
                break;
        }
        
        $this->cwsDebug->labelValue('Count', $result);
        
        return $result;
    }

    /**
     * Social networks list
     * @return array
     */
    private static function getSocialNetworks()
    {
        return array(
            self::SN_DELICIOUS,
            self::SN_FACEBOOK,
            self::SN_GOOGLEPLUS,
            self::SN_LINKEDIN,
            self::SN_PINTEREST,
            self::SN_REDDIT,
            self::SN_STUMBLEUPON,
            self::SN_TWITTER,
        );
    }

    /**
     * Check if url is valid
     * @param $url
     * @return bool
     */
    private static function isValidUrl($url)
    {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url) 
            || filter_var(filter_var($url, FILTER_SANITIZE_URL), FILTER_VALIDATE_URL);
    }

    /**
     * The last error.
     * @return string $error
     */
    public function getError()
    {
        return $this->error;
    }
}
