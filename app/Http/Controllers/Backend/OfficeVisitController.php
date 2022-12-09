<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Office;
use App\Models\OfficeVisit;
use App\Models\User;
use Illuminate\Http\Request;

class OfficeVisitController extends Controller
{
    
    //waiting
    public function officeVisitWaiting(){
        $clients = Client::get();
        $users = User::get();
        $officeVisites = OfficeVisit::with('client', 'user')->get();
        $offices = Office::get();

        // dd($clients);
        return view('backend/officevisit/waiting', [
            'users' => $users,
            'clients' => $clients,
            'offices' => $offices,
            'officeVisites' => $officeVisites
        ]);
    }
    public function createOfficeWaiting(Request $request){
        $request->validate([
            'contact_id' => 'required',
        ]);
        // dd($_POST);

        $officeVisit = new OfficeVisit();
        $officeVisit->contact_id = $request->contact_id;
        $officeVisit->visit_purpose = $request->visit_purpose;
        $officeVisit->assigne_id = $request->assigne_id;
        $officeVisit->save();

        
        return response()->json(['success'=>'Record is successfully added']);
    }
    public function editOfficeWaiting(Request $request){
        $officeVisite = OfficeVisit::find($request->visite_id);
        $clients = Client::get();
        $users = User::get();

        $result = [
            'users' => $users,
            'clients' => $clients,
            'officeVisite' => $officeVisite
        ];

        echo json_encode($result);
    }
    public function updateOfficeWaiting(Request $request){
        $request->validate([
            'contact_id' => 'required',
        ]);
        // dd($_POST);

        $officeVisit = OfficeVisit::find($request->visite_id);
        $officeVisit->contact_id = $request->contact_id;
        $officeVisit->visit_purpose = $request->visit_purpose;
        $officeVisit->assigne_id = $request->assigne_id;
        $officeVisit->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function deleteOfficeWaiting($id)
    {
        OfficeVisit::where('id', $id)->delete();
        return redirect('admin/officevisit/waiting')->with('success', 'Office checkin has been deleted successfully !!');
    }





    public function officeVisitAttending(){
        // echo 22; die();
        return view('/backend/officevisit/attending');
    }
    public function officeVisitCompleted(){
        // echo 33; die();
        return view('/backend/officevisit/completed');
    }
    public function officeVisitAll(){
        // echo 44; die();
        return view('/backend/officevisit/all');
    }
    public function officeVisitArchived(){
        // echo 55; die();
        return view('/backend/officevisit/archived');
    }
}
