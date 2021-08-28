<?php

namespace App\Http\Controllers;

use App\FixedPages;
use App\MainSection;
use App\SubSection;
use App\Advs;
use App\Advertiser;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        
      $adv = Advs::count();
      $advcount = ceil(($adv/50));
      return response()->view('sitemap.index',['advcount' => $advcount])->header('Content-Type', 'text/xml');
    }
    

    
    public function pages()
    {
      $pages = FixedPages::all();
      
      return response()->view('sitemap.pages', [
          'pages' => $pages,
      ])->header('Content-Type', 'text/xml');
    }
    
    public function categories()
    {
        $main_sections = MainSection::all();
    
      return response()->view('sitemap.categories', [
          'main_sections' => $main_sections,
      ])->header('Content-Type', 'text/xml');
    }
    
    public function posts(Request $Request)
    {
      
        $page = 0;
        $limit = 50;
          if($Request->page > 1){
               $page = (($Request->page-1) * $limit) +1  ;
          }
         
        $Advs = Advs::select('id','updated_at')->offset($page)->limit($limit)->get(); 
    
      return response()->view('sitemap.posts', [
          'Advs' => $Advs,
      ])->header('Content-Type', 'text/xml');
    }
     
    public function advertisers()
    {
      $Advertiser = Advertiser::all();
      return response()->view('sitemap.advertisers', [
          'Advertiser' => $Advertiser,
      ])->header('Content-Type', 'text/xml');
    }
    
}