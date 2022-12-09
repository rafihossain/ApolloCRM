<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AgentModel;
use App\Models\Client;
use App\Models\Country;
use App\Models\Office;
use App\Models\OfficeVisit;
use App\Models\User;
use Illuminate\Http\Request;
use Image;
use File;

class AgentController extends Controller
{
    public function agentActiveList(){
        $agents = AgentModel::with('office')->where('status', 1)->get();
        return view('backend/agents/agentactive', [
            'agents' => $agents
        ]);
    }
    public function agentInactiveList(){
        // echo 11; die();
        $agents = AgentModel::where('status', 2)->get();
        // dd($agents);

        return view('backend/agents/agentinactive', [
            'agents' => $agents
        ]);
    }
    public function agentAdd(){
        $countries = Country::get();
        $offices = Office::get();
        return view('backend/agents/agentactive-add', [
            'offices' => $offices,
            'countries' => $countries
        ]);
    }
    public function agentEdit($id){
        // echo 11; die();
        $countries = Country::get();
        $offices = Office::get();
        $agent = AgentModel::find($id);
        return view('backend/agents/agentactive-edit', [
            'agent' => $agent,
            'offices' => $offices,
            'countries' => $countries
        ]);
    }
    protected function personalImageUpload($request){
        // echo 11; die();
        $personalImage = $request->file('personal_image');
        $image = Image::make($personalImage);
        $fileType = $personalImage->getClientOriginalExtension();
        $imageName = 'agents_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/agents/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);
        return $imageUrl;
    }
    protected function businessImageUpload($request){
        // echo 11; die();
        $businessImage = $request->file('business_image');
        $image = Image::make($businessImage);
        $fileType = $businessImage->getClientOriginalExtension();
        $imageName = 'agents_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/agents/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);
        return $imageUrl;
    }
    public function agentSave(Request $request){

        $agent = new AgentModel();
        $agent->super_agent = $request->super_agent;
        $agent->sub_agent = $request->sub_agent;
        $agent->agent_structure = $request->agent_structure;

        if($request->agent_structure == 1){
            if($request->hasFile('personal_image')){
                $agent->profile_image = $this->personalImageUpload($request);
            }
            $agent->full_name = $request->full_name;
        }
        if($request->agent_structure == 2){
            if($request->hasFile('business_image')){
                $agent->profile_image = $this->businessImageUpload($request);
            }
            $agent->business_name = $request->business_name;
            $agent->contact_name = $request->contact_name;
            $agent->tax_number = $request->tax_number;
            $agent->expiry_date = $request->expiry_date;
        }

        $agent->phone_number = $request->phone_number;
        $agent->email = $request->email;
        $agent->street = $request->street;
        $agent->city = $request->city;
        $agent->state = $request->state;
        $agent->post_code = $request->post_code;
        $agent->country_id = $request->country_id;
        $agent->office_id = $request->office_id;
        $agent->status = 1;
        $agent->save();

        return redirect('admin/agents/active/list')->with('success', 'Agent information has been successfully added !!');
    }
    public function agentUpdate(Request $request){

        // dd($_POST);

        $agent = AgentModel::find($request->agent_id);
        $agent->super_agent = $request->super_agent;
        $agent->sub_agent = $request->sub_agent;
        $agent->agent_structure = $request->agent_structure;

        if($request->agent_structure == 1){
            if($request->hasFile('personal_image')){
                $agent->profile_image = $this->personalImageUpload($request);
            }
            $agent->full_name = $request->full_name;
        }
        if($request->agent_structure == 2){
            if($request->hasFile('business_image')){
                $agent->profile_image = $this->businessImageUpload($request);
            }
            $agent->business_name = $request->business_name;
            $agent->contact_name = $request->contact_name;
            $agent->tax_number = $request->tax_number;
            $agent->expiry_date = $request->expiry_date;
        }

        $agent->phone_number = $request->phone_number;
        $agent->email = $request->email;
        $agent->street = $request->street;
        $agent->city = $request->city;
        $agent->state = $request->state;
        $agent->post_code = $request->post_code;
        $agent->country_id = $request->country_id;
        $agent->office_id = $request->office_id;
        $agent->status = 1;
        $agent->save();

        return redirect('admin/agents/active/list')->with('success', 'Agent information has been successfully added !!');
    }
    public function deleteAgent($id)
    {
        AgentModel::where('id', $id)->delete();
        return redirect('admin/agents/active/list/')->with('success', 'Agent has been deleted successfully !!');
    }
    public function agentActive($id)
    {
        $agent = AgentModel::find($id);
        $agent->status = 1;
        $agent->save();
        return redirect('admin/agents/active/list/')->with('success', 'Agent has been active successfully !!');
    }
    public function agentInactive($id)
    {
        $agent = AgentModel::find($id);
        $agent->status = 2;
        $agent->save();

        return redirect('admin/agents/inactive/list')->with('success', 'Agent has been inactive successfully !!');
    }
}
