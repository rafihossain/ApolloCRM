<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Athlete;
use App\Tempathlete;
use App\Media_setting;
use App\Partner;
use App\eventdata_2025;
use App\Age_group;
use App\Event;
use App\Follow;
use App\Setting;
use App\OverallRanking;
use App\BadgeUpload;
use Redirect;
use Session;
use DB;

class TeamController extends Controller
{

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

       $data['badge'] = BadgeUpload::first();

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
        

      $data['comming_event'] = Event::where('event_year' ,$data['current_year'])->where('event_show',1)->where('type',0)->select('event_name','id', 'event_date' , 'event_logo' , 'slider_event_logo')->orderBy('event_date', 'ASC')->get();
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


        $data['teams'] = Team::orderBy('order_field')->get();
        $data['partner'] = Partner::where('status',1)->get();
        $data['follow'] = Follow::where('status',1)->get();
        return $data;
    }
    
    public function index()
    {
      $data["data"] = Team::all();
      $data["captain"] = Athlete::select(['id','athlete_name'])->get();
      return view('admin.team.index', $data);
    }

    public function store(Request $request)
    {
      $data = array();
       $ck = DB::table('athletes')->where('id', $request->captain)->first();
      $validateData = $request->validate([
            'name'=>'required',
            'mission'=>'required',
            'team_members'=>'required',
            'goal'=>'required',
            'description'=>'required',
            'link'=>'required',
            'banner_img'=>'required|dimensions:width=1350,height=462',
            'logo'=>'required',
            'leader_email' => 'unique:teams,leader_email',
            'leader_image' => 'dimensions:width=240,height=270',
        ]); 

        if (empty($request->Team_captain_text)) {
          $data['captain_name'] = $ck->athlete_name;
          $data['captain'] = $request->captain;
          $data['Team_captain_text'] = $request->Team_captain_text;
        }else{
          $data['captain_name'] = $request->Team_captain_text;
          $data['captain'] = $request->Team_captain_text;
          $data['Team_captain_text'] = $request->Team_captain_text;
        }

        $data['name'] = $request->name;
        $data['mission'] = $request->mission;
        $data['goal'] = $request->goal;
        $data['description'] = $request->description;
        $data['link'] = $request->link;
        $data['facebook_link'] = $request->facebook_link;
        $data['instragram_link'] = $request->instragram_link;
        $data['youtube_link'] = $request->youtube_link;
        $data['fb_status']         = empty($request->fb_status)?0:1;
        $data['instragram_status'] = empty($request->instragram_status)?0:1;
        $data['youtube_status']    = empty($request->youtube_status)?0:1;
        $data['team_members'] = json_encode($request->team_members);
        $data['visibility'] = $request->visibility;

        $data['leader_email'] = $request->leader_email;
        $data['leader_password'] = $request->leader_password;
        $data['leader_phone'] = $request->leader_phone;
        $data['leader_information_status'] = $request->leader_information_status;
        $data['leader_email_status'] = $request->leader_email_status;
        $data['leader_phone_status'] = $request->leader_phone_status;

        if ($request->leader_email != '' && $request->leader_password != '')
        {
            $leader_email = $request->leader_email;
            $leader_password = $request->leader_password;
            $hash_password =  $leader_password;
//            $hash_password =  Hash::make($leader_password);
            $data['leader_email'] = $leader_email;
            $data['password'] = $hash_password;
            $from_email = 'info@patrishisports.com';
            $subject = 'patrishi sports team leader';
            $name = $data['captain_name'];
            $leader_message = 'This is your Team account.you can login and modify team information';
            $d = array('name'=>$data['captain_name'],'email'=>$request->leader_email,'password'=>$request->leader_password,'subject'=>$subject,'mess'=>$leader_message);
            \Mail::send('email.team_leader',$d,function($message) use ($from_email, $subject, $name,$leader_email){
            $message->to($leader_email,$name)
                    ->subject($subject);
                $message->from($from_email);
            });
        }

        if ($image=$request->file('leader_image')) {
 
           $uploadPath = 'athlete_image';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);
      
            $data['leader_image']= $dbUrl;
         
        }

        if ($image=$request->file('banner_img')) {
 
           $uploadPath = 'assets/img/';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);
      
            $data['banner_img']= $file_name;
         
        }

        if ($images=$request->file('logo')) {
 
           $uploadPaths = 'assets/img/';
           
           $file_names = time()."-".$images->getClientOriginalName();
           $dbUrls = $uploadPaths."/".$file_names;
       
           $images->move($uploadPaths,$dbUrls);
      
            $data['logo']= $file_names;
         
        }
        $count_team =  Team::all()->count();
        $data['order_field'] = $count_team + 1;

        Team::insert($data);

        $sum_overall = 0;
        $sum_category = 0;

        $last2 = Team::orderBy('id', 'DESC')->first();

          $team_members_show = json_decode($last2['team_members']);

          $key = in_array($last2['captain'], $team_members_show);

          if ($key == FALSE) {
            $team_members_show[] = $last2['captain'];
          }


          $users['total_member'] = count($team_members_show);

          $team_members_name = Athlete::select('athlete_name')
                               ->whereIn('id', $team_members_show)
                               ->get();

          $orange_jersey = 0;
          $blue_jersey =0;
          $red_jersey =0;
          $white_jersey =0;

          $abcd = DB::select('SHOW TABLES');

            $dbname = DB::connection()->getDatabaseName();
            $tb = 'Tables_in_'.$dbname;

           foreach ($abcd as $key => $value) {
            $strpos = strpos($value->$tb , "eventdata" );
            if ($strpos !== false ) {
              $year2[] = $value->$tb;
            }
           }

          foreach ($team_members_name as $key => $value235ff) {
               $orange_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('rank',1)->where('age_type',0)->sum('rank');
    if (date('Y') >= 2020) {
          $blue_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_category', 'like', '%16-19%')->where('rank',1)->where('age_type',0)->sum('rank');
                  }else{
                    $blue_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_category', 'like', '%U-20%')->where('rank',1)->where('age_type',0)->sum('rank');
                  }
                    $red_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_wise_rank',1)->where('age_type',0)->where('age_category', 'like', '%50-54%')->sum('age_wise_rank');
                    $red_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_wise_rank',1)->where('age_type',0)->where('age_category', 'like', '%55-59%')->sum('age_wise_rank');
                    $red_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_wise_rank',1)->where('age_type',0)->where('age_category', 'like', '%60+%')->sum('age_wise_rank');

                    $white_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('rank',1)->where('age_type',1)->sum('rank');
    
  }

          /*foreach ($year2 as $key => $value) {
           foreach ($team_members_name as $key => $value235ff) {
            $orange_jersey += DB::table($value)->where('overall_rank', 1)->where('athlete', $value235ff->athlete_name)->sum('overall_rank');

            if (date('Y') >= 2020) {
                  $blue_jersey += DB::table($value)->where('overall_rank', 1)->where('age_category', 'like', '%16-19%')->where('athlete', $value235ff->athlete_name)->sum('overall_rank');
                }else{
                  $blue_jersey += DB::table($value)->where('overall_rank', 1)->where('age_category', 'like', '%U-20%')->where('athlete', $value235ff->athlete_name)->sum('overall_rank');
                }

            $white_jersey += DB::table('athletes')
                ->join($value, 'athletes.athlete_name', '=', ''.$value.'.athlete')
                ->where('athletes.athlete_name', '=', $value235ff->athlete_name)
                ->where(''.$value.'.age_type', 1)
                ->where(''.$value.'.overall_rank', 1)
                ->sum('overall_rank');

          }
         }*/

         $users['orange_jersey'] = $orange_jersey;
         $users['blue_jersey'] = $blue_jersey;
         $users['red_jersey'] = $red_jersey;
         $users['white_jersey'] = $white_jersey;

          $team_members = Athlete::all();

          foreach ($team_members as $key => $val) {
              foreach ($team_members_show as $key => $value) {
                  if ($value == $val['id']) {
                      $overall_wins =   Athlete::where('id',$value)->sum('overall_wins');
                      $sum_overall  += $overall_wins;
                      $category_wins =  Athlete::where('id',$value)->sum('category_wins');
                      $sum_category  += $category_wins;
                  }
             }
          }

          $users['overall_wins'] = $sum_overall; 
          $users['cat_wins'] = $sum_category; 

          DB::table('teams')
              ->where('id', $last2->id)
              ->update($users);

          return Redirect::back()->with('msg', 'Successfully Added');        
    }
    public function edit($id)
    {
      $data['data'] = Team::where('id', $id)->first();
      $data['teams'] = Team::select('logo', 'order_field','id')->get();

      $data["members"] = json_decode($data['data']['team_members']);
      $data["selected_captain"] = $data['data']['captain'];
      $data["captain"] = Athlete::all();

      $view = view('admin.team.edit_team' , $data);
      echo $view->render();
    }

   public function update(Request $request)
    {
        ini_set('memory_limit', '512M');
        $data = array();
        $ck = DB::table('athletes')->where('id', $request->captain)->first();
        $data = Team::where('id',$request->id)->first();
      
      $validateData = $request->validate([
            'name'=>'required',
            'mission'=>'required',
            'team_members'=>'required',
            'goal'=>'required',
            'description'=>'required',
            'link'=>'required',
            'banner_img'=>'dimensions:width=1350,height=462',
            'leader_image' => 'dimensions:width=240,height=270',
        ]);

        if (empty($request->Team_captain_text)) {
          $data['captain_name'] = $ck->athlete_name;
          $data['captain'] = $request->captain;
      $data['Team_captain_text'] = $request->Team_captain_text; 
        }else{
          $data['captain_name'] = $request->Team_captain_text;
          $data['captain'] = $request->Team_captain_text;
          $data['Team_captain_text'] = $request->Team_captain_text;
        }

        $data['name'] = $request->name;
        $data['mission'] = $request->mission;
        $data['goal'] = $request->goal;
        $data['description'] = $request->description;
        $data['link'] = $request->link;
        $data['facebook_link'] = $request->facebook_link;
        $data['instragram_link'] = $request->instragram_link;
        $data['youtube_link'] = $request->youtube_link;
        $data['visibility'] = $request->visibility;
        $data['leader_phone'] = $request->leader_phone;
        $data['leader_email'] = $request->leader_email;

        $data['leader_email_status'] = $request->leader_email_status;
        $data['leader_phone_status'] = $request->leader_phone_status;
        

        $data['fb_status']         = empty($request->fb_status)?0:1;
        $data['instragram_status'] = empty($request->instragram_status)?0:1;
        $data['youtube_status']    = empty($request->youtube_status)?0:1;

        $data['team_members'] = json_encode($request->team_members);


        if ($request->leader_password != '')
        {
            $data['leader_password'] = $request->leader_password;
        }
        
        if ($request->leader_information_status != '')
        {
            $data['leader_information_status'] = $request->leader_information_status;
        }

        if ($image=$request->file('leader_image')) {

 
           $uploadPath = 'athlete_image';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);
      
            $data['leader_image']= $dbUrl;
        }

        if ($image=$request->file('banner_img')) {
 
           $uploadPath = 'assets/img/';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);
      
            $data['banner_img']= $file_name;

            
         
        }

        if ($images=$request->file('logo')) {
 
           $uploadPaths = 'assets/img/';
           
           $file_names = time()."-".$images->getClientOriginalName();
           $dbUrls = $uploadPaths."/".$file_names;
       
           $images->move($uploadPaths,$dbUrls);
      
            $data['logo']= $file_names;         
        }

        if($data->update()){

          $data['oder_array'] = $request->oder_array;
          $data['oder_array_id'] = $request->oder_array_id;
          


          foreach ($data['oder_array_id'] as $key => $value) {
            DB::table('teams')
              ->where('id', $value)
              ->update(['order_field' => $data['oder_array'][$key]]);
          }

            $sum_overall = 0;
            $sum_category = 0;

            $last2 = Team::where('id', $request->id)->first();

            $team_members_show = json_decode($last2['team_members']);

            $key = in_array($last2['captain'], $team_members_show);

            if ($key == FALSE) {
              $team_members_show[] = $last2['captain'];
            }


            $users['total_member'] = count($team_members_show);

            $team_members_name = Athlete::select('athlete_name')
                                 ->whereIn('id', $team_members_show)
                                 ->get();

            $orange_jersey = 0;
            $blue_jersey =0;
            $red_jersey =0;
            $white_jersey =0;

            $abcd = DB::select('SHOW TABLES');

            $dbname = DB::connection()->getDatabaseName();
            $tb = 'Tables_in_'.$dbname;

           foreach ($abcd as $key => $value) {
            $strpos = strpos($value->$tb , "eventdata" );
            if ($strpos !== false ) {
              $year2[] = $value->$tb;
            }
           }

          foreach ($team_members_name as $key => $value235ff) {
               $orange_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('rank',1)->where('age_type',0)->sum('rank');
    if (date('Y') >= 2020) {
          $blue_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_category', 'like', '%16-19%')->where('rank',1)->where('age_type',0)->sum('rank');
                  }else{
                    $blue_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_category', 'like', '%U-20%')->where('rank',1)->where('age_type',0)->sum('rank');
                  }
                    $red_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_wise_rank',1)->where('age_type',0)->where('age_category', 'like', '%50-54%')->sum('age_wise_rank');
                           $red_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_wise_rank',1)->where('age_type',0)->where('age_category', 'like', '%55-59%')->sum('age_wise_rank');
                           $red_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_wise_rank',1)->where('age_type',0)->where('age_category', 'like', '%60+%')->sum('age_wise_rank');

                    $white_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('rank',1)->where('age_type',1)->sum('rank');
    
  }
      
            /*foreach ($year2 as $key => $value) {
             foreach ($team_members_name as $key => $value235ff) {
              $orange_jersey += DB::table($value)->where('overall_rank', 1)->where('athlete', $value235ff->athlete_name)->sum('overall_rank');

              if (date('Y') >= 2020) {
                  $blue_jersey += DB::table($value)->where('overall_rank', 1)->orWhere('age_category', 'like', '%16-19%')->where('age_category', 'like', '%U-20%')->where('athlete', $value235ff->athlete_name)->sum('overall_rank');
                }else{
                  $blue_jersey += DB::table($value)->where('overall_rank', 1)->where('age_category', 'like', '%U-20%')->where('athlete', $value235ff->athlete_name)->sum('overall_rank');
                }

              

              $white_jersey += DB::table('athletes')
                ->join($value, 'athletes.athlete_name', '=', ''.$value.'.athlete')
                ->where('athletes.athlete_name', '=', $value235ff->athlete_name)
                ->where(''.$value.'.age_type', 1)
                ->where(''.$value.'.overall_rank', 1)
                ->sum('overall_rank');

            }
           }*/

           $users['orange_jersey'] = $orange_jersey;
           $users['blue_jersey'] = $blue_jersey;
            $users['red_jersey'] = $red_jersey;
           $users['white_jersey'] = $white_jersey;

            $team_members = Athlete::all();

            foreach ($team_members as $key => $val) {
                foreach ($team_members_show as $key => $value) {
                    if ($value == $val['id']) {
                        $overall_wins =   Athlete::where('id',$value)->sum('overall_wins');
                        $sum_overall  += $overall_wins;
                        $category_wins =  Athlete::where('id',$value)->sum('category_wins');
                        $sum_category  += $category_wins;
                    }
               }
            }

            $users['overall_wins'] = $sum_overall; 
            $users['cat_wins'] = $sum_category; 

            DB::table('teams')
              ->where('id', $last2->id)
              ->update($users);

            return Redirect::back()->with('msg', 'Successfully Updated');
        }
    }


    public function team_member($id)
    {

      $data = Team::where('id', $id)->select('team_members')->first();

      $data_2 = Team::where('id', $id)->select('captain_name')->first();

      $a = json_decode($data['team_members']);

        $output ='';
        $output .=' <h5 style="color:green;"> Team Captain : '.$data_2["captain_name"].' </h5>';
        $output .=' <p> Team Members In Orders: </p><br>';

        print_r($output);

        foreach ($a as $key => $value) {
            $mem[] = Athlete::where('id', $value)->select('athlete_name', 'id' , 'image')->first();
        }

        $temp['members'] = $mem;
        $temp['team_id'] = $id;

        $view = view('admin.team.order_member' , $temp);
        echo $view->render();
    }

    public function delete(Request $request)
    {
      $id = Team::where('id',$request->id)->first();
        if($id->delete()){
            echo json_decode(1);
        }
    }

    public function test($slug)
    {

       $kids = 0;
       $overall =0; 
       $year = array();
       $year2 = array();
       $year10 = array(); 
       $type = array();

       $a =  str_replace("____","/",$slug);
       $a =  str_replace("_"," ",$a);

       $a =  str_replace("____","/",$a);
       $data["data"] = Athlete::where('athlete_name', '=', $a)->first();

       $abcd = DB::select('SHOW TABLES');

       $dbname = DB::connection()->getDatabaseName();
        $tb = 'Tables_in_'.$dbname;

       foreach ($abcd as $key => $value) {
        $strpos = strpos($value->$tb , "eventdata" );
        if ($strpos !== false ) {
          $year2[] = $value->$tb;
        }
       }

       rsort($year2);
    
       $year3 = array();
       foreach ($year2 as $key => $value1141) {
       
         $ck_yr = DB::table($value1141)->where('athlete', $a)->where('age_type', 0)->first();
         $ck_yr_2 = DB::table($value1141)->where('athlete', $a)->where('age_type', 1)->first();
         $ck_yr_youth = DB::table($value1141)->where('athlete', $a)->where('age_type', 2)->first();

           if($ck_yr !=null){

            $type[] = $ck_yr->age_type;
             if($ck_yr->age_type == 1){
              $data['has_kid'] = 1;
              $kid = 1;
              $year3[] = $value1141;
             }else{

              $athlete = 1;
              $data['has_kid'] = 0;
              $year10[] = $value1141;
             }
           }

           if($ck_yr_2 !=null){

            $type[] = $ck_yr_2->age_type;
             if($ck_yr_2->age_type == 1){
              $data['has_kid'] = 1;
              $kid = 1;
              $year3[] = $value1141;
             }else{

              $athlete = 1;
              $data['has_kid'] = 0;
              $year10[] = $value1141;
             }
           }

           if($ck_yr_youth !=null){

            $type[] = $ck_yr_youth->age_type;
             if($ck_yr_youth->age_type == 2){
              $data['has_youth'] = 2;
              $has_youth = 1;
              $year_youth[] = $value1141;
             }
           }
       }


       if (isset($has_youth)) {
         $data['yr_val_youth'] = $year_youth;
       }else{

         if (isset($kid) && isset($athlete) ) {
           $data['yr_val_kid'] = $year3;
         }
         if ( !isset($athlete)  ) {
           $data['yr_val_kid'] = $year3;
         }
         if ( !isset($kid)   ) {
           $data['yr_val_athlete'] = $year10;
         }
       }

       return view('front_end.team.team_member', $data , $this->common() );
    }
    public function old_details($yr,$type,$player)
    {
        $pledgeCampaignBadg = array();

        $BadgeConsistency2019 = 0;
        $BadgeSuperConsistent = 0;
        $BadgeConsistency2020 = 0;

        $badge_10k = 0;
        $badge_21k = 0;
        $badge_42k = 0;
        $ultra_merathon = 0;

        $Urataka = 0;
        $Betico = 0;
        $Half = 0;
        $Ronde = 0;
        $Turibana = 0;
        $Brandweer = 0;
        $ClassicQuest = 0;

        $UratakaQuest = 0;
        $ArubaBank1Quest = 0;
        $ArubaBank2Quest = 0;
        $ArubaBank3Quest = 0;
        $ArubaBank4Quest = 0;
        $RunBack2SchoolQuest = 0;
        $SportCaribeQuest = 0;
        $InfiniteQuest = 0;
        $Chasing5KQuest = 0;
        $age_typ = $type;
        str_replace(array('eventdata_' , 's'), '', $yr);
        $sum_overall = 0;
        $top3_finishes = 0;
        $top10_finishes = 0;
        $category_wins = 0;
        $data['blue_light'] = $type;
        $total_races = DB::table($yr)->where('age_type', $type)->groupBy('event_id')->select('event_id')->get()->count();
        $users['variable'] = DB::table('athletes')
            ->select(DB::raw($yr.'.event_date as ev_date,old_events.event_name as event_name, athletes.id as athlete_id ,  athletes.category_wins as athlete_category_wins , athletes.current_overall_rank as athlete_current_overall_rank , athletes.current_category_rank_status as athlete_current_category_rank_status , athletes.overall_wins as athlete_overall_wins ,  athletes.top3_finishes as athlete_top3_finishes , athletes.top10_finishes as athlete_top10_finishes , athletes.current_category_rank as athlete_current_category_rank , athletes.mrp as athlete_mrp ,  athletes.arp as athlete_arp ,  athletes.current_overall_rank_status as athlete_current_overall_rank_status ,  old_events.id as event_id, athletes.image as image, '.$yr.'.overall_rank as overall_rank, '.$yr.'.bib as bib, '.$yr.'.category_rank as category_rank,'.$yr.'.age_category as age_category, '.$yr.'.distance as distance,'.$yr.'.speed as speed,'.$yr.'.time as time,'.$yr.'.points as points'))
//            ->select(DB::raw($yr.'.event_date as ev_date,old_events.event_name as event_name, old_events.id as event_id, athletes.image as image, '.$yr.'.overall_rank as overall_rank,'.$yr.'.category_rank as category_rank,'.$yr.'.age_category as age_category, '.$yr.'.bib as bib, '.$yr.'.distance as distance,'.$yr.'.speed as speed,'.$yr.'.time as time,'.$yr.'.points as points'))
            ->join($yr, 'athletes.athlete_name', '=', ''.$yr.'.athlete')
            ->join('old_events', ''.$yr.'.event_id', '=', 'old_events.id')
            ->where('athletes.athlete_name', '=', $player)
            ->where(''.$yr.'.age_type', '=', $type)
            ->orderBy('old_events.event_date', 'DESC')
            ->get();
        $team_under = Team::select('team_members', 'name' , 'logo')->get();
        foreach ($team_under as $key => $value) {
            $under_team = json_decode($value['team_members']);
            foreach ($under_team as $key => $val) {
                if ($val == $users['variable'][0]->athlete_id) {
                    $data['under_team'] = $value['name'];
                    $data['under_team_logo'] = $value['logo'];
                    break;
                }
            }
        }
        $a = count($users['variable']) - 1;
        $data['age_category'] = $users['variable'][0]->age_category;
        foreach ($users['variable'] as $key => $value) {
            if ($value->overall_rank == 1 && $value->overall_rank != 0) {
                $sum_overall ++;
            }
            if ($value->overall_rank <= 3 && $value->overall_rank !=0 ) {
                $top3_finishes ++;
            }
            if ($value->overall_rank <= 10 && $value->overall_rank !=0 ) {
                $top10_finishes ++;
            }
            if ($value->category_rank == 1 && $value->category_rank !=0) {
                $category_wins ++;
            }

        }

        $data['overall_wins'] = $sum_overall;
        $data['top3_finishes'] = $top3_finishes;
        $data['top10_finishes'] = $top10_finishes;
        $data['category_wins'] = $category_wins;
        if (count($users['variable']) == 0 && $type == 1) {
            $users['kids_none'] = 1;
        }

        if (count($users['variable']) == 0 && $type == 0) {
            $users['overall_none'] = 1;
        }

        $data['total_races'] = count($users['variable']);

        if ($type == 1) {
            $users["type"] = 1;
        }else{
            $users["type"] = 0;
        }
        $kids = 0;
        $overall =0;
        $year = array();
        $year2 = array();
        $type = array();
        $a =  str_replace("_"," ",$player);
        $data_2["data"] = Athlete::where('athlete_name', '=', $a)->first();
        $abcd = DB::select('SHOW TABLES');

        $dbname = DB::connection()->getDatabaseName();
        $tb = 'Tables_in_'.$dbname;

        foreach ($abcd as $key => $value) {
            $strpos = strpos($value->$tb , "eventdata" );
            if ($strpos !== false ) {
                $year2[] = $value->$tb;
            }
        }
        $year3 = array();

        foreach ($year2 as $key => $value1141) {

            $ck_yr = DB::table($value1141)->where('athlete', $a)->where('age_type', 0)->first();
            $ck_yr_2 = DB::table($value1141)->where('athlete', $a)->where('age_type', 1)->first();

            if($ck_yr !=null){
                $athlete = 1;
                $data['has_kid'] = 0;
                $year10[] = $value1141;
            }

            if($ck_yr_2 !=null){

                $type[] = $ck_yr_2->age_type;
                if($ck_yr_2->age_type == 1){
                    $data['has_kid'] = 1;
                    $kid = 1;
                    $year3[] = $value1141;
                }
            }
        }
        if (isset($kid) && isset($athlete) ) {
            $data['yr_name'] = $year3;
            $data['yr_val_both'] = $year3;

        }
        if ( !isset($athlete)  ) {
            $data['yr_name'] = $year3;
            $data['yr_val_kid'] = $year3;
        }
        if ( !isset($kid) ) {

            $data['yr_name'] = $year10;
            $data['yr_val_athlete'] = $year10;
        }

        if($age_typ == 1){
            $data['yr_name'] = $year3;
        }else{
            $data['yr_name'] = $year10;
        }

        $data['yr_name'] = array_unique($data['yr_name']);


        $year_123 = array();

        foreach ($data['yr_name'] as $key => $value) {
            $year_123[] = str_replace(array('eventdata_', 's'), '', $value);
        }
        rsort($data['yr_name']);
        rsort($year_123);
        $data['yr_show'] = $year_123;
        $data['yr_val'] = $year3;
        $data['selected_yaer'] = $yr;


        $data['name'] = $player;
        if(str_replace(array('eventdata_' , 's'), '', $yr)>=2020){
            $principle = 1/2;
        }
        else{
            $principle = 2/3;
        }
        $pieces = explode("_", $yr);
        $pieces = explode("s", $pieces[1]);
        $international_event = DB::table('international_athletes')->where('athlete', $player)->select('id')->first();
        $users['year'] = $pieces[0];
        $users['international_event_status'] = $international_event;
        $view = view('front_end.team.show_old_data' , $users , $data );
        echo $view->render();
    }
    public function detail($yr,$type,$player)
    {
  
    
      $player =  str_replace("____","/",$player);
        $old_year = str_replace(array('eventdata_' , 's'), '', $yr);
        if ($old_year < 2018)
        {
            $this->old_details($yr,$type,$player);
            die;
        }
        $pledgeCampaignBadg = array();

        $BadgeConsistency2019 = 0;
        $BadgeSuperConsistent = 0;
        $BadgeConsistency2020 = 0;

        $badge_10k = 0;
        $badge_21k = 0;
        $badge_42k = 0;
        $ultra_merathon = 0;

        $Urataka = 0;
        $Betico = 0;
        $Half = 0;
        $Ronde = 0;
        $Turibana = 0;
        $Brandweer = 0;
        $ClassicQuest = 0;

        $UratakaQuest = 0;
        $ArubaBank1Quest = 0;
        $ArubaBank2Quest = 0;
        $ArubaBank3Quest = 0;
        $ArubaBank4Quest = 0;
        $RunBack2SchoolQuest = 0;
        $SportCaribeQuest = 0;
        $InfiniteQuest = 0;
        $Chasing5KQuest = 0;

        $total_races = DB::table($yr)->where('age_type', $type)->groupBy('event_id')->select('event_id')->get()->count();
        


        $age_typ = $type;
        str_replace(array('eventdata_' , 's'), '', $yr);
        $sum_overall = 0;
        $top3_finishes = 0;
        $top10_finishes = 0;
        $category_wins = 0;
        $data['blue_light'] = $type;
        $total_races = DB::table($yr)->where('age_type', $type)->groupBy('event_id')->select('event_id')->get()->count();
        
       
          $users['variable'] = DB::table('athletes')
          ->select(DB::raw($yr.'.event_date as ev_date,events.event_name as event_name, athletes.id as athlete_id ,  athletes.category_wins as athlete_category_wins , athletes.current_overall_rank as athlete_current_overall_rank , athletes.current_category_rank_status as athlete_current_category_rank_status , athletes.overall_wins as athlete_overall_wins ,  athletes.top3_finishes as athlete_top3_finishes , athletes.top10_finishes as athlete_top10_finishes , athletes.current_category_rank as athlete_current_category_rank , athletes.mrp as athlete_mrp ,  athletes.arp as athlete_arp ,  athletes.current_overall_rank_status as athlete_current_overall_rank_status ,  events.id as event_id, athletes.image as image, '.$yr.'.overall_rank as overall_rank, '.$yr.'.bib as bib, '.$yr.'.category_rank as category_rank,'.$yr.'.age_category as age_category, '.$yr.'.distance as distance,'.$yr.'.speed as speed,'.$yr.'.time as time,'.$yr.'.points as points'))
          ->join($yr, 'athletes.athlete_name', '=', ''.$yr.'.athlete')
          ->join('events', ''.$yr.'.event_id', '=', 'events.id')
          ->where('athletes.athlete_name', '=', $player)
          ->where(''.$yr.'.age_type', '=', $type)
          ->orderBy('events.event_date', 'DESC')
          ->get();


//echo '<pre>';
//print_r($users);
//die();


          $team_under = Team::select('team_members', 'name' , 'logo')->get();
          foreach ($team_under as $key => $value) {
            $under_team = json_decode($value['team_members']);
            foreach ($under_team as $key => $val) {
              if ($val == $users['variable'][0]->athlete_id) {
                $data['under_team'] = $value['name'];
                $data['under_team_logo'] = $value['logo'];
                break;
              }
            }
          }

            $a = count($users['variable']) - 1;
            

        $current_overall_rank_status = DB::table("overall_rankings")->where('athlete_name',$player)->where('event_date', 'like' , '%'.date("Y", strtotime($users['variable'][0]->ev_date)).'%')->where('age_type', $type)->orderBy('event_date', 'DESC')->first();
    
        $mydata = DB::table("age_wise_rankings")->where('athlete_name',$player)->groupBy('age_type')->get()->toArray();

        $agew = [];

        foreach($mydata as $fd){
        if($fd->age_type == 0){
          $fd->year = date('Y', strtotime($fd->event_date));
          $agew['overall'] = $fd;
        } 

        if($fd->age_type == 1){
          $fd->year = date('Y', strtotime($fd->event_date));
          $agew['kids'] = $fd;
        } 

        if($fd->age_type == 2){
          $fd->year= date('Y', strtotime($fd->event_date));
          $agew['youth'] = $fd;
        } 
        if($fd->age_type == 3){
          $fd->year = date('Y', strtotime($fd->event_date));
          $agew['nyouth'] = $fd;
      }

        }
          
        $data['agew'] = $agew;
        
        $data['current_overall_rank_status'] = $current_overall_rank_status->progress_status;
        $data['current_category_rank_status'] = $current_overall_rank_status->age_wise_progress_status;

        $data['age_category'] = $users['variable'][0]->age_category;
        $data['current_overall_rank'] = $current_overall_rank_status->rank;
        $data['current_category_rank'] = $current_overall_rank_status->age_wise_rank;
        $data['mrp'] = $current_overall_rank_status->mrp;


        foreach ($users['variable'] as $key => $value) {
          if ($value->overall_rank == 1 && $value->overall_rank != 0) {
            $sum_overall ++;
          }
          if ($value->overall_rank <= 3 && $value->overall_rank !=0 ) {
            $top3_finishes ++;
          }
          if ($value->overall_rank <= 10 && $value->overall_rank !=0 ) {
            $top10_finishes ++;
          }
          if ($value->category_rank == 1 && $value->category_rank !=0) {
            $category_wins ++;
          }
 
        }
        
        $data['overall_wins'] = $sum_overall;
        $data['top3_finishes'] = $top3_finishes;
        $data['top10_finishes'] = $top10_finishes;
        $data['category_wins'] = $category_wins;

        if (count($users['variable']) == 0 && $type == 1) {
              $users['kids_none'] = 1;
            }

        if (count($users['variable']) == 0 && $type == 0) {
              $users['overall_none'] = 1;
            }         

        $data['total_races'] = count($users['variable']);

        if ($type == 1) {
            $users["type"] = 1;
          }else{
            $users["type"] = 0;
          } 

           $kids = 0;
           $overall =0; 
           $year = array();
           $year2 = array();
           $type = array();
           $a =  str_replace("_"," ",$player);
           $data_2["data"] = Athlete::where('athlete_name', '=', $a)->first();
           $abcd = DB::select('SHOW TABLES');

          $dbname = DB::connection()->getDatabaseName();
            $tb = 'Tables_in_'.$dbname;

           foreach ($abcd as $key => $value) {
            $strpos = strpos($value->$tb , "eventdata" );
            if ($strpos !== false ) {
              $year2[] = $value->$tb;
            }
           }

           $year3 = array();

           foreach ($year2 as $key => $value1141) {
       
             $ck_yr = DB::table($value1141)->where('athlete', $a)->where('age_type', 0)->first();
             $ck_yr_2 = DB::table($value1141)->where('athlete', $a)->where('age_type', 1)->first();
             $ck_yr_youth = DB::table($value1141)->where('athlete', $a)->where('age_type', 2)->first();
           
             if($ck_yr !=null){
                $athlete = 1;
                $data['has_kid'] = 0;
                $year10[] = $value1141;
             }

             if($ck_yr_2 !=null){
           
              $type[] = $ck_yr_2->age_type;
               if($ck_yr_2->age_type == 1){
                $data['has_kid'] = 1;
                $kid = 1;
                $year3[] = $value1141;
               }
             }

             if($ck_yr_youth !=null){

              $type[] = $ck_yr_youth->age_type;
               if($ck_yr_youth->age_type == 2){
                $data['has_youth'] = 2;
                $has_youth = 1;
                $year_youth[] = $value1141;
               }
             }
         }

          if (isset($kid) && isset($athlete) && isset($has_youth)  ) {
             $data['yr_val_both'] = $year3;
           }else{

            if ( isset($athlete)  ) {
             $data['yr_val_athlete'] = $year10;

             }
             if ( isset($kid) ) {
               $data['yr_val_kid'] = $year3;
             }
             if ( isset($has_youth) ) {
               $data['yr_val_youth'] = $year_youth;
             }

           }

    
          if($age_typ == 1){
             $data['yr_name'] = $year3;
          }
          if($age_typ == 0){
             $data['yr_name'] = $year10;
          }
          if($age_typ == 2){
             $data['yr_name'] = $year_youth;
          }

           $data['yr_name'] = array_unique($data['yr_name']);


           $year_123 = array();

           foreach ($data['yr_name'] as $key => $value) {
             $year_123[] = str_replace(array('eventdata_', 's'), '', $value);
           }
           rsort($data['yr_name']); 
           rsort($year_123);  
           $data['yr_show'] = $year_123;  
           $data['yr_val'] = $year3;
           $data['selected_yaer'] = $yr;  

          
          $data['name'] = $player;
          if(str_replace(array('eventdata_' , 's'), '', $yr)>=2020){
            $principle = 1/2;
          }
          else{
            $principle = 2/3;
          }

          if ($data['total_races'] !=0) {
            $data['arp'] = round( $data['mrp']  * round( $principle * $total_races ) , 3);
          }

          $pieces = explode("_", $yr);
          $pieces = explode("s", $pieces[1]);
          $international_event = DB::table('international_athletes')->where('athlete', $player)->select('id')->first();
          $users['year'] = $pieces[0];
          $users['international_event_status'] = $international_event;

        $view = view('front_end.team.show_data' , $users , $data );
        echo $view->render();
    }

    public function detail_overall($type,$player)
    {
        $player =  str_replace("____","/",$player);
        $pledgeCampaignBadg = array();

        $BadgeConsistency2019 = 0;
        $BadgeSuperConsistent = 0;
        $BadgeConsistency2020 = 0;

        $badge_10k = 0;
        $badge_21k = 0;
        $badge_42k = 0;
        $ultra_merathon = 0;

        $Urataka = 0;
        $Betico = 0;
        $Half = 0;
        $Ronde = 0;
        $Turibana = 0;
        $Brandweer = 0;
        $ClassicQuest = 0;

        $UratakaQuest = 0;
        $ArubaBank1Quest = 0;
        $ArubaBank2Quest = 0;
        $ArubaBank3Quest = 0;
        $ArubaBank4Quest = 0;
        $RunBack2SchoolQuest = 0;
        $SportCaribeQuest = 0;
        $InfiniteQuest = 0;
        $Chasing5KQuest = 0;

        $abcd = DB::select('SHOW TABLES');

        $dbname = DB::connection()->getDatabaseName();
        $tb = 'Tables_in_'.$dbname;

        foreach ($abcd as $key => $value) {
        $strpos = strpos($value->$tb , "eventdata" );
        if ($strpos !== false ) {
          $year2[] = $value->$tb;
        }
       }

       $year3 = array();
       $overall_year = array();

       foreach ($year2 as $key => $value1141) {
         
           $ck_yr = DB::table($value1141)->where('athlete', $player)->select('id')->where('age_type' , $type)->first();
             if($ck_yr !=null){

               $overall_year[] = $value1141;
             }
         }

         foreach ($year2 as $key => $value1141) {
       
         $ck_yr = DB::table($value1141)->where('athlete', $player)->where('age_type', 0)->first();
         $ck_yr_2 = DB::table($value1141)->where('athlete', $player)->where('age_type', 1)->first();
         $ck_yr_youth = DB::table($value1141)->where('athlete', $player)->where('age_type', 2)->first();

           if($ck_yr !=null){

             if($ck_yr->age_type == 1){
              $data['has_kid'] = 1;
              $kid = 1;
              $year3[] = $value1141;
             }else{

              $athlete = 1;
              $data['has_kid'] = 0;
              $year10[] = $value1141;
             }
           }

           if($ck_yr_2 !=null){

             if($ck_yr_2->age_type == 1){
              $data['has_kid'] = 1;
              $kid = 1;
              $year3[] = $value1141;
             }else{

              $athlete = 1;
              $data['has_kid'] = 0;
              $year10[] = $value1141;
             }
           }

           if($ck_yr_youth !=null){

               if($ck_yr_youth->age_type == 2){
                $data['has_youth'] = 2;
                $has_youth = 1;
                $year_youth[] = $value1141;
               }
             }
       }


         if (isset($kid) && isset($athlete) && isset($has_youth)  ) {
             $data['yr_val_both'] = $year3;
           }else{

            if ( isset($athlete)  ) {
             $data['yr_val_athlete'] = $year10;

             }
             if ( isset($kid) ) {
               $data['yr_val_kid'] = $year3;
             }
             if ( isset($has_youth) ) {
               $data['yr_val_youth'] = $year_youth;
             }

           }
 

         rsort($overall_year);
         $data['yr_name'] = $overall_year;

        str_replace(array('eventdata_' , 's'), '', $data['yr_name'][0]);
        $sum_overall = 0;
        $top3_finishes = 0;
        $top10_finishes = 0;
        $category_wins = 0;

        $data['blue_light'] = $type;
        $total_races = DB::table($overall_year[0])->where('age_type', $type)->groupBy('event_id')->select('event_id')->get()->count();


          $users['variable'] = DB::table('athletes')
          ->select(DB::raw($overall_year[0].'.event_date as ev_date,events.event_name as event_name, athletes.id as athlete_id ,  athletes.category_wins as athlete_category_wins , athletes.current_overall_rank as athlete_current_overall_rank , athletes.current_category_rank_status as athlete_current_category_rank_status , athletes.overall_wins as athlete_overall_wins ,  athletes.top3_finishes as athlete_top3_finishes , athletes.top10_finishes as athlete_top10_finishes , athletes.current_category_rank as athlete_current_category_rank , athletes.mrp as athlete_mrp ,  athletes.arp as athlete_arp ,  athletes.current_overall_rank_status as athlete_current_overall_rank_status , athletes.id as athlete_id ,athletes.image as image,events.id as event_id,'.$overall_year[0].'.overall_rank as overall_rank,'.$overall_year[0].'.category_rank as category_rank,'.$overall_year[0].'.age_category as age_category, '.$overall_year[0].'.bib as bib, '.$overall_year[0].'.distance as distance,'.$overall_year[0].'.speed as speed,'.$overall_year[0].'.time as time,'.$overall_year[0].'.points as points'))
          ->join($overall_year[0], 'athletes.athlete_name', '=', ''.$overall_year[0].'.athlete')
          ->join('events', ''.$overall_year[0].'.event_id', '=', 'events.id')
          ->where('athletes.athlete_name', '=', $player)
          ->where(''.$overall_year[0].'.age_type', '=', $type)
          ->orderBy('events.event_date', 'DESC')
          ->get();

          $data['total_races'] = count($users['variable']);

           $team_mem = Team::select('team_members', 'captain' , 'name', 'logo')->get();

          foreach ($team_mem as $key => $value2) {

            if ($value2->captain == $users['variable'][0]->athlete_id ) {
              $data['team_name'] = $value2['name'];
            }

             $members_team[] = json_decode($value2['team_members']);

             foreach ($members_team as $key => $value33) {

              foreach ($value33 as $key => $value) {

                if ($value == $users['variable'][0]->athlete_id ) {
               
                 $data['team_name'] = $value2['name'];
                 $data['team_logo'] = $value2['logo'];
                 break;
                } 
              }

               
             }
           }
           

        $a = count($users['variable']) - 1;

        $current_overall_rank_status = DB::table("overall_rankings")->where('athlete_name',$player)->where('event_date', 'like' , '%'.date("Y", strtotime($users['variable'][0]->ev_date)).'%')->where('age_type', $type)->orderBy('event_date', 'DESC')->first();
    
        $data['current_overall_rank_status'] = $current_overall_rank_status->progress_status;
        $data['current_category_rank_status'] = $current_overall_rank_status->age_wise_progress_status;

        $data['age_category'] = $users['variable'][0]->age_category;
        $data['current_overall_rank'] = $current_overall_rank_status->rank;
        $data['current_category_rank'] = $current_overall_rank_status->age_wise_rank;
        $data['mrp'] = $current_overall_rank_status->mrp;

        foreach ($users['variable'] as $key => $value) {
          if ($value->overall_rank == 1 && $value->overall_rank != 0) {
            $sum_overall ++;
          }
          if ($value->overall_rank <= 3 && $value->overall_rank !=0 ) {
            $top3_finishes ++;
          }
          if ($value->overall_rank <= 10 && $value->overall_rank !=0 ) {
            $top10_finishes ++;
          }
          if ($value->category_rank == 1 && $value->category_rank !=0) {
            $category_wins ++;
          }
              
        }
        $mydata = DB::table("age_wise_rankings")->where('athlete_name',$player)->groupBy('age_type')->get()->toArray();

        $agew = [];

        foreach($mydata as $fd){
        if($fd->age_type == 0){
          $fd->year = date('Y', strtotime($fd->event_date));
          $agew['overall'] = $fd;
        } 

        if($fd->age_type == 1){
          $fd->year = date('Y', strtotime($fd->event_date));
          $agew['kids'] = $fd;
        } 

        if($fd->age_type == 2){
          $fd->year= date('Y', strtotime($fd->event_date));
          $agew['youth'] = $fd;
        } 
        if($fd->age_type == 3){
          $fd->year = date('Y', strtotime($fd->event_date));
          $agew['nyouth'] = $fd;
      }

        }
          
        $data['agew'] = $agew;

        $data['overall_wins'] = $sum_overall;
        $data['top3_finishes'] = $top3_finishes;
        $data['top10_finishes'] = $top10_finishes;
        $data['category_wins'] = $category_wins;

            if(str_replace(array('eventdata_' , 's'), '', $overall_year[0])>=2020){
              $principle = 1/2;
            }
            else{
              $principle = 2/3;
            }


              if ($data['total_races'] !=0) {
                $data['arp'] = round( $data['mrp']  * round( $principle * $total_races ) , 3);

              }else{
                $data['arp'] = 0;
              }
          // }
          

           $kids = 0;
           $overall =0; 
           $year = array();
           $year2 = array();
           $type = array();
           $a =  str_replace("_"," ",$player);
           $data_2["data"] = Athlete::where('athlete_name', '=', $a)->first();


           $data['yr_name'] = array_unique($data['yr_name']);
           rsort($data['yr_name']); 

           $year_123 = array();

           foreach ($data['yr_name'] as $key => $value) {
             $year_123[] = str_replace(array('eventdata_', 's'), '', $value);
           }  
           rsort($year_123);
           $data['yr_show'] = $year_123;
           $data['yr_val'] = $year3;
           $data['selected_yaer'] = $overall_year[0];

           $data['name'] = $player;

           $pieces = explode("_", $overall_year[0]);
           $pieces = explode("s", $pieces[1]);

           $users['year'] = $pieces[0];


        
          $view = view('front_end.team.show_data' , $users , $data );
          echo $view->render();
    }

    public function category_rank($yr,$type,$player,$age_category,$event_date,$mrp)
    {
      $two_id= DB::table('overall_rankings')->select('athlete_name', 'event_date', 'event_id')->where('age_type', $type)->where('age_category', 'like', '%'.$age_category.'%' )->where('event_date', 'like', '%'.date("Y", strtotime($event_date)).'%' )->groupBy('event_date')->orderBy('event_date', 'DESC')->take(2)->get();
    

      $data["current_category_rank"] = DB::table('overall_rankings')->select('athlete_name')->where('event_date',$two_id[0]->event_date )->where('age_type', $type)->where('age_category', 'like', '%'.$age_category.'%' )->orderBy('mrp', 'DESC')->get();


      foreach ($data["current_category_rank"] as $key => $value) {
        if ($value->athlete_name == $player) {
          $data["current_category_rank"] = $key + 1 ;
          break;
        }
      }

      $data["previous_category_rank"] = DB::table('overall_rankings')->select('athlete_name')->where('event_date',$two_id[1]->event_date )->where('age_type', $type)->where('age_category', 'like', '%'.$age_category.'%' )->orderBy('mrp', 'DESC')->get();

      foreach ($data["previous_category_rank"] as $key => $value) {
        if ($value->athlete_name == $player) {
          $data["previous_category_rank"] = $key + 1 ;
          break;
        }
      }


      $data['current_category_rank_status'] = $data["previous_category_rank"] - $data["current_category_rank"];

      $view = view('front_end.team.category' , $data );
      echo $view->render();
    }

    public function athletes()
    {
      $query["age"] = Age_group::all();
      
      return view('front_end.athletic.index', $query , $this->common()  );
    }

    public function athletes_filter($slug,$search="",$offset="")
    {
    if($offset!=""){
      if($offset==1){
        $offset=0;
      }
      if($search=='blank'){
        $search = ""; 
      }
      if(trim($search)!=""){
     $data["data"] = Athlete::where('athlete_name', 'LIKE' , '%' .$search. '%' )->select('age_category' , 'athlete_name' , 'image','total_races' , 'overall_wins' , 'top3_finishes' , 'top10_finishes' , 'category_wins' , 'current_overall_rank' , 'current_category_rank' , 'mrp' , 'current_overall_rank_status' , 'current_category_rank_status' ,'arp')->skip($offset)->take(50)->get();
     $data['total'] = Athlete::where('athlete_name', 'LIKE' , '%' .$search. '%' )->select('age_category' , 'athlete_name' , 'image','total_races' , 'overall_wins' , 'top3_finishes' , 'top10_finishes' , 'category_wins' , 'current_overall_rank' , 'current_category_rank' , 'mrp' , 'current_overall_rank_status' , 'current_category_rank_status' ,'arp')->get()->count();  
    }
    else{
      $data["data"] = Athlete::where('age_category', '=', $slug)->skip($offset)->take(50)->get();
    $data['total'] =  Athlete::where('age_category', '=', $slug)->get()->count();
    }
    }
    else{
      if(trim($search)!=""){
     $data["data"] = Athlete::where('athlete_name', 'LIKE' , '%' .$search. '%' )->select('age_category' , 'athlete_name' , 'image','total_races' , 'overall_wins' , 'top3_finishes' , 'top10_finishes' , 'category_wins' , 'current_overall_rank' , 'current_category_rank' , 'mrp' , 'current_overall_rank_status' , 'current_category_rank_status' ,'arp')->take(50)->get();
     $data['total'] = Athlete::where('athlete_name', 'LIKE' , '%' .$search. '%' )->select('age_category' , 'athlete_name' , 'image','total_races' , 'overall_wins' , 'top3_finishes' , 'top10_finishes' , 'category_wins' , 'current_overall_rank' , 'current_category_rank' , 'mrp' , 'current_overall_rank_status' , 'current_category_rank_status' ,'arp')->get()->count();  
    }
    else{
      $data["data"] = Athlete::where('age_category', '=', $slug)->take(50)->get();
    $data['total'] =  Athlete::where('age_category', '=', $slug)->get()->count();
    }
    }
    
      
      $data['cont'] = count($data["data"]);
      $view = view('front_end.athletic.show_data' , $data);
      echo $view->render();
    }

    public function athletes_filter_2($slug)
    {
      $data["data"] = Athlete::where('athlete_name', 'LIKE' , '%' .$slug. '%' )->select('age_category' , 'athlete_name' , 'total_races' , 'overall_wins' , 'top3_finishes' , 'top10_finishes' , 'category_wins' , 'current_overall_rank' , 'current_category_rank' , 'mrp' , 'current_overall_rank_status' , 'current_category_rank_status' ,'arp')->get();

      $data['cont'] = count($data["data"]);

      $view = view('front_end.athletic.show_data' , $data);
      echo $view->render();
    }

    public function team_list()
    {
    $team = Team::all();
        return view('front_end.team.team_list' , $this->common(),['team'=>$team] );
    }

    public function team($id)
    {

        $team_members_show = array();
        $flag = 0;

        $users["team"] = Team::where('id', '=', $id)->first();

        if (empty($users["team"])) {
          return redirect('error');
        }

        $users["team_next"] = Team::where('id', '>', $id)->orderBy('order_field')->first();
        $users["team_prev"] = Team::where('id', '<', $id)->orderBy('id','desc')->first();

        $members = json_decode($users['team']['team_members']);

        foreach ($members as $key => $value) {
            if ($value == $users['team']['captain']) {
                $flag =1; break;
            }
        }

        if ($flag ==0 ) {
            $members[] = $users['team']['captain'];
        }


        $users['total_member'] = count($members);

        $sum_overall = 0;
        $sum_category = 0;

        foreach ($members as $key => $value) {
             $team_members = DB::table('athletes')->where('id', '=', $value)->first();
             if (!empty($team_members)) {
                $team_members_show[] = $team_members;
              } 
            
        }

        $users['team_members_show'] = $team_members_show;
        
        return view('front_end.team.team' , $users , $this->common() );
    }
    
    public function update_sort(Request $request)
    {
      $x = $request->order;
      $team_id = $request->team_id;

      $z = explode(",",$x);

      $xy ='';

      $xy .='[';


      foreach ($z as $key => $value) {

        if (count($z)-2 >= $key) {
          $xy .= json_encode($value).',';
        }else{
          $xy .= json_encode($value);
        }
        
      }

      $xy .=']';

      $data = Team::where('id',$request->team_id)->first();

      $data['team_members'] = $xy;

      if($data->update()){

        echo 1;

      }

    }
    
    public function athlete_log()
    {
      $sum_overall = 0;
     $top3_finishes = 0;
     $top10_finishes = 0;
     $category_wins = 0;

     // CHECK IF WE HAVE ANY ATHLETE IN TABLE , THEN GET 50 at a row and update

      $y = Tempathlete::select('athletename')->take(100)->get();


      foreach ($y as $key => $value) {
          $rs_tmp_ath =  $value->athletename;
        $data['data'] = OverallRanking::where('athlete_name',  $value->athletename)->orderBy('event_date', 'DESC')->first();
       if(!empty($data['data'])){
           echo $value->athletename.'<br>';
    
       $x = OverallRanking::select('rank', 'age_wise_rank' , 'athlete_name' ,'event_date')->where('athlete_name', $value->athletename)->where('event_date', 'LIKE' , '%' .date('Y', strtotime($data['data']->event_date)). '%' )->where('age_type' , $data['data']->age_type)->orderBy('event_date', 'DESC')->get();
       
       $data['arp'] = DB::table('eventdata_'.date('Y', strtotime($data['data']->event_date)).'s')->where('athlete',  $value->athletename)->where('age_type' , $data['data']->age_type)->sum('points');


       foreach ($x as $key => $value) {
            if ($value->rank == 1 && $value->rank != 0) {
              $sum_overall ++;
            }
            if ($value->rank <= 3 && $value->rank !=0 ) {
              $top3_finishes ++;
            }
            if ($value->rank <= 10 && $value->rank !=0 ) {
              $top10_finishes ++;
            }
            if ($value->age_wise_rank == 1 && $value->age_wise_rank !=0) {
              $category_wins ++;
            }
          }

          $var = [

            "mrp"=>$data['data']['mrp'],
            "athlete_name"=>$data['data']['athlete_name'],
            "current_overall_rank"=>$data['data']['rank'],
            "current_overall_rank_status"=>$data['data']['progress_status'],
            "current_category_rank_status"=>$data['data']['age_wise_progress_status'],
            "current_category_rank"=>$data['data']['age_wise_rank'],
            "overall_wins"=>$sum_overall,
            "top3_finishes"=>$top3_finishes,
            "top10_finishes"=>$top10_finishes,
            "category_wins"=>$category_wins,
            "arp"=>$data['arp'],
          ];

          DB::table('athletes')
              ->where('athlete_name', $data['data']['athlete_name'])
              ->update($var);

               $sum_overall = 0;
               $top3_finishes = 0;
               $top10_finishes = 0;
               $category_wins = 0;
          }
          
          //Now delete from tem log
          DB::table('tempathletes')->where('athletename', $rs_tmp_ath)->delete();
      }

    }  

    public function cup_achievment($type , $player , $year , $cup_type)
    {
      $abcd = DB::select('SHOW TABLES');

      $dbname = DB::connection()->getDatabaseName();
      $tb = 'Tables_in_'.$dbname;

     foreach ($abcd as $key => $value) {
      $strpos = strpos($value->$tb , "eventdata" );
      if ($strpos !== false && $value->$tb != $year ) {
        $x = str_replace("eventdata_","", $value->$tb);
        $yearxx[] = str_replace("s","", $x);
      }
     }

     foreach ($yearxx as $key => $value) {
       $last_achievment[] = DB::table('overall_rankings')
                               ->where('athlete_name', $player)
                               ->where('age_type', $type) 
                               ->where('event_date','like', '%'.$value.'%')
                               ->orderBy('event_date', 'Desc')
                               ->select('rank', 'age_wise_rank','event_date')
                               ->first();
     }

     $overall_achivment =array();
     $category_achivment =array();


     foreach ($last_achievment as $key => $value) {
       if ($value->rank == 1 ) {
         $overall_achivment[] = date("Y", strtotime($value->event_date)).' Champion ';
       }

       if ($value->age_wise_rank == 1 ) {
         $category_achivment[] = date("Y", strtotime($value->event_date)).' Champion ';
       }
     }

     $output ='';

     $output .='<div>';

     if ($cup_type =='overall_achivment') {
       $output .='<p> Overall Champion : </p>';
       $output .='<ul>';
       foreach ($overall_achivment as $key => $value) {
         $output .='<li>'.$value.'';
         $output .='</li>';
       }
       $output .='</ul>';
     }else{

       $output .='<p> Category Champion : </p>';
       $output .='<ul>';
       foreach ($category_achivment as $key => $value) {
         $output .='<li>'.$value.'';
         $output .='</li>';
       }
       $output .='</ul>';

     }

     $output .='</div>';

     echo $output;

    }  


    public function personal_best($type , $player , $year)
    {
      $player =  str_replace("____","/",$player);
      $abcd = DB::select('SHOW TABLES');

      $low_time =array();
      $distance =array();
      $infos =array();
      $var =array();

        $dbname = DB::connection()->getDatabaseName();
        $tb = 'Tables_in_'.$dbname;
        $year2 = array();
       foreach ($abcd as $key => $value) {
        $strpos = strpos($value->$tb , "eventdata" );
        if ($strpos !== false ) {
          $year2[] = $value->$tb;
        }
       }

       foreach ($year2 as $key => $year) {

         \DB::enableQueryLog();
          $data = DB::table($year)->where('athlete', $player)->whereIn('distance' , [2.8 , 2.9 , 3, 3.1 , 3.2, 5, 9.8 , 9.9 , 10, 10.1 , 10.2 , 14.7 , 14.8 , 14.9 , 15 , 15.1 , 15.2  , 15.3 , 20.8 , 20.9, 21,  21.1 , 21.2 , 21.3 ,42.2 , 1.6 , 1.5 , 1 , 0.8 , 0.4])->groupBy('distance')->orderBy('distance', 'ASC')->get();

          foreach ($data as $key => $value) {
            $distance[] = $value->distance;
            $low_time[] = DB::table($year)->where('distance' , $value->distance)->where('athlete', $player)->groupBy('distance')->min('time');
            
          }

          foreach ($low_time as $key => $value) {
            $infos[] = DB::table($year)->where('distance' , $distance[$key])->where('athlete', $player)->where('time',$value)->first();
          }
       }


       foreach ($infos as $key => $value) {
         if ($value !=null) {
           $info[] = $value;
         }
       }



      foreach ($distance as $key => $value) {

        if ($value == 1.6 ) {
         $value_1_6[] = $low_time[$key];
         sort($value_1_6);

         foreach ($info as $key => $value22) {
          if ($value22 != '') {
            if ($value_1_6[0] == $value22->time) {
             $time_1_6 = $value22->time;
             $info_1_6 = $value22;


           }
          }
         }
         
       }



       if ($value == 1.5 ) {
         $value_1_5[] = $low_time[$key];
         sort($value_1_5);

         foreach ($info as $key => $value22) {
          if ($value22 != '') {
            if ($value_1_5[0] == $value22->time) {
             $time_1_5 = $value22->time;
             $info_1_5 = $value22;


           }
          }
         }
       }
       if ($value == 1 ) {
         $value_1[] = $low_time[$key];
         sort($value_1);

         foreach ($info as $key => $value22) {
          if ($value22 != '') {
            if ($value_1[0] == $value22->time) {
             $time_1 = $value22->time;
             $info_1 = $value22;


           }
          }
         }

       }
       if ($value == 0.8 ) {
         $value_0_8[] = $low_time[$key];
         sort($value_0_8);

         foreach ($info as $key => $value22) {
          if ($value22 != '') {
            if ($value_0_8[0] == $value22->time) {
             $time_0_8 = $value22->time;
             $info_0_8 = $value22;


           }
          }
         }

       }
       if ($value == 0.4 ) {
         $value_0_4[] = $low_time[$key];
         sort($value_0_4);

         foreach ($info as $key => $value22) {
          if ($value22 != '') {
            if ($value_0_4[0] == $value22->time) {
             $value_0_4_info = $value22;

             $time_0_4 = $value22->time;
             $info_0_4 = $value22;


           }
          }
         }


       }

       if ($value == 5 ) {
         $value_5[] = $low_time[$key];
         sort($value_5);

         foreach ($info as $key => $value22222) {
          if ($value22222->time != '') {
            if ($value_5[0] == $value22222->time) {
             $time5 = $value22222->time;
             $info5 = $value22222;
           }
          }
         }

       }

       if ($value == 2.8 || $value == 2.9 || $value == 3 || $value == 3.1 || $value == 3.2  ) {
         $value_3[] = $low_time[$key];
         sort($value_3);
         foreach ($info as $key => $value22222) {
          if ($value22222->time != '') {
            if ($value_3[0] == $value22222->time) {
             $time33 = $value22222->time;
             $info33 = $value22222;
           }
          }
         }
       }


       if ($value >= 9.8 && $value <= 10.2 ) {
         $value_10[] = $low_time[$key];
         sort($value_10);

         foreach ($info as $key => $value22) {
          if ($value22 != '') {
            if ($value_10[0] == $value22->time) {
              $time4 = $value22->time;
              $info4 = $value22;

           }
          }
         }

       }
       if ($value >= 14.7 && $value <= 15.3 ) {
         $value_15[] = $low_time[$key];
         sort($value_15);

         foreach ($info as $key => $value22) {
          if ($value22 != '') {
            if ($value_15[0] == $value22->time) {
             $value_15_info = $value22;

             $time3 = $value22->time;
             $info3 = $value22;


           }
          }
         }

       }
       if ( $value >= 20.8 && $value <= 21.3 ) {
         $value_21[] = $low_time[$key];
         sort($value_21);

         foreach ($info as $key => $value22) {
          if ($value22 != '') {
            if ($value_21[0] == $value22->time) {

             $time2 = $value22->time;
             $info2 = $value22;

           }
          }
         }

         

       }
       if ($value == 42.2 ) {

         $value_42[] = $low_time[$key];
         sort($value_42);

         foreach ($info as $key => $value22) {
          if ($value22 != '') {
            if ($value_42[0] == $value22->time) {

              $time1111 = $value22->time;
              $info1111 = $value22;


           }
          }
         }

       }
      }

      if (isset($time1111)) {
        $var[] = [

              "time" => $time1111,
              "info" => $info1111,
              "distance" => 42.2,

             ];
      }

      if (isset($time2)) {
        $var[] = [

              "time" => $time2,
              "info" => $info2,
              "distance" => 21.1,

             ];
      }


      if (isset($time3)) {
        $var[] = [

              "time" => $time3,
              "info" => $info3,
              "distance" => 15,

             ];
      } 

      if (isset($time4)) {
        $var[] = [

              "time" => $time4,
              "info" => $info4,
              "distance" => 10,

             ];
      } 

      

      if (isset($time5)) {
        $var[] = [

              "time" => $time5,
              "info" => $info5,
              "distance" => 5,

             ];
      } 

      if (isset($time33)) {
        $var[] = [

              "time" => $time33,
              "info" => $info33,
              "distance" => 3,

             ];
  
      }

      if (isset($time_1_6)) {
        $var[] = [

              "time" => $time_1_6,
              "info" => $info_1_6,
              "distance" => 1.6,

             ];
      }

      if (isset($time_1_5)) {
        $var[] = [

              "time" => $time_1_5,
              "info" => $info_1_5,
              "distance" => 1.5,

             ];
      }

      if (isset($time_1)) {
        $var[] = [

              "time" => $time_1,
              "info" => $info_1,
              "distance" => 1,

             ];
      }


      if (isset($time_0_8)) {
        $var[] = [

              "time" => $time_0_8,
              "info" => $info_0_8,
              "distance" => .8,

             ];
      } 

      if (isset($time_0_4)) {
        $var[] = [

              "time" => $time_0_4,
              "info" => $info_0_4,
              "distance" => .4,

             ];
      } 

      $data['var'] = $var;
      if (count($var)) {
        $view = view('front_end.team.personal_best' , $data);
        echo $view->render();
      }
   
    }

    public function personal_cup_show($player , $type , $year)
    {
      $player =  str_replace("____","/",$player);

      $abcd = DB::select('SHOW TABLES');

      $dbname = DB::connection()->getDatabaseName();
      $tb = 'Tables_in_'.$dbname;

     foreach ($abcd as $key => $value) {
      $strpos = strpos($value->$tb , "eventdata" );
      if ($strpos !== false && $value->$tb != 'eventdata_'.date("Y").'s' ) {
        $x = str_replace("eventdata_","", $value->$tb);
        $yearxx[] = str_replace("s","", $x);
      }
     }

     foreach ($yearxx as $key => $value) {
       $last_achievments[] = DB::table('overall_rankings')
                               ->where('athlete_name', $player)
                               ->where('age_type', $type) 
                               ->where('event_date','like', '%'.$value.'%')
                               ->orderBy('event_date', 'Desc')
                               ->select('rank', 'age_wise_rank','event_date')
                               ->first();
                  
     }

     $overall_achivment =array();
     $category_achivment =array();

     $over = 0;
     $category = 0;
     $i = 0;
     $j = 0;

     $title_over =array();
     $title_category =array();

     $base_url = url('/');

     foreach ($last_achievments as $key => $value) {
       if ($value !='') {
         $last_achievment[] = $value;
       }
     }

     $data['last_achievment'] = $last_achievment;

     if ($type == 2 ) {
       
       foreach ($last_achievment as $key => $value) {
         if ($value->rank == 1  ) {
          $over = 1;
          $i++;
           $title_over[] =''.date("Y", strtotime($value->event_date)).' Youth Champion ';
         }

       }

     }else{
      foreach ($last_achievment as $key => $value) {
         if ($value->rank == 1  ) {
          $over = 1;
          $i++;
           $title_over[] =''.date("Y", strtotime($value->event_date)).' Overall Champion ';
         }

         if ($value->age_wise_rank == 1 ) {
          $j++;
          $category = 1;
           $title_category[] =''.date("Y", strtotime($value->event_date)).' Category Champion ';
         }
       }

     }

     $data['type'] = $type;
     $data['over'] = $over;
     $data['category'] = $category;
     $data['title_over'] = $title_over;
     $data['title_category'] = $title_category;

     $data['jersey'] = BadgeUpload::first();

     $view = view('front_end.team.cup' , $data);
     echo $view->render();
    }  

    public function personal_badge_show($player , $type , $year, $events = '')
    {

      $player =  str_replace("____","/",$player);

      $abcd = DB::select('SHOW TABLES');

      $dbname = DB::connection()->getDatabaseName();
      $tb = 'Tables_in_'.$dbname;

     foreach ($abcd as $key => $value) {
      $strpos = strpos($value->$tb , "eventdata" );
      if ($strpos !== false ) {
        $x = str_replace("eventdata_","", $value->$tb);
        $yearxx[] = str_replace("s","", $x);
      }
     }

     $yearss = str_replace("eventdata_","", $year);
     $year_selected= str_replace("s","", $yearss) - 1;

        $badge_3k = 0;
        $badge_5k = 0;
        $badge_10k = 0;
        $badge_21k = 0;
        $badge_42k = 0;
        $ultra_merathon = 0;

        $BadgeConsistency2019 = 0;
        $BadgeSuperConsistent = 0;
        $BadgeConsistency2020 = 0;
        $BadgeConsistency2019Increment = 0;
        $BadgeConsistency2020Increment = 0;

        $ThreeYearBadge = 0;
        $ThreeYearBadge_2 = 0;
        $ThreeYearBadge_3 = 0;

        $Urataka = 0;
        $Betico = 0;
        $Half = 0;
        $Ronde = 0;
        $Turibana = 0;
        $Brandweer = 0;
        $ClassicQuest = 0;
        $Chasing5KQuest = 0;
        $ArubaBank1Quest = 0;

        $UratakaQuest = 0;
        $ArubaBank1Quest = 0;
        $ArubaBank2Quest = 0;
        $ArubaBank3Quest = 0;
        $ArubaBank4Quest = 0;
        $RunBack2SchoolQuest = 0;
        $SportCaribeQuest = 0;
        $InfiniteQuest = 0;
        $Chasing5KQuest = 0;

        $pledgeCampaignBadg =array();
        $Chasing5KQuest_aarray =array();

        foreach ($yearxx as $key => $value) {
         $last_achievment[] = DB::table('eventdata_'.$value.'s')
                                ->where('athlete', $player)
                                ->where('age_type', $type)
                                ->orderBy('event_date', 'Desc')
                                ->get();
       }
   
    //   echo  '<pre>';
    //   print_r($last_achievment);
    //   die();
      

       foreach ($last_achievment as $key => $value) {
         foreach ($value as $key => $value2) {

           if ( (float) $value2->distance >= 3 && (float) $value2->distance <= 3.5 ) {
             $badge_3k = 1;
           }
           if ( (float) $value2->distance >= 4.8 && (float) $value2->distance <= 6 ) {
             $badge_5k = 1;
           }
           if ( (float) $value2->distance >= 9.9 && (float) $value2->distance <= 10.5 ) {
             $badge_10k = 1;
           }
           if ($value2->distance == 21.1) {
             $badge_21k = 1;
           }
           if ($value2->distance == 42.2) {
             $badge_42k = 1;
           }
           if ( (float) $value2->distance > 42.2) {
             $ultra_merathon = 1;
           }

           //years badge
           
         //  echo $value2->event_date.'   '.$year_selected. '  '.$year_selected;
                
                
                
           if (date("Y", strtotime($value2->event_date)) == $year_selected && ($year_selected+1) >=2020 ) {
             $BadgeConsistency2019Increment++;
             if ($BadgeConsistency2019Increment >= 14) {
              
               $BadgeConsistency2019 = 1;
             }
           }
           if ( date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020 ) {
             $BadgeConsistency2020Increment++;
             if ($BadgeConsistency2020Increment >= 12 ) {
                $BadgeConsistency2020 = 1;
              }
           }





           if ( date("Y", strtotime($value2->event_date)) == date("Y")  ) {
              $ThreeYearBadge = 1;
           }

           if ( date("Y", strtotime($value2->event_date)) == date("Y",strtotime("-1 year")) ) {
             $ThreeYearBadge_2 = 1;
           }

           if ( date("Y", strtotime($value2->event_date)) == date("Y",strtotime("-2 year")) ) {
             $ThreeYearBadge_3 = 1;
           }

           if (date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020 ) {
             if ( date("F", strtotime($value2->event_date)) == "September" || date("F", strtotime($value2->event_date)) == "October" ) {

                $pledgeCampaignBadg[] = 1;
              } 
           }


           //Quest Badges


          if ( (strpos($value2->event_name , "Urataka" ) !==false) && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020 ) {
              $Urataka = 1;
            }

          if ( (strpos($value2->event_name , "Betico" ) !==false) && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020 ) {
              $Betico = 1;
            } 
            
          if ( (strpos($value2->event_name , "Half" ) !==false) && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020 ) {
              $Half = 1;
            }

          if ( (strpos($value2->event_name , "Ronde" ) !==false) && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020 ) {
              $Ronde = 1;
            } 
            
          if ( (strpos($value2->event_name , "Turibana" ) !==false) && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020 ) {
              $Turibana = 1;
            }

          if ( (strpos($value2->event_name , "Brandweer" ) !==false) && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020 ) {
              $Brandweer = 1;
            }


            // Chasing 5K Quest  distance

            if ( (strpos($value2->event_name , "Urataka" ) !==false ) && $value2->distance >= 5  && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020 ) {
              $Chasing5KQuest_aarray[] = 1;
            }

            if ( (strpos($value2->event_name , "Aruba Bank 1" ) !==false) && $value2->distance >= 5  && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020 ) {
                $Chasing5KQuest_aarray[] = 1;
              } 
              
            if ( (strpos($value2->event_name , "Aruba Bank 2" ) !==false) && $value2->distance >= 5  && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020) {
                $Chasing5KQuest_aarray[] = 1;
              }

            if ( (strpos($value2->event_name , "Aruba Bank 3" ) !==false) && $value2->distance >= 5  && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020) {
                $Chasing5KQuest_aarray[] = 1;
              } 
              
            if ( (strpos($value2->event_name , "Aruba Bank 4" ) !==false) && $value2->distance >= 5  && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020) {
                $Chasing5KQuest_aarray[] = 1;
              }

            if ( (strpos($value2->event_name , "Run Back 2 School" ) !==false) && $value2->distance >= 5  && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020) {
                $Chasing5KQuest_aarray[] = 1;
              }

            if ( (strpos($value2->event_name , "Sport Caribe" ) !==false) && $value2->distance >= 5  && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020) {
                $Chasing5KQuest_aarray[] = 1;
              }

            if ( (strpos($value2->event_name , "Infinite" ) !==false) && $value2->distance >= 5  && date("Y", strtotime($value2->event_date)) == ($year_selected+1) && ($year_selected+1) >=2020) {
                $Chasing5KQuest_aarray[] = 1;
              } 


         }
       }

       if ( count($Chasing5KQuest_aarray) >=5 ) {
          $Chasing5KQuest = 1;
        }

        $data['Chasing5KQuest'] = $Chasing5KQuest;

       if ($Urataka == 1 && $Betico == 1 && $Half == 1 && $Ronde == 1 && $Turibana == 1 && $Brandweer == 1 && $year != 'eventdata_2018s' && $year != 'eventdata_2019s'  ) {
          $ClassicQuest = 1;
        }

        $data['ClassicQuest'] = $ClassicQuest;

       $data['pledgeCampaignBadg'] = 0;

        if (count($pledgeCampaignBadg) >=4) {
          $data['pledgeCampaignBadg'] = 1;
        }

       if ($ThreeYearBadge == 1 && $ThreeYearBadge_2 == 1 && $ThreeYearBadge_3 == 1 && $year !='eventdata_2018s' && $year !='eventdata_2019s') {
         $data['ThreeYearBadge'] = 1;
       }else{
        $data['ThreeYearBadge'] = 0;
       }

       if ($year_selected >2017) {
         $total_races_previous_year_event = DB::table('eventdata_'.$year_selected.'s')->where('age_type', $type)->groupBy('event_id')->select('event_id')->get()->count();

         if ( ( $total_races_previous_year_event * .8 ) <= $BadgeConsistency2019Increment  && ($year_selected+1) >=2020 ) {
              $BadgeSuperConsistent = 1;
            }
       }
    // we count Dixien Saavedra unwave badge for 2019 if he played 14 plus game before 2020 and 
    // even dates in 2019 to 2020  and if he played 80% plus game form previous year 

 
       $data['BadgeConsistency2019'] = $BadgeConsistency2019;
       $data['BadgeSuperConsistent'] = $BadgeSuperConsistent;
       $data['BadgeConsistency2020'] = $BadgeConsistency2020;

       $data['badge_3k'] = $badge_3k;
       $data['badge_5k'] = $badge_5k;
       $data['badge_10k'] = $badge_10k;
       $data['badge_21k'] = $badge_21k;
       $data['badge_42k'] = $badge_42k;
       $data['ultra_merathon'] = $ultra_merathon;

       $data['jersey'] = BadgeUpload::first();

       $view = view('front_end.team.badge' , $data);
       echo $view->render();
    }

    public function badge_list()
    {

      $data['jersey'] = BadgeUpload::first();
      return view('admin.badge.badge_list', $data);

    }

    public function update_badge(Request $request)
    {
        $validateData = $request->validate([
            'overall'=>'dimensions:width=60,height=45',
            'category'=>'dimensions:width=60,height=45',
            'youth'=>'dimensions:width=60,height=45',
            'badge_3k'=>'dimensions:width=80,height=60',
            'badge_5k'=>'dimensions:width=80,height=60',
            'badge_10k'=>'dimensions:width=80,height=60',
            'badge_21k'=>'dimensions:width=80,height=60',
            'badge_42k'=>'dimensions:width=80,height=60',
            'ultra_merathon'=>'dimensions:width=80,height=60',
            'BadgeConsistency2019'=>'dimensions:width=80,height=60',
            'BadgeSuperConsistent'=>'dimensions:width=80,height=60',
            'BadgeConsistency2020'=>'dimensions:width=80,height=60',
            'ThreeYearBadge'=>'dimensions:width=80,height=60',
            'ClassicQuest'=>'dimensions:width=80,height=60',
            'Chasing5KQuest'=>'dimensions:width=80,height=60',
            'pledgeCampaignBadg'=>'dimensions:width=80,height=60',

            'medalEvent'=>'dimensions:width=30,height=17',
            'shirtEvent'=>'dimensions:width=30,height=17',
            'kidsEvent'=>'dimensions:width=30,height=17',
            'adultEvent'=>'dimensions:width=30,height=17',
            'SilverEvent'=>'dimensions:width=30,height=17',
            'goldenEvent'=>'dimensions:width=30,height=17',
            'ClassicEvent'=>'dimensions:width=30,height=17',
            'kids_adult_Event'=>'dimensions:width=30,height=17',
            'Young_events'=>'dimensions:width=30,height=17',
            
            'adult_youth'=>'dimensions:width=30,height=17',
            'kids_youth'=>'dimensions:width=30,height=17',
        ]);

        $badge = BadgeUpload::first();


        if ($image=$request->file('youth')) {
           $uploadPath = 'assets/event_badge';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->youth = $dbUrl;
         
         }

         if ($image=$request->file('adult_youth')) {
           $uploadPath = 'assets/event_badge';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->adult_youth = $dbUrl;
         
         }
         
         if ($image=$request->file('kids_youth')) {
           $uploadPath = 'assets/event_badge';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->kids_youth = $dbUrl;
         
         }


        if ($image=$request->file('Young_events')) {
           $uploadPath = 'assets/event_badge';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->Young_events = $dbUrl;
         
         }
         
         if ($image=$request->file('kids_adult_Event')) {
           $uploadPath = 'assets/event_badge';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->kids_adult_Event = $dbUrl;
         
         }

         if ($image=$request->file('medalEvent')) {
           $uploadPath = 'assets/event_badge';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->medalEvent = $dbUrl;
         
         }
         if ($image=$request->file('shirtEvent')) {
           $uploadPath = 'assets/event_badge';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->shirtEvent = $dbUrl;
         
         }
         if ($image=$request->file('kidsEvent')) {
           $uploadPath = 'assets/event_badge';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->kidsEvent = $dbUrl;
         
         }
         if ($image=$request->file('adultEvent')) {
           $uploadPath = 'assets/event_badge';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->adultEvent = $dbUrl;
         
         }
         if ($image=$request->file('SilverEvent')) {
           $uploadPath = 'assets/event_badge';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->SilverEvent = $dbUrl;
         
         }
         if ($image=$request->file('goldenEvent')) {
           $uploadPath = 'assets/event_badge';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->goldenEvent = $dbUrl;
         
         }
         if ($image=$request->file('ClassicEvent')) {
           $uploadPath = 'assets/event_badge';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->ClassicEvent = $dbUrl;
         
         }


        if ($image=$request->file('overall')) {
           $uploadPath = 'assets/icon_player';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $badge->overall = $dbUrl;
         
         }

          if ($image=$request->file('category')) {

          

           $uploadPath = 'assets/icon_player';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);

           $badge->category = $dbUrl;
         
        }if ($image=$request->file('badge_3k')) {
          
           $uploadPath = 'assets/icon_player';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);

           $badge->badge_3k = $dbUrl;
         
        }if ($image=$request->file('badge_5k')) {
          
           $uploadPath = 'assets/icon_player';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);

           $badge->badge_5k = $dbUrl;
         
        }
        if ($image=$request->file('badge_10k')) {
          
           $uploadPath = 'assets/icon_player';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);

           $badge->badge_10k = $dbUrl;
         
        }if ($image=$request->file('badge_21k')) {
        
        $uploadPath = 'assets/icon_player';

        $file_name = time()."-".$image->getClientOriginalName();
        $dbUrl = $uploadPath."/".$file_name;

        $image->move($uploadPath,$dbUrl);

        $badge->badge_21k = $dbUrl;

        }if ($image=$request->file('badge_42k')) {
        
            $uploadPath = 'assets/icon_player';

            $file_name = time()."-".$image->getClientOriginalName();
            $dbUrl = $uploadPath."/".$file_name;

            $image->move($uploadPath,$dbUrl);

            $badge->badge_42k = $dbUrl;

        }if ($image=$request->file('ultra_merathon')) {
              
               $uploadPath = 'assets/icon_player';
               
               $file_name = time()."-".$image->getClientOriginalName();
               $dbUrl = $uploadPath."/".$file_name;
           
               $image->move($uploadPath,$dbUrl);

             $badge->ultra_merathon = $dbUrl;
             
            }


          if ($image=$request->file('BadgeConsistency2019')) {
            
            $uploadPath = 'assets/icon_player';

            $file_name = time()."-".$image->getClientOriginalName();
            $dbUrl = $uploadPath."/".$file_name;

            $image->move($uploadPath,$dbUrl);

            $badge->BadgeConsistency2019 = $dbUrl;

        }if ($image=$request->file('BadgeSuperConsistent')) {
              
               $uploadPath = 'assets/icon_player';
               
               $file_name = time()."-".$image->getClientOriginalName();
               $dbUrl = $uploadPath."/".$file_name;
           
               $image->move($uploadPath,$dbUrl);

             $badge->BadgeSuperConsistent = $dbUrl;
             
            }


        if ($image=$request->file('BadgeConsistency2020')) {
            
            $uploadPath = 'assets/icon_player';

            $file_name = time()."-".$image->getClientOriginalName();
            $dbUrl = $uploadPath."/".$file_name;

            $image->move($uploadPath,$dbUrl);

            $badge->BadgeConsistency2020 = $dbUrl;

        }if ($image=$request->file('ThreeYearBadge')) {
              
               $uploadPath = 'assets/icon_player';
               
               $file_name = time()."-".$image->getClientOriginalName();
               $dbUrl = $uploadPath."/".$file_name;
           
               $image->move($uploadPath,$dbUrl);

             $badge->ThreeYearBadge = $dbUrl;
             
            }

            if ($image=$request->file('ClassicQuest')) {
            
            $uploadPath = 'assets/icon_player';

            $file_name = time()."-".$image->getClientOriginalName();
            $dbUrl = $uploadPath."/".$file_name;

            $image->move($uploadPath,$dbUrl);

            $badge->ClassicQuest = $dbUrl;

        }if ($image=$request->file('Chasing5KQuest')) {
              
               $uploadPath = 'assets/icon_player';
               
               $file_name = time()."-".$image->getClientOriginalName();
               $dbUrl = $uploadPath."/".$file_name;
           
               $image->move($uploadPath,$dbUrl);

             $badge->Chasing5KQuest = $dbUrl;
             
            }

         if ($image=$request->file('pledgeCampaignBadg')) {
              
               $uploadPath = 'assets/icon_player';
               
               $file_name = time()."-".$image->getClientOriginalName();
               $dbUrl = $uploadPath."/".$file_name;
           
               $image->move($uploadPath,$dbUrl);

             $badge->pledgeCampaignBadg = $dbUrl;
             
            }   

        if($badge->update()){
            return redirect()->back()->with('success_message','Badge updated successfully!');
        }
    }

}

