<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Athlete;
use App\Partner;
use App\Age_group;
use App\Event;
use App\Follow;
use App\Setting;
use App\OverallRanking;
use App\EventRanking;
use App\BadgeUpload;
use Redirect;
use Session;
use DB;

class RankingController extends Controller
{

 public function common()
    {
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

       // $event = Event::all();
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



        $date =  date('M d, Y', strtotime('-7 days'));

        $december =  date("F", strtotime(date('Y-m-d') ));

        if ($december == 'December') {
            $data['current_year'] = date('Y') + 1;
            $data['next_year'] = date('Y') + 2 ;
        }else{
            $data['current_year'] = date('Y');
            $data['next_year'] = date('Y') + 1 ;
        }

       $data['comming_event'] = Event::where('event_year' ,$data['current_year'])->where('type',0)->select('event_name','id', 'event_date' , 'event_logo' , 'slider_event_logo')->where('event_show',1)->orderBy('event_date', 'ASC')->get();
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
        // $data['comming_event_2'] = Event::where('event_date' ,'<' ,date('Y-m-d') )->where('event_show',1)->where('event_year' ,$data['current_year'])->where('type',0)->select('event_name','id', 'event_date' , 'event_logo' , 'slider_event_logo')->orderBy('event_date', 'DESC')->get();


        $data['international_event'] = Event::where('event_year', $data['current_year'] )->where('event_show',1)->where('type', 2 )->select('event_name','id', 'event_date' , 'event_logo','event_visibility')->orderBy('event_date', 'ASC')->get();

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


        $data['team'] = Team::orderBy('order_field')->get();
        $data['partner'] = Partner::where('status',1)->get();
        $data['follow'] = Follow::where('status',1)->get();
        $data['badge'] = BadgeUpload::first();

        return $data;
    }
    public function index($e_id="")
    {
      $comming_event = array();

        $abcd = DB::select('SHOW TABLES');

        $dbname = DB::connection()->getDatabaseName();
        $tb = 'Tables_in_'.$dbname;

       foreach ($abcd as $key => $value) {
        $strpos = strpos($value->$tb , "eventdata" );
        if ($strpos !== false ) {
          $year2[] = $value->$tb;
        }
       }

       foreach ($year2 as $key => $value) {
          $com_event = DB::table($value)->groupBy('event_id')->where('age_type' , 0)->select('event_id')->get();
          foreach ($com_event as $key => $value) {
            $comming_event[] = $value->event_id;
          }
       }
      
      $yr_data = array();
      
      foreach ($year2 as $key => $value) {
        $com_event = DB::table($value)->where('age_type' , 0 )->select('id')->first();
        if($com_event != null){
        $yr_data[] = str_replace(array('eventdata_' , 's'), '', $value );
        }
      }

        $data['selected_year'] =  Event::select('event_year','event_date')->where('id', $e_id )->first();
       
        $data['year'] = Event::select('event_year')->where('type', 0)->whereIn('event_year' , $yr_data)->orderBy('event_year','DESC')->distinct()->get();

        if (count($data['year']) == 0 ) {
         $data['empty'] = 1;
        }else{

        if ($e_id !='') {
        $data["hidden_id"] = $e_id;
        
        }
      }

      return view('front_end.ranking.ranking' , $data ,  $this->common() );
    }

    public function youth_ranking($e_id="")
    {
        
        $comming_event = array();
        $abcd = DB::select('SHOW TABLES');

        $dbname = DB::connection()->getDatabaseName();
        $tb = 'Tables_in_'.$dbname;




       foreach ($abcd as $key => $value) {
        $strpos = strpos($value->$tb , "eventdata" );
        if ($strpos !== false ) {
          $year2[] = $value->$tb;
        }
       }



       foreach ($year2 as $key => $value) {
  
          $com_event = DB::table($value)->groupBy('event_id')->where('age_type' , 2)->select('event_id')->get();
          

          foreach ($com_event as $key => $value) {
            $comming_event[] = $value->event_id;
          }
       }

 
      $yr_data = array();
      
      foreach ($year2 as $key => $value) {
        $com_event = DB::table($value)->where('age_type' , 2 )->select('id')->first();
        if($com_event != null){
        $yr_data[] = str_replace(array('eventdata_' , 's'), '', $value );
        }
      }

        $data['selected_year'] =  Event::select('event_year','event_date')->where('id', $e_id )->first();
       
        $data['year'] = Event::select('event_year')->where('type', 0)->whereIn('event_year' , $yr_data)->orderBy('event_year','DESC')->distinct()->get();

        if (count($data['year']) == 0 ) {
         $data['empty'] = 1;
        }else{

        if ($e_id !='') {
        $data["hidden_id"] = $e_id;
        
        }
      }



      return view('front_end.ranking.youth_ranking' , $data ,  $this->common() );
    }

    public function events_list_young($id)
    {

        $event_data = 'eventdata_'.$id.'s';
        $data["data"] = DB::table($event_data)->select('event_id','event_name')->groupBy('event_id')->where('age_type' , 2)->orderBy('event_date','DESC')->get();
        
        $view = view('front_end.ranking.select_youth' , $data);
        echo $view->render();
    }

    public function overall_list_young($event_title , $year)
    {
        $data['variable'] = OverallRanking::groupBy('athlete_name')->where('age_type', 2)->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->select('progress_status', 'athlete_name', 'mrp' , 'event_id', 'rank')->orderBy('rank', 'asc')->orderBy('athlete_name', 'ASC')->take(10)->get();
        $data['variable_f'] = OverallRanking::groupBy('athlete_name')->where('age_type', 2)->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->select('progress_status', 'athlete_name', 'mrp', 'rank', 'event_id')->orderBy('rank', 'asc')->orderBy('athlete_name', 'ASC')->take(10)->get();
    
    

        if (count($data['variable']) == 0 && count($data['variable_f']) == 0) {
          echo " ";
        }else{
          $data['type'] = 1;

          $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type',2)->get();

          $data["all"] = "all";
      
      $data['event_id'] = $event_title;
            $event = Event::where('id',$event_title)->first();
            $data['year'] = $year;
            $data['event_id'] = $event_title;
            $data['event_date'] = $event->event_date;
            
        

          $view = view('front_end.ranking.overall_youth' , $data);
          echo $view->render();
      }
    }


    public function events_list($id)
    {

        $event_data = 'eventdata_'.$id.'s';
        $data["data"] = DB::table($event_data)->select('event_id','event_name')->groupBy('event_id')->where('age_type' , 0)->orderBy('event_date','DESC')->get();


        $view = view('front_end.ranking.select' , $data);
        echo $view->render();
    }

    public function events_list_2($id , $nxt_pri)
    {

      $data['nxt_pri'] = $nxt_pri;

      $event_data = 'eventdata_'.$id.'s';
      $data["data"] = DB::table($event_data)->groupBy('event_id')->where('age_type' , 0)->orderBy('event_date','DESC')->get();


      $view = view('front_end.ranking.select' , $data);
      echo $view;
    }

    public function principle(){
        $settings = Setting::all();
        foreach($settings as $s){
            if($s->column_name=='principle'){
                $principle = $s->value;
            }
        }
        $p = explode('/',$principle);
        $p = $p[0]/$p[1];
        return $p;
    }

    public function overall_list($event_title , $year)
    {
        $data['variable'] = OverallRanking::groupBy('athlete_name')->where('age_type', 0)->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->select('progress_status', 'athlete_name', 'mrp' , 'event_id', 'rank')->orderBy('rank', 'asc')->orderBy('athlete_name', 'ASC')->take(10)->get();
        $data['variable_f'] = OverallRanking::groupBy('athlete_name')->where('age_type', 0)->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->select('progress_status', 'athlete_name', 'mrp', 'rank', 'event_id')->orderBy('rank', 'asc')->orderBy('athlete_name', 'ASC')->take(10)->get();

        if (count($data['variable']) == 0 && count($data['variable_f']) == 0) {
          echo " ";
        }else{
          $data['type'] = 1;

          $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type',0)->get();

            $data["all"] = "all";
      
            $data['event_id'] = $event_title;
            $event = Event::where('id',$event_title)->first();
            $data['year'] = $year;
            $data['event_id'] = $event_title;
            $data['event_date'] = $event->event_date;
 $data['event_year'] = $event->event_year;
          $view = view('front_end.ranking.overall' , $data);
          echo $view->render();
      }
    }

    public function ranking_list($event_title , $year)
    {
      $data['event_id'] = $event_title;

      $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->orderBy('event_point', 'DESC')->take(10)->get();
      $data['variable_f'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->orderBy('event_point', 'DESC')->take(10)->get();

      if (count($data['variable']) == 0 && $data['variable_f']) {
        echo " ";
      }else{

      $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type', 0)->get();

      $data['type'] = 2;

    $data["all"] = "all";
    $event = Event::where('id',$event_title)->first();
    $data['event_id'] = $event_title;
    $data['event_date'] = $event->event_date;
    $data['event_year'] = $event->event_year;
      $view = view('front_end.ranking.overall' , $data);
      echo $view->render();
      }
    }
    

    public function overall_list_age_group($event_title , $year, $age_group)
    {
      $data['age_title'] = $age_group;
      if ($age_group == 'all') {
        
        $data['variable'] = OverallRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->orderBy('mrp', 'DESC')->select('progress_status', 'athlete_name', 'mrp' , 'event_id', 'rank')->take(10)->get();
        $data['variable_f'] = OverallRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->orderBy('mrp', 'DESC')->select('progress_status', 'athlete_name', 'mrp' , 'event_id', 'rank')->take(10)->get();
        $data["all"] = "all";
      }else{
        $data['variable'] = OverallRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%'.'M '.$age_group.'%' )->select('age_wise_progress_status', 'athlete_name', 'mrp' , 'event_id', 'age_wise_rank')->orderBy('mrp', 'DESC')->take(10)->get();

        $data['variable_f'] = OverallRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->where('age_category' , 'like', '%'.$age_group.'%' )->select('age_wise_progress_status', 'athlete_name', 'mrp' , 'event_id', 'age_wise_rank')->orderBy('mrp', 'DESC')->take(10)->get();
        $data["age_group_flag"] = $age_group;
      }
      $data['type'] = 1;

      if ($age_group == "14-16" ) {
        $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type',2)->get();
      }else{
        $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type',0)->get();
      }

      $data["select_age_group"] = $age_group;

        

      $event = Event::where('id',$event_title)->first();
      $data['year'] = $year;
      $data['event_id'] = $event_title;
      $data['event_date'] = $event->event_date;
       $data['event_year'] = $event->event_year;

      $view = view('front_end.ranking.overall' , $data);
      echo $view->render(); 
    }

    public function overall_list_age_group_kid($event_title , $year, $age_group)
    {

      $data['age_title'] = $age_group;

      if ($age_group == 'all') {
        $data['variable'] = OverallRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->select('progress_status', 'athlete_name', 'mrp' , 'event_id', 'rank')->orderBy('mrp', 'DESC')->take(10)->get();
        $data['variable_f'] = OverallRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->select('progress_status', 'athlete_name', 'mrp' , 'event_id', 'rank')->orderBy('mrp', 'DESC')->take(10)->get();
        $data["all"] = "all";
      }else{
    $data['age_group_flag'] =1;
        $data['variable'] = OverallRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->where('age_category' , 'like', '%'.$age_group.'%' )->select('age_wise_progress_status', 'athlete_name', 'mrp' , 'event_id', 'age_wise_rank')->orderBy('mrp', 'DESC')->take(10)->get();

        $data['variable_f'] = OverallRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->where('age_category' , 'like', '%'.$age_group.'%' )->select('age_wise_progress_status', 'athlete_name', 'mrp' , 'event_id', 'age_wise_rank')->orderBy('mrp', 'DESC')->take(10)->get();

        $data["select_age_group"] = $age_group;
      }

      

      $data['type'] = 1;
      $data['kids'] = 1;

      $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type',1)->get();

      $data["select_age_group"] = $age_group;

    $event = Event::where('id',$event_title)->first();
      $data['year'] = $year;
      $data['event_id'] = $event_title;
      $data['event_date'] = $event->event_date;
       $data['event_year'] = $event->event_year;
      $view = view('front_end.ranking.overall' , $data);
      echo $view->render();  
    }

    public function eventRank_list_age_group_kid($event_title , $year, $age_group)
    {

      $data['age_title'] = $age_group;

      if ($age_group == 'all') {
        $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->orderBy('event_point', 'DESC')->take(10)->get();
        $data['variable_f'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->orderBy('event_point', 'DESC')->take(10)->get();
        $data["all"] = "all";
      }else{
        $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->where('age_category' , 'like', '%'.$age_group.'%' )->orderBy('event_point', 'DESC')->take(10)->get();

        $data['variable_f'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->where('age_category' , 'like', '%'.$age_group.'%' )->orderBy('event_point', 'DESC')->take(10)->get();

        $data["select_age_group"] = $age_group;
      }

      

      $data['type'] = 2;
      $data['kids'] = 1;

      $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type',1)->get();

      $data["select_age_group"] = $age_group;
    $event = Event::where('id',$event_title)->first();
    $data['year'] = $year;
    $data['event_id'] = $event_title;
    $data['event_date'] = $event->event_date;
    $data['event_year'] = $event->event_year;

      $view = view('front_end.ranking.overall' , $data);
      echo $view->render();  
    }

    public function event_list_age_group($event_title , $year , $age_group)
    {
      $data['age_title'] = $age_group;
      if ($age_group == 'all') {
        $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->orderBy('event_point', 'DESC')->take(10)->get();
        $data['variable_f'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->orderBy('event_point', 'DESC')->take(10)->get();

        $data["all"] = "all";
      }else{
        $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->where('age_category' , 'like', '%'.$age_group.'%' )->orderBy('event_point', 'DESC')->take(10)->get();
        $data['variable_f'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->where('age_category' , 'like', '%'.$age_group.'%' )->orderBy('event_point', 'DESC')->take(10)->get();

        $data["select_age_group"] = $age_group;
      }

      $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type',0)->get();

      $data['type'] = 2;
    $event = Event::where('id',$event_title)->first();
    $data['event_id'] = $event_title;
    $data['event_date'] = $event->event_date;
    $data['event_year'] = $event->event_year;
      $view = view('front_end.ranking.overall' , $data);
      echo $view->render();
    }

    public function event_list_age_group_kid($event_title , $year , $age_group)
    {
      $data['age_title'] = $age_group;
      if ($age_group == 'all') {
        $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->orderBy('event_point', 'DESC')->take(10)->get();
        $data['variable_f'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->orderBy('event_point', 'DESC')->take(10)->get();

        $data["all"] = "all";
      }else{
        $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->where('age_category' , 'like', '%'.$age_group.'%' )->orderBy('event_point', 'DESC')->take(10)->get();
        $data['variable_f'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->where('age_category' , 'like', '%'.$age_group.'%' )->orderBy('event_point', 'DESC')->take(10)->get();

        $data["select_age_group"] = $age_group;
      }

      $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type',1)->get();

      $data['type'] = 2;
      $data['kids'] = 1;

      $view = view('front_end.ranking.overall' , $data);
      echo $view->render();
    }

    public function all_list($type ,$rank ,  $id)
    {
      $data_M_overall = array();
      $data_F_overall = array();

      $year = Event::select('event_year')->where('id', $id)->first();

      if ($type == 1 && $rank == 1) {

         $data['variable'] = OverallRanking::groupBy('athlete_name')->where('age_category' , 'like', '%M%' )->where('event_id',$id)->where('age_type',0)->orderBy('mrp', 'DESC')->get();
         $data["male"] = 1;
      }

      if ($type == 2 &&  $rank == 1) {

         $data['variable'] = OverallRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F%' )->where('event_id',$id)->where('age_type',0)->orderBy('mrp', 'DESC')->get();
      }
      if ($type == 1  && $rank == 2) {

         $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$id)->where('age_category' , 'like', '%M%' )->orderBy('event_point', 'DESC')->get();
         $data["event"] ="yes";
         $data["male"] = 1;
      }if ($type == 2  && $rank == 2) {

         $data['variable'] = EventRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F%' )->where('event_id',$id)->orderBy('event_point', 'DESC')->get();
         $data["event"] ="yes";
      }
      $event = Event::where('id',$id)->first();
      $data['year'] = $year;
      $data['event_id'] = $id;
      $data['event_date'] = $event->event_date;
      $data['flag'] = 'overall';
      $data['event_name'] = Event::where('id' , $id)->select('event_name')->first();

      return view('front_end.ranking.full_list' ,$data , $this->common() );
    }

    public function all_list_age_group($type ,$rank , $Age_group , $id)
    {

      $data_M_overall = array();
      $data_F_overall = array();

      $year = Event::select('event_year')->where('id', $id)->first();

      if ($Age_group != "all") {

        $data['age_group_flag'] = 1;
        if ($type == 1 && $rank == 1) {

           $data['variable'] = OverallRanking::groupBy('athlete_name')->select('age_wise_rank', 'age_wise_progress_status' , 'mrp' ,'athlete_name')->where('age_category' , 'like', '%M '.$Age_group.'%' )->where('event_id',$id)->where('age_type',0)->orderBy('age_wise_rank', 'asc')->get();
           $data["male"] = 1;
        }

        if ($type == 2 &&  $rank == 1) {

           $data['variable'] = OverallRanking::groupBy('athlete_name')->select('age_wise_rank', 'age_wise_progress_status' , 'mrp' ,'athlete_name')->where('age_category' , 'like', '%F '.$Age_group.'%' )->where('event_id',$id)->where('age_type',0)->orderBy('age_wise_rank', 'asc')->get();
        }
        if ($type == 1  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$id)->where('age_category' , 'like', '%M '.$Age_group.'%' )->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
           $data["male"] = 1;
        }if ($type == 2  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F '.$Age_group.'%' )->where('event_id',$id)->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
        }
      }else{

        if ($type == 1 && $rank == 1) {

           $data['variable'] = OverallRanking::groupBy('athlete_name')->select('rank', 'progress_status' , 'mrp' ,'athlete_name')->where('age_category' , 'like', '%M%' )->where('event_id',$id)->where('age_type',0)->orderBy('rank', 'DESC')->get();
           $data["male"] = 1;
        }

        if ($type == 2 &&  $rank == 1) {

           $data['variable'] = OverallRanking::groupBy('athlete_name')->select('rank', 'progress_status' , 'mrp' ,'athlete_name')->where('age_category' , 'like', '%F%' )->where('event_id',$id)->where('age_type',0)->orderBy('rank', 'DESC')->get();
        }
        if ($type == 1  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$id)->where('age_category' , 'like', '%M%' )->where('age_type',0)->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
           $data["male"] = 1;
        }if ($type == 2  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F%' )->where('event_id',$id)->where('age_type',0)->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
        }

      }
        $data['year'] = $year;
        $data['event_id'] = $id;
        $event = Event::where('id',$id)->first();
        $data['event_date'] = $event->event_date;
        $data['flag'] = 'overall';
        $data['Age_group'] = $Age_group; 
        $data['event_name'] = Event::where('id' , $id)->select('event_name')->first();

      return view('front_end.ranking.full_list' ,$data , $this->common() );
    }

   public function kids($e_id="")
    {

      $abcd = DB::select('SHOW TABLES');

        $dbname = DB::connection()->getDatabaseName();
        $tb = 'Tables_in_'.$dbname;

       foreach ($abcd as $key => $value) {
        $strpos = strpos($value->$tb , "eventdata" );
        if ($strpos !== false ) {
          $year2[] = $value->$tb;
        }
       }


       foreach ($year2 as $key => $value) {
          $com_event = DB::table($value)->groupBy('event_id')->where('age_type' , 1)->select('event_id')->get();
          foreach ($com_event as $key => $value) {
            $comming_event[] = $value->event_id;
          }
       }

       // print_r($comming_event); die();

       
          $yr_data = array();
      
         foreach ($year2 as $key => $value) {
            $com_event = DB::table($value)->where('age_type' , 1 )->first();
            if($com_event != null){
            $yr_data[] = str_replace(array('eventdata_' , 's'), '', $value );
            }
          }
       
        $data['year'] = Event::select('event_year')->where('type', 0)->whereIn('event_year' , $yr_data)->orderBy('event_year','DESC')->distinct()->get();
        $selected_year =  Event::select('event_year','event_date')->where('id', $e_id )->first();
          
          $data['selected_year'] = $selected_year;

        if (count($data['year']) == 0 ) {
         $data['empty'] = 1;
        }else{
          if ($e_id !='') {
          $data["hidden_id"] = $e_id;


          }

        }

      return view('front_end.ranking.kids_ranking' , $data , $this->common());
    }

    public function events_list_kids($id)
    {
    $event_data = 'eventdata_'.$id.'s';
    $data["data"] = DB::table($event_data)->groupBy('event_id')->where('age_type' , 1)->orderBy('event_date','DESC')->get();
    
    $data["kids"] = "kids";

    $view = view('front_end.ranking.select' , $data);
    echo $view->render();
    }

    public function overall_list_kids($event_title , $year)
    {
    
      $data['variable'] = OverallRanking::groupBy('athlete_name')->where('age_type', 1)->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->orderBy('mrp', 'DESC')->take(10)->get();
      $data['variable_f'] = OverallRanking::groupBy('athlete_name')->where('age_type', 1)->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->orderBy('mrp', 'DESC')->take(10)->get();


      if (count($data['variable']) == 0 && $data['variable_f']) {
        echo " ";
      }else{

      $data['type'] = 1;

      $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type',1)->get();

      $data["all"] = "all";

      $data['kids'] =1;
      
    $data['event_id'] = $event_title;   



        
        $event = Event::where('id',$event_title)->first();
        $data['year'] = $year;
        $data['event_year'] =  $event->event_year;
        $data['event_id'] = $event_title;
        $data['event_date'] = $event->event_date;




      $view = view('front_end.ranking.overall' , $data);
      echo $view->render();
      }
    }

    public function ranking_list_kid($event_title , $year)
    {
      $data['event_id'] = $event_title;
      $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->orderBy('event_point', 'DESC')->take(10)->get();
      $data['variable_f'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->orderBy('event_point', 'DESC')->take(10)->get();

      if (count($data['variable']) == 0 && $data['variable_f']) {
        echo " ";
      }else{

      $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type',1)->get();

      $data['type'] = 2;
      $data['kids'] = 1;

      $data["all"] = "all";
       $event = Event::where('id',$event_title)->first();
        $data['year'] = $year;
        $data['event_year'] =  $event->event_year;
        $data['event_id'] = $event_title;
        $data['event_date'] = $event->event_date;
      $view = view('front_end.ranking.overall' , $data);
      echo $view->render();
      }
    }

    public function all_list_kid($type ,$rank ,  $id)
    {

      $data_M_overall = array();
      $data_F_overall = array();

      $year = Event::select('event_year')->where('id', $id)->first();
      $event_date = Event::select('event_date')->where('id', $id)->first();

        if ($type == 1 && $rank == 1) {

           $data['variable'] = OverallRanking::groupBy('athlete_name')->where('age_category' , 'like', '%M%' )->where('event_id',$id)->where('age_type',1)->select('rank', 'progress_status' , 'mrp' ,'athlete_name')->orderBy('mrp', 'DESC')->get();
           $data["male"] = 1;
        }

        if ($type == 2 &&  $rank == 1) {

           $data['variable'] = OverallRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F%' )->where('event_id',$id)->where('age_type',1)->select('rank', 'progress_status' , 'mrp' ,'athlete_name')->orderBy('mrp', 'DESC')->get();
        }
        if ($type == 1  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$id)->where('age_category' , 'like', '%M%' )->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
           $data["male"] = 1;
        }if ($type == 2  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F%' )->where('event_id',$id)->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
        }


        
    $data['flag'] = 'kid';
    $data['year'] = $year;
    $data['event_date'] = $event_date->event_date;
        $data['event_name'] = Event::where('id' , $id)->select('event_name')->first();

      return view('front_end.ranking.full_list' ,$data , $this->common() );
    }

    public function all_list_age_group_kid($type ,$rank , $Age_group , $id)
    {

      $data_M_overall = array();
      $data_F_overall = array();

      $year = Event::select('event_year')->where('id', $id)->first();

      if ($Age_group != "all") {
        if ($type == 1 && $rank == 1) {
      $data['age_group_flag'] =1;

           $data['variable'] = OverallRanking::groupBy('athlete_name')->where('age_category' , 'like', '%M '.$Age_group.'%' )->where('event_id',$id)->where('age_type',1)->select('age_wise_rank', 'age_wise_progress_status' , 'mrp' ,'athlete_name')->orderBy('mrp', 'DESC')->get();
           $data["male"] = 1;
        }

        if ($type == 2 &&  $rank == 1) {
      
      $data['age_group_flag'] =1;

           $data['variable'] = OverallRanking::groupBy('athlete_name')->select('age_wise_rank', 'age_wise_progress_status' , 'mrp' ,'athlete_name')->where('age_category' , 'like', '%F '.$Age_group.'%' )->where('event_id',$id)->where('age_type',1)->orderBy('mrp', 'DESC')->get();

           
        }
        if ($type == 1  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$id)->where('age_category' , 'like', '%M '.$Age_group.'%' )->orderBy('event_point', 'DESC')->get();

           $data["event"] ="yes";
           $data["male"] = 1;
        }if ($type == 2  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F '.$Age_group.'%' )->where('event_id',$id)->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
        }
      }else{

        if ($type == 1 && $rank == 1) {

           $data['variable'] = OverallRanking::groupBy('athlete_name')->where('age_category' , 'like', '%M%' )->where('event_id',$id)->where('age_type',1)->orderBy('mrp', 'DESC')->get();
           $data["male"] = 1;
        }

        if ($type == 2 &&  $rank == 1) {

           $data['variable'] = OverallRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F%' )->where('event_id',$id)->where('age_type',1)->orderBy('mrp', 'DESC')->get();
        }
        if ($type == 1  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$id)->where('age_category' , 'like', '%M%' )->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
           $data["male"] = 1;
        }if ($type == 2  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F%' )->where('event_id',$id)->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
        }
      }
    $data['flag'] = 'kid';
        $data['Age_group'] = $Age_group;
        $data['year'] = $year;
        $data['event_date'] = Event::where('id' , $id)->select('event_date')->first();
        $data['event_name'] = Event::where('id' , $id)->select('event_name')->first();
      return view('front_end.ranking.full_list' ,$data , $this->common() );
    }

    public function events_list_2_kid($id , $nxt_pri)
    {

      $data['nxt_pri'] = $nxt_pri;

      $event_data = 'eventdata_'.$id.'s';
      $data["data"] = DB::table($event_data)->groupBy('event_id')->where('age_type' , 1)->orderBy('event_date','DESC')->get();
      $data["kids"] = "kids";

      $view = view('front_end.ranking.select' , $data);
      echo $view->render();
    }

    public function nxt_btn_overall($event_id , $year)
    {
      $event_data = 'eventdata_'.$year.'s';

      $com_event = DB::table($event_data)->where('event_id', $event_id)->select('event_date', 'age_type')->first();

      $data['next_data'] = DB::table($event_data)->where('event_date', '>', $com_event->event_date)->where('age_type', $com_event->age_type )->orderBy('event_date', 'asc')->select('event_name', 'event_id')->first();

      $data['age_type'] = $com_event->age_type;

      $view = view('front_end.ranking.next_btn' , $data);
      echo $view->render();
    }

    public function pre_btn_overall($event_id , $year, $type)
    {
      $event_data = 'eventdata_'.$year.'s';

      $com_event = DB::table($event_data)->where('event_id', $event_id)->select('event_date')->first();

      $data['next_data'] = DB::table($event_data)->where('event_date', '<', $com_event->event_date)->where('age_type', $type)->orderBy('event_date', 'DESC')->select('event_name', 'event_id')->first();

      $data['age_type'] = $type;

      $view = view('front_end.ranking.next_btn' , $data);
      echo $view->render();
    }

    public function ranking_list_youth($event_title , $year)
    {
      $data['event_id'] = $event_title;

      $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->orderBy('event_point', 'DESC')->take(10)->get();
      $data['variable_f'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->orderBy('event_point', 'DESC')->take(10)->get();

      if (count($data['variable']) == 0 && $data['variable_f']) {
        echo " ";
      }else{

      $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type', 2)->get();

      $data['type'] = 2;

      $data["all"] = "all";
    $event = Event::where('id',$event_title)->first();
    $data['year'] = $year;
    $data['event_year'] =  $event->event_year;
    $data['event_id'] = $event_title;
    $data['event_date'] = $event->event_date;
      $view = view('front_end.ranking.overall' , $data);
      echo $view->render();
      }
    }

    public function ranking_overall_age_group_young($event_title , $year, $age_group)
    {
      $data['age_title'] = $age_group;
      if ($age_group == 'all') {
        
        $data['variable'] = OverallRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->orderBy('mrp', 'DESC')->select('progress_status', 'athlete_name', 'mrp' , 'event_id', 'rank')->take(10)->get();
        $data['variable_f'] = OverallRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->orderBy('mrp', 'DESC')->select('progress_status', 'athlete_name', 'mrp' , 'event_id', 'rank')->take(10)->get();
        $data["all"] = "all";
      }else{
        $data['variable'] = OverallRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%'.'M '.$age_group.'%' )->select('age_wise_progress_status', 'athlete_name', 'mrp' , 'event_id', 'age_wise_rank')->orderBy('mrp', 'DESC')->take(10)->get();

        $data['variable_f'] = OverallRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->where('age_category' , 'like', '%'.$age_group.'%' )->select('age_wise_progress_status', 'athlete_name', 'mrp' , 'event_id', 'age_wise_rank')->orderBy('mrp', 'DESC')->take(10)->get();
        $data["age_group_flag"] = $age_group;
      }
      $data['type'] = 1;

      $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type',2)->get();

      $data["select_age_group"] = $age_group;

      $event = Event::where('id',$event_title)->first();
      $data['year'] = $year;
      $data['event_id'] = $event_title;
      $data['event_date'] = $event->event_date;

      $view = view('front_end.ranking.overall_youth' , $data);
      echo $view->render(); 
    }

    public function ranking_event_age_group_youth($event_title , $year , $age_group)
    {
      $data['age_title'] = $age_group;
      if ($age_group == 'all') {
        $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->orderBy('event_point', 'DESC')->take(10)->get();
        $data['variable_f'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->orderBy('event_point', 'DESC')->take(10)->get();

        $data["all"] = "all";
      }else{
        $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%M%' )->where('age_category' , 'like', '%'.$age_group.'%' )->orderBy('event_point', 'DESC')->take(10)->get();
        $data['variable_f'] = EventRanking::groupBy('athlete_name')->where('event_id',$event_title)->where('age_category' , 'like', '%F%' )->where('age_category' , 'like', '%'.$age_group.'%' )->orderBy('event_point', 'DESC')->take(10)->get();

        $data["select_age_group"] = $age_group;
      }

      $data['age_group'] = Age_group::where('from_year', '<=', $year)->where('to_year' , '>=' , $year)->orderBy("end_age" , "ASC")->where('type',2)->get();

      $data['type'] = 2;
    $event = Event::where('id',$event_title)->first();
      $data['year'] = $year;
      $data['event_id'] = $event_title;
      $data['event_date'] = $event->event_date;
      $data['event_year'] = $event->event_year;
      $view = view('front_end.ranking.overall' , $data);
      echo $view->render();
    }

    public function all_list_youth($type ,$rank ,  $id)
    {
      $data_M_overall = array();
      $data_F_overall = array();

      $year = Event::select('event_year')->where('id', $id)->first();

      if ($type == 1 && $rank == 1) {

         $data['variable'] = OverallRanking::groupBy('athlete_name')->where('age_category' , 'like', '%M%' )->where('event_id',$id)->where('age_type', 2 )->orderBy('mrp', 'DESC')->get();
         $data["male"] = 1;
      }

      if ($type == 2 &&  $rank == 1) {

         $data['variable'] = OverallRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F%' )->where('event_id',$id)->where('age_type', 2 )->orderBy('mrp', 'DESC')->get();
      }
      if ($type == 1  && $rank == 2) {

         $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$id)->where('age_category' , 'like', '%M%' )->orderBy('event_point', 'DESC')->get();
         $data["event"] ="yes";
         $data["male"] = 1;
      }if ($type == 2  && $rank == 2) {

         $data['variable'] = EventRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F%' )->where('event_id',$id)->orderBy('event_point', 'DESC')->get();
         $data["event"] ="yes";
      }
      $event = Event::where('id',$id)->first();
      $data['year'] = $year;
      $data['event_id'] = $id;
      $data['event_date'] = $event->event_date;
      $data['flag'] = 'overall';
      $data['event_name'] = Event::where('id' , $id)->select('event_name')->first();

      

      return view('front_end.ranking.full_list_youth' ,$data , $this->common() );
    }

    public function all_list_age_group_youth($type ,$rank , $Age_group , $id)
    {

      $data_M_overall = array();
      $data_F_overall = array();

      $year = Event::select('event_year')->where('id', $id)->first();

      if ($Age_group != "all") {

        $data['age_group_flag'] = 1;
        if ($type == 1 && $rank == 1) {

           $data['variable'] = OverallRanking::groupBy('athlete_name')->select('age_wise_rank', 'age_wise_progress_status' , 'mrp' ,'athlete_name')->where('age_category' , 'like', '%M '.$Age_group.'%' )->where('event_id',$id)->where('age_type',2)->orderBy('age_wise_rank', 'asc')->get();
           $data["male"] = 1;
        }

        if ($type == 2 &&  $rank == 1) {

           $data['variable'] = OverallRanking::groupBy('athlete_name')->select('age_wise_rank', 'age_wise_progress_status' , 'mrp' ,'athlete_name')->where('age_category' , 'like', '%F '.$Age_group.'%' )->where('event_id',$id)->where('age_type',2)->orderBy('age_wise_rank', 'asc')->get();
        }
        if ($type == 1  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$id)->where('age_category' , 'like', '%M '.$Age_group.'%' )->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
           $data["male"] = 1;
        }if ($type == 2  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F '.$Age_group.'%' )->where('event_id',$id)->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
        }
      }else{

        if ($type == 1 && $rank == 1) {

           $data['variable'] = OverallRanking::groupBy('athlete_name')->select('rank', 'progress_status' , 'mrp' ,'athlete_name')->where('age_category' , 'like', '%M%' )->where('event_id',$id)->where('age_type',2)->orderBy('rank', 'DESC')->get();
           $data["male"] = 1;
        }

        if ($type == 2 &&  $rank == 1) {

           $data['variable'] = OverallRanking::groupBy('athlete_name')->select('rank', 'progress_status' , 'mrp' ,'athlete_name')->where('age_category' , 'like', '%F%' )->where('event_id',$id)->where('age_type',2)->orderBy('rank', 'DESC')->get();
        }
        if ($type == 1  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('event_id',$id)->where('age_category' , 'like', '%M%' )->where('age_type',2)->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
           $data["male"] = 1;
        }if ($type == 2  && $rank == 2) {

           $data['variable'] = EventRanking::groupBy('athlete_name')->where('age_category' , 'like', '%F%' )->where('event_id',$id)->where('age_type',2)->orderBy('event_point', 'DESC')->get();
           $data["event"] ="yes";
        }

      }

        $data['year'] = $year;
        $data['event_id'] = $id;
        $event = Event::where('id',$id)->first();
        $data['event_date'] = $event->event_date;
        $data['flag'] = 'overall';
        $data['Age_group'] = $Age_group; 
        $data['event_name'] = Event::where('id' , $id)->select('event_name')->first();

      return view('front_end.ranking.full_list_youth' ,$data , $this->common() );
    }

}
