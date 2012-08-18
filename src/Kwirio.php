<?php
        
    ###################################
    # Kwirio.us v0.1                  # 
    # The Royal Panda Company         #
    ###################################
    
    class Kwirio {
        
        private $hash;
        
        function __construct() {  
            //constructor
        }
        
        function validate(){
            return !empty($this->hash) && preg_match('/^[a-f0-9]{32}$/', $this->hash);
        }
        
        function confirm($solution){
            return (md5(strtolower($solution)) == $this->hash);
        }
        
        function setHash($hash){
            $this->hash = $hash;
        }
        
        ##################################################
        #                Service Format                  # 
        #================================================#
        #                                                #
        # function serviceName(){                        #
        #     $response = //Retrieve and decode call     #
        #                                                #
        #     if(clearTextIsFound)                       #
        #         return clearText;                      #
        #                                                #
        #     return notFound;                           #
        # }                                              #
        #                                                #
        ##################################################
        
        function collision(){
            $response = json_decode(file_get_contents('http://api.dev.c0llision.net/json/crack/md5/'.$this->hash), true);
            
            if($response['response']['result']['cracked'])
                return $response['response']['result']['plaintext']['raw'];
                
            return false;
        }
        
        function noisette(){
            $response = simplexml_load_string(file_get_contents('http://md5.noisette.ch/md5.php?hash='.$this->hash), null, LIBXML_NOCDATA);
                        
            if(isset($response->string))
                return $response->string;
                
            return false;      
        }
        
        function rednoize(){
            $response = file_get_contents('http://md5.rednoize.com/?p&s=md5&q='.$this->hash);
            
            if(strlen($response)>0)
                return $response;
                
            return false;
        }
        
        function ramsey(){
            $response = simplexml_load_string(file_get_contents('http://tools.benramsey.com/md5/md5.php?hash='.$this->hash), null, LIBXML_NOCDATA);
                        
            if(isset($response->string))
                return $response->string;
                
            return false;      
        }
        
        function darkbyte(){
            $response = file_get_contents('http://md5.darkbyte.ru/api.php?q='.$this->hash);
            
            if(strlen($response)>0)
                return $response;
                
            return false;
        }
        
        function search(){
            include ('MD5Decryptor.php');

            $decryptors = array('Google', 'Gromweb', 'DarkByte');
                                                            
            foreach($decryptors as $decrytor)
                if (NULL !== ($plain = MD5Decryptor::plain($this->hash, $decrytor))) {
                    return $plain;
                }            
        }
                    
        function crack(){
            
            if (!($this->validate())):
                return "Please set a valid hash.";
            elseif ($this->confirm($this->collision())):
                return $this->collision();
            elseif ($this->confirm($this->search())):
                return $this->search();
            elseif ($this->confirm($this->noisette())):
                return $this->noisette();    
            elseif ($this->confirm($this->rednoize())):
                return $this->rednoize();    
            elseif ($this->confirm($this->ramsey())):
                return $this->ramsey();  
            elseif ($this->confirm($this->darkbyte())):
                return $this->darkbyte();                                                                                
            else:
                return 'Hash not cracked! :(';
            endif;
            
        }
    }
  
?>

