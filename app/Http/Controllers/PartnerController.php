<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Partner;
use App\Follow;
use App\Media_setting;
use Redirect;
use Session;

class PartnerController extends Controller
{
    public function index()
    {
    	$users["data"] = Partner::all();
    	return view('admin.partner.index', $users);
    }
    public function store(Request $request)
    {
    	$data = array();
    	$validateData = $request->validate([
            'name'=>'required',
            'link'=>'required',
            'status'=>'required',
            'image'=>'required',
        ]);

        $data['name'] = $request->name;
        $data['link'] = $request->link;
        $data['status'] = $request->status;

        if ($image=$request->file('image')) {
 
           $uploadPath = 'assets/img/';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);
      
            $data['image']= $file_name;
         
        }

        Partner::insert($data);

        return Redirect::back()->with('msg', 'Successfully Added');
    }

    public function edit($id)
    {
    	$data = Partner::where('id', $id)->first();

    	
    	$output ='';


    	$output .='
    	<input  name="id" value="'.$data['id'].'" type="hidden">
    	<div class="row">
                    <div>
                        <label >Name</label>
                        <input placeholder="Placeholder" id="first_name" name="name" value="'.$data['name'].'" type="text" class="validate">
                        <b><p style="color: red;" id="name2"></p></b>
                    </div>
                    <div>
                        <label for="Link">Link</label>
                        <input id="last_name" type="text" name="link" value="'.$data['link'].'" class="validate">
                        
                        <b><p style="color: red;" id="link2"></p></b>
                    </div>
                </div>';

        if ($data['status'] == 1)
         {
            $output .='<label>Status</label><div class="row">
                    <div class="input-field">
                    
                        <select name="status">
                                <option value="1">Active</option>
                                <option value="2">Non - Active </option>
                        </select>
                    </div>
                </div>' ;

         } else{
         	$output .='<label>Status</label><div class="row">
                    <div class="input-field">
                        <select name="status">
                                <option value="2">Non - Active </option>
                                <option value="1">Active</option>
                        </select>
                        
                    </div>
                </div>';
         }         
        

         $output .= '<div class="row">
	                    <div class="file-field input-field">
	                        <div class="btn blue darken-1">
	                            <span>File</span>
	                            <input type="file" name="image" id="myFileInput" accept="image/*">
	                        </div>
	                        <div class="file-path-wrapper">
	                            <input class="file-path validate"  type="text" placeholder="Upload one or more files">	                            <b><p style="color: red;" id="image"></p></b>
	                        </div>
	                    </div>
	                </div>'; 


	    print_r($output);              
    }

    public function update(Request $request)
    {
    	$data = array();
    	$data = Partner::where('id',$request->id)->first();
    	
    	$validateData = $request->validate([
            'name'=>'required',
            'link'=>'required',
            'status'=>'required',
        ]);

        $data['name'] = $request->name;
        $data['link'] = $request->link;
        $data['status'] = $request->status;

        if ($image=$request->file('image')) {
 
           $uploadPath = 'assets/img/';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);
      
            $data['image']= $file_name;
         
        }

        if($data->update()){
            return Redirect::back()->with('msg', 'Successfully Added');
        }
    }

    public function delete(Request $request)
    {
    	$id = Partner::where('id',$request->id)->first();
        if($id->delete()){
            echo json_decode(1);
        }
    }

    public function follow()
    {
    	$users["data"] = Follow::all();
    	return view('admin.partner.follow', $users);
    }

    public function store_fellow(Request $request)
    {
    	$data = array();
    	$validateData = $request->validate([
            'name'=>'required',
            'link'=>'required',
            'status'=>'required',
            'image'=>'required',
        ]);

        $data['name'] = $request->name;
        $data['link'] = $request->link;
        $data['status'] = $request->status;

        if ($image=$request->file('image')) {
 
           $uploadPath = 'assets/img/';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);
      
            $data['image']= $file_name;
         
        }

        Follow::insert($data);

        return Redirect::back()->with('msg', 'Successfully Added');
    }

    public function edit2($id)
    {
    	$data = Follow::where('id', $id)->first();

    	
    	$output ='';


    	$output .='
    	<input  name="id" value="'.$data['id'].'" type="hidden">
    	<div class="row">
                    <div>
                        <label >Name</label>
                        <input placeholder="Placeholder" id="first_name" name="name" value="'.$data['name'].'" type="text" class="validate">
                        <b><p style="color: red;" id="name2"></p></b>
                    </div>
                    <div>
                        <label for="Link">Link</label>
                        <input id="last_name" type="text" name="link" value="'.$data['link'].'" class="validate">
                        
                        <b><p style="color: red;" id="link2"></p></b>
                    </div>
                </div>';

        if ($data['status'] == 1)
         {
            $output .='<label>Status</label><div class="row">
                    <div class="input-field">
                    
                        <select name="status">
                                <option value="1">Active</option>
                                <option value="2">Non - Active </option>
                        </select>
                    </div>
                </div>' ;

         } else{
         	$output .='<label>Status</label><div class="row">
                    <div class="input-field">
                        <select name="status">
                                <option value="2">Non - Active </option>
                                <option value="1">Active</option>
                        </select>
                        
                    </div>
                </div>';
         }         
        

         $output .= '<div class="row">
	                    <div class="file-field input-field">
	                        <div class="btn blue darken-1">
	                            <span>File</span>
	                            <input type="file" name="image" id="myFileInput" accept="image/*">
	                        </div>
	                        <div class="file-path-wrapper">
	                            <input class="file-path validate"  type="text" placeholder="Upload one or more files">	                            <b><p style="color: red;" id="image"></p></b>
	                        </div>
	                    </div>
	                </div>'; 


	    print_r($output);              
    }

    public function update2(Request $request)
    {
    	$data = array();
    	$data = Follow::where('id',$request->id)->first();
    	
    	$validateData = $request->validate([
            'name'=>'required',
            'link'=>'required',
            'status'=>'required',
        ]);

        $data['name'] = $request->name;
        $data['link'] = $request->link;
        $data['status'] = $request->status;

        if ($image=$request->file('image')) {
 
           $uploadPath = 'assets/img/';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);
      
            $data['image']= $file_name;
         
        }



        if($data->update()){
            return Redirect::back()->with('msg', 'Successfully Added');
        }
    }

    public function social()
    {
    	$users["data"] = Media_setting::all();
    	return view('admin.partner.social', $users);
    }

    public function social_edit($id)
    {
    	$data = Media_setting::where('id', $id)->first();

    	$output ='';
    	$output .='
    	<input  name="id" value="'.$data['id'].'" type="hidden">
    	<div class="row">
            <div>
                <label >Name</label>
                <input placeholder="Placeholder" name="name" value="'.$data['name'].'" type="text" class="validate">
                <b><p style="color: red;" id="name2"></p></b>
            </div>
            <div>
                <label for="Link">Link</label>
                <input type="text" name="link" value="'.$data['link'].'" class="validate">
                
            </div>
        </div>';

        $output .='
        <div class="row">
            <div>
                <label >App ID</label>
                <input placeholder="App ID"  name="app_id" value="'.$data['app_id'].'" type="text" class="validate">
            </div>
            <div>
                <label >App Secret</label>
                <input Placeholder="App Secret" type="text" name="app_secret" value="'.$data['app_secret'].'" class="validate">
            </div>
            <div>
                <label >App Token</label>
                <input Placeholder="App Token" type="text" name="app_token" value="'.$data['app_token'].'" class="validate">
            </div>
        </div>';


        if ($data['status'] == 1)
         {
            $output .='<label>Status</label><div class="row">
                    <div class="input-field">
                    
                        <select name="status">
                                <option value="1">Active</option>
                                <option value="2">Non - Active </option>
                        </select>
                    </div>
                </div>' ;

         } else{
         	$output .='<label>Status</label><div class="row">
                    <div class="input-field">
                        <select name="status">
                                <option value="2">Non - Active </option>
                                <option value="1">Active</option>
                        </select>
                        
                    </div>
                </div>';
         }         
        

         $output .= '<div class="row">
	                    <div class="file-field input-field">
	                        <div class="btn blue darken-1">
	                            <span>File</span>
	                            <input type="file" name="image" id="myFileInput" accept="image/*">
	                        </div>
	                        <div class="file-path-wrapper">
	                            <input class="file-path validate"  type="text" placeholder="Upload one or more files">
	                            <b><p style="color: red;" id="image"></p></b>
	                        </div>
	                    </div>
	                </div>'; 


	    print_r($output);              
    }

    public function update_social(Request $request)
    {
    	$data = array();
    	$data = Media_setting::where('id',$request->id)->first();
    	
    	$validateData = $request->validate([
            'name'=>'required',
            'link'=>'required',
        ]);

        $data['name'] = $request->name;
        $data['link'] = $request->link;
        $data['status'] = $request->status;
        
        $data['app_id'] = $request->app_id;
        $data['app_secret'] = $request->app_secret;
        $data['app_token'] = $request->app_token;

        if ($image=$request->file('image')) {
 
           $uploadPath = 'assets/img/';
           
           $file_name = time()."-".$image->getClientOriginalName();
           $dbUrl = $uploadPath."/".$file_name;
       
           $image->move($uploadPath,$dbUrl);
      
            $data['image']= $file_name;
         
        }

        if($data->update()){
            return Redirect::back()->with('msg', 'Successfully Added');
        }
    }
}


                
                