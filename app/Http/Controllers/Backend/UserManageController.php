<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use App\Models\TimeZone;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Events\Backend\UserCreated;
use App\Models\Office;
use App\Models\Currency;
use App\Models\UserKpiTarget;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Image;
use File;
use DB;
//
class UserManageController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:editor_permission');
        $this->module_name = 'users';
    }

    protected function userValidate($request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'office' => 'required',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);
    }

    protected function userupdateValidate($request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'office' => 'required',
        ]);
    }

    protected function userupdatenewValidate($request)
    {
        // $request->validate([
        //     'user_name' => 'required',
        //     'user_email' => 'required|unique:users,email',
        //     'user_phone' => 'required',
        //     'user_role' => 'required',
        // ]);

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'office' => 'required',
        ]);

    }

    protected function userImageUpload($request)
    {
        $profile_image = $request->file('profile_image');
        $image = Image::make($profile_image);
        $fileType = $profile_image->getClientOriginalExtension();
        $imageName = 'user_' . time() . '_' . rand(10000, 999999) . '.' . $fileType;
        $directory = 'images/user/';
        $imageUrl = $directory . $imageName;
        $image->save($imageUrl);

        $thumbnail = $directory . "thumbnail/" . $imageName;
        $image->resize(200, 200, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save($thumbnail);

        return $imageName;
    }

    public function manageUsers()
    {
        // echo 11; die();
         $manageUsers = User::with('role','office')->where('invite_status',1)->get();
        //dd($manageUsers);

        $offices = Office::get();
        $roles = Role::get();
        return view('backend.teams.users.users-list', [
            'manageUsers' => $manageUsers,
            'roles' => $roles,
            'offices' => $offices
        ]);
    }

    public function createUsers()
    {
        $offices = Office::get();
        $roles = Role::get();

        return view('backend.teams.users.users-create', [
            'roles' => $roles,
            'offices' => $offices
        ]);
    }

    public function saveUsers(Request $req)
    {
        //For Validation--------------
        $this->userValidate($req);

        // echo "<pre>"; print_r($_POST); die();

        // $imageUrl = $this->userImageUpload($req);

        $module_name = $this->module_name;
        $module_name_singular = Str::singular($module_name);

        $data_array = $req->except('_token', 'roles', 'permissions', 'password_confirmation');
        $imageUrl = $this->userImageUpload($req);
        $data_array['name'] = $req->first_name;
        $data_array['first_name'] = $req->first_name;
        $data_array['last_name'] = $req->last_name;
        $data_array['mobile'] = $req->phone;
        $data_array['user_role'] = $req->role;
        $data_array['position'] = $req->position_title;
        $data_array['office_id'] = $req->office;
        $data_array['profile_image'] = $imageUrl;
        $data_array['password'] = Hash::make($req->password);

        if ($req->confirmed == 1) {
            $data_array = Arr::add($data_array, 'email_verified_at', Carbon::now());
        } else {
            $data_array = Arr::add($data_array, 'email_verified_at', null);
        }

        $$module_name_singular = User::create($data_array);
        $user_id = DB::getPdo()->lastInsertId();

        if ($req->role == 3) {
            $roles = Role::select('name')->where('id', 8)->get()->toArray();
            $permissions = Permission::select('name')->whereIn('id', [1, 40])->get()->toArray();
        } else {
            $roles = Role::select('name')->where('id', 7)->get()->toArray();
            $permissions = Permission::select('name')->whereIn('id', [1, 39])->get()->toArray();
        }

        $permission = array();
        $role = array();
        foreach ($roles as $getrole) {
            $role[] = $getrole['name'];
        }

        foreach ($permissions as $getper) {
            $permission[] = $getper['name'];
        }

        $module_name_singular = Str::singular('user');

        if (isset($roles)) {
            $$module_name_singular->syncRoles($roles);
        } else {
            $roles = [];
            $$module_name_singular->syncRoles($roles);
        }

        // Sync Permissions
        if (isset($permissions)) {
            $$module_name_singular->syncPermissions($permissions);
        } else {
            $permissions = [];
            $$module_name_singular->syncPermissions($permissions);
        }

        // Username
        $id = $$module_name_singular->id;
        $username = config('app.initial_username') + $id;
        $$module_name_singular->username = $username;
        $$module_name_singular->save();

        event(new UserCreated($$module_name_singular));

        return response()->json(['success'=>'Successfully Inserted']);
    }

    public function all_users()
    {
        // $user = User::whereIn('user_type', [2, 3, 4])->get()->toArray();
       
        $user = User::whereIn('user_type', [2, 3, 4])->get()->toArray();

        return view('backend.users.all_users', compact('user'));
    }

    public function editUsers($id)
    {
        $offices = Office::get();
        $roles = Role::get();
        $user = User::find($id);
        return view('backend.teams.users.users-edit', [
            'user' => $user,
            'roles' => $roles,
            'offices' => $offices
        ]);
    }

    public function updateUsers(Request $req)
    {
        // echo "<pre>"; print_r($_POST); die();

        $user_id = $req->id;
        $password = $req->password;
        $re_password = $req->confirm_password;

        $user = User::find($user_id)->toArray();
        // dd($user);


        if ($user['email'] == $req->email) {
            $this->userupdateValidate($req);
        } else {
            $this->userupdatenewValidate($req);
        }

        if (($password != '') && ($re_password != '')) {
            // echo 11; die();
            if ($password == $re_password) {
                // echo 22; die();
                $profile_image = $req->file('profile_image');

                if ($profile_image) {
                    $users = User::find($user_id)->toArray();
                    if ($users['profile_image'] != '') {

                        if (File::exists('admin/image/user/' . $users['profile_image'])) {
                            unlink('admin/image/user/' . $users['profile_image']);
                        }
                        if (File::exists('admin/image/user/thumbnail/' . $users['profile_image'])) {
                            unlink('admin/image/user/thumbnail/' . $users['profile_image']);
                        }
                    }
                    $imageUrl = $this->userImageUpload($req);
                    $user = User::find($user_id);
                    $user->name = $req->user_name;
                    $user->first_name = $req->user_name;
                    $user->last_name = $req->user_name;
                    $user->email = $req->user_email;
                    $user->mobile = $req->user_phone;
                    $user->user_role = $req->user_role;
                    $user->profile_image = $imageUrl;
                    $user->password = Hash::make($req->password);
                    $user->office_id = $req->office;
                    $user->save();
                } else {
                    // echo 33; die();
                    $user = User::find($user_id);

                    $user->name = $req->first_name;
                    $user->first_name = $req->first_name;
                    $user->last_name = $req->last_name;
                    $user->email = $req->email;
                    $user->user_role = $req->role;
                    $user->mobile = $req->phone;
                    $user->position = $req->position_title;
                    $user->password = Hash::make($req->password);
                    $user->office_id = $req->office;
                    $user->save();
                }

                return redirect('admin/users/list')->with('success', 'Successfully Updated');
            } else {
                return redirect('admin/users/edit/'. $user_id)->with('do_not_match', 'Password did not match');
            }
        } else {
            $profile_image = $req->file('profile_image');

            if ($profile_image) {

                $users = User::find($user_id)->toArray();
                if ($users['profile_image'] != '') {

                    if (File::exists('admin/image/user/' . $users['profile_image'])) {
                        unlink('admin/image/user/' . $users['profile_image']);
                    }
                    if (File::exists('admin/image/user/thumbnail/' . $users['profile_image'])) {
                        unlink('admin/image/user/thumbnail/' . $users['profile_image']);
                    }
                }
                $imageUrl = $this->userImageUpload($req);
                $user = User::find($user_id);
                $user->name = $req->user_name;
                $user->first_name = $req->user_name;
                $user->last_name = $req->user_name;
                $user->email = $req->user_email;
                $user->mobile = $req->user_phone;
                $user->status = $req->user_role;
                $user->profile_image = $imageUrl;
                $user->office_id = $req->office;
                $user->save();
            } else {
                // echo 11; die();
                $user = User::find($user_id);
                $user->name = $req->first_name;
                $user->first_name = $req->first_name;
                $user->last_name = $req->last_name;
                $user->email = $req->email;
                $user->user_role = $req->role;
                $user->mobile = $req->phone;
                $user->position = $req->position_title;
                $user->office_id = $req->office;
                $user->save();
            }

            return redirect('admin/users/list')->with('success', 'Successfully Updated');
        }
    }

    public function deleteUsers($id)
    {
        $data = User::find($id);

        if ($data->profile_image != '') {

            if (File::exists('admin/image/user/' . $data->profile_image)) {
                unlink('admin/image/user/' . $data->profile_image);
            }
            if (File::exists('admin/image/user/thumbnail/' . $data->profile_image)) {
                unlink('admin/image/user/thumbnail/' . $data->profile_image);
            }
        }
        DB::table('users')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Successfully Deleted');
    }

    public function usersdetails($id)
    {
        $user=User::with('clients','office','role')->find($id)->toArray();
        // echo "<pre>";
        // print_r($user);die();
        return view('backend.teams.users.usersdetails',compact('user'));
    }

    public function user_datetime($id)
    {
        $user=User::with('clients','office','role')->find($id)->toArray();
        $timezone=TimeZone::get()->toArray();
        return view('backend.teams.users.usersdate_time',compact('user','timezone'));
    }

    public function user_timezone_save(Request $req,$id)
    {
        $req->validate([
            'user_timezone' => 'required',
        ]);

        $data['user_timezone']=$req->user_timezone;
        User::where('id',$id)->update($data);
        return redirect()->back()->with('success', 'Successfully updated');
    }
    

    public function user_kpi($id)
    {
        $user=User::with('clients','office','role')->find($id)->toArray();
        $currency=Currency::get();
        return view('backend.teams.users.user_kpi',compact('user','currency')); 
    }

    public function save_kpi_target(Request $req)
    {
        $req->validate([
            'kpi_heading' => 'required',
            'kpi_perameter' => 'required',
            'kpi_frequency' => 'required'
        ]);

        $data_arr['user_id']=$req->user_id;
        $data_arr['kpi_heading']=$req->kpi_heading;
        $data_arr['kpi_perameter']=$req->kpi_perameter;
        $data_arr['kpi_frequency']=$req->kpi_frequency;
        $data_arr['date_form']=json_encode($req->date_form);
        $data_arr['date_to']=json_encode($req->date_to);
        $data_arr['target_currency']=json_encode($req->target_currency);
        $data_arr['target_value']=json_encode($req->target_value);

        UserKpiTarget::create($data_arr);

        return response()->json(['success'=>'Successfully Inserted']);
    }

    public function user_inactive($id)
    {
        $data['invite_status']=2;
        DB::table('users')->where('id', $id)->update($data);
        return redirect()->back()->with('success', 'Successfully Inactive');
    }

    public function usersinactive()
    {
        $manageUsers = User::with('role','office')->where('invite_status',2)->get();
        //dd($manageUsers);

        $offices = Office::get();
        $roles = Role::get();
        return view('backend.teams.users.user_inactive', [
            'manageUsers' => $manageUsers,
            'roles' => $roles,
            'offices' => $offices
        ]);
    }

    public function user_active($id)
    {
        $data['invite_status']=1;
        DB::table('users')->where('id', $id)->update($data);
        return redirect()->back()->with('success', 'Successfully active');
    }

    public function usersinvited()
    {
        $manageUsers = User::with('role','office')->where('invite_status',0)->get();
        $offices = Office::get();
        $roles = Role::get();
        return view('backend.teams.users.user_invited', [
            'manageUsers' => $manageUsers,
            'roles' => $roles,
            'offices' => $offices
        ]);
    }

    public function cancel_invite($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Successfully Cancel Invitation');
    }
}
