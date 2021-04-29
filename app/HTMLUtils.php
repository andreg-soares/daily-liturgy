<?php
class HTMLUtils {
    public static function removeBreak($string) {
        return trim(preg_replace('/\s+/', ' ', $string));
    }

    public static function DOMinnerHTML(DOMNode $element) {
        $innerHTML = "";
        $children  = $element->childNodes;

        foreach ($children as $child)
            $innerHTML .= $element->ownerDocument->saveHTML($child);

        return $innerHTML;
    }

    public static function color($query)
    {
        switch (strtolower($query)) {
            case 'branco':
                return '#FEDD16';
            case 'verde':
                return '#2FB166';
            case 'vermelho':
                return '#FB0033';
            case 'roxo':
                return '#803E96';
            case 'rosa':
                return '#F7B8D7';
            default :
                return "#007AFF";
        }
    }

    public static function colorText($query){
        return explode(": " ,HTMLUtils::removeBreak($query))[1];
    }


}