<?php
namespace System\Helper; 
/**
* String helper
*/
class Str
{
	
    /**
     * 	Ékezetes karaktereket és a szóközt cseréli le ékezet nélkülire és alulvonásra
     * 	minden karaktert kisbetűre cserél
     */
    public function stringToSlug($string)
    {
        $accent = array("?", "!", ".", ":", "&", " ", "_", "á", "é", "í", "ó", "ö", "ő", "ú", "ü", "ű", "Á", "É", "Í", "Ó", "Ö", "Ő", "Ú", "Ü", "Ű");
        $no_accent = array('', '', '', '', '-', '-', '-', 'a', 'e', 'i', 'o', 'o', 'o', 'u', 'u', 'u', 'A', 'E', 'I', 'O', 'O', 'O', 'U', 'U', 'U');
        $string = str_replace($accent, $no_accent, $string);
        $string = strtolower($string);
        return $string;
    }

    /**
     * Egy szövegből az elejétől kezdődően adott karakterszámú rész ad vissza szóra kerekítve
     *  
     * @param   string  $string  szöveg
     * @param   int  $char  karakterek száma
     * @return  string  a levágott szöveg
     */
    public function substrWord($string, $char)
    {
        $s = mb_substr($string, 0, $char, 'UTF-8');
        return substr($s, 0, strrpos($s, ' '));
    }

    /**
     * Egy szövegből az elejétől adott számú mondatot ad vissza
     *  
     * @param   string  $body  szöveg
     * @param   int  $sentencesToDisplay  a mondatk száma
     * @return  string  a levágott szöveg
     */
    public function sentenceTrim($body, $sentencesToDisplay = 1)
    {
        $nakedBody = preg_replace('/\s+/', ' ', strip_tags($body));
        $sentences = preg_split('/(\.|\?|\!)(\s)/', $nakedBody);

        if (count($sentences) <= $sentencesToDisplay)
            return $nakedBody;

        $stopAt = 0;
        foreach ($sentences as $i => $sentence) {
            $stopAt += strlen($sentence);

            if ($i >= $sentencesToDisplay - 1)
                break;
        }

        $stopAt += ($sentencesToDisplay * 2);
        return trim(substr($nakedBody, 0, $stopAt));
    }    
}
?>