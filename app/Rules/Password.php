<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Password implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $score = 0;
        if (preg_match("/[0-9]+/",$value)) {
            $score ++;
        }
        if (preg_match("/[0-9]{3,}/",$value)) {
            $score ++;
        }
        if(preg_match("/[a-z]+/",$value)) {
            $score ++;
        }
        if(preg_match("/[a-z]{3,}/",$value)) {
            $score ++;
        }
        if(preg_match("/[A-Z]+/",$value)) {
            $score ++;
        }
        if(preg_match("/[A-Z]{3,}/",$value)) {
            $score ++;
        }
        if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]+/",$value)) {
            $score += 2;
        }
        if(preg_match("/[_|\-|+|=|*|!|@|#|$|%|^|&|(|)]{3,}/",$value)) {
            $score ++ ;
        }
        if(strlen($value) >= 8) {
            $score ++;
        }
        if($score < 6){
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return '密码必须包含数字、字母、符号，且长度在8位以上';
    }
}
