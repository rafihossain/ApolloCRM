<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CompanyProfile;
use App\Models\Currency;
use App\Models\InterestedService;
use App\Models\Office;
use App\Models\Partner;
use App\Models\PartnerBranch;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\Quotationitem;
use App\Models\QuotationsTemplate;
use App\Models\User;
use App\Models\WorkflowCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use PDF;

class QuotationsController extends Controller
{
    //quotation-template
    public function QuotationsTemplateList(Request $request){
        // dd(11);
        if ($request->ajax()) {
            $data = Quotation::with('office','user')->where('status', 0)->get();
            // dd($data);
            return DataTables::of($data)
                ->editColumn('created_at', function ($row) {
                    $newDate = date("d-m-Y", strtotime($row->created_at));
                    return $newDate;
                })
                ->editColumn('create_by', function ($row) {
                    $fullName = $row->user->first_name.' '.$row->user->last_name;
                    return $fullName;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="dropdown float-end"><button type="button" class="btn btn-outline-primary btn-sm template" data-id="'.$row->id.'">Use</button><a href="#" class="dropdown-toggle btn btn-outline-primary btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-angle-down"></i></a><div class="dropdown-menu dropdown-menu-end"><a href="'.url('/').'/admin/quotations/template/edit/'.$row->id.'" class="dropdown-item">Edit</a><a href="javascript:void(0);" class="dropdown-item">Clone</a><a href="javascript:void(0);" class="dropdown-item">Delete</a></div></div>';
                    return $actionBtn;
                })

                ->rawColumns(['action','create_by'])
                ->make(true);
        }

        $clients = Client::get();
        return view('backend/main-quotations/quotations', [
            'clients' => $clients
        ]);
    }
    public function QuotationsTemplateAdd(){

        $interestedServices = InterestedService::with('workflow', 'partner', 'product', 'client', 'branch')->get();
        $workflowCategories = WorkflowCategory::get();
        $offices = Office::get();
        $currencies = Currency::get();

        return view('backend.main-quotations.create-template', [
            'offices' => $offices,
            'currencies' => $currencies,
            'interestedServices' => $interestedServices,
            'workflowCategories' => $workflowCategories,
        ]);

    }
    public function QuotationsTemplateSave(Request $request){
        // dd($_POST);

        if ($request->grand_total == 0) {
            return redirect()->back()->with('danger', "Total can't zero");
            die();
        }

        // $quotation = new QuotationsTemplate();
        $quotation = new Quotation();
        $quotation->template_name = $request->template_name;
        $quotation->product_item = count($request->product_id);
        $quotation->total_fee = $request->grand_total;
        $quotation->due_date = date('Y-m-d');
        $quotation->office = $request->office;
        $quotation->quote_currency = $request->quote_currency;
        $quotation->status = 0;
        $quotation->created_user = 1;
        $quotation->save();
        $qid = $quotation->id;

        for ($i = 0; $i < count($request->workflow_id); $i++) {
            $qitem = new Quotationitem();
            $qitem->quotation_id = $qid;
            $qitem->workflow_id = $request->workflow_id[$i];
            $qitem->partner_id = $request->partner_id[$i];
            $qitem->product_id = $request->product_id[$i];
            $qitem->branch_id = $request->branch_id[$i];
            $qitem->description = $request->description[$i];
            $qitem->service_fee = $request->service_fee[$i];
            $qitem->discount = $request->discount[$i];
            $qitem->net_fee = $request->net_fee[$i];
            $qitem->egx_rte = $request->egx_rte[$i];
            $qitem->total_ammount = $request->total_ammount[$i];
            $qitem->save();
        }
        return redirect('admin/quotations/template/list/')->with('success', 'Quotation template has been added successfully !!');
    }
    public function QuotationsTemplateCreate(Request $request){
        // dd($_POST);
        // $request->validate([
        //     'client_id' => 'required'
        // ]);
        
        // $quotation = new Quotation();
        // $quotation->client_id = $request->client_id;
        // $quotation->save();

        return response()->json([
            "success" => "Successfully record added",
            "client_id" => $request->client_id,
            "template_id" => $request->template_id,
        ]);
    }
    public function QuotationsTemplateUse($templateId, $clientId){
        // dd($templateId);
        // $quotation = QuotationsTemplate::with('quotation_product')->find($templateId);
        $quotation = Quotation::with('quotation_product')->find($templateId);
        // dd($quotation);

        if ($quotation == null) {
            return redirect()->back()->with('success', "Quotation not found");
            die();
        }
        $client = Client::find($clientId);
        $oldProduct = $quotation->quotation_product;
        $newproduct = [];
        foreach ($oldProduct as $product) {
            $product->newhtml = $this->crateUpdathtml($product->workflow_id, $product->partner_id, $product->product_id, $product->branch_id, $product->id);
            $newproduct[] = $product;
        }
        $quotation->quotation_product = $newproduct;
        $interestedServices = InterestedService::where('client_id', $templateId)->with('workflow', 'partner', 'product', 'client', 'branch')->get();
        $workflowCategories = WorkflowCategory::get();

        // dd($quotation);

        return view('backend/main-quotations/use-template', [
            'client' => $client,
            'quotation' => $quotation,
            'workflowCategories' => $workflowCategories,
            'interestedServices' => $interestedServices,
        ]);
    }
    public function QuotationsTemplateSubmit(Request $request){
        // dd($_POST);
        if ($request->grand_total == 0) {
            return redirect()->back()->with('danger', "Total can't zero");
            die();
        }

        // $quotation = new QuotationsTemplate();
        $quotation = new Quotation();
        $quotation->product_item = count($request->product_id);
        $quotation->total_fee = $request->grand_total;
        $quotation->due_date = $request->due_date;
        $quotation->quote_currency = $request->quote_currency;
        $quotation->status = 1;
        $quotation->client_id = $request->client_id;
        $quotation->created_user = Session::get('user_id');
        $quotation->save();
        $qid = $quotation->id;

        for ($i = 0; $i < count($request->workflow_id); $i++) {
            $qitem = new Quotationitem();
            $qitem->quotation_id = $qid;
            $qitem->workflow_id = $request->workflow_id[$i];
            $qitem->partner_id = $request->partner_id[$i];
            $qitem->product_id = $request->product_id[$i];
            $qitem->branch_id = $request->branch_id[$i];
            $qitem->description = $request->description[$i];
            $qitem->service_fee = $request->service_fee[$i];
            $qitem->discount = $request->discount[$i];
            $qitem->net_fee = $request->net_fee[$i];
            $qitem->egx_rte = $request->egx_rte[$i];
            $qitem->total_ammount = $request->total_ammount[$i];
            $qitem->save();
        }
        return redirect('admin/quotations/active/list/')->with('success', 'Quotation has been added successfully !!');
    }
    public function QuotationsTemplateEdit($id){
        $quotation = Quotation::with('quotation_product')->find($id);
        // dd($quotation);

        if ($quotation == null) {
            return redirect()->back()->with('success', "Quotation not found");
            die();
        }
        $client = Client::find($quotation->client_id);
        $oldProduct = $quotation->quotation_product;
        $newproduct = [];
        foreach ($oldProduct as $product) {
            $product->newhtml = $this->crateUpdathtml($product->workflow_id, $product->partner_id, $product->product_id, $product->branch_id, $product->id);
            $newproduct[] = $product;
        }
        $quotation->quotation_product = $newproduct;
        $interestedServices = InterestedService::where('client_id', $id)->with('workflow', 'partner', 'product', 'client', 'branch')->get();
        
        $offices = Office::get();
        $currencies = Currency::get();
        $workflowCategories = WorkflowCategory::get();

        // dd($quotation);

        return view('backend/main-quotations/edit-template', [
            'client' => $client,
            'offices' => $offices,
            'quotation' => $quotation,
            'currencies' => $currencies,
            'workflowCategories' => $workflowCategories,
            'interestedServices' => $interestedServices,
        ]);
    }
    public function QuotationsTemplateUpdate(Request $request){
        // dd($_POST);

        if ($request->grand_total == 0) {
            return redirect()->back()->with('danger', "Total can't zero");
            die();
        }
        $quotation = Quotation::find($request->id);
        $quotation->template_name = $request->template_name;
        $quotation->product_item = count($request->product_id);
        $quotation->total_fee = $request->grand_total;
        $quotation->due_date = date('Y-m-d');
        $quotation->office = $request->office;
        $quotation->quote_currency = $request->quote_currency;
        $quotation->created_user = 1;
        $quotation->status = 0;
        $quotation->save();

        $allItemIds = Quotationitem::where('quotation_id', $request->id)->whereNotIn('id', $request->quotation_id)->delete();
        $qid = $request->id;
        for ($i = 0; $i < count($request->workflow_id); $i++) {
            //echo $id;die();
            if (isset($request->quotation_id[$i])) {
                $qitem = Quotationitem::where('id', $request->quotation_id[$i])->first();
                $qitem->quotation_id = $qid;
                $qitem->workflow_id = $request->workflow_id[$i];
                $qitem->partner_id = $request->partner_id[$i];
                $qitem->product_id = $request->product_id[$i];
                $qitem->branch_id = $request->branch_id[$i];
                $qitem->description = $request->description[$i];
                $qitem->service_fee = $request->service_fee[$i];
                $qitem->discount = $request->discount[$i];
                $qitem->net_fee = $request->net_fee[$i];
                $qitem->egx_rte = $request->egx_rte[$i];
                $qitem->total_ammount = $request->total_ammount[$i];
                $qitem->save();
            } else {
                $qitem = new Quotationitem();
                $qitem->quotation_id = $qid;
                $qitem->workflow_id = $request->workflow_id[$i];
                $qitem->partner_id = $request->partner_id[$i];
                $qitem->product_id = $request->product_id[$i];
                $qitem->branch_id = $request->branch_id[$i];
                $qitem->description = $request->description[$i];
                $qitem->service_fee = $request->service_fee[$i];
                $qitem->discount = $request->discount[$i];
                $qitem->net_fee = $request->net_fee[$i];
                $qitem->egx_rte = $request->egx_rte[$i];
                $qitem->total_ammount = $request->total_ammount[$i];
                $qitem->save();
            }
        }
        return redirect('admin/quotations/template/edit/'. $qid)->with('success', 'Quotation has been update successfully !!');
    }
    public function QuotationsTemplateDelete($id){
        // dd($id);
        Quotation::find($id)->delete();
        Quotationitem::where('quotation_id',$id)->delete();
        return redirect('admin/quotations/active/list')->with('success', 'Successfully quotations deleted');
    }


    //active-quotation
    public function QuotationsActiveList(Request $request){
        // echo 11; die();

        if ($request->ajax()) {
            $data = Quotation::with('client','user')->where('status', 1)->get();
            // dd($data);
            return DataTables::of($data)
                ->editColumn('created_at', function ($row) {
                    $newDate = date("d-m-Y", strtotime($row->created_at));
                    return $newDate;
                })
                ->editColumn('client_name', function ($row) {
                    $fullName = $row->client->first_name.' '.$row->client->last_name;
                    return $fullName;
                })
                ->editColumn('user_name', function ($row) {
                    $fullName = $row->user->first_name.' '.$row->user->last_name;
                    return $fullName;
                })
                ->editColumn('status', function ($row) {
                    $status = ($row->quotation_status == 1 ? '<button type="button" class="btn btn-light">Draft</button>' : '<button type="button" class="btn btn-danger">Decline</button>');
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $decline = '';
                    if($row->quotation_status != 2){
                        $decline = '<a href="'.url('/').'/admin/quotations/decline/'.$row->id.'" class="dropdown-item decline">Decline</a>';
                    }else{
                        $decline = '';
                    }

                    $actionBtn = '<div class="dropdown float-end"><a href="'.url('/').'/admin/quotations/preview/'.$row->id.'" target="_blank" class="btn btn-outline-primary btn-sm preview" data-id="'.$row->id.'">Preview</a><a href="#" class="dropdown-toggle btn btn-outline-primary btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-angle-down"></i></a><div class="dropdown-menu dropdown-menu-end"><a href="'.url('/').'/admin/quotations/active/edit/'.$row->id.'" class="dropdown-item">Edit</a><a href="javascript:void(0);" class="dropdown-item">Send Email</a>'.$decline.'<a href="'.url('/').'/admin/quotations/archived/'.$row->id.'" class="dropdown-item archive">Archive</a></div></div>';

                    return $actionBtn;
                })

                ->rawColumns(['action','client_name','user_name','status'])
                ->make(true);
        }

        $clients = Client::get();
        return view('backend/main-quotations/active', [
            'clients' => $clients
        ]);

    }
    public function QuotationsActiveCreate(Request $request){
        // $request->validate([
        //     'client_id' => 'required'
        // ]);
        
        $quotation = new Quotation();
        $quotation->client_id = $request->client_id;
        $quotation->save();

        return response()->json([
            "success" => "Successfully record added",
            "quotation_id" => $quotation->id,
        ]);
    }
    private function crateUpdathtml($workflow_id, $partner_id, $product_id, $branch_id, $appendDiv)
    {

        $workflow = WorkflowCategory::where('id', $workflow_id)->first();
        $partner = Partner::where('id', $partner_id)->first();
        $product = Product::where('id', $product_id)->first();
        $branch =  PartnerBranch::where('id', $branch_id)->first();
        $html = '<div class="first_div" id="first_div' . $appendDiv . '"><input type="hidden" name="quotation_id[]" value="' . $appendDiv . '" > <h5>' . $product->name . '</h5> <p>' . $partner->name . '</p><p>(' . $workflow->service_workflow . ')</p><input type="hidden" name="workflow_id[]" value="' . $workflow_id . '"><input type="hidden" name="partner_id[]" value="' . $partner_id . '"><input type="hidden" name="product_id[]" value="' . $product_id . '"><input type="hidden" name="branch_id[]" value="' . $branch_id . '"><a href="javascript:void(0)" class="editDiv" attr="' . $appendDiv . '" workflow_id="' . $workflow_id . '" partner_id="' . $partner_id . '"  product_id="' . $product_id . '" branch_id="' . $branch_id . '"><i class="mdi mdi-square-edit-outline"></i></a></div>';

        return $html;
    }
    public function QuotationsActiveEdit($id){
        $quotation = Quotation::with('quotation_product')->find($id);

        if ($quotation == null) {
            return redirect()->back()->with('success', "Quotation not found");
            die();
        }
        $client = Client::find($quotation->client_id);
        $oldProduct = $quotation->quotation_product;
        $newproduct = [];
        foreach ($oldProduct as $product) {
            $product->newhtml = $this->crateUpdathtml($product->workflow_id, $product->partner_id, $product->product_id, $product->branch_id, $product->id);
            $newproduct[] = $product;
        }
        $quotation->quotation_product = $newproduct;
        $interestedServices = InterestedService::where('client_id', $id)->with('workflow', 'partner', 'product', 'client', 'branch')->get();
        $workflowCategories = WorkflowCategory::get();

        // dd($quotation);

        return view('backend/main-quotations/create-quotations', [
            'client' => $client,
            'quotation' => $quotation,
            'workflowCategories' => $workflowCategories,
            'interestedServices' => $interestedServices,
        ]);
    }
    public function QuotationsActiveUpdate(Request $request){
        // echo 11; die();
        // dd($_POST);

        $request->validate([
            'due_date' => 'required',
            'quote_currency' => 'required',
        ]);


        if ($request->grand_total == 0) {
            return redirect()->back()->with('success', "Total can't zero");
            die();
        }
        $quotation = Quotation::find($request->id);
        // $quotation->template_name = $request->template_name;
        $quotation->product_item = count($request->product_id);
        $quotation->total_fee = $request->grand_total;
        $quotation->due_date = $request->due_date;
        $quotation->quote_currency = $request->quote_currency;
        $quotation->client_id = $request->client_id;
        $quotation->created_user = 1;
        $quotation->status = 1;
        $quotation->save();

        for ($i = 0; $i < count($request->workflow_id); $i++) {
            //echo $id;die();
            if (isset($request->quotation_id[$i])) {
                // dd($request->quotation_id);
                // dd($_POST);

                $allItemIds = Quotationitem::where('quotation_id', $request->quotation_id)->whereNotIn('id', $request->quotation_id)->delete();

                $qitem = Quotationitem::find($request->quotation_id[$i]);
                $qitem->quotation_id = $request->id;
                $qitem->workflow_id = $request->workflow_id[$i];
                $qitem->partner_id = $request->partner_id[$i];
                $qitem->product_id = $request->product_id[$i];
                $qitem->branch_id = $request->branch_id[$i];
                $qitem->description = $request->description[$i];
                $qitem->service_fee = $request->service_fee[$i];
                $qitem->discount = $request->discount[$i];
                $qitem->net_fee = $request->net_fee[$i];
                $qitem->egx_rte = $request->egx_rte[$i];
                $qitem->total_ammount = $request->total_ammount[$i];
                $qitem->save();
            } else {

                $qitem = new Quotationitem();
                $qitem->quotation_id = $request->id;
                $qitem->workflow_id = $request->workflow_id[$i];
                $qitem->partner_id = $request->partner_id[$i];
                $qitem->product_id = $request->product_id[$i];
                $qitem->branch_id = $request->branch_id[$i];
                $qitem->description = $request->description[$i];
                $qitem->service_fee = $request->service_fee[$i];
                $qitem->discount = $request->discount[$i];
                $qitem->net_fee = $request->net_fee[$i];
                $qitem->egx_rte = $request->egx_rte[$i];
                $qitem->total_ammount = $request->total_ammount[$i];
                $qitem->save();
            }
        }
        return redirect('admin/quotations/active/list/')->with('success', 'Quotation has been update successfully !!');
    }
    public function QuotationPreview($id){
        $quotation = Quotation::with('quotation_product')->find($id);
        // dd($quotation);
        
        $newproduct = [];
        foreach ($quotation->quotation_product as $product) {
            $product->workflow = WorkflowCategory::find($product->workflow_id);
            $product->partner = Partner::find($product->partner_id);
            $product->product = Product::find($product->product_id);
            $product->branch = PartnerBranch::find($product->branch_id);
            $newproduct[] = $product;
        }
        $quotation->quotation_product = $newproduct;

        $client = Client::find($quotation->client_id);
        $user = CompanyProfile::where('user_id',$quotation->created_user)->first();
        // dd($user);

        $pdf = PDF::loadView('backend/main-quotations/quotation-preview', [
            'user' => $user,
            'client' => $client,
            'quotation' => $quotation
        ]);

        return $pdf->stream('invoice.pdf');
    }


    //archived-quotation
    public function QuotationsArchivedList(Request $request){
        if ($request->ajax()) {
            // dd(11);
            $data = Quotation::with('client')->where('status', 2)->get();
            // dd($data);
            return DataTables::of($data)
                ->editColumn('created_at', function ($row) {
                    $newDate = date("d-m-Y", strtotime($row->created_at));
                    return $newDate;
                })
                ->editColumn('client_name', function ($row) {
                    $fullName = $row->client->first_name.' '.$row->client->last_name;
                    return $fullName;
                })
                ->addColumn('action', function ($row) {

                    $actionBtn = '<div class="dropdown float-end"><a href="'.url('/').'/admin/quotations/archived/preview/'.$row->id.'" target="_blank" class="btn btn-outline-primary btn-sm preview" data-id="'.$row->id.'">Preview</a><a href="#" class="dropdown-toggle btn btn-outline-primary btn-sm" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-angle-down"></i></a><div class="dropdown-menu dropdown-menu-end"><a href="'.url('/').'/admin/quotations/archive/delete/' . $row->id . '" class="dropdown-item delete">Delete</a></div></div>';

                    return $actionBtn;
                })

                ->rawColumns(['action','client_name','user_name','status'])
                ->make(true);
        }

        $clients = Client::get();

        return view('backend/main-quotations/archived', [
            'clients' => $clients
        ]);
    }
    public function QuotationArchivedPreview($id){
        $quotation = Quotation::where('status', 2)->with('quotation_product')->find($id);
        
        $newproduct = [];
        foreach ($quotation->quotation_product as $product) {
            $product->workflow = WorkflowCategory::find($product->workflow_id);
            $product->partner = Partner::find($product->partner_id);
            $product->product = Product::find($product->product_id);
            $product->branch = PartnerBranch::find($product->branch_id);
            $newproduct[] = $product;
        }
        $quotation->quotation_product = $newproduct;

        $client = Client::find($quotation->client_id);
        $user = CompanyProfile::where('user_id',$quotation->created_user)->first();
        // dd($user);

        $pdf = PDF::loadView('backend/main-quotations/quotation-preview', [
            'user' => $user,
            'client' => $client,
            'quotation' => $quotation
        ]);

        return $pdf->stream('invoice.pdf');
    }
    public function QuotationsArchived($id){
        // echo 11; die();
        $quotation = Quotation::find($id);
        $quotation->status = 2;
        $quotation->save();

        return redirect('admin/quotations/active/list')->with('success', 'Successfully quotations archived');
    }
    public function QuotationsDecline($id){
        $quotation = Quotation::find($id);
        $quotation->quotation_status = 2;
        $quotation->save();

        return redirect('admin/quotations/active/list')->with('success', 'Successfully quotations decline');
    }
    public function QuotationsArchiveDelete($id){
        // dd($id);
        Quotation::find($id)->delete();
        Quotationitem::where('quotation_id',$id)->delete();
        return redirect('admin/quotations/archived/list')->with('success', 'Successfully archived quotations deleted');
    }
}
