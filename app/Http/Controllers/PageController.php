<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController
{
    public function home(){
        return "Home";
    }
    public function contact(){
        return "Contact";
    }
    public function about(){
        return "About"; 
    }
    
}
