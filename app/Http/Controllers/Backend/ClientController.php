<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\ProductDocumentation;
use App\Models\PriorityCategory;
use App\Models\TaskCategory;
use App\Models\PartnerBranch;
use App\Models\PartnerAppointment;
use App\Models\WorkflowCategory;
use App\Models\InterestedService;
use App\Models\DegreeLevel;
use App\Models\EnglishtestScore;
use App\Models\OthertestScore;
use App\Models\ClientEducation;
use App\Models\Subject;
use App\Models\SubjectArea;
use App\Models\Application;
use App\Models\PartnerNote;
use App\Models\Client;
use App\Models\ClientTag;
use Illuminate\Http\Request;
use App\Models\Office;
use App\Models\Partner;
use App\Models\Product;
use App\Models\SourceList;
use App\Models\TimeZone;
use App\Models\User;
use App\Models\Tag;
use App\Models\Task;
use App\Models\Quotation;
use App\Models\Quotationitem;
use App\Models\Applicationtypecategorie;
use App\Models\Applicationoption;
use App\Models\Country;
use App\Models\Currency;
use Image;
use File;
use Mail;
use DataTables;

class ClientController extends Controller
{
    protected function saveClientInfoValidate($request)
    {
        $request->validate([
            'client_image' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'assignee_id' => 'required',
        ]);
    }
    protected function updateClientInfoValidate($request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'assignee_id' => 'required',
        ]);
    }
    protected function assignee_name_and_office($clients){
        $array = [];
        foreach($clients as $key => $client){
            $user = User::find($client->assignee_id);
            $array = Office::find($user->office_id);
            $clients[$key]->office = $array;
        }
    }
    public function manageProspects()
    {
        $clients = Client::where('client_status',0)->with('product_info','user_info','tag_info','flowers','pass_country','country')->get();
        $this->assignee_name_and_office($clients);
        $offices = Office::get();

        return view('backend.client.prospect', [
            'offices' => $offices,
            'clients' => $clients
        ]);
    }

    public function manageClient()
    {
        $clients = Client::where('client_status',1)->with('product_info','user_info','tag_info','flowers')->get();
       $this->assignee_name_and_office($clients);
        $offices = Office::get();
        return view('backend.client.client', [
            'offices' => $offices,
            'clients' => $clients
        ]);
    }
    public function manageArchived()
    {
        $clients = Client::where('client_status',2)->with('product_info','user_info','tag_info','flowers')->get();
        $this->assignee_name_and_office($clients);
        $offices = Office::get();
        return view('backend.client.archived', [
            'offices' => $offices,
            'clients' => $clients
        ]);
    }
    public function clientProfileActivitie($id)
    {
        $client = Client::where('id',$id)->with('product_info','user_info','tag_info')->first();

        return view('/backend/client/activitie', ['client'=>$client]);
    }
    public function addClient()
    {
        $users = User::with('office')->get();
        $countries = Country::get();
        $currencies = Currency::get();
        // dd($currencies);

        $clientTags = ClientTag::get();
        $sourceLists = SourceList::get();
        $offices = Office::get();
        $applications = DB::table('partners')
            ->join('products', 'partners.product_id', '=', 'products.id')
            ->join('partner_branches', 'products.branch_id', '=', 'partner_branches.id')
            ->select('partners.id', 'products.name as product_name', 'partners.name as partner_name', 'partner_branches.name as branch_name')
            ->get();
            
        return view('backend.client.addclient', [
            'users' => $users,
            'currencies' => $currencies,
            'countries' => $countries,
            'clientTags' => $clientTags,
            'sourceLists' => $sourceLists,
            'applications' => $applications,
            'offices' => $offices
        ]);
    }
    protected function clientSectionImage($request)
    {
        $clientImage = $request->file('client_image');

        $image = Image::make($clientImage);
        $fileType = $clientImage->getClientOriginalExtension();
        $imageName = 'client_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/clients/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);

        $thumbnail = $directory . "thumbnail/" . $imageName;
        $image->resize(null, 200, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($thumbnail);

        return $imageUrl;
    }
    public function saveClient(Request $request)
    {
        $this->saveClientInfoValidate($request);
        $imageUrl = $this->clientSectionImage($request);

        // dd($_POST);

        $client = new Client();
        $client->client_image = $imageUrl;
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->client_dob = $request->client_dob;
        $client->client_id = $request->client_id;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->street = $request->street;
        $client->city = $request->city;
        $client->state = $request->state;
        $client->post_code = $request->post_code;
        $client->country_id = $request->country_id;
        $client->preferred_intake = $request->preferred_intake;
        $client->country_passport = $request->country_passport;
        $client->passport_number = $request->passport_number;
        $client->visa_type = $request->visa_type;
        $client->visa_expiry = $request->visa_expiry;
        $client->assignee_id = $request->assignee_id;
        $client->follower_id = $request->follower_id;
        $client->source_id = $request->source_id;
        $client->tag_id = $request->tag_id;
        $client->save();
        
        if(isset($request->application)){
            $clientId = $client->id;

            $application = new Application();
            $application->workflow_id = $request->workflow_id;
            $application->partner_id = $request->partner_id;
            $application->product_id = $request->product_id;
            $application->client_id = $clientId;
            $application->stage_id = $request->stage_id;
            $application->save();

            $applications = Application::where('client_id', $clientId)->get();

            $client = Client::find($clientId);
            $client->application = count($applications);
            $client->client_status = 1;
            $client->save();
        }

        if(isset($request->application)){
            return redirect('admin/client/clients')->with('success', 'Clients has been added successfully !!');
        }else{
            return redirect('admin/client/prospects')->with('success', 'Prospect has been added successfully !!');
        }
        
    }
    public function editClient($id)
    {
        $client = Client::find($id);
        $users = User::with('office')->get();
        $tags = Tag::get();
        $sourceLists = SourceList::get();

        $countries = Country::get();
        return view('backend.client.client-edit', [
            'tags' => $tags,
            'users' => $users,
            'client' => $client,
            'countries' => $countries,
            'sourceLists' => $sourceLists,
        ]);
    }
    protected function clientBasicInfo($request, $client, $imageUrl = null)
    {
        // dd($_POST);

        if ($imageUrl) {
            $client->client_image = $imageUrl;
        }

        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->client_dob = $request->client_dob;
        $client->client_id = $request->client_id;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->street = $request->street;
        $client->city = $request->city;
        $client->state = $request->state;
        $client->post_code = $request->post_code;
        $client->country_id = $request->country_id;
        $client->preferred_intake = $request->preferred_intake;
        $client->country_passport = $request->country_passport;
        $client->passport_number = $request->passport_number;
        $client->visa_type = $request->visa_type;
        $client->visa_expiry = $request->visa_expiry;
        $client->application = $request->application;
        $client->assignee_id = $request->assignee_id;
        $client->follower_id = $request->follower_id;
        $client->source_id = $request->source_id;
        $client->tag_id = $request->tag_id;
        $client->save();
    }
    public function updateClient(Request $request)
    {
        // dd($_POST);

        // echo "<pre>"; print_r($_POST); die();

        $this->updateClientInfoValidate($request);
        $clientImage = $request->file('client_image');
        $client = Client::find($request->id);

        if ($clientImage) {
            if (File::exists($client->client_image)) {
                unlink($client->client_image);
            }
            $imageUrl = $this->clientSectionImage($request);
            $this->clientBasicInfo($request, $client, $imageUrl);
        } else {
            $this->clientBasicInfo($request, $client);
        }

        return redirect('admin/client/clients')->with('success', 'Clients has been updated successfully !!');
    }
    public function archiveClient($id)
    {
        $client = Client::find($id);
        $client->client_status = 2;
        $client->save();
        return redirect('admin/client/archived')->with('success', 'Clients has been Successfully Archived !!');
    }
    public function restoreClient($id)
    {
        $client = Client::find($id);
        $client->client_status = 1;
        $client->save();
        return redirect('admin/client/clients')->with('success', 'Clients has been Successfully Restore !!');
    }

    /*===============================================================================
                            Client Profile Start
    =================================================================================*/
    
    public function clientProfileActivities($id)
    {

        $client = Client::with('country','pass_country','user_info')->find($id);
        // dd($client);

        return view('backend.client.activitie', [
            'client' => $client
        ]);
    }
    public function clientProfileApplications($id)
    {
        $client = Client::find($id);
        $applications = Application::where('client_id',$id)
                        ->with('workflow','partner','product','client','branch')
                        ->get();
        // dd($applications);

        $partners = Partner::get();
        $products = Product::get();
        $workflowCategories = WorkflowCategory::get();

        return view('backend.client.application', [
            'client' => $client,
            'products' => $products,
            'partners' => $partners,
            'applications' => $applications,
            'workflowCategories' => $workflowCategories,
        ]);
    }
    public function clientProfileApplicationDetails($id, $client_id)
    {
        $client = Client::find($client_id);
        $applications = Application::find($id);
        $taskCategories = TaskCategory::get();
        $list = Applicationtypecategorie::get()->toArray();
        $priorityCategories = PriorityCategory::get();
        $tasks = Task::where('client_id', $id)->get();
        $users = User::get();
        for($i=0; $i < count($list); $i++){
            $list[$i]['notes'] = Applicationoption::where(['client_id'=>$client_id,'application_id'=>$id,'category_id'=>$list[$i]['id'],'type'=>'note'])->get()->toArray();
            $list[$i]['documentations'] = Applicationoption::where(['client_id'=>$client_id,'application_id'=>$id,'category_id'=>$list[$i]['id'],'type'=>'documentation'])->get()->toArray();
        }
        
        
        return view('backend.client.applicationdetails', [
            'client' => $client,
            'lists' =>$list,
            'applications' => $applications,
            'taskCategories' =>$taskCategories,
            'priorityCategories'=>$priorityCategories,
            'tasks'=>$tasks,
            'users'=>$users,
        ]);
        
    }
    public function serviceWorkflow(Request $request)
    {
        $partners = Partner::where('workflow_id', $request->workflow_id)->get();
        return json_encode($partners);
    }
    public function productInfo(Request $request)
    {
        $partner = Partner::where('id', $request->partner_id)->get()->first();
        $products = Product::where('id', $partner->product_id)->get();
        return json_encode($products);
    }
    public function partnerBranch(Request $request)
    {
        $product = Product::where('id', $request->product_id)->get()->first();
        $branches = PartnerBranch::where('id', $product->branch_id)->get();
        return json_encode($branches);
    }
    protected function saveClientApplicationInfoValidate($request)
    {
        $request->validate([
            'workflow_id' => 'required',
            'partner_id' => 'required',
            'product_id' => 'required|unique:applications,product_id',
        ]);
    }
    public function saveClientApplication(Request $request)
    {
        // echo 11; die();
        $this->saveClientApplicationInfoValidate($request);
        // echo "<pre>"; print_r($_POST); die();

        $clientId = $request->client_id;

        $application = new Application();
        $application->workflow_id = $request->workflow_id;
        $application->partner_id = $request->partner_id;
        $application->product_id = $request->product_id;
        $application->client_id = $clientId;
        $application->save();

        $applications = Application::where('client_id', $clientId)->get();

        $client = Client::find($clientId);
        $client->application = count($applications);
        $client->client_status = 1;
        $client->save();

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function clientProfileService($id)
    {
        $client = Client::find($id);
        $interestedServices = InterestedService::where('client_id', $id)->with('workflow','partner','product','client','branch')->get();
        // dd($interestedServices);

        $workflowCategories = WorkflowCategory::get();
        return view('backend.client.interestedservice', [
            'client' => $client,
            'interestedServices' => $interestedServices,
            'workflowCategories' => $workflowCategories,
        ]);
    }
    public function clientServiceCreate(Request $request)
    {
        $request->validate([
          'workflow_id'    => 'required',
        ]);
        // echo "<pre>"; print_r($_POST); die();
        $interestedService = new InterestedService();
        $interestedService->client_id = $request->client_id;
        $interestedService->workflow_id = $request->workflow_id;    
        $interestedService->partner_id = $request->partner_id;    
        $interestedService->product_id = $request->product_id;    
        $interestedService->branch_id = $request->branch_id;    
        $interestedService->start_date = $request->start_date;    
        $interestedService->end_date = $request->end_date;    
        $interestedService->save();
        return response()->json(['success'=>'Record is successfully added']);
    }

    public function clientServiceEdit(Request $request)
    { 
        $workflowes = WorkflowCategory::get();
        $service = InterestedService::where('client_id', $request->client_id)->find($request->service_id);

        $partners = Partner::where('id', $service->partner_id)->get();
        $products = Product::where('id', $service->product_id)->get();
        $branches = PartnerBranch::where('id', $service->branch_id)->get();

        // echo "<pre>"; print_r($_POST); die(); 
        $result = [
            'service' => $service,
            'partners' => $partners,
            'products' => $products,
            'branches' => $branches,
            'workflowes' => $workflowes,
        ];
        return json_encode($result);
    }
    public function clientServiceView(Request $request)
    { 
        $service = InterestedService::where('client_id', $request->client_id)->with('workflow','partner','product','client','branch')->find($request->service_id);
        return json_encode($service);
    }
    public function clientServiceUpdate(Request $request)
    {
        $request->validate([
          'workflow_id'    => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $interestedService = InterestedService::find($request->service_id);
        $interestedService->client_id = $request->client_id;
        $interestedService->workflow_id = $request->workflow_id;    
        $interestedService->partner_id = $request->partner_id;    
        $interestedService->product_id = $request->product_id;    
        $interestedService->branch_id = $request->branch_id;    
        $interestedService->start_date = $request->start_date;    
        $interestedService->end_date = $request->end_date;    
        $interestedService->save();

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function clientServiceDelete($id, $clientId)
    {
        InterestedService::where('id', $id)->delete();
        return redirect('admin/client/profile/services/'.$clientId)->with('success', 'Services has been deleted successfully !!');
    }
    public function clientProfileDocuments($id)
    {
        $client = Client::find($id);
        $docs = ProductDocumentation::where('client_id',$id)->with('alluser')->get();
        // dd($docs);
        return view('backend.client.document', [
            'client' => $client,
            'docs' => $docs,
        ]);
    }
    public function clientDocumentCreate(Request $request)
    {
        // echo "<pre>"; print_r($image->filesize()); die();
        $clientImage = $request->file('product_doc');

        if ($clientImage) {
            $image = Image::make($clientImage);

            $fileType = $clientImage->getClientOriginalExtension();
            $imageName = 'document_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
            $directory = 'assets/upload/product_doc/';
            $imageUrl = $directory . $imageName;
            $image->save($imageUrl);

            $prodDoc = new ProductDocumentation();
            $prodDoc->client_id = $request->id;
            $prodDoc->file_name = $imageName;
            $prodDoc->file_size = $image->filesize();
            $prodDoc->author = session()->get('user_id');
            $prodDoc->save();

            return redirect('admin/client/profile/documents/' . $request->id)->with('success', 'Doucmentation has been added successfully !!');
        } else {
            return redirect('admin/client/profile/documents/' . $request->id)->with('danger', 'Error Something !!');
        }
    }
    public function clientDocumentDelete($id, $partnerId)
    {
        $prod = ProductDocumentation::where('id', $id)->first();
        $myLink = base_path() . "/assets/upload/product_doc/" . $prod->file_name;
        if (file_exists($myLink)) {
            unlink($myLink);
        }
        ProductDocumentation::where('id', $id)->delete();
        return redirect('admin/client/profile/documents/' . $partnerId)->with('success', 'Doucmentation has been delete successfully !!');
    }
    public function clientProfileAppointments($id)
    {
        $client = Client::find($id);
        $timezones = TimeZone::get();
        $appointments = PartnerAppointment::with('user')->where('client_id', $id)->get();
        $user = User::where('id', Session::get('user_id'))->get()->first();
        return view('backend.client.appointment', [
            'user' => $user,
            'client' => $client,
            'timezones' => $timezones,
            'appointments' => $appointments,
        ]);
    }
    public function clientAppointmentCreate(Request $request)
    {
        $request->validate([
          'client_name'    => 'required',
          'timezone_id'   => 'required',
          'date'   => 'required',
          'time'   => 'required',
          'title'   => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $partnerAppointment = new PartnerAppointment();
        $partnerAppointment->client_id = $request->client_id;
        $partnerAppointment->related_to = 1;
        $partnerAppointment->added_by = $request->added_by;
        $partnerAppointment->timezone_id = $request->timezone_id;
        $partnerAppointment->date = $request->date;
        $partnerAppointment->time = $request->time;
        $partnerAppointment->title = $request->title;
        $partnerAppointment->description = $request->description;
        $partnerAppointment->invite = $request->invite;     
        $partnerAppointment->save();
        return response()->json(['success'=>'Record is successfully added']);
    }
    public function clientAppointmentEdit(Request $request){
        $appointment = PartnerAppointment::where('client_id', $request->client_id)->find($request->appointment_id);
        $user = User::where('id', Session::get('user_id'))->get()->first();
        $timezones = TimeZone::get();
        $client = Client::find($request->client_id);

        $result = [
            'user' => $user,
            'client' => $client,
            'appointment' => $appointment,
            'timezones' => $timezones,
        ];

        echo json_encode($result);
    }
    public function clientAppointmentUpdate(Request $request)
    {
        
        $request->validate([
          'client_name'    => 'required',
          'timezone_id'   => 'required',
          'date'   => 'required',
          'time'   => 'required',
          'title'   => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();

        $partnerAppointment = PartnerAppointment::find($request->appointment_id);
        $partnerAppointment->related_to = 1;
        $partnerAppointment->added_by = $request->added_by;
        $partnerAppointment->client_id = $request->client_id;
        $partnerAppointment->timezone_id = $request->timezone_id;
        $partnerAppointment->date = $request->date;
        $partnerAppointment->time = $request->time;
        $partnerAppointment->title = $request->title;
        $partnerAppointment->description = $request->description;
        $partnerAppointment->invite = $request->invite;     
        $partnerAppointment->save();
        return response()->json(['success'=>'Record is successfully added']);
    }
    public function clientAppointmentDelete($id, $partnerId)
    {
        PartnerAppointment::where('id', $id)->delete();
        return redirect('admin/client/profile/appointments/'.$partnerId)->with('success', 'Appointment has been deleted successfully !!');
    }
    public function clientProfileNotes($id)
    {
        $client = Client::find($id);
        $notes = PartnerNote::where('client_id', $id)->get();
        return view('backend.client.note', [
            'notes' => $notes,
            'client' => $client
        ]);
    }
    public function clientNoteCreate(Request $request)
    {
        $request->validate([
          'note_title'    => 'required',
          'note_description'   => 'required',
        ]);
        // echo "<pre>"; print_r($_POST); die();

        $partnerNote = new PartnerNote();
        $partnerNote->client_id = $request->client_id;
        $partnerNote->note_title = $request->note_title;
        $partnerNote->note_description = $request->note_description;        
        $partnerNote->save();
        return response()->json(['success'=>'Record is successfully added']);
    }
    public function clientNoteEdit(Request $request)
    {
        $note = PartnerNote::where('client_id', $request->client_id)->find($request->note_id);
        echo json_encode($note);
    }
    public function clientNoteUpdate(Request $request)
    {
        $request->validate([
          'note_title'    => 'required',
          'note_description'   => 'required',
        ]);
        
        $partnerNote = PartnerNote::find($request->note_id);
        $partnerNote->client_id = $request->client_id;
        $partnerNote->note_title = $request->note_title;
        $partnerNote->note_description = $request->note_description;        
        $partnerNote->save();
        return response()->json(['success'=>'Record is successfully added']);
    }
    public function clientNoteDelete($id, $clientId)
    {
        PartnerNote::where('id', $id)->delete();
        return redirect('admin/client/profile/notes/'.$clientId)->with('success', 'Note has been deleted successfully !!');
    }
    public function clientProfileQuotations($id)
    {
        $client = Client::find($id);
        return view('backend.client.quotation', [
            'client' => $client
        ]);
    }
    public function clientProfileAccounts($id)
    {
        $client = Client::find($id);
        return view('backend.client.account', [
            'client' => $client
        ]);
    }
    public function clientProfileConversation($id)
    {
        $client = Client::find($id);
        return view('backend.client.conversation', [
            'client' => $client
        ]);
    }
    public function clientProfileTasks($id)
    {
        $client = Client::find($id);
        $priorityCategories = PriorityCategory::get();
        $taskCategories = TaskCategory::get();
        $tasks = Task::where('client_id', $id)->get();
        $users = User::get();

        return view('backend.client.task', [
            'users' => $users,
            'tasks' => $tasks,
            'client' => $client,
            'taskCategories' => $taskCategories,
            'priorityCategories' => $priorityCategories,
        ]);
    }
    protected function clientTaskImageUpload($request){
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
    public function clientTaskCreate(Request $request)
    {
        $request->validate([
          'title'    => 'required',
          'category_id'   => 'required',
        ]);
        // echo "<pre>"; print_r($_POST); die();

        $task = new Task();
        $task->client_id = $request->client_id;
        $task->title = $request->title;
        $task->category_id = $request->category_id;
        $task->assigee_id = $request->assigee_id;
        $task->priority_id = $request->priority_id;
        $task->due_date = $request->due_date;
        $task->description = $request->description;

        if($request->file('attachment')){
            $imageUrl = $this->clientTaskImageUpload($request);
            $task->attachment = $imageUrl;
        }

        $task->follower_id = $request->follower_id;   
        $task->status = $request->status;   
        $task->save();

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function clientTaskEdit(Request $request){
        $task = Task::where('client_id', $request->client_id)->find($request->task_id);
        
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
        $task->client_id = $request->client_id;
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

        $task->save();
    }
    public function clientTaskUpdate(Request $request)
    {
        
        $request->validate([
          'title'   => 'required',
          'category_id'   => 'required',
        ]);
        // echo "<pre>"; print_r($_POST); die();

        $taskImage = $request->file('attachment');
        $task = Task::find($request->task_id);

        if($taskImage){
            if (File::exists($task->attachment)) {
                unlink($task->attachment);
            }
            
            $imageUrl = $this->clientTaskImageUpload($request);
            // echo "<pre>"; print_r($imageUrl); die();
            $this->taskBasicInfoUpdate($request, $task, $imageUrl);
        }else{
            $this->taskBasicInfoUpdate($request, $task);
        }

        return response()->json(['success'=>'Record is successfully added']);
    }
    
    public function clientTaskDelete($id, $clientId)
    {
        Task::where('id', $id)->delete();
        return redirect('admin/client/profile/tasks/'.$clientId)->with('success', 'Task has been deleted successfully !!');
    }
    
    public function clientProfileEducations($id)
    {
        $client = Client::find($id);
        $degrees = DegreeLevel::get();
        $subjectareas = SubjectArea::get();

        $englishtestscores = EnglishtestScore::get();
        $othertestscore = OthertestScore::get()->first();
        // dd($englishtestscores);

        $educations = ClientEducation::with('degreelevel','subjectarea','subject','client')->where('client_id', $id)->get();
        // dd($educations);

        return view('backend.client.education', [
            'client' => $client,
            'degrees' => $degrees,
            'educations' => $educations,
            'subjectareas' => $subjectareas,
            'othertestscore' => $othertestscore,
            'englishtestscores' => $englishtestscores,
        ]);
    }
    public function updateEducationScore(Request $request)
    {
        foreach ($request->listening as $key => $listening) {
            $result = [];
            $result['listening'] = $listening;
            $result['id'] = $request->id[$key];
            $result['reading'] = $request->reading[$key];
            $result['writing'] = $request->writing[$key];
            $result['speaking'] = $request->speaking[$key];
            $result['overall_scores'] = $request->overall_scores[$key];
            // echo "<pre>"; print_r($result);

            $englishScore = EnglishtestScore::find($result['id']);
            $englishScore->listening = $result['listening']; 
            $englishScore->reading = $result['reading'];  
            $englishScore->writing = $result['writing'];  
            $englishScore->speaking = $result['speaking'];  
            $englishScore->overall_scores = $result['overall_scores'];
            $englishScore->save();

        }
        return response()->json(['success'=>'Record is successfully added']);
    }
    public function updateOtherScore(Request $request)
    {
        // echo "<pre>"; print_r($_POST); die();

        $otherScore = OthertestScore::find($request->id);
        $otherScore->sat_one = $request->sat_one; 
        $otherScore->sat_two = $request->sat_two;  
        $otherScore->gre = $request->gre;  
        $otherScore->gmat = $request->gmat;
        $otherScore->save();

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function clientSubjectInfo(Request $request)
    {
        $subjects = Subject::where('subject_id', $request->subjectarea_id)->get();
        return json_encode($subjects);
    }
    public function clientEducationCreate(Request $request)
    {
        $request->validate([
          'degree_title'    => 'required',
          'degree_level'   => 'required',
          'institution'   => 'required',
        ]);
        // echo "<pre>"; print_r($_POST); die();

        $education = new ClientEducation();
        $education->client_id = $request->client_id;
        $education->degree_title = $request->degree_title;
        $education->degree_level = $request->degree_level;        
        $education->institution = $request->institution;        
        $education->course_start = $request->course_start;        
        $education->course_end = $request->course_end;        
        $education->subject_area = $request->subject_area;        
        $education->subject_id = $request->subject_id;
        $education->score_status = $request->score_status;
        $education->score = $request->score;
        $education->save();

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function clientEducationEdit(Request $request)
    {
        $education = ClientEducation::where('client_id', $request->client_id)->find($request->education_id);
        $subjects = Subject::get();
        $degrees = DegreeLevel::get();
        $subjectareas = SubjectArea::get();

        $result = [
            'degrees' => $degrees,
            'subjects' => $subjects,
            'education' => $education,
            'subjectareas' => $subjectareas
        ];
        echo json_encode($result);
    }
    public function clientEducationUpdate(Request $request)
    {
        $request->validate([
          'degree_title'    => 'required',
          'degree_level'   => 'required',
          'institution'   => 'required',
        ]);

        // echo "<pre>"; print_r($_POST); die();
        $education = ClientEducation::find($request->education_id);
        $education->client_id = $request->client_id;
        $education->degree_title = $request->degree_title;
        $education->degree_level = $request->degree_level;        
        $education->institution = $request->institution;        
        $education->course_start = $request->course_start;        
        $education->course_end = $request->course_end;        
        $education->subject_area = $request->subject_area;        
        $education->subject_id = $request->subject_id;
        $education->score_status = $request->score_status;
        $education->score = $request->score;
        $education->save();

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function clientEducationDelete($id, $clientId)
    {
        ClientEducation::where('id', $id)->delete();
        return redirect('admin/client/profile/educations/'.$clientId)->with('success', 'Educations has been deleted successfully !!');
    }
    public function clientProfileInformations($id)
    {
        $client = Client::find($id);
        return view('backend.client.otherinformation', [
            'client' => $client
        ]);
    }
    public function clientProfileLogs($id)
    {
        $client = Client::find($id);
        return view('backend.client.checkinlogs', [
            'client' => $client
        ]);
    }
    /*===============================================================================
                            Client Profile End
    =================================================================================*/


    public function autocomplete(Request $request)
    {
        $data = [];
        $data = Tag::select("name", "id")
            ->where('name', 'LIKE', '%' . $request->get('search') . '%')
            ->get();
        return response()->json($data);
    }
    public function sourceAutocomplete(Request $request)
    {
        $data = [];
        $data = SourceList::select("source_name as name", "id")
            ->where('source_name', 'LIKE', '%' . $request->get('search') . '%')
            ->get();
        return response()->json($data);
    }
    public function applicationAutocomplete(Request $request)
    {

        $data = Product::where('name', 'LIKE', '%' . $request->get('name') . '%')->with('partnerBranches')
            ->get();

        $vdata = [];
        $i = 0;
        foreach ($data as $row) {
            $vdata[$i]['id'] = $row->id;
            $name = $row->partnerBranches["name"];
            $vdata[$i]['text'] = '<div>' . $row->name . '</div><div><small>' . $name . '</small></div>';
            $i++;
        }
        return response()->json($vdata);
    }
    
    public function applicationInfoAppend(Request $request)
    {
        $product = Product::with('partner','partnerBranches')->find($request->product_id);

        $array = [];
        $partner = Partner::find($product->partner_id);
        $array = WorkflowCategory::find($partner->workflow_id);

        $product->workflow = $array;
        echo json_encode($product);
    }
    
    public function clientProfileQuotationsAdd($id){
      //  $client = Client::find($id);
      //  return view('backend.quotations.createtemplate', ['client'=>$client]);  
        $client = Client::find($id);
        $interestedServices = InterestedService::where('client_id', $id)->with('workflow','partner','product','client','branch')->get();
        $workflowCategories = WorkflowCategory::get();
        return view('backend.quotations.createtemplate', [
            'client' => $client,
            'interestedServices' => $interestedServices,
            'workflowCategories' => $workflowCategories,
        ]); 
        
    }
    
    public function clientProfileQuotationsAddsubmit($id,Request $request){
        
        if($request->grand_total == 0){
          return redirect()->back()->with('danger', "Total can't zero");   
            die();
        }

 
        $quotation = new Quotation();
        $quotation->template_name = $request->template_name;
        $quotation->product_item = count($request->product_id);
        $quotation->total_fee = $request->grand_total;
        $quotation->due_date = date('Y-m-d');
        $quotation->office = $request->office;
        $quotation->quote_currency = $request->quote_currency;
        $quotation->created_user =1;
        $quotation->client_id =$id;
        $quotation->save();
        $qid = $quotation->id;
        
        for($i = 0; $i< count($request->workflow_id); $i++){
            $qitem = new Quotationitem();
            $qitem->quotation_id = $qid;
            $qitem->workflow_id= $request->workflow_id[$i];
            $qitem->partner_id= $request->partner_id[$i];
            $qitem->product_id= $request->product_id[$i];
            $qitem->branch_id= $request->branch_id[$i];
            $qitem->description= $request->description[$i];
            $qitem->service_fee= $request->service_fee[$i];
            $qitem->discount= $request->discount[$i];
            $qitem->net_fee= $request->net_fee[$i];
            $qitem->egx_rte= $request->egx_rte[$i];
            $qitem->total_ammount = $request->total_ammount[$i];
            $qitem->save();
        }
         return redirect('admin/client/profile/quotations/'.$id)->with('success', 'Quotation has been added successfully !!');
    }
    
    public function clientProfileCreatehtml(Request $request){
        
        $request->validate([
            'workflow_id' => 'required',
            'partner_id' => 'required',
            'product_id' => 'required',
            'branch_id' => 'required',
        ]);
        
        $workflow_id = $request->workflow_id;
        $partner_id = $request->partner_id;
        $product_id = $request->product_id;
        $branch_id = $request->branch_id;
        $appendDiv = $request->appendDiv;
        $workflow = WorkflowCategory::where('id',$workflow_id)->first();
        $partner = Partner:: where('id',$partner_id)->first();
        $product = Product::where('id',$product_id)->first();
        $branch =  PartnerBranch::where('id',$branch_id)->first();
        
        $html = '<tr id="appendDiv'.$appendDiv.'" class="appendDiv" attr="'.$appendDiv.'"><td>'.$appendDiv.'</td>';
        $html .= '<td><div class="first_div" id="first_div'.$appendDiv.'"><h5>'.$product->name.'</h5> <p>'.$partner->name.'</p><p>('.$workflow->service_workflow.')</p><input type="hidden" name="workflow_id[]" value="'.$workflow_id.'"><input type="hidden" name="partner_id[]" value="'.$partner_id.'"><input type="hidden" name="product_id[]" value="'.$product_id.'"><input type="hidden" name="branch_id[]" value="'.$branch_id.'"><a href="javascript:void(0)" class="editDiv" attr="'.$appendDiv.'" workflow_id="'.$workflow_id.'" partner_id="'.$partner_id.'"  product_id="'.$product_id.'" branch_id="'.$branch_id.'"><i class="mdi mdi-square-edit-outline"></i></a></div></td>';
        $html .='<td><div class="input-group mb-2"> <textarea class="form-control" name="description[]" rows="3">Tuition Fee </textarea></td>';
        $html .='<td><div class="input-group mb-2"><input type="text" class="form-control service_fee" name="service_fee[]" value="0.00"></td>';
        $html .='<td><div class="input-group mb-2"><input type="text" class="form-control discount" name="discount[]" value="0.00"></td>';
        $html .='<td><div class="input-group mb-2"><input type="text" class="form-control net_fee" name="net_fee[]" value="0.00"></td>';
        $html .='<td><div class="input-group mb-2"><input type="text" class="form-control egx_rte" name="egx_rte[]" value="0.00"></td>';
        $html .='<td><div class="input-group mb-2"><input type="text" class="form-control total_ammount" name="total_ammount[]" value="0.00"></td>';
        $html .='<td><a attr="'.$appendDiv.'" class="removeDiv" href="javascript:void(0)"><i class="mdi mdi-trash-can-outline"></i></a></td>';
        $html .= '</tr>';
        //  echo  $html;
        
        return response()->json($html);
        
    }
    
    public function clientProfileOption(Request $request){
        
        $workflow_id = $request->workflow_id;
        $partner_id = $request->partner_id;
        $product_id = $request->product_id;
        $branch_id = $request->branch_id;
        //$workflow = WorkflowCategory::where('id',$workflow_id)->first();
        $partner = Partner:: where('id',$partner_id)->first();
        $product = Product::where('id',$product_id)->first();
        $branch =  PartnerBranch::where('id',$branch_id)->first();  
        $array = [];
        $array['partner'] = '<option value="'.$partner_id.'">'.$partner->name.'</option>';
        $array['product'] = '<option value="'.$product_id.'">'.$product->name.'</option>';
        $array['branch'] = '<option value="'.$branch_id.'">'.$branch->name.'</option>';
        return response()->json($array);
        
    }
    
    
    public function clientProfileEditoption(Request $request){
        $workflow_id = $request->workflow_id;
        $partner_id = $request->partner_id;
        $product_id = $request->product_id;
        $branch_id = $request->branch_id;
        $appendDiv = $request->appendDiv;
        $workflow = WorkflowCategory::where('id',$workflow_id)->first();
        $partner = Partner:: where('id',$partner_id)->first();
        $product = Product::where('id',$product_id)->first();
        $branch =  PartnerBranch::where('id',$branch_id)->first();
        $html = '<h5>'.$product->name.'</h5> <p>'.$partner->name.'</p><p>('.$workflow->service_workflow.')</p><input type="hidden" name="workflow_id[]" value="'.$workflow_id.'"><input type="hidden" name="partner_id[]" value="'.$partner_id.'"><input type="hidden" name="product_id[]" value="'.$product_id.'"><input type="hidden" name="branch_id[]" value="'.$branch_id.'"><a href="javascript:void(0)" class="editDiv" attr="'.$appendDiv.'" workflow_id="'.$workflow_id.'" partner_id="'.$partner_id.'"  product_id="'.$product_id.'" branch_id="'.$branch_id.'"><i class="mdi mdi-square-edit-outline"></i></a>';
         echo  $html;
    }
    
    public function clientProfileQuotationslist($id,Request $request){
        
      if ($request->ajax()) {
          $data = Quotation::where('client_id',$id)->get();
            return Datatables::of($data)
                ->editColumn('created_at', function($row){
                    $newDate = date("d-m-Y", strtotime($row->created_at));  
                    return $newDate;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.url('/').'/admin/client/profile/quotationsedit/'.$row->id.'" class="edit btn btn-success btn-sm">Edit</a> <a href="'.url('/').'/admin/client/profile/quotationsdelete/'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                
                ->rawColumns(['action'])
                ->make(true);
        }  
    
    }
    
    public function clientQuotationsSaveoptions(Request $request){
    
    
    
    }
    
    public function clientProfileQuotationsEdit($id,Request $request){
    
        $quotation = Quotation::where('id',$id)->with('quotation_product')->first();
        if($quotation == null){
            return redirect()->back()->with('danger', "Quotation not found");   
            die();
        }
        
        $cid = $quotation->client_id;
        $client = Client::find($cid);
        $oldProduct = $quotation->quotation_product;
        $newproduct = [];
        foreach($oldProduct as $product){
        $product->newhtml = $this->crateUpdathtml($product->workflow_id,$product->partner_id,$product->product_id,$product->branch_id,$product->id);
        $newproduct[] = $product;
        }
        $quotation->quotation_product = $newproduct;
        
        $interestedServices = InterestedService::where('client_id', $id)->with('workflow','partner','product','client','branch')->get();
        $workflowCategories = WorkflowCategory::get();
        return view('backend.quotations.edittemplate', [
        'client' => $client,
        'quotation' => $quotation,
        'interestedServices' => $interestedServices,
        'workflowCategories' => $workflowCategories,
        ]); 
    }
    
    private function crateUpdathtml($workflow_id,$partner_id,$product_id,$branch_id,$appendDiv){
        
         $workflow = WorkflowCategory::where('id',$workflow_id)->first();
         $partner = Partner:: where('id',$partner_id)->first();
         $product = Product::where('id',$product_id)->first();
         $branch =  PartnerBranch::where('id',$branch_id)->first();
         $html = '<div class="first_div" id="first_div'.$appendDiv.'"><input type="hidden" name="quotation_id[]" value="'.$appendDiv.'" > <h5>'.$product->name.'</h5> <p>'.$partner->name.'</p><p>('.$workflow->service_workflow.')</p><input type="hidden" name="workflow_id[]" value="'.$workflow_id.'"><input type="hidden" name="partner_id[]" value="'.$partner_id.'"><input type="hidden" name="product_id[]" value="'.$product_id.'"><input type="hidden" name="branch_id[]" value="'.$branch_id.'"><a href="javascript:void(0)" class="editDiv" attr="'.$appendDiv.'" workflow_id="'.$workflow_id.'" partner_id="'.$partner_id.'"  product_id="'.$product_id.'" branch_id="'.$branch_id.'"><i class="mdi mdi-square-edit-outline"></i></a></div>';
 
        return $html;
   
    }
    
    public function clientProfileQuotationsUpdatesubmit($id,Request $request){
  
    if($request->grand_total == 0){
          return redirect()->back()->with('danger', "Total can't zero");   
            die();
        }
        $quotation =Quotation::where('id',$id)->first();
        $quotation->template_name = $request->template_name;
        $quotation->product_item = count($request->product_id);
        $quotation->total_fee = $request->grand_total;
        $quotation->due_date = date('Y-m-d');
        $quotation->office = $request->office;
        $quotation->quote_currency = $request->quote_currency;
        $quotation->created_user =1;
        $quotation->save();
        
        // $qusIds =  implode(",",$request->quotation_id);
        // var_dump($qusIds);
        // die();
        //DB::enableQueryLog();
        $allItemIds = Quotationitem::where('quotation_id',$id)->whereNotIn('id',$request->quotation_id)->delete();
        //dd(DB::getQueryLog());
        $qid = $id;
        for($i = 0; $i< count($request->workflow_id); $i++){
                  //echo $id;die();
                if(isset($request->quotation_id[$i])){
                    $qitem = Quotationitem::where('id',$request->quotation_id[$i])->first();
                    $qitem->quotation_id = $qid;
                    $qitem->workflow_id= $request->workflow_id[$i];
                    $qitem->partner_id= $request->partner_id[$i];
                    $qitem->product_id= $request->product_id[$i];
                    $qitem->branch_id= $request->branch_id[$i];
                    $qitem->description= $request->description[$i];
                    $qitem->service_fee= $request->service_fee[$i];
                    $qitem->discount= $request->discount[$i];
                    $qitem->net_fee= $request->net_fee[$i];
                    $qitem->egx_rte= $request->egx_rte[$i];
                    $qitem->total_ammount = $request->total_ammount[$i];
                    $qitem->save(); 
                   
                }else{
                    $qitem = new Quotationitem();
                    $qitem->quotation_id = $qid;
                    $qitem->workflow_id= $request->workflow_id[$i];
                    $qitem->partner_id= $request->partner_id[$i];
                    $qitem->product_id= $request->product_id[$i];
                    $qitem->branch_id= $request->branch_id[$i];
                    $qitem->description= $request->description[$i];
                    $qitem->service_fee= $request->service_fee[$i];
                    $qitem->discount= $request->discount[$i];
                    $qitem->net_fee= $request->net_fee[$i];
                    $qitem->egx_rte= $request->egx_rte[$i];
                    $qitem->total_ammount = $request->total_ammount[$i];
                    $qitem->save();  
                }
        }
     return redirect('admin/client/profile/quotationsedit/'.$qid)->with('success', 'Quotation has been update successfully !!');      
    }
    
    public function clientProfileQuotationsDelete($id,Request $request){

    }
    

    public function applicationAddNote(Request $reques){
    $values = ['title'=> $reques->addnote_title,'description'=> $reques->addnote_description];
    $newoption = new Applicationoption();
    $newoption->client_id = $reques->client_id;
    $newoption->application_id =$reques->applicaion_id;
    $newoption->category_id = $reques->collection_id;
    $newoption->type = 'note';
    $newoption->info_value = json_encode($values);
    $newoption->save();
    return redirect('admin/client/profile/application/details/'.$reques->applicaion_id.'/'.$reques->client_id)->with('success', 'Note has been added successfully !!');     
    }
    
    public function applicationAddDocumentation(Request $request){
        $request->validate([
       'application_file' => 'required|mimes:docx,csv,txt,xlx,xls,pdf|max:2048'
        ]);
         
        $file = $request->application_file;
        $file_extenion = $file->getClientOriginalExtension();
        $file_name = time().'_'.$file->getClientOriginalName();
        $destinationPath = public_path().'/files/';
        $getfilename   = $file->getClientOriginalName();
        $uploadedFile = time().$getfilename;
        $file->move($destinationPath, $uploadedFile);
        
        
        $values = ['extenion'=> $file_extenion,'file_name'=> $file_name,'file_path'=>'/files/'];
        $newoption = new Applicationoption();
        $newoption->client_id = $request->client_id;
        $newoption->application_id =$request->applicaion_id;
        $newoption->category_id = $request->collection_id;
        $newoption->type = 'documentation';
        $newoption->info_value = json_encode($values);
        $newoption->save();
        return redirect('admin/client/profile/application/details/'.$request->applicaion_id.'/'.$request->client_id)->with('success', 'Note has been added successfully !!');     

    }
    
    public function applicationAddAppointment(Request $request){
        $values = ['customRadio'=>$request->customRadio,'client_name'=>$request->client_name,'date_time_date'=>$request->date_time_date,'date_time_time'=>$request->date_time_time,'title'=>$request->title,'description'=>$request->description,'invitees'=>$request->invitees];
        $newoption = new Applicationoption();
        $newoption->client_id = $request->client_id;
        $newoption->application_id =$request->applicaion_id;
        $newoption->category_id = $request->collection_id;
        $newoption->type = 'appointment';
        $newoption->info_value = json_encode($values);
        $newoption->save();
        return redirect('admin/client/profile/application/details/'.$request->applicaion_id.'/'.$request->client_id)->with('success', 'Note has been added successfully !!');     
    }
    
    public function applicationSendMail(Request $request){
    
        $file = $request->attachment;
        $file_extenion = $file->getClientOriginalExtension();
        $file_name = time().'_'.$file->getClientOriginalName();
        $destinationPath = public_path().'/files/';
        $getfilename   = $file->getClientOriginalName();
        $uploadedFile = time().$getfilename;
        $file->move($destinationPath, $uploadedFile);
        
        // $from_mail = $request->from_mail;
        // $to_mail = $request->to_mail;
        // $send_individual_mail = $request->send_individual_mail;
        // $cc_mail = $request->cc_mail;
        // $subject = $request->subject;
        // $message = $request->message;
        // //$from_mail = $request->from_mail;
            $data["email"] = "pijush@sahajjo.com";
            $data["title"] =$request->subject;
            $data["body"] = $request->message;
            
            $files = [
            public_path('files/'.$file_name),
            ];

        Mail::send('email.myTestMail', $data, function($message)use($data, $files) {
        $message->to($data["email"], $data["email"])
                    ->from($data["email"])
                    ->subject($data["title"]);
            foreach ($files as $file){
                $message->attach($file);
            }
        });

    
    
    }
    
    
    public function applicationDocs($aid,$cid,Request $request){
        if ($request->ajax()) {
          $data = Applicationoption::where(['client_id'=>$cid,'application_id'=>$aid,'type'=>'documentation'])->get();
            return Datatables::of($data)
                ->editColumn('file_name', function($row){
                    $row = json_decode($row->info_value);
                    return $row->file_name;
                })
                ->editColumn('related', function($row){
                    $cat = Applicationtypecategorie::where('id',$row->category_id)->first(); 
                    return $cat->category_name;
                })
                       
                ->editColumn('add_by', function($row){
                    return 'Rafi';
                })
                ->editColumn('add_on', function($row){
                    $newDate = date("d-m-Y", strtotime($row->created_at));  
                    return $newDate;
                })
                ->addColumn('action', function($row){
                $actionBtn = '<a href="'.url('/').'/admin/application-edit-docs/'.$row->id.'" class="edit btn btn-success btn-sm">Edit</a> <a href="'.url('/').'/admin/application-delete-docs/'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } 
    }
    
    public function applicationEditDocs($aid){
        
    }
    
    
    public function applicationDeleteDocs($aid){
        $data = Applicationoption::where(['id'=>$aid])->first();
        $row = json_decode($row->info_value);
        //return $row->file_name;
        //Applicationoption::where(['id'=>$aid])->delete();
        return redirect()->back()->with('success', 'Delete sucessfully');   
         //echo '<pre>';
        // print_r($data);
         //die();
    }
 
 public function applicationNotes($aid,$cid){
    $data = Applicationoption::where(['client_id'=>$cid,'application_id'=>$aid,'type'=>'note'])->get();
     $html = '';  
    foreach($data as $dd){
        $val =  json_decode($dd->info_value);
        $cat = Applicationtypecategorie::where('id',$dd->category_id)->first(); 
        $html .='<div class="col-md-6" id="note_'.$dd->id.'"><div class="card"><div class="card-body p-2"><div class="dropdown float-end"><a href="javascript:void(0);"  class="dropdown-toggle arrow-none card-drop " data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></a><div class="dropdown-menu dropdown-menu-end"><a href="javascript:void(0);" aid="'.$aid.'" cid="'.$cid.'" cat_id="'.$dd->category_id.'" class="dropdown-item note_edit">Edit</a><a href="javascript:void(0);" aid="'.$aid.'" cid="'.$cid.'" cat_id="'.$dd->category_id.'" class="dropdown-item note_delete">Delete</a></div></div><div class="mb-3">';
        //$html .='<input type="hidden" value="'.$dd->info_value.'" />';
        $html .='<h5 class="media-heading mt-0 mb-0">'.$val->title.'</h5>';
        $html .='<p class="media-heading mt-0 mb-0"><small>'.$cat->category_name.'</small></p>';
        $html .='</div>';
        $html .= $val->description; 
        $html .=' </div>';
        $html .='<div class="card-footer p-2"><div class="d-flex align-items-center">';
        $html .='<a href="#"><img class="flex-shrink-0 me-1 rounded-circle avatar-sm" alt="64x64" src="'.url('/').'/assets/images/users/user-5.jpg"></a>';
        $html .='<div class="flex-grow-1"><p class="mb-0">Last Modified:</p><p class="mb-0"><small>'.date_format($dd->updated_at,"d-m-Y").'</small></p></div>';
        $html .='</div></div></div></div>';
    }
    
    echo  $html;
 }
 
 public function applicationEditNotes(){
     
 }
 public function applicationDeleteNotes(){
     
 }
  public function applicationClientAddTask($aid,$cid,Request $request){
    $request->validate([
          'title'    => 'required',
          'category_id'   => 'required',
        ]);
        
        if($request->file('attachment')){
            $imageUrl = $this->clientTaskImageUpload($request);
            //$task->attachment = $imageUrl;
        }
        
        $values = ['attachment'=>$imageUrl,'title'=> $request->title,'category_id'=> $request->category_id,'assigee_id'=>$request->assigee_id,'priority_id'=>$request->priority_id,'due_date'=>$request->due_date,'description'=>$request->description];
        $newoption = new Applicationoption();
        $newoption->client_id = $request->client_id;
        $newoption->application_id =$request->applicaion_id;
        $newoption->category_id = $request->collection_id;
        $newoption->type = 'task';
        $newoption->info_value = json_encode($values);
        $newoption->save();
        
        // return redirect('admin/client/profile/application/details/'.$request->applicaion_id.'/'.$request->client_id)->with('success', 'Note has been added successfully !!');     
        // echo "<pre>"; print_r($_POST); die();

        // $task = new Task();
        // $task->client_id = $request->client_id;
        // $task->title = $request->title;
        // $task->category_id = $request->category_id;
        // $task->assigee_id = $request->assigee_id;
        // $task->priority_id = $request->priority_id;
        // $task->due_date = $request->due_date;
        // $task->description = $request->description;
        // $task->follower_id = $request->follower_id;   
        // $task->status = $request->status;   
        // $task->save();

         return response()->json(['success'=>'Record is successfully added']); 
 }
 
 public function getClientTaskCategory($aid,$cid,$catid,Request $request){
     //echo 23234;die();
// $newoption = new Applicationoption();
// $newoption->client_id = $request->client_id;
// $newoption->application_id =$request->applicaion_id;
// $newoption->category_id = $request->collection_id;
        $data = Applicationoption::where(['client_id'=>$cid,'application_id'=>$aid,'category_id'=>$catid,'type'=>'task'])->get();
        if ($request->ajax()) {
          $data = Applicationoption::where(['client_id'=>$cid,'application_id'=>$aid,'category_id'=>$catid,'type'=>'task'])->get();
            return Datatables::of($data)
                ->editColumn('category', function($row){
                    $nrow = json_decode($row->info_value);
                    $cat = TaskCategory::where('id',$nrow->category_id)->first();
                    return $cat->task_name;
                })
                ->editColumn('comments', function($row){
                    $nrow = json_decode($row->info_value);
                    return $nrow->description;
                })
                ->editColumn('attachments', function($row){
                    $nrow = json_decode($row->info_value);
                    $doc = str_replace("images/tasks/","",$nrow->attachment);
                    return $doc;
                })
                ->editColumn('assignee', function($row){
                    $nrow = json_decode($row->info_value);
                    $user = User::where('id',$nrow->assigee_id)->first();
                    return $user->first_name.''.$user->last_name;
                })
                ->editColumn('priority', function($row){
                    $nrow = json_decode($row->info_value);
                    $prioritie = PriorityCategory::where('id',$nrow->assigee_id)->first();
                    return $prioritie->priority_name;
                })
                ->editColumn('due-date', function($row){
                    $nrow = json_decode($row->info_value);
                    return $nrow->due_date;
                })
                ->editColumn('status', function($row){
                     return 'status';
                }) 
                ->make(true);
        }
 }
    
}



