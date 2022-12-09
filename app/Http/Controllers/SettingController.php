<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\EmailSetting;
use App\Jersey;
use App\JerseyWinner;
use App\Athlete;
use App\Event;
use DB;
use App\WeekendWinner;

class SettingController extends Controller
{
    public function set_principle_form(){
        $settings = Setting::all();
        foreach($settings as $s){
            if($s->column_name=='principle'){
                $principle_val = $s->value;
            }
        }
        $principles = array('1/2','2/3','3/4','4/5','5/6','6/7','7/8','8/9','9/10');
        return view('admin.setting.set_principle',['principles'=>$principles,'principle_val'=>$principle_val]);
    }
    
    
        public function set_apikey() {
          $mysettings =[];
           $settings = Setting::all();
            foreach($settings as $s){
                if($s->column_name=='API KEY'){
                $mysettings = $s;
                }
            }
        return view('admin.setting.set_apikey',['mysettings'=>$mysettings]);
        }
     
     public function update_apikey(Request $request){
         
         $id = $request->id;
         $key = $request->key;
         
         if($id == 0){
            $settings = new Setting;
            $settings->column_name = 'API KEY';
            $settings->value = $key;
            $settings->save(); 
             return redirect()->route('setting.set_apikey')->with('success_message','APK KEY Added successfully!');
         }else{
  
        Setting::where('id', $id)
        ->update(['value' => $key]);
         return redirect()->route('setting.set_apikey')->with('success_message','APK KEY updated successfully!');
         }
         
      
         
     }
        
        
        
    public function set_principle_form_submit(Request $request){
        $validateData = $request->validate([
            'principle'=>'required'
        ]);
        $settings = Setting::all();
        foreach($settings as $s){
            if($s->column_name=='principle'){
                $s->value = $request->principle;
                if($s->update()){
                    return redirect()->route('setting.set_principle_form')->with('success_message','Principle updated successfully');
                }
            }
        }
    }

    public function set_home_banner_image_form(){
        $settings = Setting::all();
        foreach($settings as $s){
            if($s->column_name=='home_banner_image'){
                $home_banner_image = $s->value;
            }
        }
        return view('admin.setting.set_home_image',['home_banner_image'=>$home_banner_image]);
    }

    public function set_home_banner_image_form_submit(Request $request){
        $validateData = $request->validate([
            'home_image'=>'dimensions:width=960,height=364'
        ]);
        
        $settings = Setting::all();
        if($request->file('home_image')){
            foreach($settings as $s){
                if($s->column_name=='home_banner_image'){
                    //coursemap image
                    $image_file = $request->file('home_image');
                    $image_filename = time().'-'.$image_file->getClientOriginalName();
                    $image_file->move("home_banner_image/",$image_filename);
                    unlink($s->value);
                    $filepath = "home_banner_image/".$image_filename;
                    $s->value = $filepath;
                    if($s->update()){
                        return redirect()->route('setting.set_home_banner_image_form')->with('success_message','Image updated successfully');
                    }
                }
            }
        }
        else{
            return redirect()->route('setting.set_home_banner_image_form')->with('success_message','Image updated successfully');
        }
       
    }
    
      public function set_email_form(){
        $email_setting = EmailSetting::first();
        return view('admin.setting.set_email',['email_setting'=>$email_setting]);
    }

    public function set_email_form_submit(Request $request){
        $validateData = $request->validate([
            'protocol'=>'required',
            'host'=>'required',
            'port'=>'required',
            'username'=>'required|email',
            'password'=>'required',

        ]);
        $email_setting = EmailSetting::first();
        $email_setting->protocol = $request->protocol;
        $email_setting->host = $request->host;
        $email_setting->port = $request->port;
        $email_setting->username = $request->username;
        $email_setting->password = $request->password;
        if($email_setting->update()){
            return redirect()->route('setting.set_email_form')->with('success_message','Email updated successfully!');
        }
    }


    public function set_schedule_image_form(){
        $events = Event::all();
        return view('admin.setting.set_schedule_image',['events'=>$events]);
    }

    public function set_schedule_image_form_submit(Request $request){
        if($request->has_image){
            $validateData = $request->validate([
                'event'=>'required',
                'schedule_image'=>'dimensions:width=1350,height=497'
            ]);
        }
        else{
            $validateData = $request->validate([
                'event'=>'required',
                'schedule_image'=>'required|dimensions:width=1350,height=497'
            ]);
        }
        
        $schedule_image = Event::where('id',$request->event)->first();
        if($request->file('schedule_image')){
            //schedule image
            $image_file = $request->file('schedule_image');
            $image_filename = time().'-'.$image_file->getClientOriginalName();
            $image_file->move("schedule_bg_image/",$image_filename);
            $filepath = "schedule_bg_image/".$image_filename;
            $schedule_image->event_schedule_image = $filepath;
        }
		if($request->heading_color){
        	$schedule_image->schedule_text_color = $request->heading_color;
		
		}
		if($request->table_header_bg_color){
        	$schedule_image->table_header_bg_color = $request->table_header_bg_color;

		
		}
        if($schedule_image->update()){
            return redirect()->route('setting.set_schedule_image_form')->with('success_message','Image added successfully');
        }

    }
	
	 public function set_schedule_headers_form(){
        $events = Event::all();
        return view('admin.setting.set_schedule_header',['events'=>$events]);
    }

    public function set_result_image_form(){
         $events = Event::all();
        return view('admin.setting.set_result_image',['events'=>$events]);
    }

    public function set_result_image_form_submit(Request $request){
         if($request->has_image){
            $validateData = $request->validate([
                'event'=>'required',
                'result_image'=>'dimensions:width=1350,height=497'
            ]);
        }
        else{
            $validateData = $request->validate([
                'event'=>'required',
                'result_image'=>'required|dimensions:width=1350,height=497'
            ]);
        }
        
        $result_image = Event::where('id',$request->event)->first();
        if($request->file('result_image')){
            //result bg image
            $image_file = $request->file('result_image');
            $image_filename = time().'-'.$image_file->getClientOriginalName();
            $image_file->move("result_bg_image/",$image_filename);
            $filepath = "result_bg_image/".$image_filename;
            $result_image->resut_background_image = $filepath;
        }
        if($result_image->update()){
            return redirect()->route('setting.set_result_image_form')->with('success_message','Image updated successfully');
        }
    }
    
    public function set_jersey()
    {
        $data['jersey'] = Jersey::first();
        return view('admin.jersey.jersey', $data);
    }

    public function update_jersey(Request $request)
    {
        $validateData = $request->validate([
            'orange_male'=>'dimensions:width=833,height=1000',
            'orange_female'=>'dimensions:width=833,height=1000',
            'blue_male'=>'dimensions:width=833,height=1000',
            'blue_female'=>'dimensions:width=833,height=1000',
            'red_male'=>'dimensions:width=833,height=1000',
            'red_female'=>'dimensions:width=833,height=1000',
            'white_male'=>'dimensions:width=833,height=1000',
            'white_female'=>'dimensions:width=833,height=1000',
            'yellow_male'=>'dimensions:width=833,height=1000',
            'yellow_female'=>'dimensions:width=833,height=1000'
        ]);

        $jersey = Jersey::first();
		$jersey->status = $request->status;

        if ($image=$request->file('orange_male')) {
 
           $uploadPath = 'jersey_image';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;

           $image->move($uploadPath,$dbUrl);
           $jersey->orange_male = $dbUrl;
         
        }if ($image=$request->file('orange_female')) {
 
           $uploadPath = 'jersey_image';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);


           $jersey->orange_female = $dbUrl;
         
        }if ($image=$request->file('blue_male')) {
 
           $uploadPath = 'jersey_image';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);

        $jersey->blue_male = $dbUrl;
         
        }if ($image=$request->file('blue_female')) {
 
           $uploadPath = 'jersey_image';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);

           $jersey->blue_female = $dbUrl;
         
        }if ($image=$request->file('red_male')) {

        $uploadPath = 'jersey_image';

        $file_name = time()."-".$image->getClientOriginalName();
        $dbUrl = $uploadPath."/".$file_name;

        $image->move($uploadPath,$dbUrl);

        $jersey->red_male = $dbUrl;

    }if ($image=$request->file('red_female')) {

        $uploadPath = 'jersey_image';

        $file_name = time()."-".$image->getClientOriginalName();
        $dbUrl = $uploadPath."/".$file_name;

        $image->move($uploadPath,$dbUrl);

        $jersey->red_female = $dbUrl;

    }if ($image=$request->file('white_male')) {
 
           $uploadPath = 'jersey_image';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);

         $jersey->white_male = $dbUrl;
         
        }if ($image=$request->file('white_female')) {
 
           $uploadPath = 'assets/img/';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);

           $jersey->white_female = $dbUrl;
         
        }

        if ($image=$request->file('yellow_male')) {
 
           $uploadPath = 'jersey_image';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);

         $jersey->yellow_male = $dbUrl;
         
        }if ($image=$request->file('yellow_female')) {
 
           $uploadPath = 'assets/img/';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);

           $jersey->yellow_female = $dbUrl;
         
        }

        if($jersey->update()){
            return redirect()->back()->with('success_message','Jersey updated successfully!');
        }
    }

    public function jersey_mans()
    {
        $data['jersey'] = JerseyWinner::first();
        $data['team'] = DB::table('athletes')->select('id', 'athlete_name')->get();
        return view('admin.jersey.jersey_man', $data);
    }

    public function update_jersey_man(Request $request)
    {
        $jersey = JerseyWinner::first();
		if($request->orange_male){
			$jersey->orange_male = Athlete::where('id',$request->orange_male)->first()->athlete_name;
		}
		if($request->orange_female){
			$jersey->orange_female = Athlete::where('id',$request->orange_female)->first()->athlete_name;
			
		}
		if($request->blue_male){
			$jersey->blue_male = Athlete::where('id',$request->blue_male)->first()->athlete_name;
		
		}
		if($request->blue_female){
			$jersey->blue_female = Athlete::where('id',$request->blue_female)->first()->athlete_name;
		
		}
        if($request->red_male){
            $jersey->red_male = Athlete::where('id',$request->red_male)->first()->athlete_name;

        }
        if($request->red_female){
            $jersey->red_female = Athlete::where('id',$request->red_female)->first()->athlete_name;

        }
		if($request->white_male){
			$jersey->white_male = Athlete::where('id',$request->white_male)->first()->athlete_name;
		
		}
		if($request->white_female){
			$jersey->white_female = Athlete::where('id',$request->white_female)->first()->athlete_name;
		
		}

        if($request->yellow_male){
            $jersey->yellow_male = Athlete::where('id',$request->yellow_male)->first()->athlete_name;
        
        }
        if($request->yellow_female){
            $jersey->yellow_female = Athlete::where('id',$request->yellow_female)->first()->athlete_name;
        
        }
		
		$jersey->update();
        
          return redirect()->back()->with('success_message','Jersey Winners updated successfully!');
    }


    public function set_weeks_players()
    {
        $data['weekend_winners'] = Setting::where('column_name', 'weekend_winners')->first();
		$data['winner'] = WeekendWinner::with('athlete')->with('event')->groupBy('distance')->get();
		$winners = array();
		if($data['winner']->count()){
			foreach($data['winner'] as $d){
				$winners[] = WeekendWinner::with('athlete')->with('event')->where('distance',$d->distance)->get();
			}
		}
		$data['winners'] = $winners;
        return view('admin.weekend_winner', $data);
    }

    public function set_weeks_players_update(Request $request)
    {
        $data = Setting::where('id',$request->id)->first();
        $data->value = $request->value;

        if($data->update()){
            return redirect()->back()->with('success_message','Updated successfully!');
        }
    }
	
	public function set_weekend_winner(Request $request){
		$check = WeekendWinner::where('event_id',$request->event)->first();
		if($check==null){
			WeekendWinner::get()->each->delete();
		}
		$weekend_winner = new WeekendWinner();
		$weekend_winner->event_id = $request->event;
		$weekend_winner->athlete_id = $request->athlete;
		$weekend_winner->time = $request->time;
		$weekend_winner->distance = $request->distance;
		if($weekend_winner->save()){
			return redirect()->back()->with('success_message','Saved successfully!');

		}
		
		
	}
	
	public function edit_set_weekend_winner($id){
	  $weekend_winners = WeekendWinner::with('athlete')->with('event')->where('id',$id)->first();
	  return view('admin.setting.edit_weekend_winners',['weekend_winners'=>$weekend_winners]);	
	}
	public function edit_set_weekend_winner_submit(Request $request){
		$weekend_winner = WeekendWinner::where('id',$request->winner_id)->first();
		if($request->event){
			$weekend_winner->event_id = $request->event;
		}
		if($request->athlete){
			$weekend_winner->athlete_id = $request->athlete;
		}
		if($request->distance){
			$weekend_winner->distance = $request->distance;
		}
		$weekend_winner->time = $request->time;
		if($weekend_winner->update()){
		 return redirect()->route('setting.set_week_players')->with('success_message','Winners updated successfully');
		}
		
	}
}
