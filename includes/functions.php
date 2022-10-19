<?php
function empbo_obfuscate_email_in_content($to_replace){
    return \empbo\filters::replace_in_content($to_replace , '' , true);
}