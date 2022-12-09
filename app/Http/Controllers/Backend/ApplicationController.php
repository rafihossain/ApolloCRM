<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function manageApplication(){

        $applications = DB::table('applications')
                        ->join('service_workflow_categories', 'applications.workflow_id', '=', 'service_workflow_categories.id')
                        ->join('partners', 'applications.partner_id', '=', 'partners.id')
                        ->join('products', 'applications.product_id', '=', 'products.id')
                        ->join('clients', 'applications.client_id', '=', 'clients.id')
                        ->join('users', 'clients.assignee_id', '=', 'users.id')
                        ->join('offices', 'users.office_id', '=', 'offices.id')
                        ->select('applications.id', DB::raw("CONCAT(users.first_name,' ',users.last_name)  AS full_username"),
                            DB::raw("CONCAT(clients.first_name,' ',clients.last_name)  AS full_clientname"),
                            'offices.office_name', 'clients.phone as client_phone', 'products.name as product_name',
                            'partners.name as partner_name', 'service_workflow_categories.service_workflow as workflow',
                            'applications.status', 'applications.created_at', 'applications.client_id')
                        ->get();

        // dd($applications);

        return view('backend.application.application-list', [
            'applications' => $applications,
        ]);
    }
}
