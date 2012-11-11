BeautifyingDocBlocker
=====================

###About
* author: Joseph Persie
* email: persie.joseph@gmail.com
* description:

A binary shell script that implements two different PEAR packages to beautify the php document
and then apply doc blocks. 

###Dependencies 

* PHP_DocBlockGenerator: http://pear.php.net/package/PHP_DocBlockGenerator
* PHP_Beautifier: http://pear.php.net/package/PHP_Beautifier

###Usage

* i (required) - input file
* o (optional) - output file
* s (optional) - the name of the ini file to parse to provide arguments to the doc block generator
* b (optional) (takes no arguments) - beautify the output file
* d (optional) (takes no arguments) - doc block the output file

./beautify -bd -i=input.php -o=output.php -s=joseph

find ./test -type f -exec ./beautify -b -i={} \;

