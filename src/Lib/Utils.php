<?php 
declare(strict_types=1);

namespace Lib;

class Utils {
    public static function dayOfTheWeek(): string {
        return date('D');
    }

    public static function timeOfTheDay(): string {
        return date('H');
    }

    public static function csrf() {
        $length = 32;
        $_SESSION['token'] = substr(base_convert(sha1(uniqid()), 16, 36), 0, $length); 

        // 1 hour = 60 seconds * 60 minutes = 3600
        $_SESSION['token-expire'] = time() + 3600;

        return $_SESSION['token'];
    }

    public function divideEqually($number, $divisor)
    {
        $parts = [];
        
        $quotient = round($number/$divisor, 2);

        for($i = 0; $i < $divisor; $i++) {
            $parts[$i] = $quotient;
        }

        $parts[0] += $number - array_sum($parts);

        return $parts;
    }
}