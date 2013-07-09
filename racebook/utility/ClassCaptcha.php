<?php


/**
 * Description of ClassCaptcha
 *
 * @author Pascal
 */
class ClassCaptcha {
    //put your code here
    
    private $secretCode;
    
    function ClassCaptcha(){
        //echo 'Good';
    }
    
    function get_captcha() {
        return $this->secretCode;
    }
    public function set_captcha($code) {
        $this->secretCode = $code;
    }
    
    function generateCode(){
        for ($i = 0; $i < 5; $i++) {
            $rota[$i][0] = chr(rand(97, 122));
            $rota[$i][1] = rand(-5, 10);
            $string .= $rota[$i][0];
        }
        //set_captcha($string);
        return $rota;
    }
}

?>
