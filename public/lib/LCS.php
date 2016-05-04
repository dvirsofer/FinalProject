<?php


class LCS
{
    public static function LCSAlgorithm($string1, $string2) {
        $lcs = array_fill(0, strlen($string1 + 1), array_fill(0, strlen($string2 + 1), 0));

        for($i = 0; $i <= strlen($string1); $i++) {
            $lcs[$i][0] = 0;
        }
        for($j = 0; $j <= strlen($string2); $j++) {
            $lcs[0][$j] = 0;
        }

        for($i = 1; $i <= strlen($string1); $i++) {
            for($j = 1; $j <= strlen($string2); $j++) {
                if($string1[$i - 1] === $string2[$j - 1]) {
                    $lcs[$i][$j] = $lcs[$i - 1][$j - 1] + 1;
                }
                else {
                    $lcs[$i][$j] = max($lcs[$i - 1][$j], $lcs[$i][$j - 1]);
                }
            }
        }
        return $lcs;
    }
}