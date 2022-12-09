<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use App\Team;
use App\Athlete;

class LeaderController extends Controller
{
    public function index()
    {
        $data = array();
        $user_id = Session::get('leader_id');
        $team_id = Session::get('team_id');
        $team = Team::where('id',$team_id)->first();
        $data["members"] = json_decode($team['team_members']);
        $data["selected_captain"] = $team['captain'];
        $data["captain"] = Athlete::select('id','athlete_name')->get();
        $data['team'] = $team;
        return view('admin.leader.dashboard',$data);
    }

    public function update(Request $request)
    {
        $data = Team::where('id',$request->id)->first();

        $validateData = $request->validate([
            'mission'=>'required',
            'team_members'=>'required',
            'goal'=>'required',
            'description'=>'required',
            'banner_img'=>'dimensions:width=1350,height=462',
            'leader_image' => 'dimensions:width=240,height=270',
        ]);

        $data['mission'] = $request->mission;
        $data['goal'] = $request->goal;
        $data['description'] = $request->description;
        if ($request->leader_password != '')
        {
            $data['leader_password'] = $request->leader_password;
        }
        if ($request->leader_email != '')
        {
            $data['leader_email'] = $request->leader_email;
        }
        $data['leader_phone'] = $request->leader_phone;

        $data['team_members'] = json_encode($request->team_members);

        if ($image=$request->file('leader_image')) {
 
           $uploadPath = 'athlete_image';
           
           $file_name = time().$image->getClientOriginalName();
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
            return Redirect::back()->with('msg', 'Successfully Updated');
        }
    }
}
