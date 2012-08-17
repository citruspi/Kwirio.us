# What is Kwirio.us?
To put it simply, Kwirio.us is a PHP script which accepts MD5 hashes and then attempts to find the "clear text" from which the hash was derived. Kwirio.us is special because it doesn't:

* use recursive algorithm to brute force the hash
* use a large database which requires 5MB to 50PB of space
* use a word list and attempt a dictionary crack

Instead, it uses the Internet[1] as a database - it acts as a meta search engine and searches through multiple other sites (including Google) for the hash. In this way, it acts as an interface between your application and other services so that you don't have to implement them yourself.

[1] It comes with a few services implemented. Additional services can be easily implemented by adding as few as six lines of PHP code.

# Installation

Installation of Kwirio.us is quick and painless. In fact, there isn't an installation, per se. Just download, extract, and load!

To get started, just use the command below:

```
$ git clone git@github.com:TheRealMihir/Kwirio.us.git
```

# Sample Code

##Usage

Kwirio.us is easy to implement and can be implemented in a little as seven lines of code. There are only three methods which you must call in order to create a working application: 

* `sethash()`
* `validate()`
* `crack()`

Let's make a basic application right now. Check it out:

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

This would print out:

```
string
```

Easy, right?


## Making an API Service

But, wait. What if you want to use Kwirio.us as an API? Still pretty easy to do:

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

So now, if the URL

```
http://domain.com/API.php?h=b45cffe084dd3d20d928bee85e7b0f21
```

is called, it prints out a JSON response like:

```json
{
  "hash":"b45cffe084dd3d20d928bee85e7b0f21",
  "valid":true,
  "found":true,
  "result":"string"
}
```

And, ta da! You have your own API for crackin' hashes.

# Services

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

# License

Kwirio.us is licensed under a WTFPL - do what the fuck you want to do. The terms are as follows:

```
         DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
                    Version 2, December 2004

 Copyright (C) 2012 The Royal Panda Company <mihir@royalpanda.co>

 Everyone is permitted to copy and distribute verbatim or modified
 copies of this license document, and changing it is allowed as long
 as the name is changed.

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

  0. You just DO WHAT THE FUCK YOU WANT TO.
```

# Credits

* [TheRealMihir](https://github.com/TheRealMihir) started and maintains the project.
* The Ruby script [BozoCrack](https://github.com/juuso/BozoCrack) inspired the project.

# Contribute

Want to contribute? We'd love to have your input.