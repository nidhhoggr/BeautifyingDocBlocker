<?php

/**
 * This is a class used to beatify a file
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
 * @package   Beautify
 * @author    Joseph Persie <persie.joseph#gmail.com>
 * @copyright 2012 Joseph Persie
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version   GIT: 0.1
 * @link      http://pear.php.net/package/Beautify
 */

/**
 * require the missing argument exception handler
 */
require_once(dirname(__FILE__) . '/MissingArgumentException.class.php');

/**
 * require the php beautifier PEAR dependency
 */
require_once ('PHP/Beautifier.php');

/**
 * require the php beautifier batch PEAR dependency
 */
require_once ('PHP/Beautifier/Batch.php');

/**
 * require the php doc block generator PEAR dependency
 */
require_once ('PHP/DocBlockGenerator.php');

/**
 * Short description for class
 * 
 * Long description (if any) ...
 * 
 * @category  PHP
 * @package   Beautify
 * @author    Joseph Persie <persie.joseph#gmail.com>
 * @copyright 2012 Joseph Persie
 * @license   http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/Beautify
 */
class Beautify extends PHP_Beautifier_Batch
{

    /**
     * the key of the input file
     */
    const ARGS_INPUT_FILE_KEY = 1;

    /**
     * the key of the output file
     */
    const ARGS_OUTPUT_FILE_KEY = 2;

    /**
     * @param Array $args an array obtained from argv
     * @return void   
     * @access public 
     */
    public function __construct($args)
    {
        //set the file to beautify
        $this->setFiles($args);
        //instantiate PHP_Beautifier pear class
        $oBeaut = new PHP_Beautifier();
        parent::__construct($oBeaut);
        $this->beautifyFile();
        $this->addDocBlocks();
    }

    /**
     * a function used to set the input and output file 
     * 
     * @param array                    $args obtained from the argv
     * @return void                    
     * @access private                 
     * @throws MissingArgumentException if filenames arent found
     */
    private function setFiles($args)
    {
        $inputfilename = $args[self::ARGS_INPUT_FILE_KEY];

        if (empty($inputfilename)) {
            throw new MissingArgumentException('An input filename must be provided', 600);
        }

        $this->input_filename = $inputfilename;

        $outputfilename = $args[self::ARGS_OUTPUT_FILE_KEY];

        if (empty($outputfilename)) {
            throw new MissingArgumentException('An output filename must be provided', 601);
        }

        $this->output_filename = $outputfilename;
    }

    /**
     * This function calls upon the beautification dependencies to beautify the input file into the output file
     * 
     * @return void   
     * @access private
     */
    private function beautifyFile()
    {
        try {
            $this->addFilter('ArrayNested');
            $this->addFilter('ListClassFunction');
            $this->addFilter('Pear');
            $this->setInputFile($this->input_filename);
            $this->process();
            file_put_contents($this->output_filename,$this->get());
        }
        catch(Exception $oExp) {
            echo ($oExp);
        }
    }

    /**
     * This function adds doc blocks to the outputfile
     * 
     * @return void   
     * @access private
     */
    private function addDocBlocks()
    {
        $param = array(
            'license' => 'mit',
            'category' => 'PHP',
            'author' => 'Joseph Persie',
            'email' => 'persie.joseph@gmail.com',
            'year' => '2012'
        );
        $docblockgen = new PHP_DocBlockGenerator();
        $docblockgen->generate($this->output_filename, $param, $this->output_filename);
    }
}
