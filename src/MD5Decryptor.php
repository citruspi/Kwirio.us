<?php

    ###################################
    # Kwirio.us v0.1                  # 
    # The Royal Panda Company         #
    ###################################

    abstract class MD5Decryptor
    {
        abstract public function probe($hash);

        public static function plain($hash, $class = NULL)
        {
            if ($class === NULL) {
                $class = get_called_class();
            } else {
                $class = sprintf('MD5Decryptor%s', $class);
            }
            $decryptor = new $class();

            if (count($hash) > 1) {
                foreach ($hash as &$one) {
                    $one = $decryptor->probe($one);
                }
            } else {
                $hash = $decryptor->probe($hash);
            }
            return $hash;
        }

        public function dictionaryAttack($hash, array $wordlist)
        {
            $hash = strtolower($hash);
            foreach ($wordlist as $word) {
                if (md5($word) === $hash)
                    return $word;
            }
        }
    }

    abstract class MD5DecryptorWeb extends MD5Decryptor
    {
        protected $url;

        public function getWordlist($hash)
        {
            $list = FALSE;
            $url = sprintf($this->url, $hash);
            if ($response = @file_get_contents($url)) {
                $list[$response] = 1;
                $list += array_flip(preg_split('/\s+/', $response));
                $list += array_flip(preg_split('/(?:\s|\.)+/', $response));
                $list = array_keys($list);
            }
            return $list;
        }

        public function probe($hash)
        {
            $hash = strtolower($hash);
            
            $list = $this->getWordlist($hash);
            if ($list === false) {
                return '';
            } else {
                return $this->dictionaryAttack($hash, $list);
            }
        }
    }
    
    class MD5DecryptorMD5Hash extends MD5DecryptorWeb
    {
        protected $url = 'http://www.md5-hash.com/md5-hashing-decrypt/%s';
    }
    
    class MD5DecryptorDarkByte extends MD5DecryptorWeb
    {
        protected $url = 'http://md5.darkbyte.ru/api.php?q=%s';
    }

    class MD5DecryptorGoogle extends MD5DecryptorWeb
    {
        protected $url = 'http://www.google.com/search?q=%s';

    }

    class MD5DecryptorGromweb extends MD5DecryptorWeb
    {
        protected $url = 'http://md5.gromweb.com/query/%s';
    }
?>