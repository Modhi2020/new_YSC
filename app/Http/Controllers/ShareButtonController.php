<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareButtonController extends Controller
{
    public function share()
    {
         // Share button 1
         $shareButtons1 = \Share::page(
            url('/share'), 
      )
      ->facebook()
      ->twitter()
      ->linkedin()
      ->telegram()
      ->whatsapp() 
      ->reddit();

      // Share button 2
      $shareButtons2 = \Share::page(
        url('/share'), 
      )
      ->facebook()
      ->twitter()
      ->linkedin()
      ->telegram();

      // Share button 3
      $shareButtons3 = \Share::page(
        url('/share'), 
      )
      ->facebook()
      ->twitter()
      ->linkedin()
      ->telegram()
      ->whatsapp() 
      ->reddit();

      // Load index view
      return view('pages.share.index')
            ->with('shareButtons1',$shareButtons1 )
            ->with('shareButtons2',$shareButtons2 )
            ->with('shareButtons3',$shareButtons3 );
    }
}
