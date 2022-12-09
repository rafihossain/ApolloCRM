<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Client;
use App\Models\Partner;
use App\Models\PriorityCategory;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Image;
use File;

class TaskController extends Controller
{
    public function taskList()
    {
        $priorityCategories = PriorityCategory::get();
        $taskCategories = TaskCategory::get();
        
        $tasks = Task::with('partner','client')->get();
        // dd($tasks);

        $partners = Partner::get();
        $clients = Client::get();
        $applications = Application::with('partner','product')->get();

        $users = User::with('office')->get();

        return view('backend.tasks.task-list', [
            'users' => $users,
            'tasks' => $tasks,
            'clients' => $clients,
            'partners' => $partners,
            'applications' => $applications,
            'taskCategories' => $taskCategories,
            'priorityCategories' => $priorityCategories,
        ]);
    }
    protected function taskImageUpload($request){
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
    public function taskCreate(Request $request)
    {
        // echo 11; die();

        $request->validate([
          'title'    => 'required',
          'category_id'   => 'required',
        ]);
        // echo "<pre>"; print_r($_POST); die();

        $task = new Task();
        $task->title = $request->title;
        $task->category_id = $request->category_id;
        $task->assigee_id = $request->assigee_id;
        $task->priority_id = $request->priority_id;
        $task->due_date = $request->due_date;
        $task->description = $request->description;

        if($request->related == 1){
            $task->contact_id = $request->contact_id;
        }else if($request->related == 2){
            $task->partner_id = $request->partner_id;
        }else if($request->related == 3){
            $task->client_id = $request->client_id;
            $task->application_id = $request->application_id;
            $task->stage_id = $request->stage_id;
        }else if($request->related == 4){
        }
        $task->related = $request->related;
        
        if($request->file('attachment')){
            $imageUrl = $this->taskImageUpload($request);
            $task->attachment = $imageUrl;
        }

        $task->follower_id = $request->follower_id;   
        $task->status = 1;   
        $task->save();

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function taskEdit(Request $request){
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
    public function taskUpdate(Request $request)
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
            $imageUrl = $this->taskImageUpload($request);
            // echo "<pre>"; print_r($imageUrl); die();
            $this->taskBasicInfoUpdate($request, $task, $imageUrl);
        }else{
            $this->taskBasicInfoUpdate($request, $task);
        }

        return response()->json(['success'=>'Record is successfully added']);
    }
    public function taskDelete($id)
    {
        // echo $id; die();
        Task::where('id', $id)->delete();
        return redirect('admin/task/list')->with('success', 'Task has been deleted successfully !!');
    }
    public function clientApplicationInfo(Request $request)
    {
        $applications = Application::with('partner','product')->where('client_id', $request->client_id)->get();
        echo json_encode($applications);
    }
}
