<?php

/**
 * An excpetion handler for missing arguments
 * 
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
 * @package   MissingArgumentException
 * @author    Joseph Persie <persie.joseph#gmail.com>
 * @copyright 2012 Joseph Persie
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link      http://pear.php.net/package/MissingArgumentException
 * @see       References to other sections (if any)...
 */

/**
 * Short description for class
 * 
 * Long description (if any) ...
 * 
 * @category  PHP
 * @package   MissingArgumentException
 * @author    Joseph Persie <persie.joseph#gmail.com>
 * @copyright 2012 Joseph Persie
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class MissingArgumentException extends Exception
{

    /**
     * output the contents of the exception
     * 
     * @return string Return description (if any) ...
     * @access public
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
