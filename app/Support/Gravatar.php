<?php

use App\Models\Permission;
use Spatie\Valuestore\Valuestore;







//ParentShow
function getParentShow($param)
{
    $f = str_replace('admin.', '', $param);
    $Mylist = Permission::where('as', $f)->first();
    return $Mylist ? $Mylist->parent_show : $f;
}


//getParent
function getParent($param)
{
    $f = str_replace('admin.', '', $param);
    $Mylist = Permission::where('as', $f)->first();
    return $Mylist ? $Mylist->parent : $f;
}


function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}
