<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
use DB;
use App\AthleteLog;
use App\Record;
use App\Athlete;
use Redirect;
use Session;
class RecordController extends Controller
{
    public function index()
    {
        $record = Record::first();
        $data["members"] = json_decode($record['event_winner']);
        $data["event_records"] = json_decode($record['event_records']);
        $data["event_winners"] = json_decode($record['event_winner']);
        $data["captain"] = Athlete::all();
        $data['record'] = $record;
        return view('admin.manage.manage-record',$data);
    }
    public function add_record(Request $request)
    {
        $validateData = $request->validate([
            'title'=>'required',
            'banner_img'=>'dimensions:width=1280,height=344',
            'national_record_img'=>'dimensions:width=1366,height=430',
            'e_record_img'=>'dimensions:width=788,height=940',
            'event_record_img'=>'dimensions:width=788,height=940',
        ]);
        $data = array();
        $data['title'] = $request->title;
        $data['first_row'] = json_encode($request->first_row);
        $data['second_row'] = json_encode($request->second_row);
        $data['third_row'] = json_encode($request->third_row);
        $data['four_row'] = json_encode($request->four_row);
        if ($request->event_winner != '')
        {
            $data['event_winner'] = json_encode($request->event_winner);
        }
        if ($image=$request->file('banner_img')) {

            $uploadPath = 'assets/img/';

            $file_name = time()."-".$image->getClientOriginalName();
            $dbUrl = $uploadPath."/".$file_name;

            $image->move($uploadPath,$dbUrl);

            $data['banner_img']= $file_name;

        }
        if ($image=$request->file('national_record_img')) {

            $uploadPath = 'assets/img/';

            $file_name = time()."-".$image->getClientOriginalName();
            $dbUrl = $uploadPath."/".$file_name;

            $image->move($uploadPath,$dbUrl);

            $data['national_record_img']= $file_name;

        }
        if ($image=$request->file('event_record_img')) {

            $uploadPath = 'assets/img/';

            $file_name = time()."-".$image->getClientOriginalName();
            $dbUrl = $uploadPath."/".$file_name;

            $image->move($uploadPath,$dbUrl);

            $data['event_record_img']= $file_name;

        }
        if ($image=$request->file('event_winner_img')) {

            $uploadPath = 'assets/img/';

            $file_name = time()."-".$image->getClientOriginalName();
            $dbUrl = $uploadPath."/".$file_name;

            $image->move($uploadPath,$dbUrl);

            $data['event_winner_img']= $file_name;

        }
        Record::insert($data);

        return Redirect::back()->with('success_message', 'Successfully Added');
    }
    public function update(Request $request)
    {
        $validateData = $request->validate([
            'title'=>'required',
//            'banner_img'=>'dimensions:width=1280,height=344',
//            'national_record_img'=>'dimensions:width=1366,height=430',
//            'e_record_img'=>'dimensions:width=788,height=940',
//            'event_record_img'=>'dimensions:width=788,height=940',
        ]);
        $id = $request->record_id;
        $data = array();
        $data['title'] = $request->title;
        $data['first_row'] = json_encode($request->first_row);
        $data['second_row'] = json_encode($request->second_row);
        $data['third_row'] = json_encode($request->third_row);
        $data['four_row'] = json_encode($request->four_row);
        if (isset($request->show_event_record) && $request->show_event_record == 1)
        {
            $data['event_records_status'] = 1;
        }else{
            $data['event_records_status'] = 0;
        }
        if (isset($request->show_event_winner) && $request->show_event_winner == 1)
        {
            $data['event_winners_status'] = 1;
        }else{
            $data['event_winners_status'] = 0;
        }
        if ($image=$request->file('banner_img')) {

            $uploadPath = 'assets/img/';

            $file_name = time()."-".$image->getClientOriginalName();
            $dbUrl = $uploadPath."/".$file_name;

            $image->move($uploadPath,$dbUrl);

            $data['banner_img']= $file_name;

        }
        if ($image=$request->file('national_record_img')) {

            $uploadPath = 'assets/img/';

            $file_name = time()."-".$image->getClientOriginalName();
            $dbUrl = $uploadPath."/".$file_name;

            $image->move($uploadPath,$dbUrl);

            $data['national_record_img']= $file_name;

        }
        if ($image=$request->file('event_record_img')) {

            $uploadPath = 'assets/img/';

            $file_name = time()."-".$image->getClientOriginalName();
            $dbUrl = $uploadPath."/".$file_name;

            $image->move($uploadPath,$dbUrl);

            $data['event_record_img']= $file_name;

        }
        if ($image=$request->file('event_winner_img')) {

            $uploadPath = 'assets/img/';

            $file_name = time()."-".$image->getClientOriginalName();
            $dbUrl = $uploadPath."/".$file_name;

            $image->move($uploadPath,$dbUrl);

            $data['event_winner_img']= $file_name;

        }
        $event_records_img_name = $request->event_records_img_name;
        $event_records_order = $request->event_records_order;
        $event_records_img_ = $request->event_records_img_;
        $event_records = array();
        $i = 1;
        foreach($event_records_order as $key=>$item)
        {
            if ($image=$request->file('event_records_img_'.$key))
            {
                $uploadPath = 'assets/img/';
                $file_name = time()."-".$image->getClientOriginalName();
//
                $dbUrl = $uploadPath."/".$file_name;
                $image->move($uploadPath,$dbUrl);
//                $file_name = 'J.J.-Redick-1.png';
                $event_records[$key]['file_name'] = $file_name;
            }else{

                if ($request->event_records_img_name[$key] != '')
                {
                    $event_records[$key]['file_name'] = $request->event_records_img_name[$key];
                }else
                {
                    $event_records[$key]['file_name'] = '';
                }
            }
            $event_records[$key]['order'] = $i;
            $i++;
        }
        $data['event_records'] = json_encode($event_records);
        $event_winners_img_name = $request->event_winners_img_name;
        $event_winners_order = $request->event_winners_order;
        $event_winners = array();
        $i = 1;
        foreach($event_records_order as $key=>$item)
        {
            if ($image=$request->file('event_winners_img_'.$key))
            {
                $uploadPath = 'assets/img/';
                $file_name = time()."-".$image->getClientOriginalName();
//
                $dbUrl = $uploadPath."/".$file_name;
                $image->move($uploadPath,$dbUrl);
//                $file_name = 'J.J.-Redick-1.png';
                $event_winners[$key]['file_name'] = $file_name;
            }else{

                if ($request->event_winners_img_name[$key] != '')
                {
                    $event_winners[$key]['file_name'] = $request->event_winners_img_name[$key];
                }else
                {
                    $event_winners[$key]['file_name'] = '';
                }
            }
            $event_winners[$key]['order'] = $i;
            $i++;
        }
        $data['event_winner'] = json_encode($event_winners);

        DB::table('records')
            ->where('id', $id)
            ->update($data);
        return Redirect::back()->with('success_message', 'Successfully Updated');
    }
    public function delete_image(Request $request)
    {
        $record_id = $request->record_id;
        $img = $request->img;
        $name = $request->name;
        $data[$name] = '';
        //$base_path = str_replace('public','',public_path());
        //$url = $base_path.'assets/img/'.$img;
        $url = base_path().'/assets/img/'.$img;
        unlink($url);
        DB::table('records')
            ->where('id', $record_id)
            ->update($data);
        $msg = array();
        $msg['msg'] = true;
        echo json_encode($msg);
    }
    public function delete_records_image(Request $request)
    {
        $record_id = $request->record_id;
        $img_src = $request->img_src;
        $order = $request->order;
        $img_type = $request->img_type;
        $records =    DB::table('records')
            ->where('id', $record_id)
            ->first();
            
        if ($img_type == 'records')
        {
            $event_records = json_decode($records->event_records);
            foreach ($event_records as $key=>$record)
            {
                if ($record->order == $order)
                {
                    $event_records[$key]->file_name = '';
                }
            }
            //$base_path = str_replace('public','',public_path());
            $url = base_path().'/assets/img/'.$img_src;
            unlink($url);
            $data['event_records'] = json_encode($event_records);
            DB::table('records')
                ->where('id',$record_id)
                ->update($data);
        }
        if ($img_type == 'winners')
        {
            $event_winners = json_decode($records->event_winner);
            foreach ($event_winners as $key=>$winner)
            {
                if ($winner->order == $order)
                {
                    $event_winners[$key]->file_name = '';
                }
            }
            //$base_path = str_replace('public','',public_path());
            $url = base_path().'/assets/img/'.$img_src;
            unlink($url);
            $data['event_winner'] = json_encode($event_winners);
            DB::table('records')
                ->where('id',$record_id)
                ->update($data);
        }
        $msg = array();
        $msg['msg'] = true;
        echo json_encode($msg);
    }

}
