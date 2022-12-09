<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MasterCategory;
use App\Models\Partner;
use App\Models\CompanyProfile;
use App\Models\Country;
use App\Models\PartnerType;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\GeneralReason;
use App\Models\FieldName;
use App\Models\CustomField;
use App\Models\User;
use App\Models\OtherGeneral;
use App\Models\GeneralAboutus;
use App\Models\CompanyEmail;
use App\Models\PaymentDetails;
use App\Models\WorkflowCategory;
use App\Models\BusinessInvoiceAddress;
use App\Models\BusinessRegistrationNumber;
use App\Models\TaxSetting;
use App\Models\MailTemplate;
use App\Models\SmsTemplate;
use Illuminate\Support\Facades\Session;
use App\Models\Automation;
use App\Models\Office;
use App\Models\DocumentChecklist;
use App\Models\DocumentTotalChecklist;
use App\Models\SettingDocumentType;
use App\Models\SettingWorkflow;
use App\Models\WorkflowStage;
use App\Models\OfficeCheckin;
use App\Models\SourceList;
use App\Models\Leadform;
use App\Models\SubjectArea;
use App\Models\UserLeadForm;
use App\Models\DegreeLevel;
use App\Models\BillingHistory;
use Illuminate\Support\Facades\URL;
use App\Models\SubscriptionBilling;
use Illuminate\Support\Str;
use File;
use Image;


class SettingsController extends Controller
{
    
    //prefarance
    public function companyProfile(){
        // echo 11; die();
        $company = CompanyProfile::find(Session::get('user_id'));
        $countries = Country::get();
        return view('backend/settings/preference/company_profile', [
            'company' => $company,
            'countries' => $countries,
        ]);
    }

    protected function userSectionImage($request)
    {
        $companyImage = $request->file('company_image');

        $image = Image::make($companyImage);
        $fileType = $companyImage->getClientOriginalExtension();
        $imageName = 'company_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/company/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);

        $thumbnail = $directory . "thumbnail/" . $imageName;
        $image->resize(null, 200, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($thumbnail);

        return $imageUrl;
    }

    public function updateCompanyProfile(Request $request){
        
        $request->validate([
            'company_name' => 'required',
            'company_email' => 'required',
            'company_phone' => 'required',
            'country_id' => 'required',
        ]);

        $company = CompanyProfile::find(Session::get('user_id'));
        $companyImage = $request->file('company_image');
        
        if($companyImage){
            if (File::exists($company->company_image)) {
                unlink($company->company_image);
            }

            $imageUrl = $this->userSectionImage($request);
            $company->company_image = $imageUrl;
        }

        $company->company_name = $request->company_name;
        $company->company_email = $request->company_email;
        $company->company_phone = $request->company_phone;
        $company->company_fax = $request->company_fax;
        $company->company_website = $request->company_website;
        $company->company_street = $request->company_street;
        $company->company_city = $request->company_city;
        $company->company_state = $request->company_state;
        $company->company_zipcode = $request->company_zipcode;
        $company->country_id = $request->country_id;
        $company->save();
        
        // echo "<pre>"; print_r($company); die();

        return redirect('admin/setting/prefarance/profile')->with('success', 'Successfully update');
    }
    
    
    public function domainInformation(){
        return view('backend/settings/preference/preferences_information');
    }
    public function preferenceLegal(){
        return view('backend/settings/preference/preferences_legal');
    }


    //tag_management
    public function tagManagement(){
        $tags = Tag::with('user')->get();
        return view('backend/settings/tag-management/tag_management', [
            'tags' => $tags
        ]);
    }
    public function tagManagementCreate(Request $request)
    {
        $request->validate([
          'name'    => 'required',
        ]);
        // echo "<pre>"; print_r($_POST); die();
        $tagExplodes = explode(',',$request->name);
        foreach($tagExplodes as $tagname){
            $tag = new Tag();
            $tag->name = $tagname;
            $tag->created_by = Session::get('user_id');
            // $tag->updated_by = Session::get('user_id');
            $tag->save();
        }

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function tagManagementEdit(Request $request)
    {
        $tag = Tag::find($request->tag_id);
        echo json_encode($tag);
    }
    public function tagManagementUpdate(Request $request)
    {
        $request->validate([
          'name'    => 'required',
        ]);

        $tag = Tag::find($request->tag_id);
        $tag->name = $request->name;
        $tag->updated_by = Session::get('user_id');
        $tag->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function tagManagementDelete($id)
    {
        Tag::where('id', $id)->delete();
        return redirect('admin/setting/tag/management')->with('success', 'Tag has been deleted successfully !!');
    }


    //setting_subscription
    public function settingSubscription(){
        // echo 11; die();
        
        $billing = SubscriptionBilling::where('user_id', Session::get('user_id'))->first();
        $users = User::get();
        return view('backend/settings/subscription-billing/subscription', [
            'users' => $users,
            'billing' => $billing,
        ]);
    }
    public function subscriptionChange(){
        return view('backend/settings/subscription-billing/subscriptionchange');
    }
    public function subscriptionBilling(){
        $BillingHistories = BillingHistory::where('user_id', Session::get('user_id'))->get();
        return view('backend/settings/subscription-billing/billing_details', [
            'BillingHistories' => $BillingHistories
        ]);
    }
    public function subscriptionBillingReview(Request $request)
    {
        // dd($request->monthy_priceplan);

        if($request->choose_plan == 1){
            $monthly = '';
            if($request->monthy_priceplan == 1){
                $mode = 'Basic';
                $monthly = 7;
            }else if($request->monthy_priceplan == 2){
                $mode = 'Professional';
                $monthly = 10;
            }else if($request->monthy_priceplan == 3){
                $mode = 'Standard';
                $monthly = 14;
            }else if($request->monthy_priceplan == 4){
                $mode = 'Premium';
                $monthly = 21;
            }

            if($request->basic_total_user == 1){
                $standard = '0.00';
            }else{
                $standard = $monthly * $request->basic_total_user;
            }

            if($request->basic_storage_capacity <= 50){
                $storage  = '0.00';
            }else{
                $storage = ($request->basic_storage_capacity * 0.1) - 5;
            }

            if($request->monthly_inbox <= 2000){
                $inbox  = '0.00';
            }else{
                $inbox = ($request->monthly_inbox * 0.005) - 10;
            }

            if($request->monthly_outbox <= 2000){
                $outbox  = '0.00';
            }else{
                $outbox = ($request->monthly_outbox * 0.005) - 10;
            }

            if($request->basic_total_user == 1){
                $total = $monthly + $storage + $inbox + $outbox;
            }else{
                $total = $standard + $storage + $inbox + $outbox;
            }
            // echo $total; die();

            $result = [
                'mode' => $mode,
                'total' => $total,
                'plan' => 'monthly',
                'inbox_unit' => $inbox,
                'mode_unit' => $monthly,
                'outbox_unit' => $outbox,
                'mode_total' => $standard,
                'storage_unit' => $storage,
                'inbox_total' => $request->monthly_inbox,
                'total_user' => $request->basic_total_user,
                'outbox_total' => $request->monthly_outbox,
                'storage_total' => $request->basic_storage_capacity,
            ];

        }
        if($request->choose_plan == 2){
            $yearly_priceplan = '';
            if($request->yearly_priceplan == 1){
                $mode = 'Basic';
                $yearly_priceplan = 60;
            }else if($request->yearly_priceplan == 2){
                $mode = 'Professional';
                $yearly_priceplan = 84;
            }else if($request->yearly_priceplan == 3){
                $mode = 'Standard';
                $yearly_priceplan = 120;
            }else if($request->yearly_priceplan == 4){
                $mode = 'Premium';
                $yearly_priceplan = 180;
            }

            if($request->yearly_total_user == 1){
                $yearly_mode = '0.00';
            }else{
                $yearly_mode = $yearly_priceplan * $request->yearly_total_user;
            }

            if($request->yearly_storage_capacity <= 50){
                // echo 11; die();

                $yearly_storage  = '0.00';
            }else{
                $yearly_storage = ($request->yearly_storage_capacity * 1.2) - 60;
            }

            if($request->yearly_inbox <= 24000){
                $yearly_inbox  = '0.00';
            }else{
                $yearly_inbox = ($request->yearly_inbox * 0.005) - 120;
            }

            if($request->yearly_outbox <= 24000){
                $yearly_outbox  = '0.00';
                // echo $yearly_outbox; die();
            }else{
                $yearly_outbox = ($request->yearly_outbox * 0.005) - 120;
            }

            if($request->yearly_total_user == 1){
                $yearly_total = $yearly_priceplan + $yearly_storage + $yearly_inbox + $yearly_outbox;
            }else{
                $yearly_total = $yearly_mode + $yearly_storage + $yearly_inbox + $yearly_outbox;
            }
            // echo $total; die();

            $result = [
                'mode' => $mode,
                'plan' => 'yearly',
                'total' => $yearly_total,
                'mode_unit' => $yearly_priceplan,
                'total_user' => $request->yearly_total_user,
                'mode_total' => $yearly_mode,
                'storage_unit' => $yearly_storage,
                'storage_total' => $request->yearly_storage_capacity,
                'inbox_unit' => $yearly_inbox,
                'inbox_total' => $request->yearly_inbox,
                'outbox_unit' => $yearly_outbox,
                'outbox_total' => $request->yearly_outbox,
            ];
            
        }

        return response()->json($result);
    }
    public function subscriptionBillingSaveReview(Request $request){
        // dd($_POST);

        $billing = SubscriptionBilling::find(Session::get('user_id'));
        $billing->user_id = Session::get('user_id');
        $billing->plan_name = $request->plan_name;
        $billing->mode_name = $request->mode_name;
        $billing->total_user = $request->total_user;
        $billing->mode_unit = $request->mode_unit;
        $billing->mode_total = $request->mode_total;
        $billing->storage_unit = $request->storage_unit;
        $billing->storage_total = $request->storage_total;
        $billing->inbox_unit = $request->inbox_unit;
        $billing->inbox_total = $request->inbox_total;
        $billing->outbox_total = $request->outbox_total;
        $billing->outbox_unit = $request->outbox_unit;
        $billing->total_amount = $request->total_amount;
        $billing->save();

        return response()->json(['billing_id'=>$billing->id]);
    }


    //setting_account
    public function settingAccount(){
        $businessregno = BusinessRegistrationNumber::get()->first();
        $businessinvoice = BusinessInvoiceAddress::get()->first();
        $countries = Country::get();
        $paymentdetails = PaymentDetails::get();
        $taxsettings = TaxSetting::get();

        return view('backend/settings/accounts/setting_account', [
            'countries' => $countries,
            'taxsettings' => $taxsettings,
            'businessregno' => $businessregno,
            'paymentdetails' => $paymentdetails,
            'businessinvoice' => $businessinvoice
        ]);
    }
    
    public function settingRegistrationSave(Request $request){
        $businessregno = BusinessRegistrationNumber::find($request->id);
        $businessregno->registration_number = $request->registration_number;
        $businessregno->save();
        return redirect('admin/setting/account')->with('success', 'Business registration number successfully updated !!');
    }
    public function updateInvoiceAddress(Request $request){
        $request->validate([
          'country_id'    => 'required',
        ]);
        $businessregno = BusinessInvoiceAddress::find($request->id);
        $businessregno->street = $request->street;
        $businessregno->city = $request->city;
        $businessregno->state = $request->state;
        $businessregno->post_code = $request->post_code;
        $businessregno->country_id = $request->country_id;
        $businessregno->save();
        return redirect('admin/setting/account')->with('success', 'Business invoice address successfully updated !!');
    }

    //payment
    public function manualPaymentCreate(Request $request){
        $request->validate([
          'option_name'    => 'required',
          'details_content'    => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();
        $paymentDetails = new PaymentDetails();
        $paymentDetails->option_name = $request->option_name;
        $paymentDetails->details_content = $request->details_content;
        $paymentDetails->invoice_type = $request->invoice_type;
        $paymentDetails->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function manualPaymentEdit(Request $request){
        $payment = PaymentDetails::find($request->payment_id);
        echo json_encode($payment);
    }
    public function manualPaymentUpdate(Request $request)
    {
        $request->validate([
          'option_name'   => 'required',
          'details_content'   => 'required',
        ]);
        
        // echo "<pre>"; print_r($_POST); die();
        $paymentDetails = PaymentDetails::find($request->payment_id);
        $paymentDetails->option_name = $request->option_name;
        $paymentDetails->details_content = $request->details_content;
        $paymentDetails->invoice_type = $request->invoice_type;
        $paymentDetails->save();

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function manualPaymentDelete($id)
    {
        PaymentDetails::where('id', $id)->delete();
        return redirect('admin/setting/account')->with('success', 'Manual payment details deleted successfully !!');
    }
    public function taxSettingUpdate(Request $request)
    {
        // echo "<pre>"; print_r($_POST); die();
        $delete = TaxSetting::get();
        if($delete){
            TaxSetting::query()->truncate();
        }

        foreach($request->tax_code as $key => $taxcode){
            $result = [];
            $result['tax_code'] = $taxcode;
            $result['tax_rate'] = $request->tax_rate[$key];

            $taxsetting = new TaxSetting();
            $taxsetting->tax_code = $result['tax_code'];
            $taxsetting->tax_rate = $result['tax_rate'];
            $taxsetting->save();
        }
        // echo "<pre>"; print_r($result); // die();
        return redirect('admin/setting/account')->with('success', 'Tax setting successfully added !!');
    }
    public function taxSettingDelete($id)
    {
        TaxSetting::where('id', $id)->delete();
        return redirect('admin/setting/account')->with('success', 'Tax setting successfully update !!');
    }


    //setting_workflow
    public function settingWorkflow(){
        $settingWorkflows = SettingWorkflow::get();
        return view('backend/settings/workflows/setting_workflow', [
            'settingWorkflows' => $settingWorkflows,
        ]);
    }
    public function addworkflow(){
        // echo 11; die();
        $offices = Office::get();
        // dd($settingWorkflow);
        return view('backend/settings/workflows/add_workflow', [
            'offices' => $offices,
        ]);
    }
    public function saveWorkflow(Request $request){
        $workflow = new SettingWorkflow();
        $workflow->name = $request->name;
        
        if($request->accessible_id == 1){
            $workflow->office_id = $request->office_id;
        }
        if($request->accessible_id == 2){
            $workflow->office_id = implode(',', $request->office_id);
        }
        $workflow->accessible_id = $request->accessible_id;
        $workflow->save();

        if($request->stage_name){
            foreach($request->stage_name as $value){
                $array = [];
                $array['stage_name'] = $value;
                $array['setting_workflow_id'] = $workflow->id;
                // echo "<pre>"; print_r($array); 
                
                $stage = new WorkflowStage();
                $stage->stage_name = $array['stage_name'];
                $stage->setting_workflow_id = $array['setting_workflow_id'];
                $stage->save();
            }
        }

        return redirect('admin/setting/workflow')->with('success', 'Workflow setting successfully added !!');
    }
    public function editSettingWorkflow($id){
        $stage = SettingWorkflow::with('stage')->find($id);
        $offices = Office::get();

        $officeId = explode(',',$stage->office_id);
        
        $relatedOffice = [];
        if($stage->office_id != ''){
            for($i=0; $i < count($officeId); $i++){
                $relatedOffice[] = Office::select('id')->where('id', $officeId[$i])->get()->first();
            }
        }

        return view('backend/settings/workflows/edit_workflow', [
            'stage' => $stage,
            'offices' => $offices,
            'relatedOffice' => $relatedOffice,
        ]);
        // dd($stage);
    }
    public function updateSettingWorkflow(Request $request){
        // echo "<pre>"; print_r($_POST); die();

        $workflow = SettingWorkflow::find($request->workflow_id);
        $workflow->name = $request->name;
        
        if($request->accessible_id == 1){
            $workflow->office_id = $request->office_id;
        }
        if($request->accessible_id == 2){
            $workflow->office_id = implode(',', $request->office_id);
        }
        $workflow->accessible_id = $request->accessible_id;
        $workflow->save();


        $checkingWorkflowStage = WorkflowStage::where('setting_workflow_id', $request->workflow_id)->get();
        if($checkingWorkflowStage){
            WorkflowStage::where('setting_workflow_id', $request->workflow_id)->delete();
        }
        // dd($checkingWorkflowStage);

        if($request->stage_name){
            foreach($request->stage_name as $value){
                $array = [];
                $array['stage_name'] = $value;
                $array['setting_workflow_id'] = $workflow->id;
                // echo "<pre>"; print_r($array); 
                
                $stage = new WorkflowStage();
                $stage->stage_name = $array['stage_name'];
                $stage->setting_workflow_id = $array['setting_workflow_id'];
                $stage->save();
            }
        }

        return redirect('admin/setting/workflow')->with('success', 'Workflow setting successfully updated !!');

    }
    public function deleteSettingWorkflowStage($id, $workflow_id)
    {
        // echo $workflow_id; die();
        WorkflowStage::where('id', $id)->delete();
        return redirect('admin/setting/workflow/edit/'.$workflow_id)->with('success', 'Workflow stage setting successfully deleted !!');
    }
    public function deleteSettingWorkflow($id)
    {
        SettingWorkflow::where('id', $id)->delete();
        WorkflowStage::where('setting_workflow_id', $id)->delete();

        return redirect('admin/setting/workflow')->with('success', 'Workflow setting successfully deleted !!');
    }
    
    //document checklist
    public function settingDocumentChecklist()
    {
        $documentChecklists = DocumentChecklist::with('workflow', 'user', 'total_checklist')->get();
        // dd($documentChecklists);
        return view('backend/settings/workflows/document-checklist/setting_document_checklist', [
            'documentChecklists' => $documentChecklists,
        ]);
    }
    public function settingDocumentChecklistAdd()
    {
        $workflows = WorkflowCategory::get();
        // dd($checklists);
        return view('backend/settings/workflows/document-checklist/add_document_checklist', [
            'workflows' => $workflows,
        ]);
    }
    public function settingDocumentChecklistSave(Request $request)
    {
        $request->validate([
          'workflow_id' => 'required',
        ]);

        $type = new DocumentChecklist();
        $type->workflow_id = $request->workflow_id;
        $type->created_by = Session::get('user_id');
        $type->status = 1;
        $type->save();

        return redirect('admin/setting/document/checklist/edit/'. $type->id);
    }
    public function settingDocumentChecklistEdit($id)
    {
        $checklists = DocumentTotalChecklist::with('document')->where('checklist_id', $id)->get();
        $partners = Partner::get();
        $products = Product::get();
        $workflows = WorkflowCategory::get();
        $types = SettingDocumentType::get();
        return view('backend/settings/workflows/document-checklist/edit_document_checklist', [
            'types' => $types,
            'checklist_id' => $id,
            'products' => $products,
            'partners' => $partners,
            'workflows' => $workflows,
            'checklists' => $checklists,
        ]);
    }
    public function settingDocumentChecklistUpdate(Request $request)
    {
        $request->validate([
          'type_name'    => 'required',
        ]);

        $type = SettingDocumentType::find($request->type_id);
        $type->type_name = $request->type_name;
        $type->created_by = Session::get('user_id');
        $type->status = 1;
        $type->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function settingDocumentChecklistDelete($id)
    {
        DocumentChecklist::where('id', $id)->delete();
        $checklists = DocumentTotalChecklist::where('checklist_id', $id)->get();
        if($checklists){
            $checklists = DocumentTotalChecklist::where('checklist_id', $id)->delete();
        }
        return redirect('admin/setting/document/checklist')->with('success', 'Document checklist has been deleted successfully !!');
    }
    
    //document total checklist
    public function settingDocumentTotalCheckCreate(Request $request)
    {
        $request->validate([
          'document_type_id' => 'required',
          'description' => 'required',
        ]);

        // dd($_POST);

        $totalCheckList = new DocumentTotalChecklist();
        $totalCheckList->checklist_id = $request->checklist_id;
        $totalCheckList->checklist_status = $request->checklist_status;
        $totalCheckList->document_type_id = $request->document_type_id;
        $totalCheckList->description = $request->description;
        
        if($request->apply_to == 1){
            $totalCheckList->select_partner = 1;
        }
        if($request->apply_to == 2){
            $totalCheckList->select_partner = implode(',', $request->select_partner);
        }
        $totalCheckList->apply_to = $request->apply_to;

        if($request->product_to == 1){
            $totalCheckList->select_product = 1;
        }
        if($request->product_to == 2){
            $totalCheckList->select_product = implode(',', $request->select_product);
        }
        $totalCheckList->product_to = $request->product_to;

        $totalCheckList->upload_document = $request->upload_document;
        $totalCheckList->mandatory_inorder = $request->mandatory_inorder;
        $totalCheckList->save();

        // die();

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function settingDocumentTotalCheckEdit(Request $request)
    {
        $checklist = DocumentTotalChecklist::with('document')->find($request->total_checklist_id);
        
        $relatedPartner = [];
        if($checklist->select_partner != '1'){
            $partnerExplodes = explode(',',$checklist->select_partner);
            foreach($partnerExplodes as $partner){
                $relatedPartner[] = Partner::find($partner);
            }
        }

        $relatedProduct = [];
        if($checklist->select_product != '1'){
            $productExplodes = explode(',',$checklist->select_product);
            foreach($productExplodes as $product){
                $relatedProduct[] = Product::find($product);
            }
        }

        $partners = Partner::get();
        $products = Product::get();

        
        $results = [
            'all_product' => $products,
            'all_partner' => $partners,
            'checklist' => $checklist,
            'relatedPartner' => $relatedPartner,
            'relatedProduct' => $relatedProduct,
        ];

        echo json_encode($results);
    }
    public function settingDocumentTotalCheckUpdate(Request $request)
    {
        $request->validate([
          'document_type_id' => 'required',
          'description' => 'required',
        ]);

        // dd($_POST);

        $totalCheckList = DocumentTotalChecklist::find($request->total_checklist_id);
        $totalCheckList->document_type_id = $request->document_type_id;
        $totalCheckList->description = $request->description;
        
        if($request->apply_to == 1){
            $totalCheckList->select_partner = 1;
        }
        if($request->apply_to == 2){
            $totalCheckList->select_partner = implode(',', $request->select_partner);
        }
        $totalCheckList->apply_to = $request->apply_to;

         if($request->product_to == 1){
            $totalCheckList->select_product = 1;
        }
        if($request->product_to == 2){
            $totalCheckList->select_product = implode(',', $request->select_product);
        }
        $totalCheckList->product_to = $request->product_to;

        $totalCheckList->upload_document = $request->upload_document;
        $totalCheckList->mandatory_inorder = $request->mandatory_inorder;
        $totalCheckList->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function settingDocumentTotalCheckDelete($id, $checklist_id)
    {
        DocumentTotalChecklist::where('id', $id)->delete();
        return redirect('admin/setting/document/checklist/edit/'.$checklist_id)->with('success', 'Document checklist has been deleted successfully !!');
    }
    public function relatedPartnerProductInfo(Request $request)
    {
        $products = Product::where('partner_id', $request->partner_id)->get();
        echo json_encode($products);
    }
    
    //document type
    public function settingDocumentType()
    {
        // echo 22; die();
        $documentTypes = SettingDocumentType::with('user')->get();
        return view('backend/settings/workflows/document-type/setting_document_type', [
            'documentTypes' => $documentTypes,
        ]);
    }
    public function settingDocumentTypeCreate(Request $request)
    {
        $request->validate([
          'type_name'    => 'required',
        ]);
        // echo "<pre>"; print_r($_POST); die();
        $tagExplodes = explode(',',$request->type_name);
        foreach($tagExplodes as $typename){
            $type = new SettingDocumentType();
            $type->type_name = $typename;
            $type->created_by = Session::get('user_id');
            $type->status = 1;
            // $tag->updated_by = Session::get('user_id');
            $type->save();
        }

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function settingDocumentTypeEdit(Request $request)
    {
        $type = SettingDocumentType::find($request->type_id);
        echo json_encode($type);
    }
    public function settingDocumentTypeUpdate(Request $request)
    {
        $request->validate([
          'type_name'    => 'required',
        ]);

        $type = SettingDocumentType::find($request->type_id);
        $type->type_name = $request->type_name;
        $type->created_by = Session::get('user_id');
        $type->status = 1;
        $type->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function settingDocumentTypeDelete($id)
    {
        SettingDocumentType::where('id', $id)->delete();
        return redirect('admin/setting/document/type')->with('success', 'Document type has been deleted successfully !!');
    }


    //setting_email
    public function settingEmail(){
        $users = User::get();
        $companyEmails = CompanyEmail::get();

        return view('backend/settings/company-email/setting_email', [
            'users' => $users,
            'companyEmails' => $companyEmails
        ]);
    }
    public function settingEmailCreate(Request $request){
        $request->validate([
          'email_id'    => 'required',
          'user_id'    => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();
        $companyEmail = new CompanyEmail();
        $companyEmail->email_id = $request->email_id;
        $companyEmail->status = $request->status;
        $companyEmail->incoming_email = $request->incoming_email;
        $companyEmail->display_name = $request->display_name;
        $companyEmail->user_id = $request->user_id;
        $companyEmail->email_singature = $request->email_singature;
        $companyEmail->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function settingEmailEdit(Request $request){
        $companyemail = CompanyEmail::find($request->email_id);
        $users = User::get();

        $result = [
            'users' => $users,
            'companyemail' => $companyemail
        ];

        echo json_encode($result);
    }
    public function settingEmailUpdate(Request $request)
    {
        $request->validate([
          'email_id'    => 'required',
          'user_id'    => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $companyEmail = CompanyEmail::find($request->company_id);
        $companyEmail->email_id = $request->email_id;
        $companyEmail->status = $request->status;
        $companyEmail->incoming_email = $request->incoming_email;
        $companyEmail->display_name = $request->display_name;
        $companyEmail->user_id = $request->user_id;
        $companyEmail->email_singature = $request->email_singature;
        $companyEmail->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function settingEmailDelete($id)
    {
        CompanyEmail::where('id', $id)->delete();
        return redirect('admin/setting/email')->with('success', 'Company email deleted successfully !!');
    }
    public function settingEmailDeactive($id)
    {
        $companyEmail = CompanyEmail::find($id);
        $companyEmail->status = 0;
        $companyEmail->save();

        return redirect('admin/setting/email')->with('success', 'Company email deactivated successfully !!');
    }
    public function settingEmailActive($id)
    {
        $companyEmail = CompanyEmail::find($id);
        $companyEmail->status = 1;
        $companyEmail->save();

        return redirect('admin/setting/email')->with('success', 'Company email activated successfully !!');
    }
    


    //setting_templates
    public function settingTemplate(){
        $mailtemplates = MailTemplate::get();
        return view('backend/settings/templates/templates_email', [
            'mailtemplates' => $mailtemplates
        ]);
    }
    protected function templateImageUpload($request){
        // echo 11; die();
        $templateImage = $request->file('documents');
        $image = Image::make($templateImage);
        $fileType = $templateImage->getClientOriginalExtension();
        $imageName = 'document_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/template/email';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);
        return $imageUrl;
    }
    public function templateEmailCreate(Request $request){
        $request->validate([
          'title'    => 'required',
          'subject'    => 'required',
          'body'    => 'required',
        ]);
        // echo "<pre>"; print_r($_POST); die();

        $mailTemplate = new MailTemplate();
        $mailTemplate->title = $request->title;
        $mailTemplate->subject = $request->subject;
        $mailTemplate->body = $request->body;
        $mailTemplate->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function templateEmailEdit(Request $request){
        $template = MailTemplate::find($request->template_id);
        echo json_encode($template);
    }
    protected function templateBasicInfoUpdate($request, $template, $imageUrl = null){
        $template->title = $request->title;
        $template->subject = $request->subject;
        $template->body = $request->body;
        if($imageUrl){
            $template->documents = $imageUrl;
        }
        $template->save();
    }
    public function templateEmailUpdate(Request $request)
    {
        $request->validate([
          'title'    => 'required',
          'subject'    => 'required',
          'body'    => 'required',
        ]);

        $templateImage = $request->file('documents');
        $template = MailTemplate::find($request->template_id);

        if($templateImage){
            if (File::exists($template->documents)) {
                unlink($template->documents);
            }
            $imageUrl = $this->templateImageUpload($request);
            $this->templateBasicInfoUpdate($request, $template, $imageUrl);
        }else{
            $this->templateBasicInfoUpdate($request, $template);
        }

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function templateEmailDelete($id)
    {
        MailTemplate::where('id', $id)->delete();
        return redirect('admin/setting/template/email')->with('success', 'Template email deleted successfully !!');
    }



    public function settingTemplatesSms(){
        $smstemplates = SmsTemplate::get();
        return view('backend/settings/templates/templates_sms', [
            'smstemplates' => $smstemplates
        ]);
    }
    public function templateSmsCreate(Request $request){
        $request->validate([
          'title'    => 'required',
          'text_message'    => 'required',
        ]);

        $smsTemplate = new SmsTemplate();
        $smsTemplate->title = $request->title;
        $smsTemplate->text_message = $request->text_message;
        $smsTemplate->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function templateSmsEdit(Request $request){
        $template = SmsTemplate::find($request->template_id);
        echo json_encode($template);
    }
    public function templateSmsUpdate(Request $request)
    {
        $request->validate([
          'title'    => 'required',
          'text_message'    => 'required',
        ]);
        // echo "<pre>"; print_r($_POST); die();

        $smsTemplate = SmsTemplate::find($request->template_id);
        $smsTemplate->title = $request->title;
        $smsTemplate->text_message = $request->text_message;
        $smsTemplate->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function templateSmsDelete($id)
    {
        SmsTemplate::where('id', $id)->delete();
        return redirect('admin/setting/template/sms')->with('success', 'Template sms deleted successfully !!');
    }


    //setting_phonesetting
    public function phoneSetting(){
        return view('backend/settings/phone-settings/phone_setting');
    }
    public function regulatoryCompliance(){
        return view('backend/settings/phone-settings/regulatory_compliance');
    }
    public function creditBalance(){
        return view('backend/settings/phone-settings/credit_balance');
    }
    public function phoneSettinglog(){
        return view('backend/settings/phone-settings/phonesetting_logs');
    }


   //setting_leadform

    protected function CoverImageUpload($cover_image){
        $image = Image::make($cover_image);
        $fileType = $cover_image->getClientOriginalExtension();
        $imageName = 'document_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/lead_form/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);
        return $imageUrl;
    }

    protected function headerImageUpload($header_image){
        $image = Image::make($header_image);
        $fileType = $header_image->getClientOriginalExtension();
        $imageName = 'document_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/lead_form/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);
        return $imageUrl;
    }


    public function settingLeadform(){
        $Leadform=Leadform::get();
        return view('backend/settings/lead-forms/setting_leadform',compact('Leadform'));
    }
    public function settingLeadformCreate(){
        $Office=Office::get();
        $SourceList=SourceList::get();
        $Tag=Tag::get();
        $view_path='backend/settings/lead-forms/setting_leadform_create';
        return view($view_path,compact('Office','SourceList','Tag'));
    }

    public function settingLeadformSave(Request $req)
    {
        //dd($req->all());
        $req->validate([
            'save_form_as'    => 'required|unique:lead_forms,save_form_as',
          ]);

        $cover_image=$req->file('cover_image');
        $header_image=$req->file('header_image');

        if($cover_image)
        {
            $imageUrl=$this->CoverImageUpload($cover_image);
        }  
        if($header_image)
        {
            $imageUrl1=$this->headerImageUpload($header_image);
        } 

        /* -------All are checkboxs-------------  */
        $data_arr['state']=isset($req->state) ? $req->state : 0;
        $data_arr['postal_code']=isset($req->postal_code) ? $req->postal_code : 0;
        $data_arr['country']=isset($req->country) ? $req->country : 0;
        $data_arr['visa_type']=isset($req->visa_type) ? $req->visa_type : 0;
        $data_arr['visa_expiry_date']=isset($req->visa_expiry_date) ? $req->visa_expiry_date : 0;
        $data_arr['country_of_passport']=isset($req->country_of_passport) ? $req->country_of_passport : 0;
        $data_arr['preferred_intake']=isset($req->preferred_intake) ? $req->preferred_intake : 0;
        $data_arr['workflow']=isset($req->workflow) ? $req->workflow : 0;
        $data_arr['partner']=isset($req->partner) ? $req->partner : 0;
        $data_arr['australian_education']=isset($req->australian_education) ? $req->australian_education : 0;
        $data_arr['us_education']=isset($req->us_education) ? $req->us_education : 0;
        $data_arr['visa_service']=isset($req->visa_service) ? $req->visa_service : 0;
        $data_arr['accomodation_service']=isset($req->accomodation_service) ? $req->accomodation_service : 0;
        $data_arr['insurance_service']=isset($req->insurance_service) ? $req->insurance_service : 0;
        $data_arr['subject_area']=isset($req->subject_area) ? $req->subject_area : 0;
        $data_arr['subject']=isset($req->subject) ? $req->subject : 0;
        $data_arr['course_start']=isset($req->course_start) ? $req->course_start : 0;
        $data_arr['course_end']=isset($req->course_end) ? $req->course_end : 0;
        $data_arr['academic_score']=isset($req->academic_score) ? $req->academic_score : 0;
        $data_arr['tofel']=isset($req->tofel) ? $req->tofel : 0;
        $data_arr['IELTS']=isset($req->IELTS) ? $req->IELTS : 0;
        $data_arr['PTE']=isset($req->PTE) ? $req->PTE : 0;
        $data_arr['sat1']=isset($req->sat1) ? $req->sat1 : 0;
        $data_arr['sat2']=isset($req->sat2) ? $req->sat2 : 0;
        $data_arr['gre']=isset($req->gre) ? $req->gre : 0;
        $data_arr['gmat']=isset($req->gmat) ? $req->gmat : 0;
        $data_arr['upload_document']=isset($req->upload_document) ? $req->upload_document : 0;
        $data_arr['comment']=isset($req->comment) ? $req->comment : 0;
        $data_arr['related_office']=isset($req->related_office) ? $req->related_office : 0;
        $data_arr['source']=isset($req->source) ? $req->source : 0;
        $data_arr['tag_name']=isset($req->tag_name) ? $req->tag_name : 0;
        $data_arr['privacy_info']=isset($req->privacy_info) ? $req->privacy_info : '';
        $data_arr['consent']=isset($req->consent) ? $req->consent : '';
        $data_arr['upload_profile_image']=isset($req->upload_profile_image) ? $req->upload_profile_image : 0;
        $data_arr['date_of_birth']=isset($req->date_of_birth) ? $req->date_of_birth : 0;
        $data_arr['phone']=isset($req->phone) ? $req->phone : 0;
        $data_arr['secondary_email']=isset($req->secondary_email) ? $req->secondary_email : 0;
        $data_arr['contact_preference']=isset($req->contact_preference) ? $req->contact_preference : 0;
        $data_arr['street']=isset($req->street) ? $req->street : 0;
        $data_arr['city']=isset($req->city) ? $req->city : 0;
        $data_arr['show_privacy_info']=isset($req->show_privacy_info) ? $req->show_privacy_info : 0;
 
        $url_title=Str::slug($req->save_form_as);
        /* -------checkboxs end-------------  */
        $Leadform=new Leadform();
        $Leadform->save_form_as=$url_title;
        $Leadform->cover_image=isset($imageUrl) ? $imageUrl :'';
        $Leadform->header_image=isset($imageUrl1) ? $imageUrl1 :'';
        $Leadform->header_title=$req->header_title;
        $Leadform->header_text=$req->header_text;
        $Leadform->system_fileds=json_encode($data_arr);
        $Leadform->lead_form_link=URL::to('')."/online-form/".$url_title;
        $Leadform->embed_code='<iframe src="https://therssoftware.agentcisapp.com/online-form/social-media-form" frameborder="0" style="width: 100%; border: none; min-height: 100vh;" onload="window.parent.scrollTo(0,0)"></iframe>';
 
        try{
            $Leadform->save();
            // $Leadform_id=$Leadform->id;
            // $Leadform_edit=Leadform::find($Leadform_id);
            // $Leadform_edit->lead_form_link =URL::to('')."/online-form/social-media-form/".$Leadform_id;
            // $Leadform_edit->save();  
            return redirect()->route('backend.setting-lead-form')->with('success', 'Successfully Inserted');
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
          }
    }

    public function settingLeadformEdit($id)
    {
        $lead_form_edit=Leadform::find($id);
        $Office=Office::get();
        $SourceList=SourceList::get();
        $Tag=Tag::get();
        $view_path='backend/settings/lead-forms/setting_leadform_edit';
        return view($view_path,compact('lead_form_edit','Office','SourceList','Tag'));
    }

    public function settingLeadformUpdate(Request $req)
    {
        $check_slug=Leadform::find($req->lead_form_id);
        if(($check_slug->save_form_as != $req->save_form_as) && ($req->save_form_as == ''))
        $req->validate([
            'save_form_as'    => 'required|unique:lead_forms,save_form_as',
          ]);

        //echo URL::to('');die();
        $cover_image=$req->file('cover_image');
        $header_image=$req->file('header_image');

        if($req->hasFile('cover_image'))
        {
            $imageUrl=$this->CoverImageUpload($cover_image);
        }  
        if($req->hasFile('header_image'))
        {
            $imageUrl1=$this->headerImageUpload($header_image);
        } 

        /* -------All are checkboxs-------------  */
        $data_arr['state']=isset($req->state) ? $req->state : 0;
        $data_arr['postal_code']=isset($req->postal_code) ? $req->postal_code : 0;
        $data_arr['country']=isset($req->country) ? $req->country : 0;
        $data_arr['visa_type']=isset($req->visa_type) ? $req->visa_type : 0;
        $data_arr['visa_expiry_date']=isset($req->visa_expiry_date) ? $req->visa_expiry_date : 0;
        $data_arr['country_of_passport']=isset($req->country_of_passport) ? $req->country_of_passport : 0;
        $data_arr['preferred_intake']=isset($req->preferred_intake) ? $req->preferred_intake : 0;
        $data_arr['workflow']=isset($req->workflow) ? $req->workflow : 0;
        $data_arr['partner']=isset($req->partner) ? $req->partner : 0;
        $data_arr['australian_education']=isset($req->australian_education) ? $req->australian_education : 0;
        $data_arr['us_education']=isset($req->us_education) ? $req->us_education : 0;
        $data_arr['visa_service']=isset($req->visa_service) ? $req->visa_service : 0;
        $data_arr['accomodation_service']=isset($req->accomodation_service) ? $req->accomodation_service : 0;
        $data_arr['insurance_service']=isset($req->insurance_service) ? $req->insurance_service : 0;
        $data_arr['subject_area']=isset($req->subject_area) ? $req->subject_area : 0;
        $data_arr['subject']=isset($req->subject) ? $req->subject : 0;
        $data_arr['course_start']=isset($req->course_start) ? $req->course_start : 0;
        $data_arr['course_end']=isset($req->course_end) ? $req->course_end : 0;
        $data_arr['academic_score']=isset($req->academic_score) ? $req->academic_score : 0;
        $data_arr['tofel']=isset($req->tofel) ? $req->tofel : 0;
        $data_arr['IELTS']=isset($req->IELTS) ? $req->IELTS : 0;
        $data_arr['PTE']=isset($req->PTE) ? $req->PTE : 0;
        $data_arr['sat1']=isset($req->sat1) ? $req->sat1 : 0;
        $data_arr['sat2']=isset($req->sat2) ? $req->sat2 : 0;
        $data_arr['gre']=isset($req->gre) ? $req->gre : 0;
        $data_arr['gmat']=isset($req->gmat) ? $req->gmat : 0;
        $data_arr['upload_document']=isset($req->upload_document) ? $req->upload_document : 0;
        $data_arr['comment']=isset($req->comment) ? $req->comment : 0;
        $data_arr['related_office']=isset($req->related_office) ? $req->related_office : 0;
        $data_arr['source']=isset($req->source) ? $req->source : 0;
        $data_arr['tag_name']=isset($req->tag_name) ? $req->tag_name : 0;
        $data_arr['privacy_info']=isset($req->privacy_info) ? $req->privacy_info : '';
        $data_arr['consent']=isset($req->consent) ? $req->consent : '';
        $data_arr['upload_profile_image']=isset($req->upload_profile_image) ? $req->upload_profile_image : 0;
        $data_arr['date_of_birth']=isset($req->date_of_birth) ? $req->date_of_birth : 0;
        $data_arr['phone']=isset($req->phone) ? $req->phone : 0;
        $data_arr['secondary_email']=isset($req->secondary_email) ? $req->secondary_email : 0;
        $data_arr['contact_preference']=isset($req->contact_preference) ? $req->contact_preference : 0;
        $data_arr['street']=isset($req->street) ? $req->street : 0;
        $data_arr['city']=isset($req->city) ? $req->city : 0;
        $data_arr['show_privacy_info']=isset($req->show_privacy_info) ? $req->show_privacy_info : 0;
        /* -------checkboxs end-------------  */

        $Leadform=Leadform::find($req->lead_form_id);
        $Leadform->save_form_as=Str::slug($req->save_form_as);
        $Leadform->cover_image=isset($imageUrl) ? $imageUrl : $req->old_cover_image;
        $Leadform->header_image=isset($imageUrl1) ? $imageUrl1 : $req->old_header_image;
        $Leadform->header_title=$req->header_title;
        $Leadform->header_text=$req->header_text;
        $Leadform->system_fileds=json_encode($data_arr);
        $Leadform->lead_form_link=$req->lead_form_link;
        $Leadform->embed_code=$req->embed_code;
        $Leadform->save();

        try{
            $Leadform->save();
            return redirect()->route('backend.setting-lead-form')->with('success', 'Successfully Updated');
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
          }
    }

    public function leadform_set_favourite($id,$status_id)
    {
        if($status_id == 0)
        {
            $Leadform = Leadform::find($id);
            $Leadform->favourite_status=1;
            $Leadform->save();
            return redirect()->route('backend.setting-lead-form')->with('success','Successfully Make favourite');
        }
        else
        {
            $Leadform = Leadform::find($id);
            $Leadform->favourite_status=0;
            $Leadform->save();
            return redirect()->route('backend.setting-lead-form')->with('success', 'Successfully Remove favourite');
        }
    }
    public function leadform_active_deactive($id,$status_id)
    {
        if($status_id == 1)
        {
            $Leadform = Leadform::find($id);
            $Leadform->status=2;
            $Leadform->save();
            return redirect()->route('backend.setting-lead-form')->with('success', 'Successfully Inactive');
        }
        else
        {
            $Leadform = Leadform::find($id);
            $Leadform->status=1;
            $Leadform->save();
            return redirect()->route('backend.setting-lead-form')->with('success', 'Successfully Active');
        }
    }

    protected function UserLeadFormValidation($request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'contact_email' => 'required|email|unique:user_lead_forms',
            'degree_title' => 'required',
            'degree_level' => 'required',
            'institution' => 'required',
        ]);
    }

    protected function personal_details_photo($personal_details_photo){
        $image = Image::make($personal_details_photo);
        $fileType = $personal_details_photo->getClientOriginalExtension();
        $imageName = 'document_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/lead_form/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);
        return $imageUrl;
    }

    protected function upload_document($upload_document){
        $image = Image::make($upload_document);
        $fileType = $upload_document->getClientOriginalExtension();
        $imageName = 'document_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/lead_form/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);
        return $imageUrl;
    }


    public function social_media_form(Request $req,$slug)
    {
        $method = $req->method();
        if($method == 'POST')
        {
            //$this->UserLeadFormValidation($req);
            if($req->hasFile('personal_details_photo'))
            {
                $imageUrl=$this->personal_details_photo($req->personal_details_photo);
            }  
            if($req->hasFile('upload_document'))
            {
                $imageUrl1=$this->upload_document($req->upload_document);
            } 
            $autralian_education=$req->autralian_education;
            $us_education=$req->us_education;
            $visa_service=$req->visa_service;
            $accomodation_service=$req->accomodation_service;
            $insurance_service=$req->insurance_service;

            $UserLeadForm=new UserLeadForm();
            $UserLeadForm->save_form_as=$slug;
            $UserLeadForm->personal_details_photo=isset($imageUrl) ? $imageUrl : '';
            $UserLeadForm->upload_document=isset($imageUrl1) ? $imageUrl1 : '';
            $UserLeadForm->first_name=$req->first_name;
            $UserLeadForm->last_name=$req->last_name;
            $UserLeadForm->date_of_birth=$req->date_of_birth;
            $UserLeadForm->contact_phone=$req->contact_phone;
            $UserLeadForm->contact_email=$req->contact_email;
            $UserLeadForm->contact_secondary_email=$req->contact_secondary_email;
            $UserLeadForm->contact_preference=$req->contact_preference;
            $UserLeadForm->street=$req->street;
            $UserLeadForm->city=$req->city;
            $UserLeadForm->state=$req->state;
            $UserLeadForm->postal_code=$req->postal_code;
            $UserLeadForm->country=$req->country;
            $UserLeadForm->visa_type=$req->visa_type;
            $UserLeadForm->visa_expire_date=$req->visa_expire_date;
            $UserLeadForm->country_passport=$req->country_passport;
            $UserLeadForm->preferred_intake=$req->preferred_intake;
            $UserLeadForm->autralian_education=isset($autralian_education)? $autralian_education :"";
            $UserLeadForm->us_education=isset($us_education)? $us_education : '';
            $UserLeadForm->visa_service=isset($visa_service)? $visa_service : '';
            $UserLeadForm->accomodation_service=isset($accomodation_service)? $accomodation_service : '';
            $UserLeadForm->insurance_service=isset($insurance_service)? $insurance_service : '';
            $UserLeadForm->degree_title=$req->degree_title;
            $UserLeadForm->degree_level=$req->degree_level;
            $UserLeadForm->institution=$req->institution;
            $UserLeadForm->course_start=$req->course_start;
            $UserLeadForm->course_end=$req->course_end;
            $UserLeadForm->subject_area=$req->subject_area;
            $UserLeadForm->subject=$req->subject;
            $UserLeadForm->academic_score=$req->academic_score;
            $UserLeadForm->academic_score_value=$req->academic_score_value;
            $UserLeadForm->tofel=$req->tofel;
            $UserLeadForm->ielts=$req->ielts;
            $UserLeadForm->pte=$req->pte;
            $UserLeadForm->sat1=$req->sat1;
            $UserLeadForm->sat2=$req->sat2;
            $UserLeadForm->gre=$req->gre;
            $UserLeadForm->gmat=$req->gmat;
            $UserLeadForm->comments=$req->comments;
            $UserLeadForm->privacy_check=$req->privacy_check;
            $UserLeadForm->gre=$req->gre;
            $UserLeadForm->gmat=$req->gmat;
            $UserLeadForm->save();

            $view_path='backend/settings/lead-forms/thank_you';

            return view($view_path,compact('slug'));
        }
        else
        {
            $DegreeLevel=DegreeLevel::get();
            $Country=Country::get();
            $subjectareas = SubjectArea::get(); 
            $lead_form_edit=Leadform::where('save_form_as',$slug)->first();
            $view_path='backend/settings/lead-forms/social_media_form';
            return view($view_path,[
                'lead_form_edit' => $lead_form_edit,
                'Country' => $Country,
                'subjectareas' => $subjectareas,
                'DegreeLevel'=>$DegreeLevel,
            ]);
        }
       
    }


    //setting_automation
    public function settingAutomation(){
        $offices = Office::get();
        $automations = Automation::with('user','office')->get();
        // dd($automations);

        return view('backend/settings/automation-settings/setting_automation', [
            'offices' => $offices,
            'automations' => $automations,
        ]);
    }

    public function settingAutomationCreate(Request $request){
        $request->validate([
          'office_id'    => 'required',
          'automation_name'    => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $automation = new Automation();
        $automation->automation_name = $request->automation_name;
        $automation->office_id = $request->office_id;
        $automation->created_by = Session::get('user_id');
        $automation->status = 1;
        $automation->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function settingAutomationEdit(Request $request){
        $automation = Automation::find($request->automation_id);
        $offices = Office::get();
        $result = [
            'automation' => $automation,
            'offices' => $offices,
        ];

        echo json_encode($result);
    }
    public function settingAutomationUpdate(Request $request)
    {
        $request->validate([
          'office_id'    => 'required',
          'automation_name'    => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $automation = Automation::find($request->automation_id);
        $automation->automation_name = $request->automation_name;
        $automation->office_id = $request->office_id;
        $automation->created_by = Session::get('user_id');
        $automation->status = $request->status;
        $automation->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function settingAutomationDelete($id)
    {
        Automation::where('id', $id)->delete();
        return redirect('admin/setting/automation/')->with('success', 'Automation deleted successfully !!');
    }


    //customfield
    public function customfieldClient(){
        $customFields = CustomField::with('field')->where('module_id', 1)->get();
        // dd($customFields);
        
        return view('backend/settings/custom-fields/customfield_client', [
            'customFields' => $customFields
        ]);
    }
    public function customfieldPartner(){
        $customFields = CustomField::where('module_id', 2)->get();
        // dd($customFields);
        return view('backend/settings/custom-fields/customfield_partner', [
            'customFields' => $customFields
        ]);
    }
    public function customfieldProduct(){
        $customFields = CustomField::where('module_id', 3)->get();
        return view('backend/settings/custom-fields/customfield_product', [
            'customFields' => $customFields
        ]);
    }
    public function customfieldApplication(){
        $customFields = CustomField::where('module_id', 4)->get();
        $workflows = WorkflowCategory::get();

        foreach($customFields as $key => $field){
            $workflow = explode(',', $field->workflow_id);
            
            $workflowName = [];
            for ($i = 0; $i < count($workflow); $i++) {
                $workflowName[] = WorkflowCategory::find($workflow[$i]);
            }
            $customFields[$key]->workflow = $workflowName;
        }

        // dd($customFields);

        return view('backend/settings/custom-fields/customfield_application', [
            'workflows' => $workflows,
            'customFields' => $customFields
        ]);
    }
    public function settingCustomfieldAdd(Request $request){
        $request->validate([
          'module_id'    => 'required',
          'section_id'    => 'required',
          'field_name'    => 'required',
          'field_id'    => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $customField = new CustomField();
        $customField->module_id = $request->module_id;
        $customField->section_id = $request->section_id;
        $customField->field_name = $request->field_name;
        $customField->field_id = $request->field_id;
        $customField->mandatory = $request->mandatory;
        $customField->list_view = $request->list_view;

        if($request->workflow_id){
            $implode = implode(',', $request->workflow_id);
            $customField->workflow_id = $implode;
        }
        
        $customField->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function settingCustomfieldEdit(Request $request){
        $customField = CustomField::where('id',$request->custom_id)->get()->first();
        $workflow = explode(',', $customField->workflow_id);
        $workflowName = [];
        for ($i = 0; $i < count($workflow); $i++) {
            $workflowName[] = WorkflowCategory::find($workflow[$i]);
        }
        $customField->workflow = $workflowName;


        $workflows = WorkflowCategory::get();
        $field = FieldName::get();
        
        $result = [
            'field' => $field,
            'workflows' => $workflows,
            'customfield' => $customField
        ];
        echo json_encode($result);
    }
    public function settingCustomfieldUpdate(Request $request){
        $request->validate([
          'module_id'    => 'required',
          'section_id'    => 'required',
          'field_name'    => 'required',
          'field_id'    => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $customField = CustomField::find($request->custom_id);
        $customField->module_id = $request->module_id;
        $customField->section_id = $request->section_id;
        $customField->field_name = $request->field_name;
        $customField->field_id = $request->field_id;
        $customField->mandatory = $request->mandatory;
        $customField->list_view = $request->list_view;

        if($request->workflow_id){
            $implode = implode(',', $request->workflow_id);
            $customField->workflow_id = $implode;
        }

        $customField->save();

        return response()->json(['success'=>'Record is successfully updated']);
    }
    public function settingCustomfieldDelete($id, $module_id)
    {
        CustomField::where('id', $id)->delete();

        if($module_id == 1){
            return redirect('admin/setting/customfield/client')->with('success', 'Custome field client deleted successfully !!');
        }else if($module_id == 2){
            return redirect('admin/setting/customfield/partner')->with('success', 'Custome field partner deleted successfully !!');
        }else if($module_id == 3){
            return redirect('admin/setting/customfield/product')->with('success', 'Custome field product deleted successfully !!');
        }else if($module_id == 4){
            return redirect('admin/setting/customfield/application')->with('success', 'Custome field application deleted successfully !!');
        }
    }
    
    //general_others
    public function manageProductPartner(){
        // echo 11; die();

        $masterCategories = MasterCategory::get();
        $partnerTypes = PartnerType::with('masterCategory')->get();
        $productTypes = ProductType::with('masterCategory')->get();
        // dd($productTypes);

        return view('backend.settings.general.partner_product', [
            'partnerTypes' => $partnerTypes,
            'productTypes' => $productTypes,
            'masterCategories' => $masterCategories,
        ]);
    }
    public function addProductPartner(Request $request){
        if($request->type == 'partner'){
            // echo "<pre>"; print_r($_POST); die();
            $partnerType = new PartnerType();
            $partnerType->partner_type = $request->partner_name;
            $partnerType->master_category_id = $request->master_category_id;
            $partnerType->partner_status = $request->partner_status;
            $result = $partnerType->save();
            // dd($partnerType);
        }
        if($request->type == 'product'){
            $productType = new ProductType();
            $productType->product_type = $request->product_name;
            $productType->master_category_id = $request->master_category_id;
            $productType->product_status = $request->product_status;
            $result = $productType->save();
        }
        echo json_encode($result);
    }
    public function editPartner($id){
        $masterCategories = MasterCategory::get();
        $partnerType = PartnerType::with('masterCategory')->find($id);
        return view('backend.settings.general.partner-edit', [
            'partnerType' => $partnerType,
            'masterCategories' => $masterCategories,
        ]);
    }
    public function updatePartner(Request $request){
        $partnerType = PartnerType::find($request->id);
        $partnerType->master_category_id = $request->master_category_id;
        $partnerType->partner_type = $request->partner_name;
        $partnerType->partner_status = $request->partner_status;
        $partnerType->save();
        
        return redirect('admin/pp/list')->with('success', 'Partner has been updated successfully !!');
    }
    public function editProduct($id){
        $masterCategories = MasterCategory::get();
        $productType = ProductType::with('masterCategory')->find($id);
        return view('backend.settings.general.product-edit', [
            'productType' => $productType,
            'masterCategories' => $masterCategories,
        ]);
    }
    public function updateProduct(Request $request){
        // echo "<pre>"; print_r($_POST); die();

        $productType = ProductType::find($request->id);
        $productType->master_category_id = $request->master_category_id;
        $productType->product_type = $request->product_name;
        $productType->product_status = $request->product_status;
        $productType->save();
        
        return redirect('admin/pp/list')->with('success', 'Product has been updated successfully !!');
    }
    public function deletePartner($id)
    {
        PartnerType::where('id', $id)->delete();
        return redirect('admin/pp/list')->with('success', 'Partner has been updated successfully !!');
    }
    public function deleteProduct($id)
    {
        ProductType::where('id', $id)->delete();
        return redirect('admin/pp/list')->with('success', 'Product has been updated successfully !!');
    }
    
    
    public function generalDiscontinued(Request $request){
        $generalReason = GeneralReason::get();
        return view('backend/settings/general/discontinued_reasons', [
            'generalReason' => $generalReason
        ]);
    }
    public function updateDiscontinueReason(Request $request)
    {
        // echo "<pre>"; print_r($_POST); die();

        $delete = GeneralReason::get();
        if($delete){
            GeneralReason::query()->truncate();
        }

        foreach($request->reason_name as $reason){
            $result = [];
            $result['reason_name'] = $reason;
            $result['status'] = 1;
            // $result['status'] = $request->status[$key];

            $reason = new GeneralReason();
            $reason->reason_name = $result['reason_name'];
            $reason->status = $result['status'];
            $reason->save();
            // echo "<pre>"; print_r($result);
        }
        // die();
        return redirect('admin/setting/general/discontinued/')->with('success', 'Tax setting successfully added !!');
    }
    public function deleteDiscontinueReason($id)
    {
        GeneralReason::where('id', $id)->delete();
        return redirect('admin/setting/general/discontinued/')->with('success', 'Product has been updated successfully !!');
    }
    public function settingGeneralOther(Request $request){
        $other = OtherGeneral::find(1);
        $aboutUs = GeneralAboutus::get();
        return view('backend/settings/general/general_others', [
            'other' => $other,
            'aboutUs' => $aboutUs
        ]);
    }
    public function updateGeneralOther(Request $request)
    {
        // echo "<pre>"; print_r($_POST); die();

        $delete = GeneralAboutus::get();
        if($delete){
            GeneralAboutus::query()->truncate();
        }

        foreach($request->about_us as $aboutus){
            $result = [];
            $result['about_us'] = $aboutus;
            $result['status'] = 1;
            // $result['status'] = $request->status[$key];

            $aboutUs = new GeneralAboutus();
            $aboutUs->about_us = $result['about_us'];
            $aboutUs->status = $result['status'];
            $aboutUs->save();
            // echo "<pre>"; print_r($result);
        }

        $other = OtherGeneral::find($request->id);
        $other->choose_criteria = $request->choose_criteria;
        $other->internal_prefix = $request->internal_prefix;
        $other->date_format = $request->date_format;
        $other->save();

        // die();
        return redirect('admin/setting/general/others')->with('success', 'General other setting successfully added !!');
    }
    public function deleteGeneralOther($id)
    {
        GeneralAboutus::where('id', $id)->delete();
        return redirect('admin/setting/general/others')->with('success', 'General other setting deleted successfully !!');
    }


    //dataimport
    public function dataimportPartnerproduct(){
        // dd(11);
        return view('backend/settings/data-import/partner_product');
    }
    public function dataimportContact(){
        return view('backend/settings/data-import/dataimport_contact');
    }
    public function dataimportApplication(){
        return view('backend/settings/data-import/dataimport_application');
    }


    //office_checkin
    public function settingOfficecheckin($office = null){
        // echo 11; die();
        if($office == ''){
            $office = 1;
        }
        $offices = Office::get();
        $office = OfficeCheckin::where('office_id',$office)->get()->first();
        // dd($office);

        return view('backend/settings/office-checkin/setting_officecheckin', [
            'office' => $office,
            'offices' => $offices,
        ]);
    }
    public function settingOfficeCheckinUpdate(Request $request){
        // echo "<pre>"; print_r($_POST); die();

        $office = OfficeCheckin::where('office_id',$request->office_id)->get()->first();
        $office->office_id = $request->office_id;
        $office->purpose_mandatory = $request->purpose_mandatory;
        $office->attending = $request->attending;
        $office->completing = $request->completing;
        $office->archiving = $request->archiving;
        $office->save();

        return redirect('admin/setting/office/checkin/'.$request->office_id)->with('success', 'Successfully Updated');
    }

    
}
