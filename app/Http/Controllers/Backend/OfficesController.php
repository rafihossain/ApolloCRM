<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\User;
use App\Models\Client;
use App\Models\Country;
use App\Models\TimeZone;

class OfficesController extends Controller
{
    protected function saveOfficersInfoValidate($request){
        $request->validate([
            'office_name' => 'required',
            'country_id' => 'required',
            'email' => 'required',
        ]);
    }
    public function manageOfficers(){
        $offices = Office::with('all_country')->get();
        return view('backend.teams.officers.officers-list', [
            'offices' => $offices
        ]);
    }
    public function addOfficers(){
        $countries = Country::get();
        return view('backend.teams.officers.officers-add', [
            'countries' => $countries
        ]);
    }
    public function branchDetails($id){
        $office = Office::with('all_country')->find($id);

        $users = User::with('role')->where('office_id', $id)->get();
        $clients = Client::with('users','office_info')->where('assignee_id', $id)->get();
        return view('backend.teams.officers.offices-details', [
            'users' => $users,
            'office' => $office,
            'clients' => $clients
        ]);
    }
    public function branchClients($id){
        $office = Office::with('all_country')->find($id);

        $users = User::with('role')->where('office_id', $id)->get();
        $clients = Client::with('users','office_info')->where('assignee_id', $id)->get();
        return view('backend.teams.officers.offices-clients', [
            'users' => $users,
            'office' => $office,
            'clients' => $clients
        ]);
    }
    
    
    public function saveOfficers(Request $request){
        $this->saveOfficersInfoValidate($request);
        // dd($_POST);

        $office = new Office;
        $office->office_name = $request->office_name;
        $office->street = $request->street;
        $office->city = $request->city;
        $office->state = $request->state;
        $office->post_code = $request->post_code;
        $office->country_id = $request->country_id;
        $office->email = $request->email;
        $office->phone = $request->phone;
        $office->mobile = $request->mobile;
        $office->contact_person = $request->contact_person;
        $office->choose_admin = $request->choose_admin;
        $office->save();

        return redirect()->back()->with('success', 'Offices has been added successfully !!');
    }
    public function editOfficers($id){
        $office = Office::find($id);
        return view('backend.teams.officers.officers-edit', [
            'office' => $office
        ]);
    }
    public function updateOfficers(Request $request){
        $this->saveOfficersInfoValidate($request);
        $office = Office::find($request->id);
        $office->office_name = $request->office_name;
        $office->street = $request->street;
        $office->city = $request->city;
        $office->state = $request->state;
        $office->post_code = $request->post_code;
        $office->country = $request->country;
        $office->email = $request->email;
        $office->phone = $request->phone;
        $office->mobile = $request->mobile;
        $office->contact_person = $request->contact_person;
        $office->choose_admin = $request->choose_admin;
        $office->save();

        return redirect()->back()->with('success', 'Offices has been update successfully !!');
    }
    public function deleteOfficers($id){
        Office::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Offices has been deleted successfully !!');
    }
}
