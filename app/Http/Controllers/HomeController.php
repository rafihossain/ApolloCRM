<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use DB;
use App\Event;
use App\Team;
use App\Follow;
use App\Partner;
use App\AthleteLog;
use App\Setting;
use App\Media_setting;
use App\Jersey;
use App\JerseyWinner;
use App\Athlete;
use App\WeekendWinner;
use App\NewsFeed;
use App\BadgeUpload;
use Session;

class HomeController extends Controller
{
  public function index()
    {
        $logs = Log::first();
    $athletes_count = AthleteLog::all()->count();
      return view('admin.dashboard',['logs'=>$logs,'athletes_count'=>$athletes_count]);
    }

    public function get_athlete_queue(){
        $athletes = AthleteLog::all()->count();
    $logs = Log::first();
        return array('athletes'=>$athletes,'logs'=>$logs);
    }

    public function err_page()
    {
      return view('error');
    }

    public function home()
    {
       // echo 123;die();
        
      $abcd = DB::select('SHOW TABLES');

      $dbname = DB::connection()->getDatabaseName();
      $tb = 'Tables_in_'.$dbname;
      $year2 = array();
       foreach ($abcd as $key => $value) {
        $strpos = strpos($value->$tb , "eventdata" );
        if ($strpos !== false ) {
          $year2[] = $value->$tb;
        }
       }

       // $event = Event::select('id')->get();
       // foreach ($event as $key => $value) {
       //     $event_data[] = $value['id'];
       // }

      $comming_event = array();
       foreach ($year2 as $key => $value) {
          $com_event = DB::table($value)->groupBy('event_id')->select('event_id')->get();
          foreach ($com_event as $key => $value) {
            $comming_event[] = $value->event_id;
          }
       }
        
        $december =  date("F", strtotime(date('Y-m-d') ));

        if ($december == 'December') {
            $data['current_year'] = date('Y') + 1;
            $data['next_year'] = date('Y') + 2 ;
        }else{
            $data['current_year'] = date('Y');
            $data['next_year'] = date('Y') + 1 ;
        }
		
        $data['comming_event'] = Event::where('event_year' ,$data['current_year'])->where('event_show',1)->where('type',0)->select('event_name','id', 'event_date' , 'event_logo' , 'slider_event_logo' ,'event_badge')->orderBy('event_date', 'ASC')->get();
    		if($data['comming_event']->count()>0){
    			$ce = array();
    			foreach($data['comming_event'] as $v){
    				$extend_date = date('Y-m-d',strtotime($v->event_date.' +7 day'));
            $extend_date_2 = date('Y-m-d',strtotime($v->event_date));
    				if(date('Y-m-d')<=$extend_date){
    					$ce[] = $v;
    				}
            if(date('Y-m-d')<=$extend_date_2){
              $ce222[] = $v;
            }
    			}
    		}

        if(count($ce222)>0){
          $data['comming_event_third_bar'] = $ce222;
        }

    		if(count($ce)>0){
    			$data['comming_event'] = $ce;
    		}
		
        // $data['comming_event_2'] = Event::where('event_date' ,'<' ,date('Y-m-d') )->where('event_show',1)->where('event_year' ,$data['current_year'])->where('type',0)->select('event_name','id', 'event_date' , 'event_logo' , 'slider_event_logo' ,'event_badge')->orderBy('event_date', 'DESC')->get();


        $data['international_event'] = Event::where('event_year', $data['current_year'] )->where('event_show',1)->where('type', 2 )->select('event_name','id', 'event_date' , 'event_logo','event_visibility','event_badge')->orderBy('event_date', 'ASC')->get();

        $data['current_schedule'] = Event::whereNotIn('id', $comming_event)->where('event_show',1)->where('type' , 0)->where('event_year' , $data['current_year'])->select('event_name','id', 'event_date' , 'event_logo', 'schedule_clickable', 'event_distance' ,'event_badge' ,'event_badge_type' , 'event_badge_shirt' , 'event_badge_medals')->orderBy('event_date', 'ASC')->get();

        if($data['current_schedule']->count()>0){
    			$cs = array();
    			foreach($data['current_schedule'] as $v){
    				$extend_date = date('Y-m-d',strtotime($v->event_date.' +7 day'));	
    				if(date('Y-m-d')<=$extend_date){
    					$cs[] = $v;
    				}
    			}
    		}
    		if(count($cs)>0){
    			$data['current_schedule'] = $cs;
    		}

        $data['next_year_schedule'] = Event::whereNotIn('id', $comming_event)->where('event_show',1)->where('type' , 0)->where('event_year' , $data['next_year'])->select('event_name','id', 'event_date' , 'event_logo', 'schedule_clickable', 'event_distance' ,'event_badge' ,'event_badge_type' , 'event_badge_shirt' , 'event_badge_medals')->orderBy('event_date', 'ASC')->get();

        $data['home_banner'] = Setting::where('id',2)->select('value')->first();

        $data['team'] = Team::select('id','name','logo','order_field','visibility')->orderBy('order_field')->get();
        $data['partner'] = Partner::where('status',1)->get();
        $data['follow'] = Follow::where('status',1)->get();
        $data['social_media'] = Media_setting::where('status',1)->get();

          $data['status'] =  Setting::select('value')->where('column_name', 'weekend_winners')->first();
    
          $data['jersey_pic'] = Jersey::first();
          $data['jersey'] = JerseyWinner::first();

          $data['male_orange'] = Athlete::select('image')->where('athlete_name', $data['jersey']['orange_male'])->first();

          $data['female_orange'] =  Athlete::select('image')->where('athlete_name', $data['jersey']['orange_female'])->first();


          $data['male_blue'] =  Athlete::select('image')->where('athlete_name', $data['jersey']['blue_male'])->first();

          $data['female_blue'] =  Athlete::select('image')->where('athlete_name', $data['jersey']['blue_female'])->first();

          $data['male_red'] =  Athlete::select('image')->where('athlete_name', $data['jersey']['red_male'])->first();

          $data['female_red'] =  Athlete::select('image')->where('athlete_name', $data['jersey']['red_female'])->first();

          $data['male_white'] =  Athlete::select('image')->where('athlete_name', $data['jersey']['white_male'])->first();

          $data['female_white'] =  Athlete::select('image')->where('athlete_name', $data['jersey']['white_female'])->first();
          
          $data['male_yellow'] =  Athlete::select('image')->where('athlete_name', $data['jersey']['yellow_male'])->first();

          $data['female_yellow'] =  Athlete::select('image')->where('athlete_name', $data['jersey']['yellow_female'])->first();
          
          // $data['weekend_winner_2'] = Event::where('event_date' , '<=' , date('Y-m-d' , strtotime('next sunday')) )->where('event_date' , '>=' , date('Y-m-d' , strtotime('last sunday')) )->where('event_year' , date('Y') )->whereIn('id', $comming_event)->select('id')->orderBy('id', 'desc')->get();

        if ($data['status']['value'] == 1) {
      
        $weekend_winners =  WeekendWinner::groupBy('distance')->select('distance')->orderBy('distance','desc')->get();
        $distance_wise_athlete = array();
        foreach($weekend_winners as $w){
          $distance_wise_athlete[] = WeekendWinner::with('athlete')->with('event')->where('distance',$w->distance)->get();
        }
        $data['distance_wise_athlete'] = $distance_wise_athlete;

            }

        $NewsFeed_ids = array();

        $newarrs  = NewsFeed::where('status', 1)->orderBy('news_date','DESC')->orderBy('id','DESC')->take(6)->get()->toArray();
        
        
        // usort($newarrs, function($a,$b) {
        // if($a['id'] === $b['id']) return 0;
        // return ($a['id'] < $b['id']) ? -1 : 1;
        // });
        
            usort($newarrs, function($a, $b) {
        return strtotime($b['news_date']) <=> strtotime($a['news_date']);
        }); 
        
        $data['NewsFeed'] =  $newarrs;
        
        foreach ($data['NewsFeed'] as $key => $value) {
        $NewsFeed_ids[] = $value['id'];
        }
        Session::put('NewsFeed_ids', $NewsFeed_ids );
        $data['NewsFeed_idsp'] =json_encode($NewsFeed_ids);
        $data['badge'] = BadgeUpload::first();
        

      define('RS_APP_ID', $data['social_media'][0]['app_id']);
      define('RS_APP_SECRET', $data['social_media'][0]['app_secret'] );
      //define('RS_APP_TOKEN', 'EAAHS2I27fuQBAHIa4ekGi2NneV1UsJe6jxMWbChbmVxVZAt1mrvFw7kXF7TpMcTxZCdKaa0oBZAk5ovmHXbOqwVH1dHDZBLbHD4QMDfQmasKdJ4O3BFSnAbMAsJRvcjkWIuz1Jvutmdjhjj7sbjy7yKoFwdXUEkZD');
      define('RS_APP_TOKEN', $data['social_media'][0]['app_token']);
      
      $fb_error =  0;    
      $fb = new \Facebook\Facebook([
        'app_id' => RS_APP_ID,
        'app_secret' => RS_APP_SECRET,
        'default_graph_version' => 'v2.10',
        'default_access_token' => RS_APP_TOKEN // optional
      ]);

      // Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
      //   $helper = $fb->getRedirectLoginHelper();
      //   $helper = $fb->getJavaScriptHelper();
      //   $helper = $fb->getCanvasHelper();
      //   $helper = $fb->getPageTabHelper();

      try {
        // Get the \Facebook\GraphNodes\GraphUser object for the current user.
        // If you provided a 'default_access_token', the '{access-token}' is optional.
       // $response = $fb->get('/me', RS_APP_TOKEN);
         $fb_error = 1;
      } catch(\Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        $fb_error = 1;
        // echo 'Graph returned an error: ' . $e->getMessage();
        // exit;
      } catch(\Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        // echo 'Facebook SDK returned an error: ' . $e->getMessage();
        // exit;
        $fb_error = 1;
      }
      
      if($fb_error == 0) {
          
          try {
        // Returns a `FacebookFacebookResponse` object
        $response = $fb->get(
          '/10163433276655344/accounts',
          RS_APP_TOKEN
        );
      } catch(FacebookExceptionsFacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
      } catch(FacebookExceptionsFacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
      }
      $graphEdge = $response->getGraphEdge();

      //var_dump($graphNode);

      foreach ($graphEdge as $graphNode) {
        $dd = $graphNode->asArray();
        
       //  echo 'Page : '.$dd['name'].' With ID: '.$dd['id'];
       // echo '<br>';
      }


      try {
        // Returns a `FacebookFacebookResponse` object
        $response = $fb->get(
          '/331573360631822/feed?fields=attachments,child_attachments,message,picture,story,status_type',
          RS_APP_TOKEN
        );
      } catch(FacebookExceptionsFacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
      } catch(FacebookExceptionsFacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
      }
      $graphEdge = $response->getGraphEdge();

      foreach ($graphEdge as $key=> $graphNode) {

        if ($key <=2) {
          $dd = $graphNode->asArray();
          $fb_data[] = $dd;
        }
        
        //echo 'Page : '.$dd['name'].' With ID: '.$dd['id'];
      }

      foreach ($fb_data as $key => $val1) {

        if (isset($val1['attachments'][0]['description']) && isset($val1['message'])) {
             if(array_key_exists ( 'attachments' , $val1 )){
          $var[] = [
          "url" => $val1['attachments'][0]['url'],
          "src" => $val1['attachments'][0]['media']['image']['src'],
          "description" => $val1['attachments'][0]['description'] ,
          "message" => $val1['message'],
          "target_url" => $val1['attachments'][0]['target']['url'],
        ];
}
        }elseif (!isset($val1['attachments'][0]['description'])) {
            
        if(array_key_exists ( 'attachments' , $val1 )){
          $var[] = [
          "url" => $val1['attachments'][0]['url'],
          "src" => $val1['attachments'][0]['media']['image']['src'],
          "message" => $val1['message'],
          "target_url" => $val1['attachments'][0]['target']['url'],
        ];
        }
        }else{
             if(array_key_exists ( 'attachments' , $val1 )){
          $var[] = [
          "url" => $val1['attachments'][0]['url'],
          "src" => $val1['attachments'][0]['media']['image']['src'],
          "description" => $val1['attachments'][0]['description'] ,
          "target_url" => $val1['attachments'][0]['target']['url'],
        ];
             }
        }
        
      }


      $txtmsg ='';
      $txtdes ='';

      $hastag = 'https://www.facebook.com/hashtag/rondevanaruba?fref=';


      foreach ($var as $key => $value) {


        if (isset($value['message']) && isset($value['description']) ) {
          $message = explode('#', $value['message']);  
          $description = explode('#', $value['description']);  

          if (count($message)) {

            
            foreach ($message as $key2 => $val) {
              
            if(strrpos($val," ") && $key2 == 0){
              $txtmsg .=$val;
              }else{
                $txtmsg .='<a target="_blank" style="color:#385898;" href="'.$hastag.''.strtok($val," ").' "> #'.strtok($val, " ").'</a>';
              }


            }
            

          }



          if (count($description)) {
            foreach ($description as $key2 => $val) {
          
            if(strrpos($val," ") && $key2 == 0){
              $txtdes .=$val;
              }else{
                $txtdes .='<a target="_blank" style="color:#385898;" href="'.$hastag.''.strtok($val," ").' "> #'.strtok($val," ").'</a>';
              }
            }


          }

          $variable[$key] = [
              "message" => $txtmsg,
              "url" => $value['url'],
              "src" => $value['src'],
              "description" => $txtdes,
              "target_url" => $value['target_url'],

            ];
          

        }


        if (!isset($value['message'])  ) {
          $description = explode('#', $value['description']);  

          if (count($description)) {
            foreach ($description as $key2 => $val) {
          
            if(strrpos($val," ") && $key2 == 0){
              $txtdes .=$val;
              }else{
                $txtdes .='<a target="_blank" style="color:#385898;" href="'.$hastag.''.strtok($val," ").' "> #'.strtok($val," ").'</a>';
              }
            }


          }

          $variable[$key] = [
              "url" => $value['url'],
              "src" => $value['src'],
              "description" => $txtdes,
              "target_url" => $value['target_url'],

            ];

        }

        if (!isset($value['description'])  ) {
          $message = explode('#', $value['message']);  

          if (count($message)) {
            foreach ($message as $key2 => $val) {
          
            if(strrpos($val," ") && $key2 == 0){
              $txtmsg .=$val;
              }else{
                $txtmsg .='<a target="_blank" style="color:#385898;" href="'.$hastag.''.strtok($val," ").' "> #'.strtok($val," ").'</a>';
              }
            }

            

          }

          $variable[$key] = [
              "url" => $value['url'],
              "src" => $value['src'],
              "message" => $txtmsg,
              "target_url" => $value['target_url'],

            ];

        }



          $txtmsg = '';

          $txtdes = '';
       
      }



      $data['fb_data'] = $variable;
          
      }
     // echo '<pre>';
     // print_r($data);
     // die();
        
    return view('front_end.home.home' , $data);
    }

    public function weekend_winners()
    {
        $view = view('front_end.home.week_end' , $data);
        echo $view;
    }

}
