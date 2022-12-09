<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\MasterCategory;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Partner;
use App\Models\PartnerAgreement;
use App\Models\PartnerBranch;
use App\Models\PartnerContact;
use App\Models\PartnerType;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\WorkflowCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PartnerNote;
use App\Models\PartnerAppointment;
use App\Models\ProductDocumentation;
use App\Models\TimeZone;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\PriorityCategory;
use App\Models\Promotion;
use File;
use Image;

class PartnerController extends Controller
{
    public function managePartner()
    {
        $partners = Partner::with('workflow', 'masterCategory', 'partnerType')->get();
        // dd($partners);

        return view('backend.partner.partner-list', [
            'partners' => $partners,
        ]);
    }

    public function addPartner()
    {
        // echo "<pre>"; print_r($_POST); die();

        $masterCategories = MasterCategory::get();
        $workflowCategories = WorkflowCategory::get();
        $countries = Country::get();
        $currencies = Currency::get();
        // dd($branch);

        return view('backend.partner.partner-add', [
            'countries' => $countries,
            'currencies' => $currencies,
            'masterCategories' => $masterCategories,
            'workflowCategories' => $workflowCategories,
        ]);
    }

    protected function partnerSectionImage($request)
    {
        $partnerImage = $request->file('partner_image');

        $image = Image::make($partnerImage);
        $fileType = $partnerImage->getClientOriginalExtension();
        $imageName = 'partner_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/partners/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);

        $thumbnail = $directory . "thumbnail/" . $imageName;
        $image->resize(null, 200, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($thumbnail);

        return $imageUrl;
    }

    public function savePartnerBranchValidate($request)
    {
        $request->validate([
            'name'   => 'required',
            'email'   => 'required',
            'partner_type'   => 'required',
            'workflow_id'   => 'required',
            'currency_id'   => 'required',
            'partner_image'   => 'required',
            'master_category_id'   => 'required',
        ]);
    }

    public function updatePartnerValidate($request)
    {
        $request->validate([
            'master_category_id'   => 'required',
            'partner_type'   => 'required',
            'workflow_id'   => 'required',
            'email'   => 'required',
            'name'   => 'required',
        ]);
    }

    public function savePartner(Request $request)
    {
        // dd($_POST);

        $this->savePartnerBranchValidate($request);

        $partner = new Partner();

        if($request->partner_image != ''){
            $imageUrl = $this->partnerSectionImage($request);
            $partner->partner_image = $imageUrl;
        }

        // echo "<pre>"; print_r($_POST); die();
        $partner->name = $request->name;
        $partner->registration_number = $request->registration_number;
        $partner->workflow_id = implode(',',$request->workflow_id);
        $partner->master_category_id = $request->master_category_id;
        $partner->partner_type = $request->partner_type;
        $partner->currency_id = $request->currency_id;
        $partner->street = $request->street;
        $partner->city = $request->city;
        $partner->state = $request->state;
        $partner->post_code = $request->post_code;
        $partner->country_id = $request->country_id;
        $partner->phone_number = $request->phone_number;
        $partner->email = $request->email;
        $partner->fax = $request->fax;
        $partner->website = $request->website;
        $partner->product_id = $request->product_id;
        $partner->enrolled = $request->enrolled;
        $partner->in_progress = $request->in_progress;
        $partner->save();

        if(isset($request->branch)) {
            $branches = json_decode($request->branch);
            foreach ($branches as $branch) {
                $partnerBranch = new PartnerBranch();
                $partnerBranch->partner_id = $partner->id;
                $partnerBranch->name = $branch->name;
                $partnerBranch->email = $branch->email;
                $partnerBranch->country_id = $branch->country_id;
                $partnerBranch->city = $branch->city;
                $partnerBranch->street = $branch->street;
                $partnerBranch->state = $branch->state;
                $partnerBranch->post_code = $branch->post_code;
                $partnerBranch->phone_number = $branch->phone;
                $partnerBranch->save();
            }
        }else{
            return redirect('admin/partner/add')->with('error', 'Please enter minimum one branch!!');
        }

        return redirect('admin/partner/list')->with('success', 'Partners has been added successfully !!');
    }

    public function getPartnerType(Request $request)
    {
        $partners = PartnerType::where('master_category_id', $request->master_category_id)->get();
        return json_encode($partners);
    }

    public function editPartner($id)
    {
        $partner = Partner::find($id);
        $masterCategories = MasterCategory::get();
        $workflowCategories = WorkflowCategory::get();
        $partnerTypes = PartnerType::get();
        $countries = Country::get();

        return view('backend.partner.partner-edit', [
            'partner' => $partner,
            'countries' => $countries,
            'partnerTypes' => $partnerTypes,
            'masterCategories' => $masterCategories,
            'workflowCategories' => $workflowCategories,
        ]);
    }

    protected function partnerBasicInfo($request, $partner, $imageUrl = null){
        $partner->name = $request->name;
        $partner->registration_number = $request->registration_number;
        $partner->workflow_id = implode(',',$request->workflow_id);
        $partner->master_category_id = $request->master_category_id;
        $partner->partner_type = $request->partner_type;
        $partner->currency_id = $request->currency_id;
        $partner->street = $request->street;
        $partner->city = $request->city;
        $partner->state = $request->state;
        $partner->post_code = $request->post_code;
        $partner->country_id = $request->country_id;
        $partner->phone_number = $request->phone_number;
        $partner->email = $request->email;
        $partner->fax = $request->fax;
        $partner->website = $request->website;
        $partner->product_id = $request->product_id;
        $partner->enrolled = $request->enrolled;
        $partner->in_progress = $request->in_progress;

        if($imageUrl){
            $partner->partner_image = $imageUrl;
        }

        $partner->save();
    }

    public function updatePartner(Request $request)
    {
        // echo "<pre>"; print_r($_POST); die();

        $this->updatePartnerValidate($request);
        $partnerImage = $request->file('partner_image');
        $partner = Partner::find($request->id);

        if($partnerImage){
            if (File::exists($partner->partner_image)) {
                unlink($partner->partner_image);
            }
            $imageUrl = $this->partnerSectionImage($request);
            $this->partnerBasicInfo($request, $partner, $imageUrl);
        }else{
            $this->partnerBasicInfo($request, $partner);
        }

        return redirect('admin/partner/list')->with('success', 'Partner has been updated successfully !!');

    }

    public function deletePartner($id)
    {
        Partner::where('id',$id)->delete();
        return redirect('admin/partner/list')->with('success', 'Partner has been delete successfully !!');
    }

    /*============================================================================
                                Profile Section
    ==============================================================================*/

    protected function partnerWorkflow($partner){
        $workflowId = explode(',',$partner->workflow_id);
        $relatedWorkflow = [];
        if($partner->workflow_id != ''){
            for($i=0; $i < count($workflowId); $i++){
                $relatedWorkflow[] = WorkflowCategory::where('id', $workflowId[$i])->first();
            }
        }
        return $relatedWorkflow;
    }


    public function partnerProfileApplication($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        return view('backend.partner.applications', [
            'partner' => $partner,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }

    public function partnerProfileProduct($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        $products = Product::where('partner_id',$id)->with('partner', 'partnerBranches')->get();
        return view('backend.partner.product', [
            'partner' => $partner,
            'products' => $products,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }

    // public function partnerProfileAdd($id)
    // {
    //     $product = Product::where('partner_id', $id)->with('PartnerBranch','partner','productType')->first()->toArray();
    //     $partners = Partner::get();
    //     $product_type = ProductType::get();
        
    //     // dd($partners);

    //     return view('backend.partner.partner-product', [
    //         'product' => $product,
    //         'partners' => $partners,
    //         'producttypes' => $product_type,
    //     ]);
    // }

    public function partnerProfileAdd($id)
    {
        $product = Product::where('partner_id', $id)->with('PartnerBranch','partner','productType')->first()->toArray();
        $partners = Partner::get();
        $product_type = ProductType::get();
        
        // dd($partners);

        return view('backend.partner.partner-product', [
            'partner_id' => $id,
            'product' => $product,
            'partners' => $partners,
            'producttypes' => $product_type,
        ]);
    }
    protected function saveProductInfoValidate($request)
    {
        $request->validate([
            'name' => 'required',
            'partner' => 'required',
            'branche' => 'required',
            'product_type' => 'required',
            'revenue_type' => 'required',
        ]);
    }
    public function partnerProfileCreate(Request $request)
    {

        // echo "<pre>"; print_r($_POST); die();
        $this->saveProductInfoValidate($request);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->partner_id = $request->partner;
        $product->branch_id = $request->branche;
        $product->product_type = $request->product_type;
        $product->enrolled = $request->revenue_type;
        $product->duration = $request->duration;
        $product->intake_month = $request->intake_month;
        $product->note = $request->note;
        $product->save();

        return redirect('admin/partner/profile/products/'. $request->partner_id)->with('success', 'Product has been added successfully !!');

    }
    public function partnerProfileBranche($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        $branches = PartnerBranch::where('partner_id',$id)->orderBy('head_office', 'DESC')->get();
        $countries = Country::get();
        // dd($countries);

        return view('backend.partner.branche', [
            'partner' => $partner,
            'branches' => $branches,
            'countries' => $countries,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }
    public function createPartnerBranch(Request $request)
    {
        // echo 11; die();

        $request->validate([
          'name'    => 'required',
          'email'   => 'required',
        ]);

        if($request->head_office){
            $headoffice = PartnerBranch::where('head_office', 1)->get()->first();
            if($headoffice){
                $headoffice->head_office = 0;
                $headoffice->save();
            }
        }

        $partnerBranche = new PartnerBranch();
        $partnerBranche->partner_id = $request->partner_id;
        $partnerBranche->name = $request->name;
        $partnerBranche->email = $request->email;
        $partnerBranche->country_id = $request->country_id;
        $partnerBranche->city = $request->city;
        $partnerBranche->street = $request->street;
        $partnerBranche->state = $request->state;
        $partnerBranche->post_code = $request->post_code;
        $partnerBranche->phone_number = $request->phone_number;

        if(isset($request->head_office)){
            $partnerBranche->head_office = $request->head_office;
        }
        
        $partnerBranche->save();

        return response()->json(['success'=>'Record is successfully added']);
        
    }
    public function editPartnerBranch(Request $request)
    {
        $branch = PartnerBranch::find($request->branch_id);
        $countries = Country::get();
        $result = [
            'branch' => $branch,
            'countries' => $countries,
        ];
        echo json_encode($result);
    }
    public function updatePartnerBranch(Request $request)
    {
        $request->validate([
          'name'    => 'required',
          'email'   => 'required',
        ]);

        // dd($_POST);

        if($request->head_office){
            $headoffice = PartnerBranch::where('head_office', 1)->get()->first();
            if($headoffice){
                $headoffice->head_office = 0;
                $headoffice->save();
            }
        }

        $partnerBranche = PartnerBranch::find($request->branch_id);
        $partnerBranche->partner_id = $request->partner_id;
        $partnerBranche->name = $request->name;
        $partnerBranche->email = $request->email;
        $partnerBranche->country_id = $request->country_id;
        $partnerBranche->city = $request->city;
        $partnerBranche->street = $request->street;
        $partnerBranche->state = $request->state;
        $partnerBranche->post_code = $request->post_code;
        $partnerBranche->phone_number = $request->phone_number;

        if(isset($request->head_office)){
            $partnerBranche->head_office = $request->head_office;
        }
        
        $partnerBranche->save();
        return response()->json(['success'=>'Record is successfully added']);
    }

    public function deletePartnerBranch($id, $partnerId)
    {
        PartnerBranch::where('id', $id)->delete();
        return redirect('admin/partner/profile/branche/'.$partnerId)->with('success', 'Branch has been deleted successfully !!');
    }

    public function partnerProfileAgreement($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        $countries = Country::get();
        return view('backend.partner.agreement', [
            'partner' => $partner,
            'countries' => $countries,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }

    public function updatePartnerAgreement(Request $request)
    {
        $partnerAgreement = new PartnerAgreement();
        $partnerAgreement->partner_id = $request->partner_id;
        $partnerAgreement->contract_expiry_date = $request->contract_expiry_date;
        $partnerAgreement->representing_regions = $request->representing_regions;
        $partnerAgreement->commission_percentage = $request->commission_percentage;
        $partnerAgreement->default_super_agent = $request->default_super_agent;
        $partnerAgreement->save();
        // echo "<pre>"; print_r($_POST); die();

        return redirect('admin/partner/profile/agreement/'.$request->partner_id)
                        ->with('success', 'Agreement has been added successfully !!');
    }

    public function partnerProfileContact($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        $branches = PartnerBranch::where('partner_id', $id)->get();
        $contacts = PartnerContact::with('branch')->where('partner_id', $id)->orderBy('primary_contact', 'DESC')->get();
        // dd($contacts);

        return view('backend.partner.contact', [
            'partner' => $partner,
            'branches' => $branches,
            'contacts' => $contacts,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }

    public function createPartnerContact(Request $request)
    {
        $request->validate([
          'name'    => 'required',
          'email'   => 'required',
          'branch_id'   => 'required',
        ]);

        if($request->primary_contact){
            $primaryContact = PartnerContact::where('primary_contact', 1)->get()->first();
            if($primaryContact){
                $primaryContact->primary_contact = 0;
                $primaryContact->save();
            }
        }

        $partnerContact = new PartnerContact();
        $partnerContact->partner_id = $request->partner_id;
        $partnerContact->name = $request->name;
        $partnerContact->email = $request->email;
        $partnerContact->branch_id = $request->branch_id;
        $partnerContact->phone_number = $request->phone_number;
        $partnerContact->fax = $request->fax;
        $partnerContact->department = $request->department;
        $partnerContact->position = $request->position;

        if(isset($request->primary_contact)){
            $partnerContact->primary_contact = $request->primary_contact;
        }
        
        $partnerContact->save();
        return response()->json(['success'=>'Record is successfully added']);
    }

    public function editPartnerContact(Request $request)
    {
        $contact = PartnerContact::where('partner_id', $request->partner_id)->find($request->contact_id);
        // dd($contact);
        $branches = PartnerBranch::where('partner_id', $request->partner_id)->get();

        $result = [
            'branches' => $branches,
            'contact' => $contact,
        ];

        echo json_encode($result);
    }

    public function updatePartnerContact(Request $request)
    {
        $request->validate([
          'name'    => 'required',
          'email'   => 'required',
          'branch_id'   => 'required',
        ]);
        // echo "<pre>"; print_r($_POST); die();

        if($request->primary_contact){
            $primaryContact = PartnerContact::where('primary_contact', 1)->get()->first();
            if($primaryContact){
                $primaryContact->primary_contact = 0;
                $primaryContact->save();
            }
        }

        $partnerContact = PartnerContact::find($request->contact_id);
        $partnerContact->partner_id = $request->partner_id;
        $partnerContact->name = $request->name;
        $partnerContact->email = $request->email;
        $partnerContact->branch_id = $request->branch_id;
        $partnerContact->phone_number = $request->phone_number;
        $partnerContact->fax = $request->fax;
        $partnerContact->department = $request->department;
        $partnerContact->position = $request->position;

        if(isset($request->primary_contact)){
            $partnerContact->primary_contact = $request->primary_contact;
        }
        
        $partnerContact->save();
        return response()->json(['success'=>'Record is successfully added']);
    }
    public function deletePartnerContact($id, $partnerId)
    {
        PartnerContact::where('id', $id)->delete();
        return redirect('admin/partner/profile/contact/'.$partnerId)->with('success', 'Contact has been deleted successfully !!');
    }
    
    
    public function partnerProfileNote($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        $notes = PartnerNote::where('partner_id', $id)->get();
        return view('backend.partner.note', [
            'notes' => $notes,
            'partner' => $partner,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }
    public function partnerNoteCreate(Request $request)
    {
        $request->validate([
          'note_title'    => 'required',
          'note_description'   => 'required',
        ]);

        $partnerNote = new PartnerNote();
        $partnerNote->partner_id = $request->partner_id;
        $partnerNote->note_title = $request->note_title;
        $partnerNote->note_description = $request->note_description;        
        $partnerNote->save();
        return response()->json(['success'=>'Record is successfully added']);
    }
    public function partnerNoteEdit(Request $request)
    {
        $note = PartnerNote::where('partner_id', $request->partner_id)->find($request->note_id);
        echo json_encode($note);
    }
    public function partnerNoteUpdate(Request $request)
    {
        $request->validate([
          'note_title'    => 'required',
          'note_description'   => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $partnerNote = PartnerNote::find($request->note_id);
        $partnerNote->partner_id = $request->partner_id;
        $partnerNote->note_title = $request->note_title;
        $partnerNote->note_description = $request->note_description;        
        $partnerNote->save();
        return response()->json(['success'=>'Record is successfully added']);
    }
    public function partnerNoteDelete($id, $partnerId)
    {
        PartnerNote::where('id', $id)->delete();
        return redirect('admin/partner/profile/note/'.$partnerId)->with('success', 'Note has been deleted successfully !!');
    }
    
    public function partnerProfileDocument($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        $docs = ProductDocumentation::where('partner_id',$id)->with('alluser')->get();
        // dd($docs);
        return view('backend.partner.document', [
            'docs' => $docs,
            'partner' => $partner,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }
    public function partnerDocumentCreate(Request $request)
    {
        // echo "<pre>"; print_r($image->filesize()); die();
        $partnerImage = $request->file('product_doc');

        if ($partnerImage) {
            $image = Image::make($partnerImage);

            $fileType = $partnerImage->getClientOriginalExtension();
            $imageName = 'document_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
            $directory = 'assets/upload/product_doc/';
            $imageUrl = $directory . $imageName;
            $image->save($imageUrl);

            $prodDoc = new ProductDocumentation();
            $prodDoc->partner_id = $request->id;
            $prodDoc->file_name = $imageName;
            $prodDoc->file_size = $image->filesize();
            $prodDoc->author = session()->get('user_id');
            $prodDoc->save();

            return redirect('admin/partner/profile/document/' . $request->id)->with('success', 'Doucmentation has been added successfully !!');
        } else {
            return redirect('admin/partner/profile/document/' . $request->id)->with('danger', 'Error Something !!');
        }
    }
    
    public function partnerDocumentDelete($id, $partnerId)
    {
        $prod = ProductDocumentation::where('id', $id)->first();
        $myLink = base_path() . "/assets/upload/product_doc/" . $prod->file_name;
        if (file_exists($myLink)) {
            unlink($myLink);
        }
        ProductDocumentation::where('id', $id)->delete();
        return redirect('admin/partner/profile/document/' . $partnerId)->with('success', 'Doucmentation has been delete successfully !!');
    }

    public function partnerProfileAppointment($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        $timezones = TimeZone::get();
        $appointments = PartnerAppointment::with('user')->where('partner_id', $id)->get();
        // dd($appointments);
        $user = User::where('id', Session::get('user_id'))->get()->first();
        return view('backend.partner.appointment', [
            'user' => $user,
            'partner' => $partner,
            'timezones' => $timezones,
            'appointments' => $appointments,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }
    public function partnerAppointmentCreate(Request $request)
    {
        $request->validate([
          'partner_name'    => 'required',
          'timezone_id'   => 'required',
          'date'   => 'required',
          'time'   => 'required',
          'title'   => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $partnerAppointment = new PartnerAppointment();
        $partnerAppointment->partner_id = $request->partner_id;
        $partnerAppointment->related_to = 2;
        $partnerAppointment->added_by = $request->added_by;
        $partnerAppointment->partner_name = $request->partner_name;
        $partnerAppointment->timezone_id = $request->timezone_id;
        $partnerAppointment->date = $request->date;
        $partnerAppointment->time = $request->time;
        $partnerAppointment->title = $request->title;
        $partnerAppointment->description = $request->description;
        $partnerAppointment->invite = $request->invite;     
        $partnerAppointment->save();
        return response()->json(['success'=>'Record is successfully added']);
    }
    public function partnerAppointmentEdit(Request $request){
        $appointment = PartnerAppointment::where('partner_id', $request->partner_id)->find($request->appointment_id);
        $user = User::where('id', Session::get('user_id'))->get()->first();
        $timezones = TimeZone::get();

        $result = [
            'user' => $user,
            'appointment' => $appointment,
            'timezones' => $timezones,
        ];

        echo json_encode($result);
    }
    public function partnerAppointmentUpdate(Request $request)
    {
        
        $request->validate([
          'partner_name'    => 'required',
          'timezone_id'   => 'required',
          'date'   => 'required',
          'time'   => 'required',
          'title'   => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $partnerAppointment = PartnerAppointment::find($request->appointment_id);
        $partnerAppointment->related_to = 2;
        $partnerAppointment->added_by = $request->added_by;
        $partnerAppointment->partner_id = $request->partner_id;
        $partnerAppointment->partner_name = $request->partner_name;
        $partnerAppointment->timezone_id = $request->timezone_id;
        $partnerAppointment->date = $request->date;
        $partnerAppointment->time = $request->time;
        $partnerAppointment->title = $request->title;
        $partnerAppointment->description = $request->description;
        $partnerAppointment->invite = $request->invite;     
        $partnerAppointment->save();
        return response()->json(['success'=>'Record is successfully added']);
    }
    public function partnerAppointmentDelete($id, $partnerId)
    {
        PartnerAppointment::where('id', $id)->delete();
        return redirect('admin/partner/profile/appointment/'.$partnerId)->with('success', 'Appointment has been deleted successfully !!');
    }
    
    
    public function partnerProfileAccount($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        return view('backend.partner.account', [
            'partner' => $partner,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }
    public function partnerProfileConversation($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        return view('backend.partner.conversation', [
            'partner' => $partner,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }
    
    
    public function partnerProfileTask($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        $priorityCategories = PriorityCategory::get();
        $taskCategories = TaskCategory::get();
        $tasks = Task::where('partner_id', $id)->get();
        $users = User::get();
        // dd($users);

        return view('backend.partner.task', [
            'users' => $users,
            'tasks' => $tasks,
            'partner' => $partner,
            'taskCategories' => $taskCategories,
            'priorityCategories' => $priorityCategories,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }
    protected function partnerTaskImageUpload($request){
        // echo 11; die();
        $taskImage = $request->file('attachment');
        $image = Image::make($taskImage);
        $fileType = $taskImage->getClientOriginalExtension();
        $imageName = 'document_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/tasks/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);
        return $imageUrl;
    }
    public function partnerTaskCreate(Request $request)
    {
        $request->validate([
          'title'    => 'required',
          'category_id'   => 'required',
        ]);

        $task = new Task();
        $task->partner_id = $request->partner_id;
        $task->title = $request->title;
        $task->category_id = $request->category_id;
        $task->assigee_id = $request->assigee_id;
        $task->priority_id = $request->priority_id;
        $task->due_date = $request->due_date;
        $task->description = $request->description;

        if($request->file('attachment')){
            $imageUrl = $this->partnerTaskImageUpload($request);
            $task->attachment = $imageUrl;
        }

        $task->follower_id = $request->follower_id;   
        $task->status = $request->status;   
        // echo "<pre>"; print_r($task); die();
        $task->save();

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function partnerTaskEdit(Request $request){
        // $appointment = Task::where('partner_id', $request->partner_id)->find($request->appointment_id);
        // $user = User::where('id', Session::get('user_id'))->get()->first();
        
        $task = Task::where('partner_id', $request->partner_id)->find($request->task_id);
        
        $users = User::get();
        $taskcategories = TaskCategory::get();
        $priorities = PriorityCategory::get();

        $result = [
            'task' => $task,
            'users' => $users,
            'taskcategories' => $taskcategories,
            'priorities' => $priorities,
        ];

        echo json_encode($result);
    }
    protected function taskBasicInfoUpdate($request, $task, $imageUrl = null){
        $task->partner_id = $request->partner_id;
        $task->title = $request->title;
        $task->category_id = $request->category_id;
        $task->assigee_id = $request->assigee_id;
        $task->priority_id = $request->priority_id;
        $task->due_date = $request->due_date;
        $task->description = $request->description;

        if($imageUrl){
            $task->attachment = $imageUrl;
        }

        $task->follower_id = $request->follower_id;
        $task->status = $request->status;
        // echo "<pre>"; print_r($imageUrl); die();

        $task->save();
    }
    public function partnerTaskUpdate(Request $request)
    {
        
        $request->validate([
          'title'   => 'required',
          'category_id'   => 'required',
        ]);

        $taskImage = $request->file('attachment');
        $task = Task::find($request->task_id);

        if($taskImage){
            if (File::exists($task->attachment)) {
                unlink($task->attachment);
            }
            $imageUrl = $this->partnerTaskImageUpload($request);
            // echo "<pre>"; print_r($imageUrl); die();
            $this->taskBasicInfoUpdate($request, $task, $imageUrl);
        }else{
            $this->taskBasicInfoUpdate($request, $task);
        }

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function partnerTaskDelete($id, $partnerId)
    {
        Task::where('id', $id)->delete();
        return redirect('admin/partner/profile/task/'.$partnerId)->with('success', 'Task has been deleted successfully !!');
    }
    
    
    public function partnerProfileOtherinformation($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        return view('backend.partner.otherinformation', [
            'partner' => $partner,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }
    
    
    public function partnerProfilePromotion($id)
    {
        $partner = Partner::find($id);
        $relatedWorkflow = $this->partnerWorkflow($partner);

        $branches = PartnerBranch::where('partner_id',$id)->get();
        $products = Product::where('partner_id',$id)->get();

        $promotions = Promotion::where('partner_id',$id)->get();

        foreach($promotions as $key => $promotion) {
            $productId = explode(',', $promotion->product_id);
            
            $relatedProduct = [];
            for ($i = 0; $i < count($productId); $i++) {
                $relatedProduct[$i] = Product::find($productId[$i]);
            }

            $promotions[$key]->products = $relatedProduct;
        }

        // dd($promotions);

        return view('backend.partner.promotion', [
            'partner' => $partner,
            'branches' => $branches,
            'products' => $products,
            'promotions' => $promotions,
            'relatedWorkflow' => $relatedWorkflow,
        ]);
    }
    protected function partnerPromotionImageUpload($request){
        // echo 11; die();
        $promotionImage = $request->file('attachment');
        $image = Image::make($promotionImage);
        $fileType = $promotionImage->getClientOriginalExtension();
        $imageName = 'promotion_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/promotions/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);
        return $imageUrl;
    }
    public function partnerPromotionCreate(Request $request)
    {
        $request->validate([
          'title'    => 'required',
          'description'   => 'required',
          'date_start_end'   => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $promotion = new Promotion();
        $promotion->partner_id = $request->partner_id;
        $promotion->title = $request->title;
        $promotion->description = $request->description;
        $promotion->date_start_end = $request->date_start_end;

        if($request->file('attachment')){
            $imageUrl = $this->partnerPromotionImageUpload($request);
            $promotion->attachment = $imageUrl;
        }

        if($request->apply_status == 1){
            $products = Product::where('partner_id',$request->partner_id)->get();
            $productArray = [];
            foreach($products as $product){
                $productArray[] = $product->id;
            }
            $productValue = implode(',',$productArray);
            $promotion->product_id = $productValue;
        }else{
            $promotion->product_id = $request->product_id;
        }

        // echo "<pre>"; print_r($promotion); die();
        $promotion->save();

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function partnerPromotionEdit(Request $request){
        $promotion = Promotion::where('partner_id', $request->partner_id)->find($request->promotion_id);
        $products = Product::where('partner_id',$request->partner_id)->get();
        $result = [
            'promotion' => $promotion,
            'products' => $products,
        ];

        echo json_encode($result);
    }
    public function partnerPromotionView(Request $request){
        $promotion = Promotion::where('partner_id', $request->partner_id)->find($request->promotion_id);
        $products = Product::where('partner_id',$request->partner_id)->get();
        $result = [
            'promotion' => $promotion,
            'products' => $products,
        ];

        echo json_encode($result);
    }
    protected function promotionBasicInfoUpdate($request, $promotion, $imageUrl = null){
        $promotion->partner_id = $request->partner_id;
        $promotion->title = $request->title;
        $promotion->description = $request->description;
        $promotion->date_start_end = $request->date_start_end;

        if($request->apply == 1){
            $products = Product::where('partner_id',$request->partner_id)->get();
            $productArray = [];
            foreach($products as $product){
                $productArray[] = $product->id;
            }
            $productValue = implode(',',$productArray);
            $promotion->product_id = $productValue;
        }else{
            $promotion->product_id = $request->product_id;
        }

        if($imageUrl){
            $promotion->attachment = $imageUrl;
        }
        // echo "<pre>"; print_r($promotion); die();
        $promotion->save();
    }
    public function partnerPromotionUpdate(Request $request)
    {
        
        $request->validate([
          'title'    => 'required',
          'description'   => 'required',
          'date_start_end'   => 'required',
        ]);

        $promotionImage = $request->file('attachment');
        $promotion = Promotion::find($request->promotion_id);

        if($promotionImage){
            if (File::exists($promotion->attachment)) {
                unlink($promotion->attachment);
            }
            $imageUrl = $this->partnerPromotionImageUpload($request);
            // echo "<pre>"; print_r($imageUrl); die();
            $this->promotionBasicInfoUpdate($request, $promotion, $imageUrl);
        }else{
            $this->promotionBasicInfoUpdate($request, $promotion);
        }

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function partnerPromotionDelete($id, $partnerId)
    {
        Promotion::where('id', $id)->delete();
        return redirect('admin/partner/profile/promotion/'.$partnerId)->with('success', 'Promotion has been deleted successfully !!');
    }
    
}
