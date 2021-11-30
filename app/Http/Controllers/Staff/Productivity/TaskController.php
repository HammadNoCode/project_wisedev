<?php

namespace App\Http\Controllers\Staff\Productivity;

use App\Models\Staff\User\{Task, User as Staff};
use Carbon\Carbon;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\{Validator};
use App\Http\Controllers\Staff\StaffController;
use Illuminate\Notifications\Notification;

class TaskController extends StaffController
{

    public function repeat_to_carbon($repeat, $scheduled_at)
    {
        switch ((int) $repeat) {
            case 1:
                return $scheduled_at->addDay()->format('Y-m-d');
            break;
            case 2:
                return $scheduled_at->addWeek()->format('Y-m-d');
            break;
            case 3:
                return $scheduled_at->addMonth()->format('Y-m-d');
            break;
            default:
                return $scheduled_at->format('Y-m-d');
            break;
        }
    }

    public function create_task()
    {
        $form = request()->all();
        Validator::make($form, ['description' => 'required'])->validate();
        Task::insert([
         'user_id' => session('staff_id'),
         'description' => $form['description'],
         'scheduled_at' => $form['scheduled_at'] ?? null,
         'repeat' => $form['repeat'] ?? 0,
         'staff_assigned' => $form['staff_assigned'] ?? session('staff_id'),
        ]);
        return response()->json(['success' => true], 201);
    }

    public function show_staff()
    {
        $staff = Staff::where('id', '!=', 81)
         ->where('id', '!=', 82)
         ->where('id', '!=', 83)
         ->select('id', 'name')->get();
        return response()->json($staff, 200);
    }

    public function show_tasks(Request $request)
    {
        $filtered = $this->filter($request->staff);
        $user = Staff::where('id', session('staff_id'))->firstOrFail();
        if ((int) $user->manager === 1 || (int) $user->administrator === 1) {
            $tasks = Task::where('deleted', 0)->whereIn('staff_assigned', $filtered)->orWhere('staff_assigned', $user->staff_assigned)->select('*')->get();
        } else {
            $tasks = Task::where('deleted', 0)->where('staff_assigned', $user->staff_assigned)->orWhere('staff_assigned', session('staff_id'))->select('*')->get();
        }
        return response()->json([
         'today' => ['data' => (clone $tasks)->where('status', 0)->where('scheduled_at', '<', Carbon::now()->endOfDay())],
         'scheduled' => ['data' => (clone $tasks)->where('status', 0)->where('scheduled_at', '!=', null)->where('scheduled_at', '>', Carbon::now()->endOfDay())],
         'list'  => ['data' => (clone $tasks)->where('status', 0)->where('scheduled_at', null)],
         'completed' => ['data' => (clone $tasks)->where('status', 1)],
        ], 200);
    }

    public function filter($staff)
    {
        if ($staff == 0) {
            return Task::where('staff_assigned', session('staff_id'))->pluck('staff_assigned');
        }
        return Task::where('staff_assigned', $staff)->pluck('staff_assigned');
    }

    public function update_task($id)
    {
        $form = request()->all();
        Validator::make($form, ['status' => 'required'])->validate();
        $task = Task::where('staff_assigned', session('staff_id'))->where('id', $id)->firstOrFail();
        $task->update(['status' => $form['status']]);
        $task->fresh();
        if ((int) $task->status === 1 && $task->repeat != 0) {
            if (!Task::where('user_id', session('staff_id'))->where('description', $task->description)->where('scheduled_at', $this->repeat_to_carbon($task->repeat, $task->scheduled_at))->exists()) {
                Task::insert([
                 'user_id' => session('staff_id'),
                 'description' => $task->description,
                 'scheduled_at' => $this->repeat_to_carbon($task->repeat, $task->scheduled_at),
                 'repeat' => $task->repeat,
                 'staff_assigned' => session('staff_id'),

                ]);
            }
        }
        return response()->json(['success' => true], 200);
    }

    public function delete_task($id)
    {
        Task::where('staff_assigned', session('staff_id'))->where('id', $id)->firstOrFail()->delete();
        return response()->json(['success' => true], 200);
    }

    public function check_todays_scheduled()
    {
        $tasks = Task::where('deleted', 0)->where('status', 0)->where('scheduled_at', '<', Carbon::now()->endOfDay())->groupBy('user_id')->selectRaw('count(*) as total, user_id')->get();
        foreach ($tasks as $task) {
            (new Task())->createNotification($task->user_id, 1, "You have {$task->total} tasks due for completion today, click to view them.", '/productivity/tasks', 1);
        }
    }
}
