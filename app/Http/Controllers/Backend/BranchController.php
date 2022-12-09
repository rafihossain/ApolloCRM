<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PartnerBranch;
use App\Models\Product;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function managePartnerBranch(){
        // echo "<pre>"; print_r($_POST); die();
        $partnerBranches = PartnerBranch::get();
        return view('backend.settings.partner-branch.manage-partner-branch', [
            'partnerBranches' => $partnerBranches,
        ]);
    }

    public function addPartnerBranch(Request $request){

        $request->validate([
          'name'    => 'required',
          'email'   => 'required',
        ]);

        $partnerBranche = new PartnerBranch();
        $partnerBranche->name = $request->name;
        $partnerBranche->email = $request->email;
        $partnerBranche->country = $request->country;
        $partnerBranche->city = $request->city;
        $partnerBranche->street = $request->street;
        $partnerBranche->state = $request->state;
        $partnerBranche->post_code = $request->post_code;
        $partnerBranche->phone_number = $request->phone_number;
        $partnerBranche->save();

        return response()->json(['success'=>'Record is successfully added']);
    }

    public function savePartnerBranch(Request $request){

        $request->validate([
          'name'    => 'required',
          'email'   => 'required',
        ]);

        $partnerBranche = new PartnerBranch();
        $partnerBranche->name = $request->name;
        $partnerBranche->email = $request->email;
        $partnerBranche->country = $request->country;
        $partnerBranche->city = $request->city;
        $partnerBranche->street = $request->street;
        $partnerBranche->state = $request->state;
        $partnerBranche->post_code = $request->post_code;
        $partnerBranche->phone_number = $request->phone_number;
        $partnerBranche->save();

        return response()->json(['success'=>'Record is successfully added']);
    }

    public function editPartnerBranch($id){
        $partnerBranch = PartnerBranch::find($id);
        // dd($partnerBranch);

        return view('backend.settings.partner-branch.edit-partner-branch', [
            'partnerBranch' => $partnerBranch,
        ]);
    }

    public function updatePartnerBranch(Request $request){
        $request->validate([
          'name'    => 'required',
          'email'   => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $partnerBranch = PartnerBranch::find($request->id);
        $partnerBranch->name = $request->name;
        $partnerBranch->email = $request->email;
        $partnerBranch->country = $request->country;
        $partnerBranch->city = $request->city;
        $partnerBranch->street = $request->street;
        $partnerBranch->state = $request->state;
        $partnerBranch->post_code = $request->post_code;
        $partnerBranch->phone_number = $request->phone_number;
        $partnerBranch->save();
        // dd($partnerBranch);

        return redirect('admin/partner/branch/list')->with('success', 'Branch Updated successfully!!');
    }

    public function deletePartnerBranch($id)
    {
        PartnerBranch::where('id',$id)->delete();
        return redirect('admin/partner/branch/list')->with('success', 'Branch deleted successfully!!');
    }

}
