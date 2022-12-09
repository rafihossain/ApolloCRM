<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Contract;
use App\Media_setting;
use App\Partner;
use App\Follow;
use App\Event;
use App\Team;
use App\Location;
use App\Request_res_change;
use App\Regulation;
use App\OurLocation;
use App\BadgeUpload;
use DB;
use Redirect;
use Session;
use App\EmailSetting;
use App\NewsFeed;
use Image;
use App\Setting;

class PageController extends Controller
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

        $data['badge'] = BadgeUpload::first();


        $data['team'] = Team::orderBy('order_field')->get();
        $data['partner'] = Partner::where('status',1)->get();
        $data['follow'] = Follow::where('status',1)->get();

        return $data;
    }
    
    public function index()
    {
        $users["data"] = Page::all();
        return view('admin.page.page', $users);
    }

    public function edit($id)
    {
        $data['data'] = Page::where('id', $id)->first();

        $view = view('admin.page.edit' , $data);
        echo $view;
    }

     public function update(Request $request)
    {
        $data = array();
        $data = Page::where('id',$request->id)->first();
        
        $validateData = $request->validate([
            'text'=>'required',
            'title'=>'required',
        ]);

        $data['text'] = $request->text;
        $data['title'] = $request->title;

        if($data->update()){
            return Redirect::back()->with('msg', 'Successfully Updated');
        }
    }

public function store_contract(Request $request)
    {
        $data = array();
        if ($request->phone != '')
        {
            $validateData = $request->validate([
                'full_name'=>'required',
                'email'=>'required',
                'phone'=>'unique:contracts,phone',
                'subject'=>'required',
                'message'=>'required',
                'g-recaptcha-response'=>'required',
            ]);
        }else{
            $validateData = $request->validate([
                'full_name'=>'required',
                'email'=>'required',
                'subject'=>'required',
                'message'=>'required',
                'g-recaptcha-response'=>'required',
            ]);
        }
        $data['full_name'] = $request->full_name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['subject'] = $request->subject;
        $data['message'] = $request->message;
        $from_email = $request->email;
        $subject = $request->subject;
        $name = $request->full_name;
        $d = array('full_name'=>$request->full_name,'email'=>$request->email,'subject'=>$request->subject,'mess'=>$request->message);
        try {

            \Mail::send('email.contact_mail',$d,function($message) use ($from_email, $subject, $name){
                $message->to('info@patrishisports.com','Admin')
                    ->subject($subject);
                $message->from($from_email,$name);
                $message->replyTo($from_email,$name);
            });
            Contract::insert($data);
            // Catch the error
        } catch(\Swift_TransportException $e){
            if($e->getMessage()) {
                return Redirect::back()->with('success_message', 'Please try again with valid email address!');
            }
        }
        return Redirect::back()->with('success_message', 'Your email sent successfully!');
    }
    
    public function regulation()
    {
        $data['Regulation'] = Regulation::orderBy('s_order')->get();
        return view('front_end.regulation' , $data ,$this->common() );
    }

    public function about_us()
    {

        $data['text'] = Page::where('id', 2)->first();

        return view('front_end.about' , $data , $this->common() );
    }

    public function history()
    {
        $data['text'] = Page::where('id', 5)->first();

        return view('front_end.history' , $data , $this->common() );
    }

    public function front_contract()
    {
        $data['address_contact'] = OurLocation::first();
        return view('front_end.contract' ,$data, $this->common()  );
    }

    public function request_chng()
    {
        $data['address_contact'] = OurLocation::first();
        return view('front_end.request' ,$data, $this->common()  );

    }

    public function request_send(Request $request)
    {
      $data = array();
      $validateData = $request->validate([
            'full_name'=>'required',
            'email'=>'required',
            'subject'=>'required',
            'message'=>'required',
        ]);

        $data['full_name'] = $request->full_name;
        $data['email'] = $request->email;
        $data['subject'] = $request->subject;
        $data['message'] = $request->message;
        $name = $request->full_name;
        $from_email = $request->email;
        $subject = $request->subject;
        Request_res_change::insert($data);
        $d = array('full_name'=>$request->full_name,'email'=>$request->email,'subject'=>$request->subject,'mess'=>$request->message);
        \Mail::send('email.contact_mail',$d,function($message) use ($from_email, $subject, $name){
            $message->to('info@patrishisports.com','Admin')
                    ->subject($subject);
            $message->from($from_email,$name);
            $message->replyTo($from_email, $name); 
        });
        return Redirect::back()->with('success_message', 'Your request sent successfully!');
    }

    public function location()
    {
        $events = Event::all();  
          $key= '';
       $settings = Setting::all();
        foreach($settings as $s){
            if($s->column_name=='API KEY'){
           $key = $s->value;
            }
        } 
        return view('admin.location.index',['events'=>$events,'key'=>$key]);
    }

    public function location_up(Request $request)
    {      
      if($request->our_location){
            $validateData = $request->validate([
                'address_first'=>'required',
                'email'=>'required|email',
                'number_two'=>'unique:our_locations,contract_two',
            ]);
        } 
        else{
            $validateData = $request->validate([
                'address_first'=>'required',
                'event'=>'required',
                'email'=>'required|email',
            ]);
        }
      
        if($request->our_location){
            $our_location = OurLocation::first();
            $our_location->address_first = $request->address_first;
            $our_location->latitude = $request->latitude;
            $our_location->longitude = $request->longitude;
            $our_location->contract_two = $request->number_one;
            $our_location->contract_three = $request->number_two;
            $our_location->contract_one = $request->email;
            if($our_location->update()){
                return Redirect::back()->with('msg', 'Successfully Saved');
            }
        }
        $check_event = Location::where('event_id',$request->event)->first();
        if($check_event!=null){
            return Redirect::back()->with('msg', 'Already the event has address');

        }
        $data = array();
        $data = new Location();
        $data['address_first'] = $request->address_first;
        $data['latitude'] = $request->latitude;
        $data['longitude'] = $request->longitude;
        $data['event_id'] = $request->event;
        $data['contract_two'] = $request->number_one;
        $data['contract_three'] = $request->number_two;
        $data['contract_one'] = $request->email;

        if($data->save()){
            return Redirect::back()->with('msg', 'Successfully Saved');
        }
    }
    
    public function regulation_create_form(){
        return view('admin.page.regulation_create');
    }

    public function regulation_create_form_submit(Request $request){
        $validateData = $request->validate([
            'question'=>'required',
            'answer'=>'required',
        ]);
        $regulation = new Regulation();
        $regulation->question = $request->question;
        $regulation->answer = $request->answer;
        if($regulation->save()){
            return redirect()->route('manage.regulation_list_index')->with('success_message','Regulation is created successfully!');
        }    
    }
    
    public function latitude_longitude(Request $request){
        
          $mysettings =[];
           $settings = Setting::all();
            foreach($settings as $s){
                if($s->column_name=='API KEY'){
                $mysettings = $s;
                }
            }
         
            
        $place_id = $request->place_id;
        $response = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?placeid=".$place_id."&fields=name,geometry&key=".$mysettings->value), true);
        
        $response1 = [
            'latitude'=>$response['result']['geometry']['location']['lat'],
            'longitude'=>$response['result']['geometry']['location']['lng']
        ];
        return response()->json($response1);
    }
    
    public function our_location_update_form(){
        $events = Event::all();
        $event_location = OurLocation::first();
    $key= '';
       $settings = Setting::all();
        foreach($settings as $s){
            if($s->column_name=='API KEY'){
           $key = $s->value;
            }
        } 
        
        return view('admin.location.our_location_create',['event_location'=>$event_location,'events'=>$events,'key'=>$key]);
    }
    
    public function sort_regulation(){

        $data['data'] = Regulation::all();

        $view = view('admin.page.sort_regulation' , $data);
        echo $view->render();
    }

    public function update_sort(Request $request){
        $data['oder_array'] = $request->oder_array;
        $data['oder_array_id'] = $request->oder_array_id;

        foreach ($data['oder_array_id'] as $key => $value) {
            DB::table('regulations')
              ->where('id', $value)
              ->update(['s_order' => $data['oder_array'][$key]]);
          }

          return redirect()->back();
    }

    public function image_process($file_name)
    {
        if ($file_name) {
             $image = $request->file($file_name);

             $image_name = time() . rand(10000,9999999).'.' . $image->getClientOriginalExtension();


             $destinationPath = 'assets/images/newsfeed';
             $resize_image_bigger = Image::make($image->getRealPath());

             $resize_image_bigger->resize(720, 388, function($constraint){
              $constraint->aspectRatio();
             })->save($destinationPath . '/' . $image_name);

             $data['image'] = $destinationPath . $image_name;
        }

         return $data;
    }

     public function news_feed(){

        $data['data'] = NewsFeed::all();

        return  view('admin.newsfeed.index' , $data);
    }

    public function add_news(){

        return  view('admin.newsfeed.add');
    }

    public function news_feed_store(Request $request){

     
        $validateData = $request->validate([
        'title'=>'required',
        'description'=>'required',
        'status'=>'required',
        'image'=>'required|dimensions:min_width=720,min_height=388',
        'news_date'=>'required',
        //'url_link'=>'required',
        // 'set_big_image'=>'required',
        ]);
        
        if ($request->set_big_image == 1) {
            DB::table('news_feeds')
              ->where('set_big_image', 1)
              ->update(['set_big_image' => 0]);
        }


        if ($image=$request->file('image')) {

             //$image_name = time() . rand(10000,9999999).'.' . $image->getClientOriginalExtension();
             $destinationPath = 'assets/images/newsfeed/';
             $file_name = time() . rand(10000,9999999).'.' . $image->getClientOriginalExtension();
             $dbUrl = $destinationPath."/".$file_name;

            $image->move($destinationPath,$dbUrl);
             //$resize_image_bigger = Image::make($image->getRealPath());

             //$resize_image_bigger->resize(720, 388, function($constraint){
              //$constraint->aspectRatio();
             //})->save($destinationPath . '/' . $image_name);

             $data['image'] = $destinationPath . $file_name;
         
        }

        $x = str_replace('<figure class="media">', ' ', $request->description);
        $x = str_replace('</figure>', ' ', $x);

        $data['title'] = $request->title;
        $data['description'] = $x;
        $data['status'] = $request->status;
        $data['news_date'] = date("Y-m-d", strtotime($request->news_date));
        //$data['url_link'] = $request->url_link;
        // $data['set_big_image'] = $request->set_big_image;

        NewsFeed::insert($data);

        return Redirect::to('news-feed')->with('msg', 'Successfully Added'); 

    }

    public function edit_feed($id){


      $data['data'] = NewsFeed::where('id', $id)->first();

      return view('admin.newsfeed.edit' , $data);

    }

    public function update_newsfeed(Request $request){

        $data = NewsFeed::where('id',$request->id)->first();

        $validateData = $request->validate([
            'title'=>'required',
            'description'=>'required',
            'status'=>'required',
            'news_date'=>'required',
            //'url_link'=>'required',
            // 'set_big_image'=>'required',
            'image'=>'dimensions:width=720,height=388',
            ]);

        if ($request->set_big_image == 1) {
            DB::table('news_feeds')
              ->where('set_big_image', 1)
              ->update(['set_big_image' => 0]);
        }


        $x = str_replace('<figure class="media">', ' ', $request->description);
        $x = str_replace('</figure>', ' ', $x);

        if ($image=$request->file('image')) {
 
           $uploadPath = 'assets/images/newsfeed';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);
      
           $data['image']= $dbUrl;
         
        }

        $data['title'] = $request->title;
        $data['description'] = $x;
        $data['status'] = $request->status;
        $data['news_date'] = date("Y-m-d", strtotime($request->news_date));
        //$data['url_link'] = $request->url_link;
        // $data['set_big_image'] = $request->set_big_image;


        if($data->update()){
            return Redirect::to('news-feed')->with('msg', 'Successfully Updated'); 
        }

    }

    public function delete_newsfeed(Request $request)
    {
      $id = NewsFeed::where('id',$request->id)->first();
        if($id->delete()){
            echo json_decode(1);
        }
    }

    public function news_section_interval_img($id)
    {

      $x = Session::get('NewsFeed_ids'); 
      $data['newsfeed'] =  NewsFeed::where('status', 1)->where('id',$id)->whereIn('id' , $x)->select('image','news_date', 'id')->first();

      if ($data['newsfeed'] =='') {
          $data['newsfeed'] =  NewsFeed::where('status', 1)->whereIn('id' , $x)->first();
      }

      $view = view('front_end.newsSection.interval_img' , $data);
      echo $view->render();

    }

    public function news_section_interval($id)
    {
      $x = Session::get('NewsFeed_ids'); 

      $data['newsfeeds'] =  NewsFeed::where('status', 1)->where('id',$id)->whereIn('id' , $x)->first();
      if ($data['newsfeeds'] =='') {
          $data['newsfeeds'] =  NewsFeed::where('status', 1)->whereIn('id' , $x)->first();
      }


      $view = view('front_end.newsSection.interval_img_2' , $data);
      echo $view->render();

    }

    public function news_section($id)
    {
        $data['newsfeed'] =  NewsFeed::where('status', 1)->where('id',$id)->first();

        //$data['NewsFeed_small'] = NewsFeed::where('status', 1)->orderBy('news_date','DESC')->orderBy('id','DESC')->where('set_big_image',0)->take(6)->get();
        $data['NewsFeed_small'] = NewsFeed::where('status', 1)->orderBy('news_date','DESC')->orderBy('id','DESC')->take(6)->get();
        
        return view('front_end.newsSection.index' , $data , $this->common());
    }
}
