<?php
namespace System\Helper;
/**
* Number helper
*/
class Num {

	/**
	 * Nagy számokat kerekíti és alakítja át rövidebb formára: 2 000 000 - 2 M
	 * 
	 * @param string||number $n
	 * @param bool $scale - ha false, akkor nem írja a szám után az M vagy E betűt
	 */
    public function niceNumber($n, $scale = true)
    {
		// a nem numerikus karaktereket üres stringre cseréljük (ha üres string marad, akkor 0 lesz)
        $n = preg_replace('~\D~', '', $n);

        // is this a number?
        if (!is_numeric($n)) {
            return false;
        }

        if ($n >= 1000000) {
			$n = round(($n / 1000000), 2);
			if ($scale) {
				$n .= '&nbsp;M';
			}	
            return $n;
        }
        elseif ($n > 1000) {
			$n = round(($n / 1000), 0);
            if ($scale) {
				$n .= '&nbsp;E';
			}
			return $n;
        }

        return number_format($n);
    }

}
?>