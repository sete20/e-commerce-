
<?php
   if (!function_exists('aurl')) {
        function aurl($url=null){
            return url('admin/'.$url);
        }   
    }
    if (!function_exists('admin')) {
        function admin($url=null){
            return auth()->guard('admin');
        }  }    
