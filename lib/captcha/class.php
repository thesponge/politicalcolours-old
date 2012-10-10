<?php
class captcha
{
    // Config the captcha
    var $captcha_number_of_chars    = 5; // number of chars in the captcha string
    var $captcha_number_of_actions  = 5; // number of actions until captcha is required again
    
    // Init
    var $captcha_action_status = 1;     // if 1, counting is enabled
    var $captcha_action_counter = array();
    
    function captcha()
    {
        // init the session
        if (session_id() == "")
        {
            session_start();
        }
        
        // init the captcha action counter
        if (is_array($_SESSION['captcha_action_counter']))
        {
            $this->captcha_action_counter = $_SESSION['captcha_action_counter'];
        }
    }
    
    
    /*
     *
     * Captcha action counter
     * 
    */    
    // Check the status
    function ca_needed($type='default', $max='5')
    {
        // Always needed
        if ($this->captcha_action_status == 0)
        {
            return true;
        }
        
        // Needed by count
        if ($this->captcha_action_counter[$type] > $max || !is_numeric($this->captcha_action_counter[$type]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    function ca_update($type='default', $max='5')
    {
        if (!is_numeric($this->captcha_action_counter[$type]))
        {
            $this->ca_reset($type);
        }
        else
        {
            if ($this->captcha_action_counter[$type] <= $max)
            {
                $this->captcha_action_counter[$type] = $this->captcha_action_counter[$type] + 1;
            }
        }
        
        $_SESSION['captcha_action_counter'] = $this->captcha_action_counter;
        return true;
    }
    
    function ca_reset($type='default')
    {
        $this->captcha_action_counter[$type] = 1;
        $_SESSION['captcha_action_counter'] = $this->captcha_action_counter;
        
        $this->refreshCaptcha();
        return true;
    }
    
    function ca_unset($type='default')
    {
        unset($this->captcha_action_counter[$type]);
        $_SESSION['captcha_action_counter'] = $this->captcha_action_counter;
        
        $this->refreshCaptcha();
        return true;
    }
    
    
    // Functions
    function captchaActionNeeded()
    {
        if ($this->captcha_action_count >= $this->captcha_number_of_actions)
        {
            // reset the action count
            $this->captcha_action_count = 0;
            return true;
        }
        else
        {
            // increase the action count
            $this->captcha_action_count++;
            return false;
        }
    }
    
    function refreshCaptcha()
    {
        $_SESSION['captcha'] = $this->random_string($this->captcha_number_of_chars);
        return true;
    }
    function returnCaptcha()
    {
        if (strlen($_SESSION['captcha']) != $this->captcha_number_of_chars)
        {
            $this->refreshCaptcha();
        }
        return $_SESSION['captcha'];
    }
    
    function random_string($nr_chars)
    {
        $chars = "abcdefghijkmnopqrstuvwxyz0123456789~!@#$%^&*";
        srand((double)microtime()*1000000);
        $i = 1;
        $text = '' ;
        while ($i <= $nr_chars)
        {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $text = $text . $tmp;
            $i++;
        }
        return $text;
    }
}
?>