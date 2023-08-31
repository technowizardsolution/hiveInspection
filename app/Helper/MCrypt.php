<?php
namespace App\Helper;

class MCrypt
{
    private $iv = 'FNdRj950geJ1mkos'; #Same as in JAVA
    private $key = '70tQ2m2b4OeN37qv'; #Same as in JAVA

    public function encrypt_str($str) {
        if($str != ""){
            // $str = $this->pkcs5_pad($str);
            $iv = $this->iv;
            $td = @mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
            @mcrypt_generic_init($td, $this->key, $iv);
            $encrypted = @mcrypt_generic($td, trim($str));
            @mcrypt_generic_deinit($td);
            @mcrypt_module_close($td);
            return bin2hex($encrypted);
        }

    }
    public function decrypt_str($code) {
        if($code != ""){
            $code = $this->hex2bin($code);
            $iv = $this->iv;
            $td = @mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
            @mcrypt_generic_init($td, $this->key, $iv);
            $decrypted = @mdecrypt_generic($td, $code);
            @mcrypt_generic_deinit($td);
            @mcrypt_module_close($td);
            $ut =  trim($decrypted);

            return $this->pkcs5_unpad($ut);
        }

    }

    protected function hex2bin($hexdata) {
        $bindata = '';
        for ($i = 0; $i < strlen($hexdata); $i += 2) {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }
        return $bindata;
    }

    protected function pkcs5_pad ($text) {
	  $blocksize = 16;
	  $pad = $blocksize - (strlen($text) % $blocksize);
	  return $text . str_repeat(chr($pad), $pad);
    }

    protected function pkcs5_unpad($text) {
	  $pad = ord($text{strlen($text)-1});
	  if ($pad > strlen($text)) {
	      return $text;
	  }
	  if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
	      return $text;
	  }
	  return substr($text, 0, -1 * $pad);
    }
}

?>
