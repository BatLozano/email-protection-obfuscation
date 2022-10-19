<?php
namespace empbo;

abstract class filters{

    public static function obfuscate() {

        $class = '\empbo\filters';

        add_filter('vc_shortcodes_custom_css', [$class, 'replace_in_content'] , 1);
        add_filter('the_content', [$class, 'replace_in_content'], 1);
        add_filter('the_editor_content', [$class, 'replace_in_content'], 2);
     
    }


    public static function replace_in_content($to_filter , $default_editor = "" , $keep_href = false){

        if(empty($to_filter)) return $to_filter;
    
    
        $components = [];
        $doc = new \DomDocument();
        @$doc->loadHTML($to_filter);
        foreach ($doc->getElementsByTagName("a") as $a) {
            if ($a->hasAttribute("href")) {
                $href = trim($a->getAttribute("href"));
                if (strtolower(substr($href, 0, 7)) === 'mailto:') {
                    $components[] = parse_url($href);
                }
            }
        }
    
        foreach($components as $mailto){
    
            $link               = "mailto:".$mailto["path"];
            $obfusctated_link   = self::obfuscate_str($mailto["path"]);
    
            $to_filter          = str_replace('"'.$link.'"' , '"" data-empbo="'.$obfusctated_link.'"' , $to_filter);
            $to_filter          = str_replace("'".$link."'" , "'' data-empbo='".$obfusctated_link."'" , $to_filter);

            if(!$keep_href){
                $to_filter          = str_replace('href=""' , "" , $to_filter);
                $to_filter          = str_replace("href=''" , "" , $to_filter);
            }
    
            $to_filter          = str_replace($mailto["path"] , antispambot($mailto["path"]) , $to_filter);
            
        }
    
       
        return $to_filter;
        
    }


    private static function obfuscate_str($str){

        $array_characters = str_split($str);
        $array_characters = array_reverse($array_characters);
    
        $obfuscated_chars = [];
        foreach($array_characters as $caractere) $obfuscated_chars[] = base64_encode(\ord($caractere) + EMPBO_SPECIAL_NUMBER);
        
        foreach($obfuscated_chars as $k => $char) $obfuscated_chars[$k] = str_ireplace("MT" , "" , $char);
        
        $obfuscated_str = join($obfuscated_chars);
        $obfuscated_str = base64_encode($obfuscated_str);
        
        return $obfuscated_str;
        
    }

}