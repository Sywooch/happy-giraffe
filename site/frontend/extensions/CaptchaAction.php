<?php

class CaptchaAction extends CCaptchaAction
{
	public $onlyDigits = FALSE;
	
        protected function generateVerifyCode()
        {
                if($this->minLength < 3)
                        $this->minLength = 3;
                if($this->maxLength > 20)
                        $this->maxLength = 20;
                if($this->minLength > $this->maxLength)
                        $this->maxLength = $this->minLength;
                $length = mt_rand($this->minLength,$this->maxLength);

                $code = '';
		if ($this->onlyDigits)
		{
			for($i = 0; $i < $length; ++$i)
			{
				$code .= mt_rand(0, 9);
			}
		}
		else
		{
			$letters = 'bcdfghjklmnpqrstvwxyz';
			$vowels = 'aeiou';
			for($i = 0; $i < $length; ++$i)
			{
				if($i % 2 && mt_rand(0,10) > 2 || !($i % 2) && mt_rand(0,10) > 9)
					$code.=$vowels[mt_rand(0,4)];
				else
					$code.=$letters[mt_rand(0,20)];
			}
		}

                return $code;
        }

}