<?php

/**
 * PHP version 5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * @category  PHP
 * @package   DocBlockIniParser
 * @author    Joseph M. Persie <persie.joseph@gmail.com>
 * @copyright 2012 Joseph M. Persie
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version   GIT 0.1
 * @link      http://pear.php.net/package/DocBlockIniParser
 */

/**
 * Short description for class
 * 
 * Long description (if any) ...
 * 
 * @category  PHP
 * @package   DocBlockIniParser
 * @author    Joseph M. Persie <persie.joseph@gmail.com>
 * @copyright 2012 Joseph M. Persie
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/DocBlockIniParser
 */
class DocBlockIniParser
{

    /**
     * the default ini filename to parse for docblockgen settings
     * @var string 
     * @access private
     */
    private $ini_filename = 'default';

    /**
     * the full absolute path of the ini file to be stored in this var
     * @var unknown
     * @access private
     */
    private $ini_file;

    /**
     * the direcotory of the ini files set in the consturctor
     * @var string 
     * @access private
     */
    private $ini_dir;

    /**
     * an array of settings of the docblockgenerator
     * @var array
     * @access private
     */
    private $settings;

    /**
     * 
     * the constructir sets the ini directory set the ini file and parse the ini file to populate the 
     * settings array for the docblockgenerator arguments
     * 
     * @param unknown $filename the name of the ini file
     * @return void   
     * @access public 
     */
    public function __construct($filename = null)
    {
        $this->ini_dir = dirname(__FILE__) . '/../docblocksettings/';
        $this->setIniFile($filename);
        $this->parseIni();
    }

    /**
     * an accessor for the settings
     * 
     * @return array returns the docblockgen settings created in parseini function
     * @access public 
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * 
     * parses the ini file and stores the settings
     * 
     * @return void   
     * @access private
     */
    private function parseIni()
    {
        $ini_settings = parse_ini_file($this->ini_file);
        $this->settings = array_merge($this->getDefaultSettings() , $ini_settings);
    }

    /**
     * set the ini file by the argued filename or the default
     * 
     * @param string  $filename the name of the possibly existing ini file
     * @return void   
     * @access private
     */
    private function setIniFile($filename = null)
    {
        $this->ini_file = $this->ini_dir . $filename . ".ini";
        if (empty($filename) || !$this->isValidIni()) {
            $this->ini_file = $this->ini_dir . $this->ini_filename . ".ini";
        }
    }

    /**
     * a function to check in the ini file exists.
     * 
     * @return boolean return if the ini file exists
     * @access private
     */
    private function isValidIni()
    {
        return file_exists($this->ini_file);
    }

    /**
     * a hard coded array of docblockgen settings to merge with from the parsed in file
     * 
     * @return array of docblockgen settings
     * @access private
     */
    private function getDefaultSettings()
    {
        return array(
            'license' => 'mit',
            'category' => 'PHP',
            'author' => 'Authors Name',
            'email' => 'authoremail@somesite.com',
            'year' => date('Y') ,
            'package' => 'the package name',
            'version' => 'GIT',
            'see' => 'for referential purposes',
            'link' => 'link goes here'
        );
    }
}

