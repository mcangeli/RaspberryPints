<?php

class HomeController extends BaseController {


	public function index()
	{
		$data['options'] = Option::AllAsFlatten();
		
		$data['taps'] = ActiveTap::orderBy('tapNumber')->get();
		
		$options = $data['options'];
		
		
		$beerInfo = array();
		foreach($data['taps'] as $taps){
		
		if($options[OptionNames::ClientID] && $taps->untID!='0'){
		
		
		$cachename = $taps->untID.".beerInfo2";
		if (Cache::has($cachename)) {
			
			
	}  else {
			
		$Info = Untappd::beerINFO($data['options'],$taps->untID);
		$beerInfo = Array( 
				
		     "untID" => $taps->untID,
			 
			 "rating_score" => $Info->rating_score,
			 "beer_label" => $Info->beer_label
			 );
		
		
		cache::put($cachename,$beerInfo,1440);
		$cachefile = Cache::get($cachename); 
		
		}
		} 
		
		$user = User::lists('username','id');
		$data['user'] = array('user' => $user);
		}
		
				
				
			return View::make('home.index', $data);
	}

	public static function setUserActive() {
		$id = Input::gety('id');
		DB::update('update users set pouring = 1 where id = ?', array($id));
		
		
	}
	
}
