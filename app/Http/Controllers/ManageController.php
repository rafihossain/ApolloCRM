<?php

namespace App\Http\Controllers;

use App\OldEvent;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Event;
use App\Athlete;
use DB;
use App\AthleteLog;
use App\EventRanking;
use App\OverallRanking;
use App\Team;
use App\PastEvent;
use App\EventGallery;
use App\EventMovie;
use App\AwardsPrize;
use App\Regulation;
use App\Location;
use App\EventDate;
use App\EventTime;
use App\EventWeekDay;
use App\EventLocation;
use App\EventInformation;
use App\ScheduleHeader;
use App\Setting;

class ManageController extends Controller
{
    

    public function event_list_index(){
		$events = Event::all();
        	 $key = '';
            $settings = Setting::all();
            foreach($settings as $s){
            if($s->column_name=='API KEY'){
                $key = $s->value;
            }
            }
        return view('admin.manage.event_list',['events'=>$events,'key'=>$key]);
    }
    
    public function past_event_list_index(){
        $events = OldEvent::all();
        return view('admin.manage.past_event_list',['events'=>$events]);
    }
    public function past_event_edit_form($id){
        	 $key = '';
            $settings = Setting::all();
            foreach($settings as $s){
            if($s->column_name=='API KEY'){
                $key = $s->value;
            }
            }

        $event = OldEvent::where('id',$id)->first();
        return view('admin.manage.past_event_edit',['event'=>$event,'key'=>$key]);
    }
    public function past_event_list(Request $request)
    {
        if($request->event){
            return Datatables::of(OldEvent::query()->where('id',$request->event)->orderBy('id','desc')->get())
                ->editColumn('type', function(OldEvent $e) {
                    if($e->type==1){
                        return 'Kids Ranking';
                    }
                    elseif($e->type==2){
                        return 'International';
                    }
                    else{
                        return 'Overall Ranking';
                    }
                })
                ->editColumn('action', function(OldEvent $e) {
                    $dbname = DB::connection()->getDatabaseName();
                    $tb = 'Tables_in_'.$dbname;
                    $mytables = array();
                    $tables = DB::select('SHOW TABLES');
                    foreach($tables as $t){
                        if(strpos($t->$tb,'eventdata_')>-1){
                            $mytables[] = $t->$tb;
                        }
                    }
                    $query = array();
                    $has_csv = 0;
                    foreach($mytables as $mytbl){
                        $mytbl = str_replace('s','',$mytbl);
                        $model = 'App\\'.$mytbl;
                        $query = $model::where('event_id',$e->id)->get();
                        if($query->count()>0){
                            $has_csv = 1;
                        }
                    }
                    $html = '';
                    $html .= '<a href="'.route('manage.past_event_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>&nbsp;';
                    $html .= '<a href="javascript:;" onclick="deleteEvent('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>&nbsp;';
                    if($has_csv==1){
                        $html .= '<a href="javascript:;" onclick="deleteCsv('.$e->id.')" class="waves-effect waves-light btn orange">Delete CSV</a>&nbsp;';
                    }else{
                        $html .= '<a href="'.route('event.import_past_csv_form').'"  class="waves-effect waves-light btn green">Upload CSV</a>&nbsp;';
                    }

                    $html .= '<a href="javascript:;" onclick="copyEvent('.$e->id.')" class="waves-effect waves-light btn green">Copy</a>';

                    return $html;
                })
                ->escapeColumns([])
                ->make(true);
        }
        else{
            return Datatables::of(OldEvent::query()->orderBy('id','desc')->get())
                ->editColumn('type', function(OldEvent $e) {
                    if($e->type==1){
                        return 'Kids Ranking';
                    }
                    elseif($e->type==2){
                        return 'International';
                    }
                    else{
                        return 'Overall Ranking';
                    }
                })
                ->editColumn('action', function(OldEvent $e) {
                    $dbname = DB::connection()->getDatabaseName();
                    $tb = 'Tables_in_'.$dbname;
                    $mytables = array();
                    $tables = DB::select('SHOW TABLES');
                    foreach($tables as $t){
                        if(strpos($t->$tb,'eventdata_')>-1){
                            $mytables[] = $t->$tb;
                        }
                    }
                    $query = array();
                    $has_csv = 0;
                    foreach($mytables as $mytbl){
                        $mytbl = str_replace('s','',$mytbl);
                        $model = 'App\\'.$mytbl;
                        $query = $model::where('event_id',$e->id)->get();
                        if($query->count()>0){
                            $has_csv = 1;
                        }
                    }
                    $html = '';
                    $html .= '<a href="'.route('manage.past_event_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>&nbsp;';
                    $html .= '<a href="javascript:;" onclick="deleteEvent('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>&nbsp;';
                    if($has_csv==1){
                        $html .= '<a href="javascript:;" onclick="deleteCsv('.$e->id.')"  class="waves-effect waves-light btn orange">Delete CSV</a>&nbsp;';
                    }else{
                        $html .= '<a href="'.route('event.import_past_csv_form').'"  class="waves-effect waves-light btn green">Upload CSV</a>&nbsp;';
                    }
//
                    $html .= '<a href="javascript:;" onclick="copyEvent('.$e->id.')" class="waves-effect waves-light btn green">Copy</a>&nbsp;';
//                    if($e->type==2){
//                        if($e->event_visibility==1){
//                            $html .= '<a href="javascript:;" onclick="visibleEvent('.$e->id.')" class="waves-effect waves-light btn brown">Hide</a>';
//                        }
//                        else{
//                            $html .= '<a href="javascript:;" onclick="visibleEvent('.$e->id.')" class="waves-effect waves-light btn gray">Show</a>';
//                        }
//
//                    }
                    return $html;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }
    public function past_event_delete(Request $request)
    {
        $event = OldEvent::where('id',$request->id)->first();
        if (!empty($event))
        {
            $event_year = $event->event_year;
            $table = 'eventdata_'.$event_year;
            $model = 'App\\'.$table;
            $delete_event_data = $model::where('event_id',$event->id)->get()->each->delete();
            if($event->delete()){
                echo 1;
            }
        }
    }
    public function past_event_csv_delete(Request $request)
    {
        $event = OldEvent::where('id',$request->id)->first();
        if (!empty($event))
        {
            $event_year = $event->event_year;
            $table = 'eventdata_'.$event_year;
            $model = 'App\\'.$table;
            $delete_event_data = $model::where('event_id',$event->id)->get()->each->delete();
            echo 1;
        }
    }
    public function past_event_copy(Request $request)
    {
        $event_copy = OldEvent::where('id',$request->id)->first();
        if (!empty($event_copy))
        {
            $event = new OldEvent();
            $event->event_name = $event_copy->event_name.' (copied)';
            $event->event_year = $event_copy->event_year;
            $event->event_date = date('Y-m-d',strtotime($event_copy->event_date));
            $event->link = $event_copy->link;
            $event->event_type = $event_copy->event_type;
            if($event->save()){
                echo 1;
            }
        }
    }
    public function event_list(Request $request){ 
			   if($request->event){
			   return Datatables::of(Event::query()->where('id',$request->event)->orderBy('id','desc')->get())
               ->editColumn('type', function(Event $e) {
                  if($e->type==1){
                    return 'Kids Ranking';
                  }
                  elseif($e->type==2){
                    return 'International';
                  }
                  else{
                    return 'Overall Ranking';
                  }
                }) 
                ->editColumn('action', function(Event $e) {
					 $dbname = DB::connection()->getDatabaseName();
					$tb = 'Tables_in_'.$dbname;
					$mytables = array();
					$tables = DB::select('SHOW TABLES');
					foreach($tables as $t){
						if(strpos($t->$tb,'eventdata_')>-1){
							$mytables[] = $t->$tb;
						}
					}
					$query = array();
					$has_csv = 0;
					foreach($mytables as $mytbl){
						$mytbl = str_replace('s','',$mytbl);
						$model = 'App\\'.$mytbl;
						$query = $model::where('event_id',$e->id)->get();
						if($query->count()>0){
							$has_csv = 1;
						}
					}
                  $html = '';
                  $html .= '<a href="'.route('manage.event_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>&nbsp;';
                  $html .= '<a href="javascript:;" onclick="deleteEvent('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>&nbsp;';
					if($has_csv==1){
						$html .= '<a href="javascript:;" onclick="deleteCsv('.$e->id.')" class="waves-effect waves-light btn orange">Delete CSV</a>&nbsp;';
					}
					
					$html .= '<a href="javascript:;" onclick="copyEvent('.$e->id.')" class="waves-effect waves-light btn green">Copy</a>';
				 	
                  return $html;
                }) 
               ->escapeColumns([])
               ->make(true);
			   }
			   else{
			   	return Datatables::of(Event::query()->orderBy('id','desc')->get())
               ->editColumn('type', function(Event $e) {
                  if($e->type==1){
                    return 'Kids Ranking';
                  }
                  elseif($e->type==2){
                    return 'International';
                  }
                  else{
                    return 'Overall Ranking';
                  }
                }) 
                ->editColumn('action', function(Event $e) {
					 $dbname = DB::connection()->getDatabaseName();
					$tb = 'Tables_in_'.$dbname;
					$mytables = array();
					$tables = DB::select('SHOW TABLES');
					foreach($tables as $t){
						if(strpos($t->$tb,'eventdata_')>-1){
							$mytables[] = $t->$tb;
						}
					}
					$query = array();
					$has_csv = 0;
					foreach($mytables as $mytbl){
						$mytbl = str_replace('s','',$mytbl);
						$model = 'App\\'.$mytbl;
						$query = $model::where('event_id',$e->id)->get();
						if($query->count()>0){
							$has_csv = 1;
						}
					}
                  $html = '';
                  $html .= '<a href="'.route('manage.event_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>&nbsp;';
                  $html .= '<a href="javascript:;" onclick="deleteEvent('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>&nbsp;';
					if($has_csv==1){
						$html .= '<a href="javascript:;" onclick="deleteCsv('.$e->id.')" class="waves-effect waves-light btn orange">Delete CSV</a>&nbsp;';
					}
					
					$html .= '<a href="javascript:;" onclick="copyEvent('.$e->id.')" class="waves-effect waves-light btn green">Copy</a>&nbsp;';
					if($e->type==2){
				 if($e->event_visibility==1){
				 $html .= '<a href="javascript:;" onclick="visibleEvent('.$e->id.')" class="waves-effect waves-light btn brown">Hide</a>';
				 }
				else{
				 $html .= '<a href="javascript:;" onclick="visibleEvent('.$e->id.')" class="waves-effect waves-light btn gray">Show</a>';
				}
				 
				 }
                  return $html;
                }) 
               ->escapeColumns([])
               ->make(true);
			   }	
               
    }
	
	public function visible_event(Request $request){
		$event = Event::where('id',$request->id)->first();
		if($event->event_visibility==1){
			$event->event_visibility = 0;
		}
		else{
			$event->event_visibility = 1;		
		}
		if($event->update()){
			echo 1;
		}
	}

	public function running_event_list_index(){
	  $december =  date("F", strtotime(date('Y-m-d') ));

              if ($december == 'December') {
                  $data['current_year'] = date('Y') + 1;
                  $data['next_year'] = date('Y') + 2 ;
              }else{
                  $data['current_year'] = date('Y');
                  $data['next_year'] = date('Y') + 1 ;
              }
		$events = Event::where('event_year',$data['current_year'])->where('type',0)->orderBy('id','desc')->get();
      return view('admin.manage.running_event_list',['events'=>$events]);
  }

  public function running_event_list(Request $request){ 
              $december =  date("F", strtotime(date('Y-m-d') ));

              if ($december == 'December') {
                  $data['current_year'] = date('Y') + 1;
                  $data['next_year'] = date('Y') + 2 ;
              }else{
                  $data['current_year'] = date('Y');
                  $data['next_year'] = date('Y') + 1 ;
              }
	   if($request->event){
	   	return Datatables::of(Event::query()->where('event_year',$data['current_year'])->where('type',0)->where('id',$request->event)->orderBy('id','desc')->get())
             ->editColumn('type', function(Event $e) {
                if($e->type==1){
                  return 'Kids Ranking';
                }
                else{
                  return 'Overall Ranking';
                }
              }) 
              ->editColumn('action', function(Event $e) {
				  $dbname = DB::connection()->getDatabaseName();
					$tb = 'Tables_in_'.$dbname;
					$mytables = array();
					$tables = DB::select('SHOW TABLES');
					foreach($tables as $t){
						if(strpos($t->$tb,'eventdata_')>-1){
							$mytables[] = $t->$tb;
						}
					}
					$query = array();
					$has_csv = 0;
					foreach($mytables as $mytbl){
						$mytbl = str_replace('s','',$mytbl);
						$model = 'App\\'.$mytbl;
						$query = $model::where('event_id',$e->id)->get();
						if($query->count()>0){
							$has_csv = 1;
						}
					}
                $html = '';
                $html .= '<a href="'.route('manage.event_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>&nbsp;';
                $html .= '<a href="javascript:;" onclick="deleteEvent('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>&nbsp;';
				  if($has_csv==1){
				  
				  $html .= '<a href="javascript:;" onclick="deleteCsv('.$e->id.')" class="waves-effect waves-light btn orange">Delete CSV</a>&nbsp;';
				  }
                return $html;
              }) 
             ->escapeColumns([])
             ->make(true);
	   }
	  else{
	  	return Datatables::of(Event::query()->where('event_year',$data['current_year'])->where('type',0)->orderBy('id','desc')->get())
             ->editColumn('type', function(Event $e) {
                if($e->type==1){
                  return 'Kids Ranking';
                }
                else{
                  return 'Overall Ranking';
                }
              }) 
              ->editColumn('action', function(Event $e) {
				  $dbname = DB::connection()->getDatabaseName();
					$tb = 'Tables_in_'.$dbname;
					$mytables = array();
					$tables = DB::select('SHOW TABLES');
					foreach($tables as $t){
						if(strpos($t->$tb,'eventdata_')>-1){
							$mytables[] = $t->$tb;
						}
					}
					$query = array();
					$has_csv = 0;
					foreach($mytables as $mytbl){
						$mytbl = str_replace('s','',$mytbl);
						$model = 'App\\'.$mytbl;
						$query = $model::where('event_id',$e->id)->get();
						if($query->count()>0){
							$has_csv = 1;
						}
					}
                $html = '';
                $html .= '<a href="'.route('manage.event_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>&nbsp;';
                $html .= '<a href="javascript:;" onclick="deleteEvent('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>&nbsp;';
				  if($has_csv==1){
				  
				  $html .= '<a href="javascript:;" onclick="deleteCsv('.$e->id.')" class="waves-effect waves-light btn orange">Delete CSV</a>&nbsp;';
				  }
                return $html;
              }) 
             ->escapeColumns([])
             ->make(true);
	  }
             
  }
	
	
    public function athlete_list_index(){
        return view('admin.manage.athlete_list');
    }

    public function athlete_list(){ 
        return Datatables::of(Athlete::query()->orderBy('id','desc')->get()) 
        ->editColumn('athlete_image', function(Athlete $e) {
          $html = '';
          if($e->image==null){
            $html = '<img src="'.url('/').'/'.'athlete_image/J.J.-Redick-1.png'.'" style="width:70px;height:70px;">';
          }
          else{
            $html = '<img src="'.url('/').'/'.$e->image.'" style="width:70px;height:70px;">';
          }
          return $html;
        }) 
        ->editColumn('mrp', function(Athlete $e) {
            return strpos($e->mrp,'.')>-1?number_format((float)$e->mrp, 2, '.', ''):$e->mrp;
          }) 
          ->editColumn('arp', function(Athlete $e) {
            return strpos($e->arp,'.')>-1?number_format((float)$e->arp, 2, '.', ''):$e->arp;
          })
        ->editColumn('action', function(Athlete $e) {
           $html = '';
           $html = '<div style="text-align:center;"><a href="'.route('manage.set_athlete_image_form',['id'=>$e->id]).'" class="waves-effect waves-light btn green">Change Image</a>';
          $html.= '<a href="'.route('manage.athlete_details',['id'=>$e->id]).'" class="btn btn-primary">View Details</a>';
          $html .= '&nbsp;<a href="javascript:;" onclick="deleteAthlete('.$e->id.')" class="waves-effect waves-light btn red">Delete</a></div>';
          return $html;
        }) 
        ->escapeColumns([])
        ->make(true);
      }

    public function athlete_details($id){
      $athlete = Athlete::where('id',$id)->first();
      return view('admin.manage.athlete_details',['athlete'=>$athlete]);
    }  

    public function athlete_events(Request $request){
      $athlete_name = Athlete::where('id',$request->id)->first();
      $tables = DB::select('SHOW TABLES');
      $dbname = DB::connection()->getDatabaseName();
      $tb = 'Tables_in_'.$dbname;
      $mytables = array();
      foreach($tables as $t){
        if(strpos($t->$tb,'eventdata_')>-1){
          $mytables[] = $t->$tb;
        }
      }
      $query = array();
      foreach($mytables as $mytbl){
        $mytbl = str_replace('s','',$mytbl);
        $model = 'App\\'.$mytbl;
        $query[] = $model::where('athlete',$athlete_name->athlete_name)->get();
      }
      $data = array();
      foreach($query as $q){
        foreach($q as $qq){
          $data[] = $qq;
        }
      }
      return Datatables::of($data) 
        ->escapeColumns([])
        ->make(true);
    }

    public function event_delete(Request $request){
      $event = Event::where('id',$request->id)->first();
      $event_log = AthleteLog::where('event_id',$event->id)->get();
      if($event_log->count()>0){
        $event_log->each->delete();
      }
      $event_award = AwardsPrize::where('event_id',$event->id)->get();
      if($event_award->count()>0){
        $event_award->each->delete();
      }
      $event_award = AwardsPrize::where('event_id',$event->id)->get();
      if($event_award->count()>0){
        $event_award->each->delete();
      }
      $abcd = DB::select('SHOW TABLES');
      $dbname = DB::connection()->getDatabaseName(); 
      $tb = 'Tables_in_'.$dbname;

      foreach ($abcd as $key => $value) {
      $strpos = strpos($value->$tb , "eventdata" );
        if($strpos !== false ){
          $year2[] = $value->$tb;
        }
      }

      $ath = array();
      foreach($year2 as $t){
        $tb_name = str_replace('s','',$t);
        $model = 'App\\'.$tb_name;
        $delete_event_data = $model::where('event_id',$event->id)->get()->each->delete();
      }
      $event_date = EventDate::where('event_id',$event->id)->first();
      if($event_date!=null){
        $event_date->delete();
      }
      $event_location = EventLocation::where('event_id',$event->id)->first();
      if($event_location!=null){
        $event_location->delete();
      }
      $event_time = EventTime::where('event_id',$event->id)->first();
      if($event_time!=null){
        $event_time->delete();
      }
      $event_week = EventWeekDay::where('event_id',$event->id)->first();
      if($event_week!=null){
        $event_week->delete();
      }
      $event_gallery = EventGallery::where('event_id',$event->id)->get();
      if($event_gallery->count()){
        foreach($event_gallery as $e){
          @unlink($e->image);
          $e->delete();
        }
      }
      $event_movie = EventMovie::where('event_id',$event->id)->get();
      if($event_movie->count()){
        foreach($event_movie as $m){
          if($m->movies!=null){
            @unlink($m->movies);
          }
          $m->delete();
        }
      }
      $event_info = EventInformation::where('event_id',$event->id)->first();
      if($event_info!=null){
        @unlink($event_info->image);
        $event_info->delete();
      }
      $location = Location::where('event_id',$event->id)->first();
      if($location!=null){
        $location->delete();
      }
      $event_ranking = EventRanking::where('event_id',$event->id)->get();
      if($event_ranking->count()>0){
        foreach($event_ranking as $e){
          $e->delete();
        }
      }
	  $check_id = OverallRanking::where('event_id',$event->id)->first();
	  if($check_id!=null){
	  	$all_ids = OverallRanking::select('event_id')->where('event_date','<',$check_id->event_date)->whereYear('event_date',date('Y',strtotime($check_id->event_date)))->where('age_type',$check_id->age_type)->groupBy('event_id')->orderBy('event_date','asc')->get();
		  
		  if($all_ids->count()>0){
			  foreach($all_ids as $a){
				DB::table('overall_events')->insert(['event_id'=>$a->event_id]);
				DB::table('age_wise_events')->insert(['event_id'=>$a->event_id]);
				DB::table('overall_ranking_updates')->insert(['event_id'=>$event->id]);
				  
			  }
		  }
		  
	  }	
      $overall_ranking = OverallRanking::where('event_id',$event->id)->get();
      if($overall_ranking->count()>0){
        foreach($overall_ranking as $o){
          $o->delete();
        }
      }
	$check_overall_events = DB::table('overall_events')->where('event_id',$event->id)->first();
	if($check_overall_events!=null){
		DB::table('overall_events')->delete($check_overall_events->id);
	}
	$check_age_events = DB::table('age_wise_events')->where('event_id',$event->id)->first();
	if($check_age_events!=null){
		DB::table('age_wise_events')->delete($check_age_events->id);
	}
	$check_overll_log = DB::table('overall_ranking_logs')->where('log_id',$event->id)->first();
	if($check_overll_log!=null){
		DB::table('overall_ranking_logs')->delete($check_overll_log->id);
	}
	$check_age_log = DB::table('age_wise_ranking_logs')->where('log_id',$event->id)->first();
	if($check_age_log!=null){
		DB::table('age_wise_ranking_logs')->delete($check_age_log->id);
	}
	$check_overll_update = DB::table('overall_ranking_updates')->where('event_id',$event->id)->first();
	if($check_overll_update!=null){
		DB::table('overall_ranking_updates')->delete($check_overll_update->id);
	}
	$check_overll_update_log = DB::table('overall_ranking_update_logs')->where('log_id',$event->id)->first();
	if($check_overll_update_log!=null){
		DB::table('overall_ranking_update_logs')->delete($check_overll_update_log->id);
	}
      $past_result = PastEvent::where('event_id',$event->id)->first();
      if($past_result!=null){
        $past_result->delete();
      }
      if($event->delete()){
        echo 1;
      }
    }
	
	  public function csv_delete(Request $request){
      $event = Event::where('id',$request->id)->first();
      $event_log = AthleteLog::where('event_id',$event->id)->get();
      if($event_log->count()>0){
        $event_log->each->delete();
      }
      $abcd = DB::select('SHOW TABLES');
      $dbname = DB::connection()->getDatabaseName(); 
      $tb = 'Tables_in_'.$dbname;

      foreach ($abcd as $key => $value) {
      $strpos = strpos($value->$tb , "eventdata" );
        if($strpos !== false ){
          $year2[] = $value->$tb;
        }
      }

      $ath = array();
      foreach($year2 as $t){
        $tb_name = str_replace('s','',$t);
        $model = 'App\\'.$tb_name;
        $delete_event_data = $model::where('event_id',$event->id)->get()->each->delete();
      }
      $event_ranking = EventRanking::where('event_id',$event->id)->get();
      if($event_ranking->count()>0){
        foreach($event_ranking as $e){
          $e->delete();
        }
      }
	    $check_id = OverallRanking::where('event_id',$event->id)->first();
	  if($check_id!=null){
	  	$all_ids = OverallRanking::select('event_id')->where('event_date','<',$check_id->event_date)->whereYear('event_date',date('Y',strtotime($check_id->event_date)))->where('age_type',$check_id->age_type)->groupBy('event_id')->orderBy('event_date','asc')->get();
		  
		  if($all_ids->count()>0){
			  foreach($all_ids as $a){
				DB::table('overall_events')->insert(['event_id'=>$a->event_id]);
				DB::table('age_wise_events')->insert(['event_id'=>$a->event_id]);
				DB::table('overall_ranking_updates')->insert(['event_id'=>$event->id]);
				  
			  }
		  }
		  
	  }	  
      $overall_ranking = OverallRanking::where('event_id',$event->id)->get();
      if($overall_ranking->count()>0){
        foreach($overall_ranking as $o){
          $o->delete();
        }
      }
	$check_overall_events = DB::table('overall_events')->where('event_id',$event->id)->first();
	if($check_overall_events!=null){
		DB::table('overall_events')->delete($check_overall_events->id);
	}
	$check_age_events = DB::table('age_wise_events')->where('event_id',$event->id)->first();
	if($check_age_events!=null){
		DB::table('age_wise_events')->delete($check_age_events->id);
	}
	$check_overll_log = DB::table('overall_ranking_logs')->where('log_id',$event->id)->first();
	if($check_overll_log!=null){
		DB::table('overall_ranking_logs')->delete($check_overll_log->id);
	}
	$check_age_log = DB::table('age_wise_ranking_logs')->where('log_id',$event->id)->first();
	if($check_age_log!=null){
		DB::table('age_wise_ranking_logs')->delete($check_age_log->id);
	}
	$check_overll_update = DB::table('overall_ranking_updates')->where('event_id',$event->id)->first();
	if($check_overll_update!=null){
		DB::table('overall_ranking_updates')->delete($check_overll_update->id);
	}
	$check_overll_update_log = DB::table('overall_ranking_update_logs')->where('log_id',$event->id)->first();
	if($check_overll_update_log!=null){
		DB::table('overall_ranking_update_logs')->delete($check_overll_update_log->id);
	}	
        echo 1;

    }
	

  public function event_copy(Request $request){
    //$event_copy = Event::where('id',$request->id)->first();
    $tasks = Event::where('id',$request->id)->first();
    $newTask = $tasks->replicate();
    $newTask->save();

    $location = Location::where('event_id',$request->id)->first();
    if ($location !='') {
      $new_location= $location->replicate();
      $new_location->save();
    }
    

    $AwardsPrize = AwardsPrize::where('event_id',$request->id)->first();
    if ($AwardsPrize !='') {
      $new_AwardsPrize= $AwardsPrize->replicate();
      $new_AwardsPrize->save();
    }
    

    $ScheduleHeader = ScheduleHeader::where('event_id',$request->id)->first();
    if ($ScheduleHeader !='') {
      $new_ScheduleHeader= $ScheduleHeader->replicate();
      $new_ScheduleHeader->save();
    }

     echo 1;
    

  }

    public function event_edit_form($id){
      $event = Event::where('id',$id)->first();
      $event_gallery = EventGallery::where('event_id',$id)->orderBy('img_order', 'ASC')->get();
      $event_movie = EventMovie::where('event_id',$id)->get();
      $event_location = Location::where('event_id',$id)->first();
      $event_award_prize = AwardsPrize::where('event_id',$id)->first();
      $event_schedule_header = ScheduleHeader::where('event_id',$id)->first();
      $past_event_results = PastEvent::where('event_id',$id)->orderBy('result_order', 'ASC')->get();
      $data['past_event_results'] = $past_event_results;
      $data['event'] = $event;
      $data['event_gallery'] = $event_gallery;
      $data['event_movie'] = $event_movie;
      $data['event_location'] = $event_location;
      $data['event_award_prize'] = $event_award_prize;
      $data['event_schedule_header'] = $event_schedule_header;
     
     	 $key = '';
            $settings = Setting::all();
            foreach($settings as $s){
            if($s->column_name=='API KEY'){
                $key = $s->value;
            }
            }
            
     $data['key'] =  $key;  
     
      return view('admin.manage.event_edit',$data );
    }

    public function event_edit_form_submit(Request $request){

        //past result start
      if ($request->result_order)
        if ($request->result_order)
        {
            $orders = $request->result_order;
            $k = 1;
            foreach($orders as $order)
            {
                DB::table('past_events')
                    ->where('id', $order)
                    ->update(['result_order'=>$k]);
                $k++;
            }

        }

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
            $o = 1;
            $event = PastEvent::where('event_id',$request->event_id)->orderBy('result_order', 'DESC')->first();
            if (isset($event->result_order) && $event->result_order != '')
            {
                $o = $event->result_order+1;
            }
            foreach ($past_results as $key=>$past_result)
            {
                $past = array();
                if (isset($past_result['past_event_image']) && isset($past_result['past_result_link']))
                {
                    $past['event_id'] = $request->event_id;
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
                $o++;
            }
        }
        //past result end

        $event = Event::where('id',$request->event_id)->first();

        //location
        $data = array();
        $data = Location::where('event_id', $request->event_id)->first();
        if ($data == null || $data =='') {
          if ($request->latitude !='' && $request->longitude !='' ) {
            $data = new Location();
            $data['address_first'] = $request->address_first;
            $data['latitude'] = $request->latitude;
            $data['longitude'] = $request->longitude;
            $data['event_id'] = $request->event_id;
            $data['contract_two'] = $request->contract_two;
            $data['contract_three'] = $request->contract_three;
            $data['contract_one'] = $request->contract_one;
            $data->save();
          }

        }else{
          $data['address_first'] = $request->address_first;
          $data['latitude'] = $request->latitude;
          $data['longitude'] = $request->longitude;
          $data['event_id'] = $request->event_id;
          $data['contract_two'] = $request->contract_two;
          $data['contract_three'] = $request->contract_three;
          $data['contract_one'] = $request->contract_one;
          $data->save();
        }
        $data = array();
        //end location

        //Award
        $award = array();
        $award = AwardsPrize::where('event_id', $request->event_id)->first();
        if ($award == null || $award =='' ) {
          if($request->title_award !='' ){

            $award = new AwardsPrize();
            $award->event_id = $request->event_id;
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
        }else{
          $award->event_id = $request->event_id;
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
       
        //schedule image
        if($request->file('schedule_image')){
            //schedule image
            $image_file = $request->file('schedule_image');
            $image_filename = time().'-'.$image_file->getClientOriginalName();
            $image_file->move("schedule_bg_image/",$image_filename);
            $filepath = "schedule_bg_image/".$image_filename;
            $event->event_schedule_image = $filepath;
        }
        if($request->heading_color){
              $event->schedule_text_color = $request->heading_color;
        }
        if($request->table_header_bg_color){
              $event->table_header_bg_color = $request->table_header_bg_color;
        }

        //schedule image

        //schedule headers
        $headers =array();
        $check_headers = ScheduleHeader::where('event_id',$request->event_id)->first();
        if($check_headers!=null){
          $headers = ScheduleHeader::where('event_id',$request->event_id)->first();
          $headers->event_id = $request->event_id;
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
        }
        else{
          $headers = new ScheduleHeader();
          //if ($headers->event_schedule !='' && $headers->Headers_online_registration !='' && $headers->Headers_cash_payment !='') {
            $headers->event_id = $request->event_id;
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
         // }
        }
        
        $headers =array();

        //end schedule header

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
        $event->type = $request->event_type;
        $event->event_show = $request->event_show;

        //rakesh
        $event->award_prize_show = $request->award_prize_show;
        $event->event_location_show = $request->event_location_show;
        $event->event_schedule_status = $request->event_schedule_status;
        $event->event_badge = $request->event_badge;
        
        $event->event_badge_shirt = $request->event_badge_shirt;
        $event->event_badge_medals = $request->event_badge_medals;
        $event->event_badge_type = $request->event_badge_type;

        if($request->file('banner_image')){
            //banner image
          $banner_file = $request->file('banner_image');
          $banner_filename = time().'-'.$banner_file->getClientOriginalName();
          $banner_file->move("banner_images/",$banner_filename);
          //unlink($event->event_banner_image);
          $filepath = "banner_images/".$banner_filename;
          $event->event_banner_image = $filepath;
        }
        if($request->file('event_winners')){
            //banner image
            $winner_file = $request->file('event_winners');
            $winner_file_name = time().'-'.$winner_file->getClientOriginalName();
            $winner_file->move("event_winners_image/",$winner_file_name);
            //unlink($event->event_banner_image);
            $filepath = "event_winners_image/".$winner_file_name;
            $event->event_winners_image = $filepath;
        }

        if($request->file('coursemap_image')){
              //coursemap image
          $coursemap_file = $request->file('coursemap_image');
          $coursemap_filename = time().'-'.$coursemap_file->getClientOriginalName();
          $coursemap_file->move("coursemap_image/",$coursemap_filename);
          //unlink($event->event_coursemap_image);
          $filepath = "coursemap_image/".$coursemap_filename;
          $event->event_coursemap_image = $filepath;
        }
      
        if($request->file('racerecords_image')){
            //racerecords image
          $racerecords_file = $request->file('racerecords_image');
          $racerecords_filename = time().'-'.$racerecords_file->getClientOriginalName();
          $racerecords_file->move("racerecords_image/",$racerecords_filename);
          //unlink($event->race_records);
          $filepath = "racerecords_image/".$racerecords_filename;
          $event->race_records = $filepath;
        }

        if($request->file('event_logo')){
            //event logo
          $logo_file = $request->file('event_logo');
          $logo_filename = time().'-'.$logo_file->getClientOriginalName();
          $logo_file->move("event_logo/",$logo_filename);
          $filepath = "event_logo/".$logo_filename;
          $event->event_logo = $filepath;
        }
    
    if($request->file('slider_event_logo')){
            //event logo
          $logo_file = $request->file('slider_event_logo');
          $logo_filename = time().'-'.$logo_file->getClientOriginalName();
          $logo_file->move("event_logo/",$logo_filename);
          $filepath = "event_logo/".$logo_filename;
          $event->slider_event_logo = $filepath;
        }

        if($event->update()){
//          if($request->gallery_image){
//            $gallery_images = $request->gallery_image;
//            foreach($gallery_images as $g){
//                $gallery_file = $g['gallery_image'];
//                $filename = time().'-'.$gallery_file->getClientOriginalName();
//                $gallery_file->move('event_gallery/',$filename);
//                $filepath = "event_gallery/".$filename;
//                $gallery = new EventGallery();
//                $gallery->event_id = $event->id;
//                $gallery->image = $filepath;
//                $gallery->save();
//            }
//        }
            if (isset($request->gallery_id) || $request->gallery_image)
            {
                $gallery_id = $request->gallery_id;
                $i = 1;
                if (!empty($gallery_id))
                {
                    foreach($gallery_id as $item)
                    {
                        DB::table('event_galleries')
                            ->where('id', $item)
                            ->update(['img_order'=>$i]);
                        $i++;
                    }
                }
                $img_order = EventGallery::where('event_id',$request->event_id)->orderBy('img_order', 'DESC')->first();
                if (isset($img_order['img_order']) && !empty($img_order['img_order']))
                {
                    $j = $img_order['img_order']+1;
                }else{
                    $j = 1;
                }
                if($request->gallery_image){
                    $gallery_images = $request->gallery_image;
                    foreach($gallery_images as $g){
                        $gallery_file = $g['gallery_image'];
                        $filename = time().'-'.$gallery_file->getClientOriginalName();
                        $gallery_file->move('event_gallery/',$filename);
                        $filepath = "event_gallery/".$filename;
                        $gallery = new EventGallery();
                        $gallery->event_id = $request->event_id;
                        $gallery->image = $filepath;
                        $gallery->img_order = $j;
                        $gallery->save();
                        $j++;
                    }
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
          return redirect()->route('manage.event_list_index')->with('success_message','Event updated successfully!');
        }
    }
	
	public function award_prize_list_index(){
		$events = Event::all();
		return view('admin.manage.award_prize_list',['events'=>$events]);
	}

    public function award_prize_list(Request $request){
	  if($request->event){
	  return Datatables::of(AwardsPrize::query()->where('event_id',$request->event)->orderBy('id','desc')->get()) 
        ->editColumn('event', function(AwardsPrize $e) {
          return $e->event->event_name;
        }) 
        ->editColumn('image', function(AwardsPrize $e) {
          return '<img src="'.url('/').'/'.$e->image.'" style="width:50px;height:50px;" />';
        })
        ->editColumn('action', function(AwardsPrize $e) {
          $html = '';
          $html .= '<a href="'.route('manage.award_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>&nbsp;';
          $html .= '<a href="javascript:;" onclick="deleteAward('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>';
          return $html;
        }) 
        ->escapeColumns([])
        ->make(true);
	  }
		else{
		return Datatables::of(AwardsPrize::query()->orderBy('id','desc')->get()) 
        ->editColumn('event', function(AwardsPrize $e) {
          return $e->event->event_name;
        }) 
        ->editColumn('image', function(AwardsPrize $e) {
          return '<img src="'.url('/').'/'.$e->image.'" style="width:50px;height:50px;" />';
        })
        ->editColumn('action', function(AwardsPrize $e) {
          $html = '';
          $html .= '<a href="'.route('manage.award_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>&nbsp;';
          $html .= '<a href="javascript:;" onclick="deleteAward('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>';
          return $html;
        }) 
        ->escapeColumns([])
        ->make(true);
		}
      
    }

    public function award_delete(Request $request){
      $award = AwardsPrize::where('id',$request->id)->first();
      @unlink($award->image);
      if($award->delete()){
        echo 1;
      }
    }

public function regulation_list_index(){
      return view('admin.manage.regulation_list');
  }

  public function regulation_list(){
    return Datatables::of(Regulation::query()->get()) 
    ->editColumn('action', function(Regulation $e) {
      $html = '';
      $html.='<a href="'.route('manage.regulation_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>';
      $html.='&nbsp;<a href="javascript:;" onclick="deleteRegulation('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>';
      return $html;
    }) 
    ->escapeColumns([])
    ->make(true);
  }

  public function regulation_delete(Request $request){
    $regulation = Regulation::where('id',$request->id)->first();
      if($regulation->delete()){
        echo 1;
      }
  }

  public function regulation_edit_form($id){
    $regulation = Regulation::where('id',$id)->first();
    return view('admin.manage.regulation_edit',['regulation'=>$regulation]);
  }

  public function regulation_edit_form_submit(Request $request){
      $validateData = $request->validate([
        'question'=>'required',
        'answer'=>'required',
      ]);
      $regulation = Regulation::where('id',$request->regulation_id)->first();
      $regulation->question = $request->question;
      $regulation->answer = $request->answer;
      if($regulation->update()){
        return redirect()->route('manage.regulation_list_index')->with('success_message','Regulation is updated successfully!');
      }  
  }
	
	  public function event_location_list_index(){
		$events = Event::all();  
    	return view('admin.manage.event_location_list',['events'=>$events]);
  }

  public function event_location_list(Request $request){
	if($request->event){
		return Datatables::of(Location::query()->where('event_id',$request->event)->get())
    ->editColumn('event_name', function(Location $e) {
      return $e->event->event_name;
    }) 
    ->editColumn('action', function(Location $e) {
      $html = '';
      $html.='<a href="'.route('manage.event_location_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>';
      $html.='&nbsp;<a href="javascript:;" onclick="deleteEventLocation('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>';
      return $html;
    }) 
    ->escapeColumns([])
    ->make(true);
	}
	else{
		return Datatables::of(Location::query()->get())
    ->editColumn('event_name', function(Location $e) {
      return $e->event->event_name;
    }) 
    ->editColumn('action', function(Location $e) {
      $html = '';
      $html.='<a href="'.route('manage.event_location_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>';
      $html.='&nbsp;<a href="javascript:;" onclick="deleteEventLocation('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>';
      return $html;
    }) 
    ->escapeColumns([])
    ->make(true);
	  }
    
  }

  public function event_location_delete(Request $request){
    $event_location = Location::where('id',$request->id)->first();
      if($event_location->delete()){
        echo 1;
      }
  }

  public function event_location_edit_form($id){
    $events = Event::all();
    $event_location = Location::where('id',$id)->first();
    return view('admin.manage.event_location_edit',['event_location'=>$event_location,'events'=>$events]);
  }

  public function event_location_edit_form_submit(Request $request){
            $validateData = $request->validate([
              'address_first'=>'required',
              'event'=>'required',
              'number_one'=>'required',
              'number_two'=>'required',
              'email'=>'required|email',
          ]);
          $check_event = Location::where('id',$request->event_location_id)->first();
          $check_event->address_first = $request->address_first;
          $check_event->latitude = $request->latitude;
          $check_event->longitude = $request->longitude;
          $check_event->event_id = $request->event;
          $check_event->contract_two = $request->number_one;
          $check_event->contract_three = $request->number_two;
          $check_event->contract_one= $request->email;
          if($check_event->update()){
            return redirect()->route('manage.event_location_list_index')->with('success_message', 'Successfully Updated');
        }

}
	
public function athlete_delete(Request $request){
    if($request->id=='all'){
      $athlete_log = AthleteLog::truncate();
      $athletes = Athlete::truncate();
      $abcd = DB::select('SHOW TABLES');
                  $dbname = DB::connection()->getDatabaseName(); 
                  $tb = 'Tables_in_'.$dbname;
                  $event_data_tables = array();
                 foreach ($abcd as $key => $value) {
                  $strpos = strpos($value->$tb , "eventdata" );
                  if ($strpos !== false ) {
                    $event_data_tables[] = $value->$tb;
                  }
                }
        if(count($event_data_tables)>0){
          foreach($event_data_tables as $tb){
            $table = str_replace('s','',$tb);
            $model = 'App\\'.$table;
            $delete_athlete_data = $model::truncate();
          }
        }
        $athlete_event_ranking = EventRanking::truncate();
        $athlete_overall_ranking = OverallRanking::truncate();
    		DB::table('age_wise_events')->truncate();
    		DB::table('age_wise_ranking_logs')->truncate();
    		DB::table('overall_events')->truncate();
    		DB::table('overall_ranking_logs')->truncate();
    		DB::table('overall_ranking_updates')->truncate();
    		DB::table('overall_ranking_update_logs')->truncate();
        $team = Team::truncate();
        echo 1;

    }
    else{
      $athlete_delete = Athlete::where('id',$request->id)->first();
      $athlete_log = AthleteLog::where('athlete_name',$athlete_delete->athlete_name)->get();
      if($athlete_log->count()>0){
        $athlete_log->each->delete();
      }
      $abcd = DB::select('SHOW TABLES');
                $dbname = DB::connection()->getDatabaseName(); 
                $tb = 'Tables_in_'.$dbname;
                $event_data_tables = array();
               foreach ($abcd as $key => $value) {
                $strpos = strpos($value->$tb , "eventdata" );
                if ($strpos !== false ) {
                  $event_data_tables[] = $value->$tb;
                }
              }
      if(count($event_data_tables)>0){
        foreach($event_data_tables as $tb){
          $table = str_replace('s','',$tb);
          $model = 'App\\'.$table;
		  $get_athlete = $model::where('athlete',$athlete_delete->athlete_name)->first();
      
      if ($get_athlete !='') {
        
            $all_ids = $model::select('event_id')->where('event_date','>=',$get_athlete->event_date)->groupBy('event_id')->get(); 
               foreach($all_ids as $a){
                DB::table('overall_events')->insert(['event_id'=>$a->event_id]);
                DB::table('age_wise_events')->insert(['event_id'=>$a->event_id]);
                DB::table('overall_ranking_updates')->insert(['event_id'=>$a->event_id]); 
              }
              
              $delete_athlete_data = $model::where('athlete',$athlete_delete->athlete_name)->get()->each->delete();

          }

        }
		  
      }
      $athlete_event_ranking = EventRanking::where('athlete_name',$athlete_delete->athlete_name)->get();
      if($athlete_event_ranking->count()>0){
       $athlete_event_ranking->each->delete(); 
      }
      $athlete_overall_ranking = OverallRanking::where('athlete_name',$athlete_delete->athlete_name)->get();
      if($athlete_overall_ranking->count()>0){
       $athlete_overall_ranking->each->delete(); 
      }
      $team = Team::all();
      $ath_id = array();
      foreach($team as $t){
        $team_members = json_decode($t->team_members);

        if ( $team_members !='') {
            foreach($team_members as $tm){
            if($athlete_delete->id !=$tm){
              $ath_id[] = $tm;
            }
          }
        }

        if($t->captain==$athlete_delete->id){
          $t->captain = 0;
        }
        if(count($ath_id)>0){
          $athletes_id = json_encode($ath_id);
          $t->team_members = $athletes_id;
        }

        $t->update();

        $ath_id = array();
        $t = array();
  
      }

      $this->team_update();
      if($athlete_delete->delete()){
        echo 1;
      }
    }

  }
	
public function team_update(){
     // Team update
				$teams = Team::all();                                             
            if($teams->count()>0){
                foreach($teams as $t){
                   $year2 = array(); 
                   $sum_overall = 0;
                   $sum_category = 0;
                   $last2 = Team::where('id',$t->id)->first();
                  $team_members_show = json_decode($last2['team_members']);

                  if ($team_members_show != '') {

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
                  $red_jersey =0;

        
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
                   foreach ($team_members_name as $key => $value235ff) {
                    $orange_jersey += DB::table($value)->where('overall_rank', 1)->where('athlete', $value235ff->athlete_name)->sum('overall_rank');
        
                    $blue_jersey += DB::table($value)->where('overall_rank', 1)->where('age_category', 'like', '%U-20%')->where('athlete', $value235ff->athlete_name)->sum('overall_rank');
        
                    $white_jersey += DB::table('athletes')
                      ->join($value, 'athletes.athlete_name', '=', ''.$value.'.athlete')
                      ->join('events', ''.$value.'.event_id', '=', 'events.id')
                      ->where('athletes.athlete_name', '=', $value235ff->athlete_name)
                      ->where('events.type', '=', 1)
                      ->where(''.$value.'.overall_rank', 1)
                      ->sum('overall_rank');

                      $red_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_wise_rank',1)->where('age_type',0)->where('age_category', 'like', '%50-54%')->sum('age_wise_rank');
                      $red_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_wise_rank',1)->where('age_type',0)->where('age_category', 'like', '%55-59%')->sum('age_wise_rank');
                      $red_jersey += DB::table('overall_rankings')->where('event_date','like', '%'.date('Y').'%')->where('athlete_name', $value235ff->athlete_name)->where('age_wise_rank',1)->where('age_type',0)->where('age_category', 'like', '%60+%')->sum('age_wise_rank');
        
                  }
                 }
        
                 $users['orange_jersey'] = $orange_jersey;
                 $users['blue_jersey'] = $blue_jersey;
                 $users['white_jersey'] = $white_jersey;
                 $users['red_jersey'] = $red_jersey;
        
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


                  }
                }
                 

            }
            
            
            //Team update end
  }
  
  
  public function event_schedule_list_index(){
	  $events = Event::all();
    return view('admin.manage.event_schedule_list',['events'=>$events]);
}

public function event_schedule_list(Request $request){ 
		   if($request->event){
			   return Datatables::of(EventDate::query()->where('event_id',$request->event)->get())
           ->editColumn('event_name', function(EventDate $e) {
              return $e->event->event_name;
            }) 
            ->editColumn('date', function(EventDate $e) {
              $html = '';
              $html.= '<span style="color:green;font-weight:bolder;">Online Registration: </span>'.$e->online_registration.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Cash Payments & Bib: </span>'.$e->cash_payment_bib.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Starts of Event: </span>'.$e->start_of_event.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Awards Ceremony: </span>'.$e->award_ceremony.'<br>';
              return $html;
            })
            ->editColumn('week_days', function(EventDate $e) {
              $html = '';
              $html.= '<span style="color:green;font-weight:bolder;">Online Registration: </span>'.$e->event->event_week_day->online_registration.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Cash Payments & Bib: </span>'.$e->event->event_week_day->cash_payment_bib.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Starts of Event: </span>'.$e->event->event_week_day->start_of_event.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Awards Ceremony: </span>'.$e->event->event_week_day->award_ceremony.'<br>';
              return $html;
            })
            ->editColumn('time', function(EventDate $e) {
              $html = '';
              $html.= '<span style="color:green;font-weight:bolder;">Online Registration: </span>'.$e->event->event_time->online_registration.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Cash Payments & Bib: </span>'.$e->event->event_time->cash_payment_bib.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Starts of Event: </span>'.$e->event->event_time->start_of_event.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Awards Ceremony: </span>'.$e->event->event_time->award_ceremony.'<br>';
              return $html;
            })
            ->editColumn('location', function(EventDate $e) {
              $html = '';
              $html.= '<span style="color:green;font-weight:bolder;">Online Registration: </span>'.$e->event->event_location->online_registration.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Cash Payments & Bib: </span>'.$e->event->event_location->cash_payment_bib.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Starts of Event: </span>'.$e->event->event_location->start_of_event.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Awards Ceremony: </span>'.$e->event->event_location->award_ceremony.'<br>';
              return $html;
            })
            ->editColumn('action', function(EventDate $e) {
              $html = '';
              $html.='<a href="'.route('manage.event_schedule_edit_form',['id'=>$e->event->id]).'" class="waves-effect waves-light btn blue">Edit</a>';
              $html.='&nbsp;<a href="javascript:;" onclick="deleteSchedule('.$e->event->id.')" class="waves-effect waves-light btn red">Delete</a>';
              return $html;
            })
           ->escapeColumns([])
           ->make(true);
		   }
			else{
			return Datatables::of(EventDate::query()->get())
           ->editColumn('event_name', function(EventDate $e) {
              return $e->event->event_name;
            }) 
            ->editColumn('date', function(EventDate $e) {
              $html = '';
              $html.= '<span style="color:green;font-weight:bolder;">Online Registration: </span>'.$e->online_registration.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Cash Payments & Bib: </span>'.$e->cash_payment_bib.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Starts of Event: </span>'.$e->start_of_event.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Awards Ceremony: </span>'.$e->award_ceremony.'<br>';
              return $html;
            })
            ->editColumn('week_days', function(EventDate $e) {
              $html = '';
              $html.= '<span style="color:green;font-weight:bolder;">Online Registration: </span>'.$e->event->event_week_day->online_registration.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Cash Payments & Bib: </span>'.$e->event->event_week_day->cash_payment_bib.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Starts of Event: </span>'.$e->event->event_week_day->start_of_event.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Awards Ceremony: </span>'.$e->event->event_week_day->award_ceremony.'<br>';
              return $html;
            })
            ->editColumn('time', function(EventDate $e) {
              $html = '';
              $html.= '<span style="color:green;font-weight:bolder;">Online Registration: </span>'.$e->event->event_time->online_registration.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Cash Payments & Bib: </span>'.$e->event->event_time->cash_payment_bib.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Starts of Event: </span>'.$e->event->event_time->start_of_event.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Awards Ceremony: </span>'.$e->event->event_time->award_ceremony.'<br>';
              return $html;
            })
            ->editColumn('location', function(EventDate $e) {
              $html = '';
              $html.= '<span style="color:green;font-weight:bolder;">Online Registration: </span>'.$e->event->event_location->online_registration.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Cash Payments & Bib: </span>'.$e->event->event_location->cash_payment_bib.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Starts of Event: </span>'.$e->event->event_location->start_of_event.'<br>';
              $html.= '<span style="color:green;font-weight:bolder;">Awards Ceremony: </span>'.$e->event->event_location->award_ceremony.'<br>';
              return $html;
            })
            ->editColumn('action', function(EventDate $e) {
              $html = '';
              $html.='<a href="'.route('manage.event_schedule_edit_form',['id'=>$e->event->id]).'" class="waves-effect waves-light btn blue">Edit</a>';
              $html.='&nbsp;<a href="javascript:;" onclick="deleteSchedule('.$e->event->id.')" class="waves-effect waves-light btn red">Delete</a>';
              return $html;
            })
           ->escapeColumns([])
           ->make(true);
			}
           
}

  public function schedule_delete(Request $request){
    $event_location = EventLocation::where('event_id',$request->id)->first();
    $event_location->delete();
    $event_time = EventTime::where('event_id',$request->id)->first();
    $event_time->delete();
    $event_week_day = EventWeekDay::where('event_id',$request->id)->first();
    $event_week_day->delete();
    $event_date = EventDate::where('event_id',$request->id)->first();
    if($event_date->delete()){
      echo 1;
    }
  }

  public function event_schedule_edit_form($id){
    $events = Event::all();
    $event_location = EventLocation::where('event_id',$id)->first();
    $event_time = EventTime::where('event_id',$id)->first();
    $event_week_day = EventWeekDay::where('event_id',$id)->first();
    $event_date = EventDate::where('event_id',$id)->first();
    return view('admin.manage.event_schedule_edit',['events'=>$events,'event_location'=>$event_location
    ,'event_time'=>$event_time,'event_week_day'=>$event_week_day,'event_date'=>$event_date]);
  }

  public function event_schedule_edit_form_submit(Request $request){
     //event date
     $event_date = EventDate::where('event_id',$request->event_id)->first();
     $event_date->event_id = $request->event;
     $event_date->online_registration = $request->date_online_registration;
     $event_date->cash_payment_bib   = $request->date_cash_payments;
     $event_date->award_ceremony = $request->date_award_ceremony;
     $event_date->bib = $request->date_bib;
	  
     $event_date->start_of_event = $request->date_start_event;
     $event_date->save();
 
     //event time
     $event_time = EventTime::where('event_id',$request->event_id)->first();
     $event_time->event_id = $request->event;
     $event_time->online_registration = $request->time_online_registration;
     $event_time->cash_payment_bib   = $request->time_cash_payments;
     $event_time->bib   = $request->time_bib;
	  
     $event_time->award_ceremony = $request->time_award_ceremony;
     $event_time->start_of_event = $request->time_start_event;
     $event_time->save();
 
     //event week day
     $event_week_day = EventWeekDay::where('event_id',$request->event_id)->first();
     $event_week_day->event_id = $request->event;
     $event_week_day->online_registration = $request->week_online_registration;
     $event_week_day->cash_payment_bib   = $request->week_cash_payments;
     $event_week_day->bib   = $request->week_bib;
	  
     $event_week_day->award_ceremony = $request->week_award_ceremony;
     $event_week_day->start_of_event = $request->week_start_event;
     $event_week_day->save();
 
     //event location
     $event_location = EventLocation::where('event_id',$request->event_id)->first();
     $event_location->event_id = $request->event;
     $event_location->online_registration = $request->location_online_registration;
     $event_location->cash_payment_bib   = $request->location_cash_payments;
     $event_location->bib   = $request->location_bib;
	  
     $event_location->award_ceremony = $request->location_award_ceremony;
     $event_location->start_of_event = $request->location_start_event;
     $event_location->registration_payment = $request->registration_payment;
     $event_location->bib_no_confirmation = $request->bib_no_confirmation;
     $event_location->save();
     return redirect()->route('manage.event_schedule_list_index')->with('success_message','Event Schedule updated successfully!');
  }

  public function gallery_delete(Request $request){
    $gallery = EventGallery::where('id',$request->id)->first();
    $file = $gallery->image;
    if($gallery->delete()){
      @unlink($file);
      echo 1;
    }
  }
    public function delete_past_result(Request $request){
        $past_result = PastEvent::where('id',$request->id)->first();
        $file = $past_result->image;
        $img_url = base_path().'/'.$file;
        $background_image = $past_result->background_image;
        $bg_url = base_path().'/'.$background_image;
        
        if($past_result->delete()){
            unlink($img_url);
            unlink($bg_url);
            echo 1;
        }
    }
  public function movie_delete(Request $request){
    $movie = EventMovie::where('id',$request->id)->first();

    // $file = $movie->movies;
    // if(!$request->youtube){
    //   unlink($file);
    // }    
      if($movie->delete()){
        echo 1;
      }
  }

  public function past_result_list_index(){
	  $events = Event::all();
    return view('admin.manage.past_result_list',['events'=>$events]);
}

public function past_result_list(Request $request){ 
		   if($request->event){
		   return Datatables::of(PastEvent::query()->where('event_id',$request->event)->get())
           ->editColumn('event_name', function(PastEvent $e) {
              return $e->event->event_name;
            }) 
            ->editColumn('image', function(PastEvent $e) {
              return '<img src="'.url('/').'/'.$e->image.'" style="width:100px;height:100px;">';
            })
            ->editColumn('action', function(PastEvent $e) {
              $html = '';
              $html.='<a href="'.route('manage.past_result_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>';
              $html.='&nbsp;<a href="javascript:;" onclick="deleteResult('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>';
              return $html;
            })
           ->escapeColumns([])
           ->make(true);
		   }
	else{
	return Datatables::of(PastEvent::query()->get())
           ->editColumn('event_name', function(PastEvent $e) {
              return $e->event->event_name;
            }) 
            ->editColumn('image', function(PastEvent $e) {
              return '<img src="'.url('/').'/'.$e->image.'" style="width:100px;height:100px;">';
            })
            ->editColumn('action', function(PastEvent $e) {
              $html = '';
              $html.='<a href="'.route('manage.past_result_edit_form',['id'=>$e->id]).'" class="waves-effect waves-light btn blue">Edit</a>';
              $html.='&nbsp;<a href="javascript:;" onclick="deleteResult('.$e->id.')" class="waves-effect waves-light btn red">Delete</a>';
              return $html;
            })
           ->escapeColumns([])
           ->make(true);
	}
           
}

public function result_delete(Request $request){
  $result = PastEvent::where('id',$request->id)->first();
      if($result->delete()){
        echo 1;
      }
}

    public function past_event_edit_form_submit(Request $request)
    {
        $event = OldEvent::where('id',$request->event_id)->first();
        $event->event_year = $request->event_year;
        $event->event_name = $request->event_name;
        $event->event_date = date('Y-m-d',strtotime($request->event_date));
        $event->link = $request->link;
        if($request->link){
            $event->link = $request->link;
        }
        if($request->event_distance){
            $event->event_distance = $request->event_distance;
        }
        $event->event_type = $request->event_type;
        if($event->update()){
            return redirect()->route('manage.past_event_list_index')->with('success_message','Event updated successfully!');
        }else{
            return redirect()->route('manage.past_event_list_index')->with('success_message','Event updated Failed!');
        }

    }
public function past_result_edit_form($id){
  $events = Event::all();
  $result = PastEvent::with('event')->where('id',$id)->first();
  return view('admin.manage.past_result_edit',['result'=>$result,'events'=>$events]);
}

public function past_result_edit_form_submit(Request $request){
        $validateData = $request->validate([
          'event'=>'required',
          'image' =>'mimes:jpeg,jpg,png',
		  'background_image'=>'dimensions:width=1350,height=497',
          'result_link' => 'required|url'
      ]);
      $past_event = PastEvent::where('id',$request->result_id)->first();
      $past_event->event_id = $request->event;
      if($request->file('image')){
        //image
      $file = $request->file('image');
      $filename = time().'-'.$file->getClientOriginalName();
      $file->move('past_event_image/',$filename);
      $filepath1 = 'past_event_image/'.$filename;
      @unlink($past_event->image);
      $past_event->image = $filepath1;
      }
	if($request->file('background_image')){
        //background image
      $file = $request->file('background_image');
      $filename = time().'-'.$file->getClientOriginalName();
      $file->move('result_bg_image/',$filename);
      $filepath1 = 'result_bg_image/'.$filename;
      @unlink($past_event->background_image);
      $past_event->background_image = $filepath1;
      }
      
      $past_event->result_link = $request->result_link;
      if($past_event->update()){
          return redirect()->route('manage.past_result_list_index')->with('success_message','Past Result updated successfully');
      }
      else{
          return redirect()->route('manage.past_result_list_index')->with('error_message','Error to update Past Result');
      }
}

public function set_athlete_image_form($id){
  $athlete = Athlete::where('id',$id)->first();
  return view('admin.manage.set_athlete_image',['athlete'=>$athlete]);
}

public function set_athlete_image_form_submit(Request $request){
  $validateData = $request->validate([
    'image'=>'dimensions:width=240,height=270'
  ]);
  $athlete = Athlete::where('id',$request->athlete_id)->first();
   
  if($request->file('image')){
    $image_file = $request->file('image');
    $image_filename = time().'-'.$image_file->getClientOriginalName();
    $image_file->move("athlete_image/",$image_filename);
    if($athlete->image!=null){
      @unlink($athlete->image);
    }
    $filepath = "athlete_image/".$image_filename;
    $athlete->image = $filepath;
  }
  if($athlete->update()){
    return redirect()->route('manage.athlete_list_index')->with('success_message','Athelte image updated successfully');

  }
}

public function award_edit_form($id){
    $events = Event::all();
    $award = AwardsPrize::where('id',$id)->first();
    return view('admin.manage.award_edit',['events'=>$events,'award'=>$award]);
}

public function award_edit_form_submit(Request $request){
        $validateData = $request->validate([
          'event' => 'required',
          'title' => 'required',
          'details' => 'required'
      ]);
      $award = AwardsPrize::where('id',$request->award_id)->first();
      $award->event_id = $request->event;
      $award->title = $request->title;
      $award->details = $request->details;
      if($request->file('image')){
          //award image
          $image_file = $request->file('image');
          $image_filename = time().'-'.$image_file->getClientOriginalName();
          $image_file->move("award_image/",$image_filename);
          @unlink($award->image);
          $filepath = "award_image/".$image_filename;
          $award->image = $filepath;
      }

      if($award->update()){
          return redirect()->route('manage.award_prize_list_index')->with('success_message','Award & Prize updated successfully');
      }
}

public function set_image(Request $request){
	if($request->result){
		$result_image = Event::where('id',$request->id)->first();
		return $result_image->resut_background_image;
	}
	else{		
		$schedule_image = Event::where('id',$request->id)->first();
		$image = $schedule_image->event_schedule_image;
		$color = $schedule_image->schedule_text_color;
		$header_bg_color = $schedule_image->table_header_bg_color;
		return array('image'=>$image,'color'=>$color,'header_bg_color'=>$header_bg_color);
	}
}
	
public function set_schedule_headers(Request $request){
	$check_headers = ScheduleHeader::where('event_id',$request->id)->first();
	if($check_headers!=null){
		echo json_encode($check_headers);
	}
	else{
		echo 1;	
	}
}
	
public function set_schedule_headers_submit(Request $request){
	$validateData = $request->validate([
		'event' => 'required'
	]);
	$check_headers = ScheduleHeader::where('event_id',$request->event)->first();
	if($check_headers!=null){
		$headers = ScheduleHeader::where('event_id',$request->event)->first();
	}
	else{
		$headers = new ScheduleHeader();
	}
	$headers->event_id = $request->event;
	$headers->event_schedule = $request->event_schedule;
	$headers->online_registration = $request->online_registration;
	$headers->cash_payment = $request->cash_payment;
	$headers->bib = $request->bib;
	$headers->start_event = $request->start_event;
	$headers->award_ceremony = $request->award_ceremony;
	$headers->date = $request->date;
	$headers->week = $request->week;
	$headers->time = $request->time;
	$headers->location = $request->location;
	if($headers->save()){
		return redirect()->route('manage.set_schedule_headers')->with('success_message','Headers updated successfully');
	}
}	

public function athlete_name_delete()
{

    $abcd = DB::select('SHOW TABLES');
    $dbname = DB::connection()->getDatabaseName(); 
    $tb = 'Tables_in_'.$dbname;

    foreach ($abcd as $key => $value) {
    $strpos = strpos($value->$tb , "eventdata" );
      if($strpos !== false ){
        $year2[] = $value->$tb;
      }
    }

   foreach ($year2 as $key => $value) {
     $names[] = DB::table($value)->select('athlete')->groupBy('athlete')->get();
       foreach ($names as $key => $value2) {
        foreach ($value2 as $key => $value) {
          $total_member[] = $value->athlete;
        }
     }
     $names = [];
   }

   $unique_member =  array_unique($total_member);


   $athlete_names_in_athlete_table = DB::table('athletes')->select('athlete_name')->get();

   $total_athlete = array();

 
  foreach ($athlete_names_in_athlete_table as $key => $value) {
      if (!in_array($value->athlete_name , $unique_member ))
        {
          $total_athlete[] = $value->athlete_name;

        }

  }

  $data['total_athlete'] = $total_athlete;

  return view('admin.manage.with_zero_event_athlete',$data);



}

public function athlete_name_delete_final()
{

    $abcd = DB::select('SHOW TABLES');
    $dbname = DB::connection()->getDatabaseName(); 
    $tb = 'Tables_in_'.$dbname;

    foreach ($abcd as $key => $value) {
    $strpos = strpos($value->$tb , "eventdata" );
      if($strpos !== false ){
        $year2[] = $value->$tb;
      }
    }

   foreach ($year2 as $key => $value) {
     $names[] = DB::table($value)->select('athlete')->groupBy('athlete')->get();
       foreach ($names as $key => $value2) {
        foreach ($value2 as $key => $value) {
          $total_member[] = $value->athlete;
        }
     }
     $names = [];
   }

   $unique_member =  array_unique($total_member);


   $athlete_names_in_athlete_table = DB::table('athletes')->select('athlete_name')->get();

 
  foreach ($athlete_names_in_athlete_table as $key => $value) {
      if (!in_array($value->athlete_name , $unique_member ))
        {

          DB::table('athletes')
            ->where('athlete_name', $value->athlete_name )
            ->delete();

          DB::table('overall_rankings')
            ->where('athlete_name', $value->athlete_name )
            ->delete(); 

          DB::table('event_rankings')
            ->where('athlete_name', $value->athlete_name )
            ->delete();      

        }

  }

  echo 1;

}

public function edit_past_result(Request $request)
{
    $html = '';
    $pastResult = PastEvent::where('id',$request->id)->first();
    $img = url('/').'/'.$pastResult->image;
    $bg_img = url('/').'/'.$pastResult->background_image;
    $link = $pastResult->result_link;
    $id = $pastResult->id;

    $html .= '<div class="row" style="margin: 0px;">';
    $html .= '<div class="col-md-4">';
    $html .= '<p>Past Result Image</p>';
    $html .= '<img src="'.$img.'" style="width:250px;">';
    $html .= '<input type="file" name="image">';
    $html .= '</div>';
    $html .= '<div class="col-md-4">';
    $html .= '<p>Past Result Background Image</p>';
    $html .= '<img src="'.$bg_img.'" style="width:250px;">';
    $html .= '<input type="file" name="bg_image">';
    $html .= '</div>';
    $html .= '<div class="col-md-4">';
    $html .= '<p>Past Result Link</p>';
    $html .= '<p>'.$link.'</p>';
    $html .= '<input type="hidden" name="past_id" value="'.$id.'">';
    $html .= '<input type="text" name="link">';
    $html .= '</div>';
    $html .= '</div>';

    echo $html;
}
public function update_past_result(Request $request)
{
    $pastResult = PastEvent::where('id',$request->past_id)->first();
    $img = base_path().'/'.$pastResult->image;
    $bg_img = base_path().'/'.$pastResult->background_image;
    if($request->file('image')){
        //image
        $file = $request->file('image');
        $filename = time().'-'.$file->getClientOriginalName();
        $file->move('past_event_image/',$filename);
        $filepath1 = 'past_event_image/'.$filename;
        unlink($img);
        $pastResult->image = $filepath1;
    }
    if($request->file('bg_image')){
        //background image
        $file = $request->file('bg_image');
        $filename = time().'-'.$file->getClientOriginalName();
        $file->move('result_bg_image/',$filename);
        $filepath1 = 'result_bg_image/'.$filename;
        unlink($bg_img);
        $pastResult->background_image = $filepath1;
    }
    if ($request->link != '')
    {
        $pastResult->result_link = $request->link;
    }
    if($pastResult->update()){
        echo 1;
    }
    else{
        echo 2;
    }
}


}
