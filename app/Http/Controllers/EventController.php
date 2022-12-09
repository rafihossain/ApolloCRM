<?php

namespace App\Http\Controllers;

use App\OldEvent;
use Illuminate\Http\Request;
use Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Event;
use App\EventGallery;
use App\Event_gallerie;
use DB;
use App\EventInformation;
use App\Event_information;
use App\EventMovie;
use App\PastEvent;
use App\Athlete;
use App\Team;
use App\Partner;
use App\Follow;
use App\AwardsPrize;
use App\EventDate;
use App\EventTime;
use App\EventWeekDay;
use App\EventLocation;
use App\Setting;
use App\Log;
use App\OverallRanking;
use App\EventRanking;
use App\AthleteLog;
use App\Location;
use App\Age_group;
use App\SetOverallRanking;
use App\ScheduleHeader;
use App\Record;
use App\BadgeUpload;
use App\InternationalAthlete;
class EventController extends Controller
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

    public function event_create_form(){
        $key = '';
        $settings = Setting::all();
        foreach($settings as $s){
        if($s->column_name=='API KEY'){
            $key = $s->value;
        }
        }
        
        return view('admin.event.event_create',['key'=>$key]);
    }
    public function past_event_create_form(){
        return view('admin.event.past_event_create');
    }
    public function import_past_csv_form_submit(Request $request)
    {
        $validateData = $request->validate([
            'event'=>'required',
            'event_csv' =>'required'
        ]);
        if($request->file('event_csv')){
            $csv_file = $request->file('event_csv');
            $errorCsv = $this->erroCsvToArray($csv_file);
            if(COUNT($errorCsv)>0){
                $events = OldEvent::all();
                return view('admin.event.import_past_csv',['events'=>$events,'header_error'=>$errorCsv]);
            }
            $customerArr = $this->csvToArray($csv_file);
        }
        $event = OldEvent::where('id',$request->event)->first();
        if($event->event_date!=date('Y-m-d',strtotime($customerArr[3]['Event Date']))){
            $events = OldEvent::all();
            return view('admin.event.import_past_csv',['events'=>$events,'date_error'=>'Event date and csv event date are not same.']);
        }
        if($request->file('event_csv')){
            $table = "eventdata_".$event->event_year.'s';
            $model = "App\\"."eventdata_".$event->event_year;
            $age_group_athlete = Age_group::where('type',0)->get();
            $age_athlete = array();
            foreach($age_group_athlete as $age){
                $age_athlete[] = $age->group_title;
            }
            $age_group_kids = Age_group::where('type',1)->get();
            $age_kids = array();
            foreach($age_group_kids as $age){
                $age_kids[] = $age->group_title;
            }
            if(Schema::hasTable($table)){

                $check_data = $model::where('event_name',$customerArr[0]['Event Name'])->get();
                if($check_data->count()>0){
                    return redirect()->route('event.import_past_csv_form')->with('error_message','The csv data is already exists');
                }
                foreach($customerArr as $c) {
                    if ($c['Event Name'] != '') {
                        $event_data = new $model;
                        $event_data->event_name = $c['Event Name'];
                        $event_data->event_id = $event->id;
                        $event_data->event_date = date('Y-m-d',strtotime($c['Event Date']));
                        $event_data->overall_rank = $c['Overall Rank'];
                        $event_data->category_rank = $c['Category Rank'];
                        $event_data->bib = $c['Bib #'];
                        $event_data->athlete = $c['Athlete'];
                        $event_data->age_category = $c['Age Category'];
                        $event_data->distance = $c['Distance'];
                        $event_data->speed = $c['Speed'];
                        $event_data->time = $c['Time'];
                        $event_data->points = $c['Points'];
                        if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_athlete)){
                            $event_data->age_type = 0;
                        }
                        else if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_kids)){
                            $event_data->age_type = 1;
                        }
                        $event_data->dob = $c['DOB'];
                        $event_data->created = date('Y-m-d');
                        $event_data->updated = date('Y-m-d');
                        $event_data->save();
                    }
                }
            }else
            {
                Schema::create($table, function (Blueprint $table) {
                    $table->increments('id');
                    $table->Integer('event_id');
                    $table->date('event_date');
                    $table->string('event_name', 250);
                    $table->Integer('overall_rank');
                    $table->Integer('category_rank');
                    $table->string('bib', 50);
                    $table->string('athlete', 250);
                    $table->string('age_category', 50);
                    $table->string('distance', 50);
                    $table->string('speed', 50);
                    $table->string('time', 50);
                    $table->Integer('points');
                    $table->Integer('age_type');
                    $table->string('dob', 50)->nullable();
                    $table->string('created', 50);
                    $table->string('updated', 50);
                    $table->timestamps();
                });
//                Artisan::call('make:model '.str_replace('s','',$table));
                foreach($customerArr as $c){
                    if ($c['Event Name'] != '')
                    {
                        $max_date = $model::max('event_date');
                        $past_overall_rank = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->first();
                        $event_data = new $model;
                        $event_data->event_name = $c['Event Name'];
                        $event_data->event_id = $event->id;
                        $event_data->event_date = date('Y-m-d',strtotime($c['Event Date']));
                        $event_data->overall_rank = $c['Overall Rank'];
                        $event_data->category_rank = $c['Category Rank'];
                        $event_data->bib = $c['Bib #'];
                        $event_data->athlete = $c['Athlete'];
                        $event_data->age_category = $c['Age Category'];
                        $event_data->distance = $c['Distance'];
                        $event_data->speed = $c['Speed'];
                        $event_data->time = $c['Time'];
                        $event_data->points = $c['Points'];
                        if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_athlete)){
                            $event_data->age_type = 0;
                        }
                        else if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_kids)){
                            $event_data->age_type = 1;
                        }
                        $event_data->dob = $c['DOB'];
                        $event_data->created = date('Y-m-d');
                        $event_data->updated = date('Y-m-d');
                        $event_data->save();
                    }
                }
            }
        }
        return redirect()->route('event.import_past_csv_form')->with('success_message','CSV file uploaded successfully!');
    }
    public function import_past_csv_form(){
        $events = OldEvent::all();
        return view('admin.event.import_past_csv',['events'=>$events]);
    }
    public function past_event_create_form_submit(Request $request)
    {

       

        if($request->file('event_csv')){
            $csv_file = $request->file('event_csv');
            $errorCsv = $this->erroCsvToArray($csv_file);
            if(COUNT($errorCsv)>0){
                return view('admin.event.event_past_create',['header_error'=>$errorCsv]);
            }
            $customerArr = $this->csvToArray($csv_file);

            if(date('Y-m-d',strtotime($request->event_date))!=date('Y-m-d',strtotime($customerArr[3]['Event Date']))){
                return view('admin.event.event_past_create',['date_error'=>'Event date and csv event date are not same.']);
            }
        }

        $event = new OldEvent();
        $event->event_name = $request->event_name;
        $event->event_year = $request->event_year;
        $event->event_date = date('Y-m-d',strtotime($request->event_date));
        $event->link = $request->link;
        if($request->registration_link){
            $event->registration_link = $request->registration_link;
        }
        if($request->event_distance){
            $event->event_distance = $request->event_distance;
        }
        if($request->registration_button_text){
            $event->registration_button_text = $request->registration_button_text;
        }
        if($request->result_button_text){
            $event->result_button_text = $request->result_button_text;
        }
        if($request->button_text_color){
            $event->button_text_color = $request->button_text_color;
        }
        $event->event_type = $request->event_type;

        if($event->save()){
            if($request->file('event_csv')){
                $table = "eventdata_".$event->event_year.'s';
                $model = "App\\"."eventdata_".$event->event_year;
                $age_group_athlete = Age_group::where('type',0)->get();
                $age_athlete = array();
                foreach($age_group_athlete as $age){
                    $age_athlete[] = $age->group_title;
                }
                $age_group_kids = Age_group::where('type',1)->get();
                $age_kids = array();
                foreach($age_group_kids as $age){
                    $age_kids[] = $age->group_title;
                }
                if(Schema::hasTable($table)){

                    $check_data = $model::where('event_name',$customerArr[0]['Event Name'])->get();
                    if($check_data->count()>0){
                        return redirect()->route('event.past_event_create_form')->with('error_message','The csv data is already exists');
                    }
                    foreach($customerArr as $c) {
                        if ($c['Event Name'] != '') {
                            $event_data = new $model;
                            $event_data->event_name = $c['Event Name'];
                            $event_data->event_id = $event->id;
                            $event_data->event_date = date('Y-m-d',strtotime($c['Event Date']));
                            $event_data->overall_rank = $c['Overall Rank'];
                            $event_data->category_rank = $c['Category Rank'];
                            $event_data->bib = $c['Bib #'];
                            $event_data->athlete = $c['Athlete'];
                            $event_data->age_category = $c['Age Category'];
                            $event_data->distance = $c['Distance'];
                            $event_data->speed = $c['Speed'];
                            $event_data->time = $c['Time'];
                            $event_data->points = $c['Points'];
                            if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_athlete)){
                                $event_data->age_type = 0;
                            }
                            else if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_kids)){
                                $event_data->age_type = 1;
                            }
                            $event_data->dob = $c['DOB'];
                            $event_data->created = date('Y-m-d');
                            $event_data->updated = date('Y-m-d');
                            $event_data->save();
                        }
                    }
                }else
                {
                    Schema::create($table, function (Blueprint $table) {
                        $table->increments('id');
                        $table->Integer('event_id');
                        $table->date('event_date');
                        $table->string('event_name', 250);
                        $table->Integer('overall_rank');
                        $table->Integer('category_rank');
                        $table->string('bib', 50);
                        $table->string('athlete', 250);
                        $table->string('age_category', 50);
                        $table->string('distance', 50);
                        $table->string('speed', 50);
                        $table->string('time', 50);
                        $table->Integer('points');
                        $table->Integer('age_type');
                        $table->string('dob', 50)->nullable();
                        $table->string('created', 50);
                        $table->string('updated', 50);
                        $table->timestamps();
                    });
//                    Artisan::call('make:model '.str_replace('s','',$table));
                    foreach($customerArr as $c){
                        if ($c['Event Name'] != '')
                        {
                            $max_date = $model::max('event_date');
                            $past_overall_rank = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->first();
                            $event_data = new $model;
                            $event_data->event_name = $c['Event Name'];
                            $event_data->event_id = $event->id;
                            $event_data->event_date = date('Y-m-d',strtotime($c['Event Date']));
                            $event_data->overall_rank = $c['Overall Rank'];
                            $event_data->category_rank = $c['Category Rank'];
                            $event_data->bib = $c['Bib #'];
                            $event_data->athlete = $c['Athlete'];
                            $event_data->age_category = $c['Age Category'];
                            $event_data->distance = $c['Distance'];
                            $event_data->speed = $c['Speed'];
                            $event_data->time = $c['Time'];
                            $event_data->points = $c['Points'];
                            if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_athlete)){
                                $event_data->age_type = 0;
                            }
                            else if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_kids)){
                                $event_data->age_type = 1;
                            }
                            $event_data->dob = $c['DOB'];
                            $event_data->created = date('Y-m-d');
                            $event_data->updated = date('Y-m-d');
                            $event_data->save();
                        }
                    }
                }
            }
            return redirect()->route('event.past_event_create_form')->with('success_message','Past event created successfully!');
        }else{
            return redirect()->route('event.past_event_create_form')->with('success_message','Past Event created failed!');
        }
    }
   public function event_create_form_submit(Request $request){
        
        //  echo '<pre>';
        // print_r($request->all());
        // die();
        
        
         if($request->file('event_csv')){
            $csv_file = $request->file('event_csv');
            $errorCsv = $this->erroCsvToArray($csv_file);
            if(count($errorCsv)>0){
                return view('admin.event.event_create',['header_error'=>$errorCsv]);
            }
            $customerArr = $this->csvToArray($csv_file);
             if(date('Y-m-d',strtotime($request->event_date))!=date('Y-m-d',strtotime($customerArr[3]['Event Date']))){
                 return view('admin.event.event_create',['date_error'=>'Event date and csv event date are not same.']);
             }
        }

        $event = new Event();
        //rakesh 
        $event->event_badge_shirt = $request->event_badge_shirt;
        $event->event_badge_medals = $request->event_badge_medals;
        $event->event_badge_type = $request->event_badge_type;

        $event->event_badge =$request->event_badge;
        $event->award_prize_show =$request->award_prize_show;
        $event->event_location_show =$request->event_location_show;
        $event->event_schedule_status =$request->event_schedule_status;
        $event->event_name = $request->event_name;
        $event->event_year = $request->event_year;
        $event->event_date = date('Y-m-d',strtotime($request->event_date));
        $event->link = $request->link;
        if($request->registration_link){
            $event->registration_link = $request->registration_link;
        }
        if($request->event_distance){
            $event->event_distance = $request->event_distance;
        }
        if($request->registration_button_text){
            $event->registration_button_text = $request->registration_button_text;
        }
        if($request->result_button_text){
            $event->result_button_text = $request->result_button_text;
        }
        if($request->button_text_color){
            $event->button_text_color = $request->button_text_color;
        }
        $event->winners_image_status = $request->winners_image_status;
        $event->banner_image_status = $request->banner_image_status;
        $event->schedule_status = $request->schedule_status;
        $event->coursemap_status = $request->course_image_status;
        $event->event_gallery_status = $request->gallery_status;
        $event->event_information_status = $request->information_status;
        $event->event_movies_status = $request->movie_status;
        $event->past_events_status = $request->past_events_status;
        $event->race_records_status = $request->race_record_status;
        $event->schedule_clickable = $request->schedule_clickable;
        $event->button_show = $request->button_show;
        $event->result_button_status = $request->result_button;
        $event->event_show = $request->event_show;
        if(empty($event->result_button_status)){
            $event->result_button_status = 1;
        }
        // $event->schedule = $request->schedule_date.' '.$request->schedule_time;
        $event->type = $request->event_type;
        //banner image
        $banner_file = $request->file('banner_image');
        $banner_filename = time().'-'.$banner_file->getClientOriginalName();
        $banner_file->move("banner_images/",$banner_filename);
        $filepath = "banner_images/".$banner_filename;
        $event->event_banner_image = $filepath;

       //winner image
       $winner_file = $request->file('event_winners');
       $winner_file_name = time().'-'.$winner_file->getClientOriginalName();
       $winner_file->move("event_winners_image/",$winner_file_name);
       $filepath = "event_winners_image/".$winner_file_name;
       $event->event_winners_image = $filepath;

        //coursemap image
        $coursemap_file = $request->file('coursemap_image');
        $coursemap_filename = time().'-'.$coursemap_file->getClientOriginalName();
        $coursemap_file->move("coursemap_image/",$coursemap_filename);
        $filepath = "coursemap_image/".$coursemap_filename;
        $event->event_coursemap_image = $filepath;

        //racerecords image
        $racerecords_file = $request->file('racerecords_image');
        $racerecords_filename = time().'-'.$racerecords_file->getClientOriginalName();
        $racerecords_file->move("racerecords_image/",$racerecords_filename);
        $filepath = "racerecords_image/".$racerecords_filename;
        $event->race_records = $filepath;

        //event logo
        $logo_file = $request->file('event_logo');
        $logo_filename = time().'-'.$logo_file->getClientOriginalName();
        $logo_file->move("event_logo/",$logo_filename);
        $filepath = "event_logo/".$logo_filename;
        $event->event_logo = $filepath;
        
        //slider event logo
        $logo_file = $request->file('slider_event_logo');
        $logo_filename = time().'-'.$logo_file->getClientOriginalName();
        $logo_file->move("slider_event_logo/",$logo_filename);
        $filepath = "slider_event_logo/".$logo_filename;
        $event->slider_event_logo = $filepath;
        if($event->save()){


            //past result start
            $past_results = array();
            if($request->past_result_file) {
                $past_result_files = $request->past_result_file;
                foreach ($past_result_files as $key=>$past_result_file) {
                    $p_r_f = $past_result_file['past_result_file'];
                    $filename = time().'-'.$p_r_f->getClientOriginalName();
                    $p_r_f->move('past_event_image/',$filename);
                    $p_r_f_path = 'past_event_image/'.$filename;
                    $past_results[$key]['past_event_image'] = $p_r_f_path;
                }
            }
            if($request->past_result_bg_image) {
                $past_result_bg_images = $request->past_result_bg_image;
                foreach ($past_result_bg_images as $key=>$past_result_bg_image) {
                    $p_r_bg_img = $past_result_bg_image['past_result_bg_image'];
                    $filename = time().'-'.$p_r_bg_img->getClientOriginalName();
                    $p_r_bg_img->move('result_bg_image/',$filename);
                    $p_r_bg_img_path = 'result_bg_image/'.$filename;
                    $past_results[$key]['past_result_bg_image'] = $p_r_bg_img_path;
                }
            }
            if($request->past_result_link) {
                $past_result_links = $request->past_result_link;
                foreach ($past_result_links as $key=>$past_result_link) {
                    $past_results[$key]['past_result_link'] = $past_result_link['past_result_link'];
                }
            }
            if (!empty($past_results))
            {
                $o = 1;
                foreach ($past_results as $key=>$past_result)
                {
                    $past = array();
                    if (isset($past_result['past_event_image']) && isset($past_result['past_result_link']))
                    {
                        $past['event_id'] = $event->id;
                        $past['image'] = $past_result['past_event_image'];
                        if (isset($past_result['past_result_bg_image']))
                        {
                            $past['background_image'] = $past_result['past_result_bg_image'];
                        }else{
                            $past['background_image'] = '';
                        }
                        $past['result_link'] = $past_result['past_result_link'];
                        $past['result_order'] = $o;
                        if ($past['image'] != '' && $past['result_link'] != '')
                        {
                            PastEvent::insert($past);
                        }

                    }
                }
            }
            //past result end


             // $event->id
            //location
            $data = array();
            if ($request->address_first != null || $request->address_first !='') {
              $data = new Location();
              $data['address_first'] = $request->address_first;
              $data['latitude'] = $request->latitude;
              $data['longitude'] = $request->longitude;
              $data['event_id'] = $event->id;
              $data['contract_two'] = $request->number_one;
              $data['contract_three'] = $request->number_two;
              $data['contract_one'] = $request->email;
              $data->save();
            }
            $data = array();
            //end location


            //Award
            $award = array();
            if ($request->title_award != null || $request->title_award !='') {
              $award = new AwardsPrize();
              $award->event_id = $event->id;
              $award->title = $request->title_award;
              $award->details = $request->details_award;
              if($request->file('award_image')){
                  //award image
                  $image_file = $request->file('award_image');
                  $image_filename = time().'-'.$image_file->getClientOriginalName();
                  $image_file->move("award_image/",$image_filename);
                  $filepath = "award_image/".$image_filename;
                  $award->image = $filepath;
              }

              $award->save();
            }

            $award = array();
            //end Award

            // //schedule headers
            $headers =array();

            if ( $request->Headers_online_registration  !='' && $request->Headers_event_schedule !='' && $request->Headers_cash_payment !=''  && $request->Headers_bib !='' && $request->Headers_start_event !='' && $request->Headers_award_ceremony !='' && $request->Headers_date !='' && $request->Headers_week !=''   ) {
                $headers = new ScheduleHeader();
                $headers->event_id = $event->id;
                $headers->event_schedule = $request->Headers_event_schedule;
                $headers->online_registration = $request->Headers_online_registration;
                $headers->cash_payment = $request->Headers_cash_payment;
                $headers->bib = $request->Headers_bib;
                $headers->start_event = $request->Headers_start_event;
                $headers->award_ceremony = $request->Headers_award_ceremony;
                $headers->date = $request->Headers_date;
                $headers->week = $request->Headers_week;
                $headers->time = $request->Headers_time;
                $headers->location = $request->Headers_location;
                $headers->save();
                $headers =array();
            }
            //end schedule header

            if($request->gallery_image){
                $gallery_images = $request->gallery_image;
                $j = 1;
                foreach($gallery_images as $g){
                    $gallery_file = $g['gallery_image'];
                    $filename = time().'-'.$gallery_file->getClientOriginalName();
                    $gallery_file->move('event_gallery/',$filename);
                    $filepath = "event_gallery/".$filename;
                    $gallery = new EventGallery();
                    $gallery->event_id = $event->id;
                    $gallery->image = $filepath;
                    $gallery->img_order = $j;
                    $gallery->save();
                    $j++;
                }
            }
            if($request->movie){
                $movies = $request->movie;
                foreach($movies as $m){
                    $movie_file = $m['movie'];
                    $filename = time().'-'.$movie_file->getClientOriginalName();
                    $movie_file->move('event_movie/',$filename);
                    $filepath = "event_movie/".$filename;
                    $movie = new EventMovie();
                    $movie->event_id = $event->id;
                    $movie->movies = $filepath;
                    $movie->save();
                }
            }
            if($request->youtube_link){
                $youtube_links = $request->youtube_link;
                foreach($youtube_links as $m){
                    if($m['youtube_link']!=null){
                        $youtube_lnk= $m['youtube_link'];
                        $y = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<iframe class=\"iframe_video\" width=\"980\" height=\"551.25\" class='embed-player slide-media'  src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>",$youtube_lnk);
                        $youtube = new EventMovie();
                        $youtube->event_id = $event->id;
                        $youtube->youtube_link = $y;
                        $youtube->save();
                    }
                    
                }
            }
            if($request->file('event_csv')){
                $table = "eventdata_".$event->event_year.'s';
                $model = "App\\"."eventdata_".$event->event_year;
                        $age_group_athlete = Age_group::where('type',0)->get();
                        $age_athlete = array();
                        foreach($age_group_athlete as $age){
                        $age_athlete[] = $age->group_title;
                        }
                        $age_group_kids = Age_group::where('type',1)->get();
                        $age_kids = array();
                        foreach($age_group_kids as $age){
                        $age_kids[] = $age->group_title;
                        }

                        $age_group_kids = Age_group::where('type',2)->get();
                        $age_kids = array();
                        foreach($age_group_kids as $age){
                        $age_youth[] = $age->group_title;
                        }

                        
                    
                        if(Schema::hasTable($table)){
                             $check_data = $model::where('event_name',$customerArr[0]['Event Name'])->get();
                             if($check_data->count()>0){
                                 return redirect()->route('event.event_create_form')->with('error_message','The csv data is already exists');
                             }
                         foreach($customerArr as $c){
                         $max_date = $model::max('event_date');
                         $past_overall_rank = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->first();
                         $event_data = new $model;
                         $event_data->event_name = $c['Event Name'];
                         $event_data->event_id = $event->id;
                         $event_data->event_date = date('Y-m-d',strtotime($c['Event Date']));
                         $event_data->overall_rank = $c['Overall Rank'];
                         $event_data->category_rank = $c['Category Rank'];
                         $event_data->bib = $c['Bib #'];
                         $event_data->athlete = $c['Athlete'];
                         $event_data->age_category = $c['Age Category'];
                         $event_data->distance = $c['Distance'];
                         $event_data->speed = $c['Speed'];                         
                         $event_data->time = $c['Time'];
                         $event_data->points = $c['Points'];
                         if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_athlete)){
                            $event_data->age_type = 0;
        
                         }
                         else if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_kids)){
                            $event_data->age_type = 1;
        
                         }
                         $event_data->dob = $c['DOB'];   
                         $event_data->created = date('Y-m-d');
                         $event_data->updated = date('Y-m-d');                                                                        
                         $event_data->save();

                         $check_athlete = Athlete::where('athlete_name',$c['Athlete'])->first();
                        if($check_athlete!=null){
                           // athlete
           
                        $total_ath_update_names = Athlete::where('athlete_name',$c['Athlete'])->first();
                        if($total_ath_update_names!=null){
                            $athlete_log = new AthleteLog();
                            $athlete_log->event_id = $event->id;
                            $athlete_log->athlete_name = $total_ath_update_names->athlete_name;
                            $athlete_log->event_year = date('Y',strtotime($c['Event Date']));
                            $athlete_log->age_group = $c['Age Category'];
                            $athlete_log->save();
                        }
        //end athlete
                        }
                        else{
                           $athlete = new Athlete();
                           $athlete->athlete_name = $c['Athlete'];
                           $athlete->year = $request->event_year;
                           $max_date = $model::max('event_date');
                        //    $history = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->orderBy('id','desc')->first();
                           $athlete->age_category = $c['Age Category'];
                           $total_race = $model::where('athlete',$c['Athlete'])->get()->count();
                           $athlete->total_races = $total_race;
                           $overall_wins = $model::where('athlete',$c['Athlete'])->where('overall_rank','1')->get()->count();
                           $athlete->overall_wins = $overall_wins;
                           $top3_finishes = $model::where('athlete',$c['Athlete'])->where(function($query){
                                   $query->where('overall_rank','1')->orWhere('overall_rank','2')->orWhere('overall_rank','3');
                           })->get()->count();
                           $athlete->top3_finishes = $top3_finishes;
                           $top10_finishes = $model::where('athlete',$c['Athlete'])->where(function($query){
                               $query->where('overall_rank','1')
                               ->orWhere('overall_rank','2')
                               ->orWhere('overall_rank','3')
                               ->orWhere('overall_rank','4')
                               ->orWhere('overall_rank','5')
                               ->orWhere('overall_rank','6')
                               ->orWhere('overall_rank','7')
                               ->orWhere('overall_rank','8')
                               ->orWhere('overall_rank','9')
                               ->orWhere('overall_rank','10');
                       })->get()->count();
                           $athlete->top10_finishes = $top10_finishes;
                           $category_wins = $model::where('athlete',$c['Athlete'])->where('category_rank','1')->get()->count();
                           $athlete->category_wins = $category_wins;
                           $max_date = $model::max('event_date');
                           $current_overall_rank = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->first();                          
                           $athlete->current_overall_rank = $c['Overall Rank'];
                           $athlete->current_category_rank =  $c['Category Rank'];
                           $total_events = $model::groupBy('event_id')->get()->count();
                            if($event->event_year>=2020){
                                $principle = 1/2;
                            }
                            else{
                                $principle = 2/3;
                            }
                           $highest_events = round($principle*$total_events);
                           $athlete_event_points = $model::where('athlete',$c['Athlete'])->orderBy('points','desc')->get()->take($highest_events);
                           $points = 0;
                           foreach($athlete_event_points as $p){
                               $points+=$p->points;
                           }
                           $athlete->mrp = $points/$highest_events;
                           $athlete->arp = ($points/$highest_events)*$highest_events;
                           if($past_overall_rank!=null){
                                $overall_status = $past_overall_rank->overall_rank-$current_overall_rank->overall_rank;
                             $category_status = $past_overall_rank->category_rank-$current_overall_rank->category_rank;
                             
                                $check_athlete->current_overall_rank_status = $overall_status;
                                $check_athlete->current_category_rank_status = $category_status;
                            }
                           $athlete->save();

                        }
                         
                     }
                    
                }
                else{
                    Schema::create($table, function (Blueprint $table) {
                        $table->increments('id');
                        $table->Integer('event_id');
                        $table->date('event_date');
                        $table->string('event_name', 250);
                        $table->Integer('overall_rank');
                        $table->Integer('category_rank');
                        $table->string('bib', 50);
                        $table->string('athlete', 250);
                        $table->string('age_category', 50);
                        $table->string('distance', 50);
                        $table->string('speed', 50);
                        $table->string('time', 50);
                        $table->Integer('points');
                        $table->Integer('age_type');
                        $table->string('dob', 50)->nullable();
                        $table->string('created', 50);
                        $table->string('updated', 50);
                        $table->timestamps();
                    });
                    Artisan::call('make:model '.str_replace('s','',$table));
                     foreach($customerArr as $c){
                        $max_date = $model::max('event_date');
                            $past_overall_rank = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->first();
                         $event_data = new $model;
                         $event_data->event_name = $c['Event Name'];
                         $event_data->event_id = $event->id;
                         $event_data->event_date = date('Y-m-d',strtotime($c['Event Date']));
                         $event_data->overall_rank = $c['Overall Rank'];
                         $event_data->category_rank = $c['Category Rank'];
                         $event_data->bib = $c['Bib #'];
                         $event_data->athlete = $c['Athlete'];
                         $event_data->age_category = $c['Age Category'];
                         $event_data->distance = $c['Distance'];
                         $event_data->speed = $c['Speed'];                         
                         $event_data->time = $c['Time'];
                         $event_data->points = $c['Points'];
                         if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_athlete)){
                            $event_data->age_type = 0;
        
                         }
                         else if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_kids)){
                            $event_data->age_type = 1;
        
                         }
                         else if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_youth)){
                            $event_data->age_type = 2;
        
                         }

                         $event_data->dob = $c['DOB'];    
                         $event_data->created = date('Y-m-d');
                         $event_data->updated = date('Y-m-d');                                                                       
                         $event_data->save();

                         $check_athlete = Athlete::where('athlete_name',$c['Athlete'])->first();
                         if($check_athlete!=null){
                           // athlete
           
                        $total_ath_update_names = Athlete::where('athlete_name',$c['Athlete'])->first();
                        if($total_ath_update_names!=null){
                            $athlete_log = new AthleteLog();
                            $athlete_log->event_id = $event->id;
                            $athlete_log->athlete_name = $total_ath_update_names->athlete_name;
                            $athlete_log->event_year = date('Y',strtotime($c['Event Date']));
                            $athlete_log->age_group = $c['Age Category'];
                            $athlete_log->save();
                        }

            
        //end athlete
                         }
                         else{
                            $athlete = new Athlete();
                            $athlete->athlete_name = $c['Athlete'];
                            $athlete->year = $request->event_year;
                            $max_date = $model::max('event_date');
                            $history = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->orderBy('id','desc')->first();
                            $athlete->age_category = $c['Age Category'];
                            $total_race = $model::where('athlete',$c['Athlete'])->get()->count();
                            $athlete->total_races = $total_race;
                            $overall_wins = $model::where('athlete',$c['Athlete'])->where('overall_rank','1')->get()->count();
                            $athlete->overall_wins = $overall_wins;
                            $top3_finishes = $model::where('athlete',$c['Athlete'])->where(function($query){
                            $query->where('overall_rank','1')->orWhere('overall_rank','2')->orWhere('overall_rank','3');
                            })->get()->count();
                            $athlete->top3_finishes = $top3_finishes;
                            $top10_finishes = $model::where('athlete',$c['Athlete'])->where(function($query){
                                $query->where('overall_rank','1')
                                ->orWhere('overall_rank','2')
                                ->orWhere('overall_rank','3')
                                ->orWhere('overall_rank','4')
                                ->orWhere('overall_rank','5')
                                ->orWhere('overall_rank','6')
                                ->orWhere('overall_rank','7')
                                ->orWhere('overall_rank','8')
                                ->orWhere('overall_rank','9')
                                ->orWhere('overall_rank','10');
                        })->get()->count();
                            $athlete->top10_finishes = $top10_finishes;
                            $category_wins = $model::where('athlete',$c['Athlete'])->where('category_rank','1')->get()->count();
                            $athlete->category_wins = $category_wins;
                            $max_date = $model::max('event_date');
                            $current_overall_rank = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->first();                          
                            $athlete->current_overall_rank = $c['Overall Rank'];
                            $athlete->current_category_rank =  $c['Category Rank'];
                            $total_events = $model::groupBy('event_id')->get()->count();
                             if($event->event_year>=2020){
                                $principle = 1/2;
                            }
                            else{
                                $principle = 2/3;
                            }
                            $highest_events = round($principle*$total_events);
                            $athlete_event_points = $model::where('athlete',$c['Athlete'])->orderBy('points','desc')->get()->take($highest_events);
                            $points = 0;
                            foreach($athlete_event_points as $p){
                                $points+=$p->points;
                            }
                            $athlete->mrp = $points/$highest_events;
                            $athlete->arp = ($points/$highest_events)*$highest_events;
                            if($past_overall_rank!=null){
                                $overall_status = $past_overall_rank->overall_rank-$current_overall_rank->overall_rank;
                             $category_status = $past_overall_rank->category_rank-$current_overall_rank->category_rank;
                             
                                $check_athlete->current_overall_rank_status = $overall_status;
                                $check_athlete->current_category_rank_status = $category_status;
                            }
                            $athlete->save();
 
                         }
                     }
                    
                }

                    $total_athlete_logs = AthleteLog::all()->count();
                    $total_team_logs = Team::all()->count();
                    $logs = Log::first();
                    $logs->total_athletes_queue = $total_athlete_logs;
                    $logs->total_teams_queue = $total_team_logs;
                    $logs->save();
                
                //Overall ranking
                    $over = OverallRanking::where('event_id',$event->id)->get()->count();
                    if($over==0){
                    $this->overall_rankings($event->id);
                        DB::table('overall_events')->insert(['event_id'=>$event->id]);
                        DB::table('age_wise_events')->insert(['event_id'=>$event->id]);
                        DB::table('overall_ranking_updates')->insert(['event_id'=>$event->id]);
                    }


                    //Event ranking  
                    $event_rk = EventRanking::where('event_id',$event->id)->get()->count();
                    if($event_rk==0){
                    $this->event_rankings($event->id);
                    }

            }
            return redirect()->route('event.event_create_form')->with('success_message','Event created successfully!');
        }
    }

public function csvToArray($filename = '', $delimiter = ',')
{
    
    if (!file_exists($filename) || !is_readable($filename))
    return false;

    $header = null;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== false)
    {
        
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
        {
            if (!$header){
                $header = $row;
            }
            else{
                $data[] = array_combine($header, $row);
            }
                
        }
        fclose($handle);
    }
    return $data;


}
public function erroCsvToArray($filename = '', $delimiter = ',')
{
    
        if (!file_exists($filename) || !is_readable($filename))
        return false;

    $header = null;
    $data = array();
    $header_error = array();
    if(count(fgetcsv(fopen($filename, 'r'), 1000, $delimiter))!=12){
         $header_error[]='Column number is greater than or less than the correct csv format.';

    }
    if (($handle = fopen($filename, 'r')) !== false)
    {
        
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
        {
            if (!$header){
                $header = $row;
                if(!in_array("Event Date",$header)){
                    $header_error[]="'Event Date' column is mission in csv";
                }
                if(!in_array("Event Name",$header)){
                    $header_error[]="'Event Name' column is mission in csv";
                }
                if(!in_array("Overall Rank",$header)){
                    $header_error[]="'Overall Rank' column is mission in csv";
                }
                if(!in_array("Category Rank",$header)){
                    $header_error[]="'Category Rank' column is mission in csv";
                }
                if(!in_array("Bib #",$header)){
                    $header_error[]="'Bib #' column is mission in csv";
                }
                if(!in_array("Athlete",$header)){
                    $header_error[]="'Athlete' column is mission in csv";
                }
                if(!in_array("Age Category",$header)){
                    $header_error[]="'Age Category' column is mission in csv";
                }
                if(!in_array("Distance",$header)){
                    $header_error[]="'Distance' column is mission in csv";
                }
                if(!in_array("Speed",$header)){
                    $header_error[]="'Speed' column is mission in csv";
                }
                if(!in_array("Time",$header)){
                    $header_error[]="'Time' column is mission in csv";
                }
                if(!in_array("Points",$header)){
                    $header_error[]="'Points' column is mission in csv";
                }
                if(!in_array("DOB",$header)){
                    $header_error[]="'DOB' column is mission in csv";
                }
            }
                
        }
        fclose($handle);
    }
    return $header_error;

}

public function event_info_create_form(){    
    $events = Event::all();
    return view('admin.event.event_info_create',['events'=>$events]);
}

public function event_info_create_form_submit(Request $request){
    $validateData = $request->validate([
        'event'=> 'required',
        'title'=> 'required',
        'description'=> 'required',
        'image' =>'required | mimes:jpeg,jpg,png'
    ]);
    $event_info = new EventInformation();
    $event_info->title = $request->title;
    $event_info->event_id = $request->event;
    $event_info->description = $request->description;
    $file = $request->file('image');
    $filename = time().'-'.$file->getClientOriginalName();
    $file->move('event_info_image/',$filename);
    $filepath = 'event_info_image/'.$filename;
    $event_info->image = $filepath;
    if($event_info->save()){
        return redirect()->route('event.event_info_create_form')->with('success_message','Event Info created successfully');
    }
    else{
    
        return redirect()->route('event.event_info_create_form')->with('error_message','Error to create Event Info');
    }
}

public function event_past_create_form(){
    $events = Event::where('type','!=',2)->get();
    return view('admin.event.event_past_create',['events'=>$events]);
}

public function event_past_create_form_submit(Request $request){
    $validateData = $request->validate([
        'event'=>'required',
        'image' =>'required | mimes:jpeg,jpg,png',
        'background_image'=>'required | dimensions:width=1350,height=497',
        'result_link' => 'required|url'
    ]);
    /*$check_event = PastEvent::where('event_id',$request->event)->first();
    if($check_event!=null){
         return redirect()->route('event.event_past_create_form')->with('error_message','The event result is already exists');   
    }*/
    $past_event = new PastEvent();
    $past_event->event_id = $request->event;
    //image
    $file = $request->file('image');
    $filename = time().'-'.$file->getClientOriginalName();
    $file->move('past_event_image/',$filename);
    $filepath1 = 'past_event_image/'.$filename;
    $past_event->image = $filepath1;
    //background image
    $file = $request->file('background_image');
    $filename = time().'-'.$file->getClientOriginalName();
    $file->move('result_bg_image/',$filename);
    $filepath1 = 'result_bg_image/'.$filename;
    $past_event->background_image = $filepath1;
    $past_event->result_link = $request->result_link;
    if($past_event->save()){
        return redirect()->route('event.event_past_create_form')->with('success_message','Past Result added successfully');
    }
    else{
        return redirect()->route('event.event_past_create_form')->with('error_message','Error to add Past Result');
    }
}

public function import_csv_form(){
    $events = Event::where('type','!=',2)->get();
    return view('admin.event.import_csv',['events'=>$events]);
}
public function import_international_csv_form()
    {
        return view('admin.event.import_international_csv');
    }
    public function import_international_csv_form_submit(Request $request)
    {
        $validateData = $request->validate([
            'international_athlete_csv' =>'required'
        ]);
        if($request->file('international_athlete_csv')){
            $csv_file = $request->file('international_athlete_csv');
            $errorCsv = $this->errorInternationalCsvToArray($csv_file);
            if(COUNT($errorCsv)>0){
                return view('admin.event.import_international_csv',['header_error'=>$errorCsv]);
            }
            $customerArr = $this->csvToArray($csv_file);
        }
        if (!empty($customerArr))
        {
            foreach($customerArr as $c)
            {
                $name = $c['Athlete'];
                if (!empty($name))
                {
                    $exist = InternationalAthlete::where('athlete',$name)->first();
                    if (empty($exist))
                    {
                        DB::table('international_athletes')->insert(['athlete'=>$name]);
                    }
                }
            }
        }
        return redirect()->route('event.import_international_csv_form')->with('success_message','Successfully Imported International Athlete data');

    }
    public function errorInternationalCsvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;
        $header = null;
        $data = array();
        $header_error = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {

            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header){
                    $header = $row;
                    if(!in_array("Athlete",$header)){
                        $header_error[]="'Athlete' column is mission in csv";
                    }
                }

            }
            fclose($handle);
        }
        return $header_error;

    }
public function athlelte_update_from_log(){
    $athletes = AthleteLog::all();
    if($athletes->count()>0){
        foreach($athletes as $a){
    /*//Overall ranking
            $over = OverallRanking::where('event_id',$a->event_id)->get()->count();
            if($over==0){
                $this->overall_rankings($a->event_id);
            }

        
        //Event ranking  
            $event_rk = EventRanking::where('event_id',$a->event_id)->get()->count();
            if($event_rk==0){
                $this->event_rankings($a->event_id);
            }*/
        $check_athlete = Athlete::where('athlete_name',$a->athlete_name)->first();        
        $check_athlete->year = $a->event_year;
        $check_athlete->age_category = $a->age_group;
        $model = 'App\\'.'eventdata_'.$a->event_year;
        $total_race = $model::where('athlete',$a->athlete_name)->get()->count();
        $check_athlete->total_races = $total_race;
        $overall_wins = $model::where('athlete',$a->athlete_name)->where('overall_rank','1')->get()->count();
        $check_athlete->overall_wins = $overall_wins;
        $top3_finishes = $model::where('athlete',$a->athlete_name)->where(function($query){
        $query->where('overall_rank','1')->orWhere('overall_rank','2')->orWhere('overall_rank','3');
        })->get()->count();
        $check_athlete->top3_finishes = $top3_finishes;
        $top10_finishes = $model::where('athlete',$a->athlete_name)->where(function($query){
            $query->where('overall_rank','1')
            ->orWhere('overall_rank','2')
            ->orWhere('overall_rank','3')
            ->orWhere('overall_rank','4')
            ->orWhere('overall_rank','5')
            ->orWhere('overall_rank','6')
            ->orWhere('overall_rank','7')
            ->orWhere('overall_rank','8')
            ->orWhere('overall_rank','9')
            ->orWhere('overall_rank','10');
    })->get()->count();
    $max_date = $model::max('event_date');
    $past_overall_rank = $model::where('athlete',$a->athlete_name)->where('event_id',$a->event_id)->first();
        
    if($past_overall_rank!=null){
        $overall_status = $past_overall_rank->overall_rank-$check_athlete->current_overall_rank;
        $category_status = $past_overall_rank->category_rank-$check_athlete->current_category_rank;         
        $check_athlete->current_overall_rank_status = $overall_status;
        $check_athlete->current_category_rank_status = $category_status;
    }
        $check_athlete->top10_finishes = $top10_finishes;
        $category_wins = $model::where('athlete',$a->athlete_name)->where('category_rank','1')->get()->count();
        $check_athlete->category_wins = $category_wins;
        $current_overall_rank = $model::where('athlete',$a->athlete_name)->where('event_id',$a->event_id)->first();
        $check_athlete->current_overall_rank = $current_overall_rank->overall_rank;
        $check_athlete->current_category_rank =  $current_overall_rank->category_rank;
        $total_events = $model::groupBy('event_id')->get()->count();
         if($a->event_year>=2020){
             $principle = 1/2;
         }
            else{
                $principle = 2/3;
            }   
        $highest_events = round($principle*$total_events);
        $athlete_event_points = $model::where('athlete',$a->athlete_name)->orderBy('points','desc')->get()->take($highest_events);
            
        $points = 0;
        foreach($athlete_event_points as $p){
            $points+=$p->points;
        }
        $check_athlete->mrp = $points/$highest_events;
        $check_athlete->arp = ($points/$highest_events)*$highest_events;
            if($check_athlete->save()){
                $log = Log::first();
                $log->total_athletes_queue-=1;
                $log->save();
                $a->delete();
            }

        }
        

             
            // Team update
            $log = Log::first();
            if($log->total_teams_queue>0){
                $teams = Team::all();                                             
            if($teams->count()>0){
                foreach($teams as $t){
                   $year2 = array(); 
                   $sum_overall = 0;
                   $sum_category = 0;
                   $last2 = Team::where('id',$t->id)->first();
                   
              $team_members_show = json_decode($last2['team_members']);
    
              $key = in_array($last2['captain'], $team_members_show);
    
              if ($key == FALSE && $last2['captain']!=0) {
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
                    $blue_jersey += DB::table($value)->where('overall_rank', 1)->orWhere('age_category', 'like', '%16-19%')->orWhere('age_category', 'like', '%U-20%')->where('athlete', $value235ff->athlete_name)->sum('overall_rank');
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
                  $log = Log::first();
                  $log->total_teams_queue-=1;
                  $log->save();
                }
                 

            }
            
            }
            
            //Team update end
            
        
        
    }
    
}
public function import_csv_form_submit(Request $request){
        
    $validateData = $request->validate([
        'event'=>'required',
        'event_csv' =>'required'
    ]);
    if($request->file('event_csv')){
        $csv_file = $request->file('event_csv');
        $errorCsv = $this->erroCsvToArray($csv_file);
        if(COUNT($errorCsv)>0){
            $events = Event::where('type','!=',2)->get();
            return view('admin.event.import_csv',['events'=>$events,'header_error'=>$errorCsv]);
        }
        $customerArr = $this->csvToArray($csv_file);
    }

    $event = Event::where('id',$request->event)->first();

    if($event->event_date!=date('Y-m-d',strtotime($customerArr[3]['Event Date']))){
        $events = Event::where('type','!=',2)->get();
        return view('admin.event.import_csv',['events'=>$events,'date_error'=>'Event date and csv event date are not same.']);
    }
    if($request->file('event_csv')){
        $table = "eventdata_".$event->event_year.'s';
        $model = "App\\"."eventdata_".$event->event_year;
        $age_group_athlete = Age_group::where('type',0)->get();
        $age_athlete = array();
        foreach($age_group_athlete as $age){
            $age_athlete[] = $age->group_title;
        }
        $age_group_kids = Age_group::where('type',1)->get();
        $age_kids = array();
        foreach($age_group_kids as $age){
            $age_kids[] = $age->group_title;
        } 

        $age_group_youth = Age_group::where('type',2)->get();
        $age_youth = array();
        foreach($age_group_youth as $age){
            $age_youth[] = $age->group_title;
        }   

        if(Schema::hasTable($table)){
        
             $check_data = $model::where('event_id',$event->id)->get();
             if($check_data->count()>0){
                 return redirect()->route('event.import_csv_form')->with('error_message','The csv data is already exists');
             }
                
             foreach($customerArr as $c){
                 $max_date = $model::max('event_date');
                 $past_overall_rank = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->first();
                 $event_data = new $model;
                 $event_data->event_name = $c['Event Name'];
                 $event_data->event_id = $event->id;
                 $event_data->event_date = date('Y-m-d',strtotime($c['Event Date']));
                 $event_data->overall_rank = $c['Overall Rank'];
                 $event_data->category_rank = $c['Category Rank'];
                 $event_data->bib = $c['Bib #'];
                 $event_data->athlete = $c['Athlete'];
                 $event_data->age_category = $c['Age Category'];
                 $event_data->distance = $c['Distance'];
                 $event_data->speed = $c['Speed'];                         
                 $event_data->time = $c['Time'];
                 $event_data->points = $c['Points'];
                 if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_athlete)){
                    $event_data->age_type = 0;

                 }
                 else if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_kids)){
                    $event_data->age_type = 1;

                 }

                 else if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_youth)){
                    $event_data->age_type = 2;

                 }

                 $event_data->dob = $c['DOB'];   
                 $event_data->created = date('Y-m-d');
                 $event_data->updated = date('Y-m-d');                                                                       
                 $event_data->save();

                $check_athlete = Athlete::where('athlete_name',$c['Athlete'])->first();
                if($check_athlete==null){
                    $athlete = new Athlete();
                    $athlete->athlete_name = $c['Athlete'];
                    $athlete->year = $event->event_year;
                    $athlete->age_category = $c['Age Category'];
                    $total_race = $model::where('athlete',$c['Athlete'])->get()->count();
                    $athlete->total_races = $total_race;
                    $overall_wins = $model::where('athlete',$c['Athlete'])->where('overall_rank','1')->get()->count();
                    $athlete->overall_wins = $overall_wins;
                    $top3_finishes = $model::where('athlete',$c['Athlete'])->where(function($query){
                            $query->where('overall_rank','1')->orWhere('overall_rank','2')->orWhere('overall_rank','3');
                    })->get()->count();
                    $athlete->top3_finishes = $top3_finishes;
                    $top10_finishes = $model::where('athlete',$c['Athlete'])->where(function($query){
                        $query->where('overall_rank','1')
                        ->orWhere('overall_rank','2')
                        ->orWhere('overall_rank','3')
                        ->orWhere('overall_rank','4')
                        ->orWhere('overall_rank','5')
                        ->orWhere('overall_rank','6')
                        ->orWhere('overall_rank','7')
                        ->orWhere('overall_rank','8')
                        ->orWhere('overall_rank','9')
                        ->orWhere('overall_rank','10');
                })->get()->count();
                    $athlete->top10_finishes = $top10_finishes;
                    $category_wins = $model::where('athlete',$c['Athlete'])->where('category_rank','1')->get()->count();
                    $athlete->category_wins = $category_wins;
                    $max_date = $model::max('event_date');
                    $current_overall_rank = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->first();                          
                    $athlete->current_overall_rank = $c['Overall Rank'];
                    $athlete->current_category_rank =  $c['Category Rank'];
                    $total_events = $model::groupBy('event_id')->get()->count();
                    if($event->event_year>=2020){
                        $principle = 1/2;
                    }
                    else{
                        $principle = 2/3;
                    }
                    $highest_events = round($principle*$total_events);
                    $athlete_event_points =                                  $model::where('athlete',$c['Athlete'])->orderBy('points','desc')->get()->take($highest_events);
                    $points = 0;
                    foreach($athlete_event_points as $p){
                        $points+=$p->points;
                    }
                    $athlete->mrp = $points/$highest_events;
                    $athlete->arp = ($points/$highest_events)*$highest_events;
                     if($past_overall_rank!=null){
                                 $overall_status = $past_overall_rank->overall_rank-$current_overall_rank->overall_rank;
                              $category_status = $past_overall_rank->category_rank-$current_overall_rank->category_rank;
                              
                                 $check_athlete->current_overall_rank_status = $overall_status;
                                 $check_athlete->current_category_rank_status = $category_status;
                             }
                    $athlete->save();
                    
                }
                else{
                    // athlete
           
            $total_ath_update_names = Athlete::where('athlete_name',$c['Athlete'])->first();
            if($total_ath_update_names!=null){
                $athlete_log = new AthleteLog();
                $athlete_log->event_id = $event->id;
                $athlete_log->athlete_name = $total_ath_update_names->athlete_name;
                $athlete_log->event_year = date('Y',strtotime($c['Event Date']));
                $athlete_log->age_group = $c['Age Category'];
                $athlete_log->save();
            }

            
        //end athlete
                }
                 
             }
        }
        else{
            Schema::create($table, function (Blueprint $table) {
                $table->increments('id');
                $table->Integer('event_id');
                $table->date('event_date');
                $table->string('event_name', 250);
                $table->Integer('overall_rank');
                $table->Integer('category_rank');
                $table->string('bib', 50);
                $table->string('athlete', 250);
                $table->string('age_category', 50);
                $table->string('distance', 50);
                $table->string('speed', 50);
                $table->string('time', 50);
                $table->Integer('points');
                $table->Integer('age_type');
                $table->string('dob', 50)->nullable();
                $table->string('created', 50);
                $table->string('updated', 50);
                $table->timestamps();
            });
            Artisan::call('make:model '.str_replace('s','',$table));
             foreach($customerArr as $c){
                $max_date = $model::max('event_date');
                $past_overall_rank = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->first();
                 $event_data = new $model;
                 $event_data->event_name = $c['Event Name'];
                 $event_data->event_id = $event->id;
                 $event_data->event_date = date('Y-m-d',strtotime($c['Event Date']));
                 $event_data->overall_rank = $c['Overall Rank'];
                 $event_data->category_rank = $c['Category Rank'];
                 $event_data->bib = $c['Bib #'];
                 $event_data->athlete = $c['Athlete'];
                 $event_data->age_category = $c['Age Category'];
                 $event_data->distance = $c['Distance'];
                 $event_data->speed = $c['Speed'];                         
                 $event_data->time = $c['Time'];
                 $event_data->points = $c['Points'];
                 if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_athlete)){
                    $event_data->age_type = 0;

                 }
                 else if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_kids)){
                    $event_data->age_type = 1;

                 }
                 $event_data->dob = $c['DOB'];
                 $event_data->created = date('Y-m-d');
                 $event_data->updated = date('Y-m-d');                                                                           
                 $event_data->save();

                 $check_athlete = Athlete::where('athlete_name',$c['Athlete'])->first();
                 if($check_athlete==null){
                    $athlete = new Athlete();
                    $athlete->athlete_name = $c['Athlete'];
                    $athlete->year = $event->event_year;
                    $athlete->age_category = $c['Age Category'];
                    $total_race = $model::where('athlete',$c['Athlete'])->get()->count();
                    $athlete->total_races = $total_race;
                    $overall_wins = $model::where('athlete',$c['Athlete'])->where('overall_rank','1')->get()->count();
                    $athlete->overall_wins = $overall_wins;
                    $top3_finishes = $model::where('athlete',$c['Athlete'])->where(function($query){
                            $query->where('overall_rank','1')->orWhere('overall_rank','2')->orWhere('overall_rank','3');
                    })->get()->count();
                    $athlete->top3_finishes = $top3_finishes;
                    $top10_finishes = $model::where('athlete',$c['Athlete'])->where(function($query){
                        $query->where('overall_rank','1')
                        ->orWhere('overall_rank','2')
                        ->orWhere('overall_rank','3')
                        ->orWhere('overall_rank','4')
                        ->orWhere('overall_rank','5')
                        ->orWhere('overall_rank','6')
                        ->orWhere('overall_rank','7')
                        ->orWhere('overall_rank','8')
                        ->orWhere('overall_rank','9')
                        ->orWhere('overall_rank','10');
                })->get()->count();
                    $athlete->top10_finishes = $top10_finishes;
                    $category_wins = $model::where('athlete',$c['Athlete'])->where('category_rank','1')->get()->count();
                    $athlete->category_wins = $category_wins;
                    $max_date = $model::max('event_date');
                    $current_overall_rank = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->first();                          
                    $athlete->current_overall_rank = $c['Overall Rank'];
                    $athlete->current_category_rank =  $c['Category Rank'];
                    $total_events = $model::groupBy('event_id')->get()->count();
                     if($event->event_year>=2020){
                        $principle = 1/2;
                    }
                    else{
                        $principle = 2/3;
                    }
                    $highest_events = round($principle*$total_events);
                    $athlete_event_points = $model::where('athlete',$c['Athlete'])->orderBy('points','desc')->get()->take($highest_events);
                    $points = 0;
                    foreach($athlete_event_points as $p){
                        $points+=$p->points;
                    }
                    $athlete->mrp = $points/$highest_events;
                    $athlete->arp = ($points/$highest_events)*$highest_events;
                     if($past_overall_rank!=null){
                                $overall_status = $past_overall_rank->overall_rank-$current_overall_rank->overall_rank;
                                $category_status = $past_overall_rank->category_rank-$current_overall_rank->category_rank;
                             
                                $check_athlete->current_overall_rank_status = $overall_status;
                                $check_athlete->current_category_rank_status = $category_status;
                            }
                    $athlete->save();
                 }
                 else{
                    // athlete
           
            // $ath_name[] = $c['Athlete'];
            $total_ath_update_names = Athlete::where('athlete_name',$c['Athlete'])->first();
            if($total_ath_update_names!=null){
                $athlete_log = new AthleteLog();
                $athlete_log->event_id = $event->id;
                $athlete_log->athlete_name = $total_ath_update_names->athlete_name;
                $athlete_log->event_year = date('Y',strtotime($c['Event Date']));
                $athlete_log->age_group = $c['Age Category'];
                $athlete_log->save();
            }

            
        //end athlete
                 }
             }
        }
                                                                  
    $total_athlete_logs = AthleteLog::all()->count();
    $total_team_logs = Team::all()->count();
    $logs = Log::first();
    $logs->total_athletes_queue = $total_athlete_logs;
    $logs->total_teams_queue = $total_team_logs;
    $logs->save();
    //Overall ranking
        $over = OverallRanking::where('event_id',$event->id)->get()->count();
        if($over==0){
        $this->overall_rankings($event->id);
								
		DB::table('overall_events')->insert(['event_id'=>$event->id]);
		DB::table('age_wise_events')->insert(['event_id'=>$event->id]);
		DB::table('overall_ranking_updates')->insert(['event_id'=>$event->id]);
        }


        //Event ranking  
        $event_rk = EventRanking::where('event_id',$event->id)->get()->count();
        if($event_rk==0){
        $this->event_rankings($event->id);
        }
    }
    
    return redirect()->route('event.import_csv_form')->with('success_message','CSV file uploaded successfully!');

}


public function event_rankings($event_id,$event_update=""){
    $array =array();
    $ev = Event::where('id',$event_id)->first();  

    $event_data = 'eventdata_'.$ev->event_year.'s';

    $data = DB::table($event_data)
                        ->where('event_id', '=', $event_id)
                        ->get();                   
    foreach($data as $d){
        if($event_update=="e"){
            $event_ranking = EventRanking::where('event_id',$event_id)->where('athlete_name',$d->athlete)->first();

        }
        else{
            $event_ranking = new EventRanking();

        }
        $event_ranking->event_id = $event_id;
        $event_ranking->athlete_name = $d->athlete;
        $event_ranking->event_point = $d->points;
        $event_ranking->age_type = $d->age_type;
        $event_ranking->age_category = $d->age_category;
        $event_ranking->save();
    }
}

public function overall_rankings($event_id,$event_update="")
    {
    
        $array =array();
        $ev = Event::where('id', $event_id)->first();  
        $event_data = 'eventdata_'.$ev->event_year.'s';
        $check_type = DB::table($event_data)    
                              ->where('event_id', '=', $event_id)
                              ->first();
                  
        if($check_type->age_type==0){
         $ag_type = 0;
        }
        if($check_type->age_type==1){
         $ag_type = 1;
        }
        if($check_type->age_type==2){
         $ag_type = 2;
        }
            
        
        $check_events_type = DB::table($event_data) 
                              ->select('event_id')      
                              ->groupBy('event_id')
                              ->where('event_date','<=',$ev->event_date)    
                              ->where('age_type',$ag_type)  
                              ->get();
        $type_events = array();                      
        foreach ($check_events_type as $value) {
           $type_events[] = $value->event_id;
         }

        
        $data['variable'] = DB::table($event_data)
                              ->select(['athlete','age_type','age_category'])   
                              ->whereIn('event_id', $type_events)
                              ->groupBy('athlete')  
                              ->get();
        
        if($ev->event_year>=2020){
            $principle = 1/2;
        }
        else{
            $principle = 2/3;
        }
        $for_mrp = round( $principle * count($type_events) );
        foreach ($data['variable'] as $key => $value) {
            $age = DB::table($event_data)
                    ->where('athlete',$value->athlete)
                    ->where('event_date','<=' ,$ev->event_date)
                    ->where('age_type',$ag_type)
                    ->orderBy('event_date','desc')
                    ->first(); 

            $total_points = DB::table($event_data)->where('athlete',$value->athlete)->whereIn('event_id' ,  $type_events)->orderBy('points', 'DESC')->get()->take($for_mrp)->sum('points');
            $data['mrp'] = round( $total_points / round( $principle * count($type_events) ) , 3);           
            $var = [
  
                "Name" =>$value->athlete,
                "age_category" =>$age->age_category,
                "MRP" =>$data['mrp'],
                "age_type" => $value->age_type
  
               
              ];
    
            $array[] = $var;
        }
      $overall = array();
      $overall_instance = new OverallRanking();  
      if($event_update=='e') {
        foreach($array as $ar){
               $overall_rank = OverallRanking::where('event_id',$event_id)->where('athlete_name',$ar['Name'])->first();
               $overall[] = [
                   'id'=>$overall_rank->id,
                   'event_date'=>$ev->event_date,
                   'athlete_name'=>$ar['Name'],
                   'age_category'=>$ar['age_category'],
                   'mrp'=>$ar['MRP'],
                   'age_type'=>$ar['age_type'],
                   'event_id'=>$event_id,
               ];
               
          }
          $index = 'id';
          batch()->update($overall_instance,$overall,$index);
      }
      else{
          $column = [
              'event_id',
              'event_date',
              'athlete_name',
              'mrp',
              'age_type',
              'age_category',
          ];
          foreach($array as $ar){
            $overall[] = [
                $event_id,
                $ev->event_date,
                $ar['Name'],
                $ar['MRP'],
                $ar['age_type'],
                $ar['age_category'],
            ];
          }

          batch()->insert($overall_instance,$column,$overall); 
      } 

    }

public function import_correct_csv_form(){
    $events = Event::where('type','!=',2)->get();
    return view('admin.event.import_correct_csv',['events'=>$events]);
}

public function import_correct_csv_form_submit(Request $request){
        $validateData = $request->validate([
        'event'=>'required',
        'event_csv' =>'required'
    ]);
     if($request->file('event_csv')){
            $csv_file = $request->file('event_csv');
            $errorCsv = $this->erroCsvToArray($csv_file);
            if(COUNT($errorCsv)){
                $events = Event::where('type','!=',2)->get();
                return view('admin.event.import_correct_csv',['events'=>$events,'header_error'=>$errorCsv]);
            }
            $customerArr = $this->csvToArray($csv_file);
        }
    $event = Event::where('id',$request->event)->first();
    if($event->event_date!=date('Y-m-d',strtotime($customerArr[3]['Event Date']))){
        $events = Event::where('type','!=',2)->get();
        return view('admin.event.import_correct_csv',['events'=>$events,'date_error'=>'Event date and csv event date are not same.']);
    }
    $model = "App\\"."eventdata_".$event->event_year;
    $age_group_athlete = Age_group::where('type',0)->get();
        $age_athlete = array();
        foreach($age_group_athlete as $age){
            $age_athlete[] = $age->group_title;
        }
        $age_group_kids = Age_group::where('type',1)->get();
        $age_kids = array();
        foreach($age_group_kids as $age){
            $age_kids[] = $age->group_title;
        }
    $delete_event_data = $model::where('event_id',$request->event)->get()->each->delete();
    if($request->file('event_csv')){
        $delete_log = AthleteLog::where('event_id',$event->id)->get()->each->delete();
        $delete_event_rnk = EventRanking::where('event_id',$event->id)->get()->each->delete();
        $delete_overall_rnk= OverallRanking::where('event_id',$event->id)->get()->each->delete();
        $check_overall_events = DB::table('overall_events')->where('event_id',$event->id)->first();
        if($check_overall_events!=null){
            DB::table('overall_events')->delete($check_overall_events->id);
        }
        $check_age_events = DB::table('age_wise_events')->where('event_id',$event->id)->first();
        if($check_age_events!=null){
            DB::table('age_wise_events')->delete($check_age_events->id);
        }
        $check_overll_log = DB::table('overall_ranking_logs')->where('event_id',$event->id)->first();
        if($check_overll_log!=null){
            DB::table('overall_ranking_logs')->delete($check_overll_log->id);
        }
        $check_age_log = DB::table('age_wise_ranking_logs')->where('event_id',$event->id)->first();
        if($check_age_log!=null){
            DB::table('age_wise_ranking_logs')->delete($check_age_log->id);
        }
        $check_overll_update = DB::table('overall_ranking_updates')->where('event_id',$event->id)->first();
        if($check_overll_update!=null){
            DB::table('overall_ranking_updates')->delete($check_overll_update->id);
        }
        $check_overll_update_log = DB::table('overall_ranking_update_logs')->where('event_id',$event->id)->first();
        if($check_overll_update_log!=null){
            DB::table('overall_ranking_update_logs')->delete($check_overll_update_log->id);
        }           
        

        
        $table = "eventdata_".$event->event_year.'s';
        if(Schema::hasTable($table)){
             foreach($customerArr as $c){
                 $max_date = $model::max('event_date');
                 $past_overall_rank = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->first();
                 $event_data = new $model;
                 $event_data->event_name = $c['Event Name'];
                 $event_data->event_id = $event->id;
                 $event_data->event_date = date('Y-m-d',strtotime($c['Event Date']));
                 $event_data->overall_rank = $c['Overall Rank'];
                 $event_data->category_rank = $c['Category Rank'];
                 $event_data->bib = $c['Bib #'];
                 $event_data->athlete = $c['Athlete'];
                 $event_data->age_category = $c['Age Category'];
                 $event_data->distance = $c['Distance'];
                 $event_data->speed = $c['Speed'];                         
                 $event_data->time = $c['Time'];
                 $event_data->points = $c['Points'];
                 if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_athlete)){
                    $event_data->age_type = 0;

                 }
                 else if(in_array(str_replace(array('M ','F '),'',$c['Age Category']),$age_kids)){
                    $event_data->age_type = 1;

                 }
                 $event_data->dob = $c['DOB'];
                 $event_data->created = date('Y-m-d');
                 $event_data->updated = date('Y-m-d');
                 $event_data->save();

                 $check_athlete = Athlete::where('athlete_name',$c['Athlete'])->first();
                if($check_athlete!=null){
                   // athlete
           
            $total_ath_update_names = Athlete::where('athlete_name',$c['Athlete'])->first();
            if($total_ath_update_names!=null){
                $athlete_log = new AthleteLog();
                $athlete_log->event_id = $event->id;
                $athlete_log->athlete_name = $total_ath_update_names->athlete_name;
                $athlete_log->event_year = date('Y',strtotime($c['Event Date']));
                $athlete_log->age_group = $c['Age Category'];
                $athlete_log->save();
            }

            
        //end athlete
                }
                else{
                   $athlete = new Athlete();
                   $athlete->athlete_name = $c['Athlete'];
                   $athlete->year = $event->event_year;
                   $athlete->age_category = $c['Age Category'];
                   $total_race = $model::where('athlete',$c['Athlete'])->get()->count();
                   $athlete->total_races = $total_race;
                   $overall_wins = $model::where('athlete',$c['Athlete'])->where('overall_rank','1')->get()->count();
                   $athlete->overall_wins = $overall_wins;
                   $top3_finishes = $model::where('athlete',$c['Athlete'])->where(function($query){
                           $query->where('overall_rank','1')->orWhere('overall_rank','2')->orWhere('overall_rank','3');
                   })->get()->count();
                   $athlete->top3_finishes = $top3_finishes;
                   $top10_finishes = $model::where('athlete',$c['Athlete'])->where(function($query){
                       $query->where('overall_rank','1')
                       ->orWhere('overall_rank','2')
                       ->orWhere('overall_rank','3')
                       ->orWhere('overall_rank','4')
                       ->orWhere('overall_rank','5')
                       ->orWhere('overall_rank','6')
                       ->orWhere('overall_rank','7')
                       ->orWhere('overall_rank','8')
                       ->orWhere('overall_rank','9')
                       ->orWhere('overall_rank','10');
               })->get()->count();
                   $athlete->top10_finishes = $top10_finishes;
                   $category_wins = $model::where('athlete',$c['Athlete'])->where('category_rank','1')->get()->count();
                   $athlete->category_wins = $category_wins;
                   $max_date = $model::max('event_date');
                   $current_overall_rank = $model::where('athlete',$c['Athlete'])->where('event_date',$max_date)->first();                          
                   $athlete->current_overall_rank = $c['Overall Rank'];
                   $athlete->current_category_rank =  $c['Category Rank'];
                   $total_events = $model::groupBy('event_id')->get()->count();
                     if($event->event_year>=2020){
                        $principle = 1/2;
                    }
                    else{
                        $principle = 2/3;
                    }
                   $highest_events = round($principle*$total_events);
                   $athlete_event_points = $model::where('athlete',$c['Athlete'])->orderBy('points','desc')->get()->take($highest_events);
                   $points = 0;
                   foreach($athlete_event_points as $p){
                       $points+=$p->points;
                   }
                   $athlete->mrp = $points/$highest_events;
                   $athlete->arp = ($points/$highest_events)*$highest_events;
                    if($past_overall_rank!=null){
                                $overall_status = $past_overall_rank->overall_rank-$current_overall_rank->overall_rank;
                             $category_status = $past_overall_rank->category_rank-$current_overall_rank->category_rank;
                             
                                $check_athlete->current_overall_rank_status = $overall_status;
                                $check_athlete->current_category_rank_status = $category_status;
                            }
                   $athlete->save();

                }
             }
             
        }

            $total_athlete_logs = AthleteLog::all()->count();
            $total_team_logs = Team::all()->count();
            $logs = Log::first();
            $logs->total_athletes_queue = $total_athlete_logs;
            $logs->total_teams_queue = $total_team_logs;
            $logs->save();
         //Overall ranking
        $over = OverallRanking::where('event_id',$event->id)->get()->count();
        if($over==0){
        $this->overall_rankings($event->id);
			DB::table('overall_events')->insert(['event_id'=>$event->id]);
			DB::table('age_wise_events')->insert(['event_id'=>$event->id]);
			DB::table('overall_ranking_updates')->insert(['event_id'=>$event->id]);

        }


        //Event ranking  
        $event_rk = EventRanking::where('event_id',$event->id)->get()->count();
        if($event_rk==0){
        $this->event_rankings($event->id);
        }
                                         
    }
    return redirect()->route('event.import_correct_csv_form')->with('success_message','CSV file uploaded successfully!');

}

public function event_schedule_create_form(){
    $events = Event::all();
    return view('admin.event.event_schedule_create',['events'=>$events]);
}

public function event_schedule_create_form_submit(Request $request){
    //event date
    $check_event_date = EventDate::where('event_id',$request->event)->first();
    if($check_event_date!=null){
        return redirect()->route('event.event_schedule_create_form')->with('error_message','The Event Schedule is already exists');
    }
    $event_date = new EventDate();
    $event_date->event_id = $request->event;
    $event_date->online_registration = $request->date_online_registration;
    $event_date->cash_payment_bib   = $request->date_cash_payments;
    $event_date->award_ceremony = $request->date_award_ceremony;
    $event_date->bib = $request->date_bib;
    $event_date->start_of_event = $request->date_start_event;
    $event_date->save();

    //event time
    $check_event_time = EventTime::where('event_id',$request->event)->first();
    if($check_event_time!=null){
        return redirect()->route('event.event_schedule_create_form')->with('error_message','The Event Schedule is already exists');
    }
    $event_time = new EventTime();
    $event_time->event_id = $request->event;
    $event_time->online_registration = $request->time_online_registration;
    $event_time->cash_payment_bib   = $request->time_cash_payments;
    $event_time->bib = $request->time_bib;
    
    $event_time->award_ceremony = $request->time_award_ceremony;
    $event_time->start_of_event = $request->time_start_event;
    $event_time->save();

    //event week day
    $check_event_week = EventWeekDay::where('event_id',$request->event)->first();
    if($check_event_week!=null){
        return redirect()->route('event.event_schedule_create_form')->with('error_message','The Event Schedule is already exists');
    }
    $event_week_day = new EventWeekDay();
    $event_week_day->event_id = $request->event;
    $event_week_day->online_registration = $request->week_online_registration;
    $event_week_day->cash_payment_bib   = $request->week_cash_payments;
    $event_week_day->bib = $request->week_bib;
    
    $event_week_day->award_ceremony = $request->week_award_ceremony;
    $event_week_day->start_of_event = $request->week_start_event;
    $event_week_day->save();

    //event location
    $check_event_location = EventLocation::where('event_id',$request->event)->first();
    if($check_event_location!=null){
        return redirect()->route('event.event_schedule_create_form')->with('error_message','The Event Schedule is already exists');
    }
    $event_location = new EventLocation();
    $event_location->event_id = $request->event;
    $event_location->online_registration = $request->location_online_registration;
    $event_location->cash_payment_bib   = $request->location_cash_payments;
    $event_location->award_ceremony = $request->location_award_ceremony;
    $event_location->bib = $request->location_bib;
    
    $event_location->start_of_event = $request->location_start_event;
    $event_location->registration_payment = $request->registration_payment;
    $event_location->bib_no_confirmation = $request->bib_no_confirmation;
    $event_location->save();
    return redirect()->route('event.event_schedule_create_form')->with('success_message','Event Schedule created successfully!');

}

public function awards_prizes_create_form(){
    $events = Event::all();
    return view('admin.event.award_prize_create',['events'=>$events]);
}

public function awards_prizes_create_form_submit(Request $request){
    $validateData = $request->validate([
        'event' => 'required',
        'title' => 'required',
        'details' => 'required',
        'image' => 'required'
    ]);
    $award = new AwardsPrize();
    $award->event_id = $request->event;
    $award->title = $request->title;
    $award->details = $request->details;
    if($request->file('image')){
        //award image
        $image_file = $request->file('image');
        $image_filename = time().'-'.$image_file->getClientOriginalName();
        $image_file->move("award_image/",$image_filename);
        $filepath = "award_image/".$image_filename;
        $award->image = $filepath;
    }
    
    if($award->save()){
        return redirect()->route('event.awards_prizes_create_form')->with('success_message','Award & Prize created successfully');
    }

}

public function overall_ranking_update(){
    $get_ids = DB::table('overall_ranking_updates')->get()->count();
    if($get_ids>0){
        $check = DB::table('overall_ranking_update_logs')->first();
        if($check==null){
            $e = DB::table('overall_ranking_updates')->first();
            DB::table('overall_ranking_update_logs')->insert(['log_id'=>$e->event_id]);
            $id_exists = OverallRanking::where('event_id',$e->event_id)->first();
            if($id_exists!=null){
                $this->overall_rankings($e->event_id,"e");  
            }
            $id_exists = EventRanking::where('event_id',$e->event_id)->first();
            if($id_exists!=null){
                $this->event_rankings($e->event_id,"e");    
            }
            DB::table('overall_ranking_updates')->delete($e->id);
            $log = DB::table('overall_ranking_update_logs')->first();
            DB::table('overall_ranking_update_logs')->delete($log->id);
            
        }
    }
    /*else{
     $event_ids = OverallRanking::select('event_id')->groupBy('event_id')->get();
     if($event_ids->count()>0){
        foreach($event_ids as $e_id){
            DB::table('overall_ranking_updates')->insert(['event_id'=>$e_id->event_id]);
        }
         $e = DB::table('overall_ranking_updates')->first();
         DB::table('overall_ranking_update_logs')->insert(['log_id'=>$e->event_id]);
         $this->overall_rankings($e->event_id,"e");
         $this->event_rankings($e->event_id,"e");        
         DB::table('overall_ranking_updates')->delete($e->id);
         $log = DB::table('overall_ranking_update_logs')->first();
         DB::table('overall_ranking_update_logs')->delete($log->id); 
         
     }  
    }*/
    
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

        return $data;
    }

     public function index($name)
    {
        $event_name =  str_replace("-"," ",$name);
        $data['data'] = Event::where('event_name',$event_name)->first();

        $data['address'] = Location::where('id',1)->first();
        $data['event_date'] = EventDate::where('event_id',$data['data']->id)->first();
        $data['week_days']  = EventWeekDay::where('event_id',$data['data']->id)->first();
        $data['event_time'] = EventTime::where('event_id',$data['data']->id)->first();
        $data['event_location'] = EventLocation::where('event_id',$data['data']->id)->first();
        $data['schedule_header'] = ScheduleHeader::where('event_id',$data['data']->id)->first();
        
        $ck = Event::where('event_date', '>' , $data['data']->event_date)->where('event_year', $data['data']->event_year )->where('type',0)->first();

        $data['result_show'] =1;
        if ($ck == null) {
            $data['result_show'] =0;
        }
        $data['past_event'] = DB::table('past_events')
            ->where('event_id',$data['data']->id)
            /*->join('events', 'events.id', '=', 'past_events.event_id')
            ->select('past_events.image', 'past_events.result_link' , 'events.resut_background_image')*/
            ->orderBy('result_order', 'ASC')
            ->get();
        
        $data['link'] = PastEvent::where('id',$data['data']->id)->first();
        
        $data['gallery'] = Event_gallerie::where('event_id',$data['data']['id'])->orderBy('img_order', 'ASC')->get();
        $data['video'] = EventMovie::where('event_id',$data['data']['id'])->get();
        $data['prize'] = Event_information::where('event_id',$data['data']['id'])->get();
        $data['locations'] = Location::where('event_id',$data['data']->id)->first();
        $data['schedule_pic'] = Setting::where('id', 3)->first();
        $data['result_pic'] = Setting::where('id', 4)->first();
        $data['AwardsPrize'] = AwardsPrize::where('event_id',$data['data']->id)->get();



        return view('front_end.event.index' , $data , $this->common() );
    }

    public function pages()
    {
        $query['data'] = Event::all();
        return view('front_end.event.all_events' , $query);
    }
    
    public function over(){

        $count_id = DB::table('overall_events')->get()->count();

        if($count_id>0){
            $overall_log = DB::table('overall_ranking_logs')->first();
            if($overall_log==null){
                $u = DB::table('overall_events')->first();
                DB::table('overall_ranking_logs')->insert(['log_id'=>$u->event_id]);
                $check_overall = OverallRanking::select('event_id')->where('event_id',$u->event_id)->first();
                if($check_overall!=null){
                    $update_male_rank = OverallRanking::select('id','mrp')->where('event_id',$u->event_id)->where('age_category','like','%'.'M'.'%')->groupBy('athlete_name')->orderBy('mrp','desc')->orderBy('athlete_name','asc')->get();
                
                    $update_female_rank =OverallRanking::select('id','mrp')->where('event_id',$u->event_id)->where('age_category','like','%'.'F'.'%')->groupBy('athlete_name')->orderBy('mrp','desc')->orderBy('athlete_name','asc')->get();

                             $male = array(); 
                            $i=0;   

    
                foreach($update_male_rank as $key => $m){


                    if($key>0 && $update_male_rank[$key-1]['mrp']==$m->mrp){
                        $male[] = [
                        'id'=>$m->id,
                        'rank'=>$i
                        ];
                    }
                    else{
                        $i++;

                        if ($key == 0) {
                            $male[] = [
                            'id'=>$m->id,
                            'rank'=>$i,
                            ];

                        }else{
                            $male[] = [
                            'id'=>$m->id,
                            'rank'=>$key+1,
                            ];

                            $i = $key+1;


                        }
                    }               
                            
                }

    $overall_instance = new OverallRanking();
    $index = 'id';
    batch()->update($overall_instance,$male,$index);
                
    $female = array();
    $j=0;           
    // foreach($update_female_rank as $key=> $f){
    //     if($key>0 && $update_female_rank[$key-1]['mrp']==$f->mrp){
    //         $female[] = [
    //         'id'=>$f->id,
    //         'rank'=>$j
    //         ];
    //     }
    //     else{
    //         $j++;
    //         $female[] = [
    //         'id'=>$f->id,
    //         'rank'=>$j
    //         ];
    //     }

    // }
    
    //update 2.2.2020
    
    foreach($update_female_rank as $key=> $f){
                        if($key>0 && $update_female_rank[$key-1]['mrp']==$f->mrp){
                            $female[] = [
                            'id'=>$f->id,
                            'rank'=>$j
                            ];
                        }
                        else{
                            $j++;

                            if ($key == 0) {
                            $female[] = [
                            'id'=>$f->id,
                            'rank'=>$j,
                            ];

                            }else{
                                $female[] = [
                                'id'=>$f->id,
                                'rank'=>$key+1,
                                ];

                                $j = $key+1;


                            }
                        }

                    }
    $overall_instance = new OverallRanking();
    $index = 'id';
    batch()->update($overall_instance,$female,$index);
            }
    
 
        
        
    $up = DB::table('overall_events')->first();
        $check_overall = OverallRanking::select('event_id')->where('event_id',$up->event_id)->first();
        
        if($check_overall!=null){
            $get_overall_event = OverallRanking::where('event_id',$up->event_id)->get();
        $progress = array();    
        foreach($get_overall_event as $g){
            $get_last_event = OverallRanking::where('athlete_name','like','%'.$g->athlete_name.'%')
                                                ->select('rank')    
                                                ->where('event_date','<',$g->event_date)
                                                ->where('age_type',$g->age_type)
                                                ->orderBy('event_date','desc')
                                                ->where('event_date','like','%'.date('Y',strtotime($g->event_date)).'%')
                                                ->first();
            

            if($get_last_event!=null){
                $progress_status = $get_last_event->rank - $g->rank;
            }
            else{
                $progress_status = 0;               
            }
            $progress[] = [
                'id'=>$g->id,
                'progress_status'=>$progress_status
            ];
        }
        $overall_instance = new OverallRanking();
        $index = 'id';
        	batch()->update($overall_instance,$progress,$index);
        }
        
        DB::table('overall_events')->delete($up->id);
        $overall_log = DB::table('overall_ranking_logs')->first();      
        DB::table('overall_ranking_logs')->delete($overall_log->id);        
                
            }
        

        }
        /*else{
            $get_id = OverallRanking::select('event_id')->groupBy('event_id')->orderBy('age_type')->orderBy('event_date')->get();
            if($get_id->count()>0){
                foreach($get_id as $g){
                    DB::table('overall_events')->insert(['event_id'=>$g->event_id]);
                }
                
                        $u = DB::table('overall_events')->first();
                        DB::table('overall_ranking_logs')->insert(['log_id'=>$u->event_id]);
        $check_overall = OverallRanking::select('event_id')->where('event_id',$u->event_id)->first();
            if($check_overall!=null){
                    $update_male_rank = OverallRanking::select('id','mrp')->where('event_id',$u->event_id)->where('age_category','like','%'.'M'.'%')->groupBy('athlete_name')->orderBy('mrp','desc')->orderBy('athlete_name','asc')->get();
$update_female_rank =OverallRanking::select('id','mrp')->where('event_id',$u->event_id)->where('age_category','like','%'.'F'.'%')->groupBy('athlete_name')->orderBy('mrp','desc')->orderBy('athlete_name','asc')->get();

                    $male = array();           
                    $i=0;   
    foreach($update_male_rank as $key => $m){
        if($key>0 && $update_male_rank[$key-1]['mrp']==$m->mrp){
            $male[] = [
            'id'=>$m->id,
            'rank'=>$i
            ];
        }
        else{
            $i++;
            $male[] = [
            'id'=>$m->id,
            'rank'=>$i
            ];
        }
                   
        
    }
                    $overall_instance = new OverallRanking();
                    $index = 'id';
                    batch()->update($overall_instance,$male,$index);
                                
                    $female = array();
                    $j=0;           
    foreach($update_female_rank as $key=> $f){
        if($key>0 && $update_female_rank[$key-1]['mrp']==$f->mrp){
            $female[] = [
            'id'=>$f->id,
            'rank'=>$j
            ];
        }
        else{
            $j++;
            $female[] = [
            'id'=>$f->id,
            'rank'=>$j
            ];
        }

    }
                    $overall_instance = new OverallRanking();
                    $index = 'id';
                    batch()->update($overall_instance,$female,$index);
            }
    

        
        
    $up = DB::table('overall_events')->first();

        $check_overall = OverallRanking::select('event_id')->where('event_id',$up->event_id)->first();
        
        if($check_overall!=null){
            $get_overall_event = OverallRanking::where('event_id',$up->event_id)->get();
            $prgoress = array();
        foreach($get_overall_event as $g){
            $get_last_event = OverallRanking::where('athlete_name','like','%'.$g->athlete_name.'%')
                                                ->select('rank')    
                                                ->where('event_date','<',$g->event_date)
                                                ->where('age_type',$g->age_type)
                                                ->orderBy('event_date','desc')
                                                ->where('event_date','like','%'.date('Y',strtotime($g->event_date)).'%')
                                                ->first();
            

            if($get_last_event!=null){
                $progress_status = $get_last_event->rank - $g->rank;
            }
            else{
                $progress_status = 0;               
            }
            $progress[] = [
                'id'=>$g->id,
                'progress_status'=>$progress_status
            ];
        }
        }
        
        DB::table('overall_events')->delete($up->id);
        $log = DB::table('overall_ranking_logs')->first();      
        DB::table('overall_ranking_logs')->delete($log->id);        
            
        }
        
        
    }*/ 



        
    }
    
 public function get_athletes(Request $request){
     $atheltes = Athlete::where('athlete_name','like','%'.$request->q.'%')->get();
     $html = [];
     foreach ($atheltes as $value) {
         $html[] = ['id'=>$value->id, 'text'=>$value->athlete_name];
     }
     echo  json_encode($html);
}
    public function get_events(Request $request){
     $events = Event::where('type','<>',2)
         ->where('event_name','like','%'.$request->q.'%')
         ->get();
            
     $html = [];
     foreach ($events as $value) {
         $html[] = ['id'=>$value->id, 'text'=>$value->event_name];
     }
     echo  json_encode($html);
}
    public function get_distances(Request $request){
     $events = Event::where('id',$request->id)->first();
     $d = explode('-',$events->event_distance); 
     $html = [];
        
     if(count($d)>0){
        echo  json_encode($d);
     }
        
        
}
    
// public function set_overall_ranking(){
//         $check_existance = OverallRanking::where('event_id',1111)->get();
//         if($check_existance->count()==0){
//             $this->overall_rankings(83,'e');
//         }   
// }
    
    
public function age_wise(){
    $count_id = DB::table('age_wise_events')->get()->count();
        if($count_id>0){
            $age_wise_log = DB::table('age_wise_ranking_logs')->first();
            if($age_wise_log==null){
                $u = DB::table('age_wise_events')->first();
                DB::table('age_wise_ranking_logs')->insert(['log_id'=>$u->event_id]);
                $check_age_wise = OverallRanking::select('event_id')->where('event_id',$u->event_id)->first();
            if($check_age_wise!=null){
                $age_group = OverallRanking::select('age_category')->groupBy('age_category')->get();
                $male = array();
                $female = array();
                foreach($age_group as $ag){

                    
                    $update_male_rank = OverallRanking::select('id','mrp')->where('event_id',$u->event_id)->where('age_category','like','%'.'M'.'%')->where('age_category',$ag->age_category)->groupBy('athlete_name')->orderBy('mrp','desc')->orderBy('athlete_name','asc')->get();
                    $update_female_rank =OverallRanking::select('id','mrp')->where('event_id',$u->event_id)->where('age_category','like','%'.'F'.'%')->where('age_category',$ag->age_category)->groupBy('athlete_name')->orderBy('mrp','desc')->orderBy('athlete_name','asc')->get();
                    
                    if($update_male_rank->count()>0){  
                        $i=0;
                        foreach($update_male_rank as $key => $m){
                            if($key>0 && $update_male_rank[$key-1]['mrp']==$m->mrp){
                                $male[] = [
                                'id'=>$m->id,
                                'age_wise_rank'=>$i
                                ];
                            }
                            else{
                                $i++;
                                $male[] = [
                                'id'=>$m->id,
                                'age_wise_rank'=>$i
                                ];
                            }
                            
                        }
                        
                         
                    }
                    if($update_female_rank->count()>0){
                        $j=0;
                        foreach($update_female_rank as $key=> $f){
                            if($key>0 && $update_female_rank[$key-1]['mrp']==$f->mrp){
                                $female[] = [
                                'id'=>$f->id,
                                'age_wise_rank'=>$j
                                ];
                            }
                            else{
                                $j++;
                                $female[] = [
                                'id'=>$f->id,
                                'age_wise_rank'=>$j
                                ];
                            }
                    
                        }
                    }         
                    
                }
                $overall_instance = new OverallRanking();
                $index = 'id';
                batch()->update($overall_instance,$male,$index);
                batch()->update($overall_instance,$female,$index);

            }
    
 
            
    $up = DB::table('age_wise_events')->first();
        $check_age_wise = OverallRanking::select('event_id')->where('event_id',$up->event_id)->first();
        
        if($check_age_wise!=null){
            $get_age_wise_events = OverallRanking::where('event_id',$up->event_id)->get();
            $age_wise_progress = array();
        foreach($get_age_wise_events as $g){
            $get_last_event = OverallRanking::where('athlete_name','like','%'.$g->athlete_name.'%')
                                                ->select('age_wise_rank')   
                                                ->where('event_date','<',$g->event_date)
                                                ->where('age_category',$g->age_category)
                                                ->where('age_type',$g->age_type)
                                                ->orderBy('event_date','desc')
                                                ->where('event_date','like','%'.date('Y',strtotime($g->event_date)).'%')
                                                ->first();
            

            if($get_last_event!=null){
                $age_wise_progress_status = $get_last_event->age_wise_rank - $g->age_wise_rank;
            }
            else{
                $age_wise_progress_status = 0;              
            }
            $age_wise_progress[] = [
                'id'=>$g->id,
                'age_wise_progress_status'=>$age_wise_progress_status
            ];
        }
        $overall_instance = new OverallRanking();
        $index = 'id';
        batch()->update($overall_instance,$age_wise_progress,$index);
        }
        
        DB::table('age_wise_events')->delete($up->id);
        $age_wise_log = DB::table('age_wise_ranking_logs')->first();        
        DB::table('age_wise_ranking_logs')->delete($age_wise_log->id);      
                
            }
        

        }
        /*else{
            $get_id = OverallRanking::select('event_id')->groupBy('event_id')->orderBy('age_type')->orderBy('event_date')->get();
            if($get_id->count()>0){
                foreach($get_id as $g){
                    DB::table('age_wise_events')->insert(['event_id'=>$g->event_id]);
                }
                
                        $u = DB::table('age_wise_events')->first();
                        DB::table('age_wise_ranking_logs')->insert(['log_id'=>$u->event_id]);
        $check_age_wise = OverallRanking::select('event_id')->where('event_id',$u->event_id)->first();
            if($check_age_wise!=null){
                $age_group = OverallRanking::select('age_category')->groupBy('age_category')->get();
                $male = array();           
                $female = array();
                foreach($age_group as $ag){
                                        $update_male_rank = OverallRanking::select('id','mrp')->where('event_id',$u->event_id)->where('age_category','like','%'.'M'.'%')->where('age_category',$ag->age_category)->groupBy('athlete_name')->orderBy('mrp','desc')->orderBy('athlete_name','asc')->get();
$update_female_rank =OverallRanking::select('id','mrp')->where('event_id',$u->event_id)->where('age_category','like','%'.'F'.'%')->where('age_category',$ag->age_category)->groupBy('athlete_name')->orderBy('mrp','desc')->orderBy('athlete_name','asc')->get();
    
                    if($update_male_rank->count()>0){
                        $i=0;
                        foreach($update_male_rank as $key => $m){
                            if($key>0 && $update_male_rank[$key-1]['mrp']==$m->mrp){
                                $male[] = [
                                'id'=>$m->id,
                                'age_wise_rank'=>$i
                                ];
                            }
                            else{
                                $i++;
                                $male[] = [
                                'id'=>$m->id,
                                'age_wise_rank'=>$i
                                ];
                            }
                            
                        }
                        
                    }
                    if($update_female_rank->count()>0){
                        $j=0;
                        foreach($update_female_rank as $key=> $f){
                             if($key>0 && $update_female_rank[$key-1]['mrp']==$f->mrp){
                                $female[] = [
                                'id'=>$f->id,
                                'age_wise_rank'=>$j
                                ];
                            }
                            else{
                                $j++;
                                $female[] = [
                                'id'=>$f->id,
                                'age_wise_rank'=>$j
                                ];
                            }

                        }
                    }
                }
                $overall_instance = new OverallRanking();
                $index = 'id';
                batch()->update($overall_instance,$male,$index);
                batch()->update($overall_instance,$female,$index);

            }
    

        
        
    $up = DB::table('age_wise_events')->first();

        $check_age_wise = OverallRanking::select('event_id')->where('event_id',$up->event_id)->first();
        
        if($check_age_wise!=null){
            $get_age_wise_event = OverallRanking::where('event_id',$up->event_id)->get();
            $age_wise_progress = array();
        foreach($get_age_wise_event as $g){
            $get_last_event = OverallRanking::where('athlete_name','like','%'.$g->athlete_name.'%')
                                                ->select('age_wise_rank')   
                                                ->where('event_date','<',$g->event_date)
                                                ->where('age_category',$g->age_category)
                                                ->where('age_type',$g->age_type)
                                                ->orderBy('event_date','desc')
                                                ->where('event_date','like','%'.date('Y',strtotime($g->event_date)).'%')
                                                ->first();
            
            if($get_last_event!=null){
                $age_wise_progress_status = $get_last_event->age_wise_rank - $g->age_wise_rank;
            }
            else{
                $age_wise_progress_status = 0;              
            }
            $age_wise_progress[] = [
                'id'=>$g->id,
                'age_wise_progress_status'=>$age_wise_progress_status
            ];
        }
        $overall_instance = new OverallRanking();
        $index = 'id';
        batch()->update($overall_instance,$age_wise_progress,$index);
        }
        
        DB::table('age_wise_events')->delete($up->id);
        $log = DB::table('age_wise_ranking_logs')->first();     
        DB::table('age_wise_ranking_logs')->delete($log->id);       
            
        }
        
        
}*/
    

}
	public function test_team(){
		// Team update
            $log = Log::first();
            if($log->total_teams_queue>0){
                $teams = Team::all();                                             
            if($teams->count()>0){
                foreach($teams as $t){
                   $year2 = array(); 
                   $sum_overall = 0;
                   $sum_category = 0;
                   $last2 = Team::where('id',$t->id)->first();
                   
              $team_members_show = json_decode($last2['team_members']);
    
              $key = in_array($last2['captain'], $team_members_show);
    
              if ($key == FALSE && $last2['captain']!=0) {
                $team_members_show[] = $last2['captain'];
              }
    
    
              $users['total_member'] = count($team_members_show);
    
              $team_members_name = Athlete::select('athlete_name')
                                   ->whereIn('id', $team_members_show)
                                   ->get();
    
              $orange_jersey = 0;
              $blue_jersey =0;
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
		
 					$white_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('rank',1)->where('age_type',1)->sum('rank');
		
	}
              /*foreach ($year2 as $key => $value) {
               foreach ($team_members_name as $key => $value235ff) {
    				 /*$orange_jersey += DB::table($value)->where('overall_rank', 1)->where('athlete', $value235ff->athlete_name)->sum('overall_rank');*/
                /*if (date('Y') >= 2020) {
                    $blue_jersey += DB::table($value)->where('overall_rank', 1)->orWhere('age_category', 'like', '%16-19%')->orWhere('age_category', 'like', '%U-20%')->where('athlete', $value235ff->athlete_name)->sum('overall_rank');
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
                  $log = Log::first();
                  $log->total_teams_queue-=1;
                  $log->save();
                }
                 

            }
            
            }
            
            //Team update end
	}
    public function record()
    {
        $data = array();
        $record = Record::first();
        $data['record'] = $record;
        return view('front_end.record.index' , $data , $this->common() );
    }
}
