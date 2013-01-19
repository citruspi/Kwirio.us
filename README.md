## Kwirio.us, An Internetz Powered Hash Cracker

### Introduction
To put it simply, Kwirio.us is a PHP script which accepts MD5 hashes and then attempts to find the "clear text" from which the hash was derived. Kwirio.us is special because it doesn't:

* use recursive algorithm to brute force the hash
* use a large database which requires 5MB to 50PB of space
* use a word list and attempt a dictionary crack

Instead, it uses the Internet[1] as a database - it acts as a meta search engine and searches through multiple other sites (including Google) for the hash. In this way, it acts as an interface between your application and other services so that you don't have to implement them yourself.

[1] It comes with a few services implemented. Additional services can be easily implemented by adding as few as six lines of PHP code.

### Usage

Kwirio.us is easy to implement and can be implemented in as little as seven lines of code. There are only three methods which you must call order to crack a hash:

* `sethash()`
* `validate()`
* `crack()`

If you ran:

```php
<?php
    include('Kwirio.php');
        
    $Kwirious = new Kwirio();
        
    $Kwirious->setHash('b45cffe084dd3d20d928bee85e7b0f21');       
        
    if($Kwirious->validate())
        echo $Kwirious->crack();
    else
        echo "Please set a valid hash."; 
?>
```

it would print out:

```
string
```

### An API

A Sample Kwirio.us API:

```php
<?php
  header('content-type: application/json; charset=utf-8');
                
  include('Kwirious/Kwirio.php');
                
  $Kwirious = new Kwirio();
                
  $Kwirious->setHash($_GET['h']);   
                
  $data = array();    
                
  if($Kwirious->validate()){
    $rslt = $Kwirious->crack();
                
    if($rslt == "Hash not cracked! :(")
      $data = array("hash" => $_GET['h'], "valid" => TRUE, "found" => FALSE, "result" => ""); 
    else
      $data = array("hash" => $_GET['h'], "valid" => TRUE, "found" => TRUE, "result" => $rslt);         
  }
                
  else
    $data = array("hash" => $_GET['h'], "valid" => FALSE, "found" => FALSE, "result" => "");  
                
  $pattern = array(',"', '{', '}');
  $replacement = array(",\n\t\"", "{\n\t", "\n}");
  $rspn = str_replace($pattern, $replacement, json_encode($data));
                
  echo $rspn;     
?>
```

So, if an HTTP request was made to:

```
http://domain.com/API.php?h=b45cffe084dd3d20d928bee85e7b0f21
```

the response would be:

```json
{
  "hash":"b45cffe084dd3d20d928bee85e7b0f21",
  "valid":true,
  "found":true,
  "result":"string"
}
```

### Services

The services which are implemented in Kwirio.us as of this point are:

|Service Name|Version Implemented|
|:-----------|:-----------------:|
|collision | v0.1 |
|noisette | v0.1 |
|rednoize | v0.1 |
|ramsey | v0.1 |
|darkbyte | v0.1 |
|md5-hash | v0.1 |
|google | v0.1  |
|gromweb | v0.1 |

### License
Zinc is open source and is distributed under the MIT License:

    Copyright © 2012 Mihir Singh <me@mihirsingh.com>

	Permission is hereby granted, free of charge, to any person obtaining a copy of 
	this software and associated documentation files (the “Software”), to deal in 
	the Software without restriction, including without limitation the rights to 
	use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of 
	the Software, and to permit persons to whom the Software is furnished to do 
	so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in all 
	copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY 
	KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE 
	WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR 
	PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, 
	DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF 
	CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS 
	IN THE SOFTWARE.
	
### Contributing
Just fork and submit a pull request ;)

# Credits

* [Mihir Singh](https://github.com/citruspi) (Author)
* [BozoCrack](https://github.com/juuso/BozoCrack) (Inspiration)
* [StackOverflow](http://stackoverflow.com) (Help)

# Contribute

Want to contribute? We'd love to have you on board.
