<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Application;
use App\Models\Invoice;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Spatie\Html\Elements\Span;

class ReportController extends Controller
{
    
    public function report_client()
    {
        //$client=Client::with('users')->whereIn('client_status',[0,1])->get();
        
        return view('backend.report.client');
    }

    public function get_report_client()
    {
        $data=Client::with('users','office_info','flowers')->whereIn('client_status',[0,1])->get();
        if(request()->ajax()) {
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function($row){
                $checkbox='<input type="checkbox" name="" class="checkbox_click" data-id="'.$row['id'].'">';

               return $checkbox; 	

            })
            ->addColumn('full_name', function($row){
                $full_name='<div class="text-truncate">
                <a href="'.route('backend.manage-activitie',$row['id']).'">
                '.$row->first_name.' '.$row->last_name.'
                </a></div>';

               return $full_name; 	

            })
            ->addColumn('client_status', function($row) {
                if($row->client_status == 0)
                {
                   $html='Prospect'; 
                }
                else if($row->client_status == 1)
                {
                    $html='Client'; 
                }
               return $html;     
            })
            ->addColumn('created_at', function($row) {
               $html=Carbon::parse($row->created_at)->format('Y-m-d');
               return $html;     
            })
            ->rawColumns(['full_name','checkbox'])
            ->make(true);
        }
    }

    public function get_single_client(Request $req)
    {
        $client_id=$req->client_id;
        $single_client=Client::where('id',$client_id)->get()->toArray();
        return response()->json($single_client);
    }

    protected function emailClientInfoValidate($request)
    {
        $request->validate([
            'send_form' => 'required',
            'send_to' => 'required',
        ]);
    }

    public function send_client_email(Request $req)
    {
        $this->emailClientInfoValidate($req);

        // $file = $req->attachment;

        // if($file)
        // {
        //     $file_extenion = $file->getClientOriginalExtension();
        //     $file_name = time().'_'.$file->getClientOriginalName();
        //     $destinationPath = public_path().'/files/';
        //     $getfilename   = $file->getClientOriginalName();
        //     $uploadedFile = time().$getfilename;
        //     $file->move($destinationPath, $uploadedFile);
        // }

        $to_email=$req->send_to;
        $cc_email=$req->cc_email;
        
        if($cc_email)
        {
           $mail_new=explode(',',$cc_email);
           $email_new[0]=$to_email;
           $to_email=array_merge($email_new,$mail_new);
        }
        //dd($to_email);
        $email_body=$req->email_body;
        file_put_contents('../resources/views/mail.blade.php',$email_body);

        $email_data = array('subject'=>$req->email_subject);
        
        // if($file)
        // {
        //     $files = public_path('files/'.$file_name);
        // }
        try{
            $send_mail=Mail::send('mail',$email_data,function($message) use ($email_data,$to_email){
                $message->to($to_email)
                        ->subject($email_data['subject']);
                //$message->attach($files);
            });
            return response()->json('success');
        }
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
          }
    }

    public function report_application()
    {
        $data=Application::with('client','workflow','partner','product','branch_office','product_price')->get();
        //dd($data);
        if(request()->ajax()) {
            return datatables()->of($data)
            ->addIndexColumn() 
            ->addColumn('checkbox', function($row){
                $checkbox='<input type="checkbox" name="" class="checkbox_click" data-id="'.$row['id'].'">';
                return $checkbox; 	

            })
            ->addColumn('id', function($row){
                return '<a href="'.route('backend.client-profile-applications',$row->id).'">'.$row->id.'</a>';
            }) 
            ->addColumn('full_name', function($row){
                $full_name=$row->client->first_name.' '.$row->client->last_name; 	
                return '<a href="'.route('backend.manage-activitie',$row->client->id).'">'.$full_name.'</a>';
            })
            ->addColumn('email', function($row){
                $email=$row->client->email; 	
                return '<a href="#" class="send_mail">'.$email.'</a>';
            })
            ->addColumn('installment_type', function($row) {
                $fee_term_id = $row->product_price->fee_term_id;
                switch ($fee_term_id) {
                case "1":
                    $html="Per Year";
                    break;
                case "2":
                    $html="Per Month";
                    break;
                case "3":
                    $html="Per Term";
                    break;
                case "4":
                    $html="Per Trimester";
                    break;
                case "5":
                    $html="Per Semester";
                    break;
                case "6":
                    $html="Per Week";
                    break;
                case "7":
                    $html="Installment";
                    break;    
                default:
                   $html="there is no installment";
                }
                return $html;     
            })
            ->addColumn('status', function($row){
                $html=" ";
                if($row->status == 1)
                {
                    $html = "In Progress";
                }
                else if($row->status == 2)
                {
                    $html = "Complete";
                } 	
               return $html;
            })
            ->addColumn('created_at', function($row) {
                $html=Carbon::parse($row->created_at)->format('Y-m-d');
                return $html;     
             })
             ->addColumn('updated_at', function($row) {
                $html=Carbon::parse($row->updated_at)->format('Y-m-d');
                return $html;     
             })
            ->rawColumns(['checkbox','full_name','email','installment_type','status','id'])
            ->make(true);
        }
        return view('backend.report.application');
    }

    public function report_invoice()
    {
        $data=Invoice::with('client','workflow','partner','product')->get();
        if(request()->ajax()) {
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('full_name', function($row){
                $full_name=$row->client->first_name.' '.$row->client->last_name; 	
                return '<a href="'.route('backend.manage-activitie',$row->client->id).'">'.$full_name.'</a>';
            })
            ->addColumn('created_at', function($row) {
                $html=Carbon::parse($row->created_at)->format('Y-m-d');
                return $html;     
             })
             ->addColumn('partner_name', function($row) {
                $partner_name=$row->partner->name; 	
                return '<a href="'.route('backend.partner-profile-branche',$row->partner->id).'">'.$partner_name.'</a>';
                return $partner_name;     
             })
             ->addColumn('product_name', function($row) {
                $product_name=$row->product->name; 	
                return '<a href="'.route('backend.applications-product',$row->product->id).'">'.$product_name.'</a>';
                return $product_name;     
             })
             ->addColumn('status', function($row){
                $html=" ";
                if($row->status == 1)
                {
                    $html = "Paid";
                }
                else if($row->status == 2)
                {
                    $html = "Unpaid";
                } 	
               return $html;
            })
            ->rawColumns(['full_name','created_at','status','partner_name','product_name']) 
            ->make(true);
        }    
        return view('backend.report.invoice');
    }

    public function report_personaltask()
    {
        $data=Task::with('taskCategory','client','partner','assign','follower')->get();
        //dd($data);
        // echo '<pre>';
        // print_r($data);
        // die();
        if(request()->ajax()) {
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('full_name', function($row){
                $html=" ";
                if(isset($row->client->first_name) && isset($row->client->last_name))
                {
                    $full_name=$row->client->first_name.' '.$row->client->last_name; 	
                    $html='<a href="'.route('backend.manage-activitie',$row->client->id).'">'.$full_name.'</a>';
                }
                return $html;
            })
            ->addColumn('partner_name', function($row){
                $html=" ";
                if(isset($row->partner->name))
                {
                    $partner=$row->partner->name; 	
                    $html='<a href="'.route('backend.partner-profile-branche',$row->partner->id).'">'.$partner.'</a>';
                }
                return $html;
            })
            ->addColumn('priority', function($row) {
                $priority = $row->priority_id;
                switch ($priority) {
                case "1":
                    $html="Low";
                    break;
                case "2":
                    $html="Normal";
                    break;
                case "3":
                    $html="High";
                    break;
                case "4":
                    $html="Urgent";
                    break;   
                default:
                   $html="there is no priority";
                }
                return $html;     
            })
            ->addColumn('status', function($row){
                switch ($row->status) {
                    case "1":
                        $html="<span class='text-warning'>To Do</span>";
                        break;
                    case "2":
                        $html="<span class='text-primary'>Inprogress</span>";
                        break;
                    case "3":
                        $html="<span class='text-secondary'>Onreview</span>";
                        break;
                    case "4":
                        $html="<span class='text-success'>Completed</span>";
                        break;   
                    default:
                       $html=" ";
                    }
                    return $html;	
            })
            ->addColumn('created_at', function($row) {
                $html=Carbon::parse($row->created_at)->format('Y-m-d');
                return $html;     
             })
             ->addColumn('due_date', function($row) {
                $html=Carbon::parse($row->due_date)->format('Y-m-d');
                return $html;     
             })
             ->addColumn('due_time', function($row) {
                $html=Carbon::parse($row->due_date)->format('h:i:s A');
                return $html;     
             })
             ->addColumn('follower_name', function($row) {
                $html=" ";
                if(isset($row->follower->name))
                {
                    $follower_name=$row->follower->name; 	
                    $html='<a href="'.route('backend.usersdetails',$row->follower->id).'">'.$follower_name.'</a>';
                }
                return $html;     
             })
             ->addColumn('related', function($row){
                switch ($row->related) {
                    case "1":
                        $html="Client";
                        break;
                    case "2":
                        $html="Partner";
                        break;
                    case "3":
                        $html="Application";
                        break;
                    case "4":
                        $html="Internal";
                        break;   
                    default:
                       $html=" ";
                    }
                    return $html;	
            })
            ->rawColumns(['full_name','partner_name','priority','status','created_at','due_time','follower_name','related']) 
            ->make(true);
        } 
        return view('backend.report.task');
    }
}
