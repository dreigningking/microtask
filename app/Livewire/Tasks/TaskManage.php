<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Comment;
use Livewire\Component;
use App\Models\TaskWorker;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\TaskSubmission;
use Illuminate\Support\Facades\Auth;
use App\Models\Task as TaskModel;



class TaskManage extends Component
{
    use WithFileUploads, WithPagination;

    public Task $task;
    public $search;
    public $commentResponses = [];
    public $activeTab = 'pending';


    public function mount(Task $task)
    {
        $this->task = $task->load([
            'user.country',
            'platform',
            'platformTemplate',
            'promotions',
            'taskSubmissions.taskWorker.user',
            'comments.user',
            'disputes'
        ]);
        $this->loadComments();
    }

    private function loadComments()
    {
        $this->task->load(['comments' => function($q) {
            $q->where('is_flag', false)->whereNull('parent_id')->with(['user', 'children.user'])->orderBy('created_at', 'desc');
        }]);
    }

    public function respondToComment($commentId)
    {
        if (!Auth::check() || Auth::id() != $this->task->user_id) {
            session()->flash('error', 'You are not authorized to answer this question.');
            return;
        }
        $this->validate([
            'commentResponses.' . $commentId => 'required|min:10|max:2000'
        ]);
        $comment = Comment::find($commentId);
        if (!$comment || $comment->commentable_id != $this->task->id) {
            session()->flash('error', 'Question not found.');
            return;
        }


        Comment::create([
            'user_id'=> Auth::id(),
            'commentable_id'=> $this->task->id,
            'commentable_type'=> get_class($this->task),
            'parent_id'=> $commentId,
            'body'=> $this->commentResponses[$commentId]
        ]);

        session()->flash('success', 'Answer submitted successfully.');
        unset($this->commentResponses[$commentId]);
        $this->loadComments();
    }


    public function getPendingSubmissionsProperty()
    {
        return TaskSubmission::where('task_id', $this->task->id)
            ->whereNull('reviewed_at')
            ->with('taskWorker.user')
            ->paginate(10, ['*'], 'pendingPage');
    }

    public function getApprovedSubmissionsProperty()
    {
        return TaskSubmission::where('task_id', $this->task->id)
            ->where('accepted', true)
            ->with('taskWorker.user')
            ->paginate(10, ['*'], 'approvedPage');
    }

    public function getRejectedSubmissionsProperty()
    {
        return TaskSubmission::where('task_id', $this->task->id)
            ->where('accepted', false)
            ->whereDoesntHave('dispute')
            ->with('taskWorker.user')
            ->paginate(10, ['*'], 'rejectedPage');
    }

    public function getDisputedSubmissionsProperty()
    {
        return TaskSubmission::where('task_id', $this->task->id)
            ->whereHas('dispute', function($q) {
                $q->whereNull('resolved_at');
            })
            ->with('taskWorker.user', 'dispute')
            ->paginate(10, ['*'], 'disputedPage');
    }

    public function getTaskCommentsProperty()
    {
        return Comment::where('commentable_type', TaskModel::class)
            ->where('commentable_id', $this->task->id)
            ->where('is_flag', false)
            ->whereNull('parent_id')
            ->with(['user', 'children.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'commentsPage');
    }

    public function render()
    {
        return view('livewire.tasks.task-manage', [
            'pendingSubmissions' => $this->pendingSubmissions,
            'approvedSubmissions' => $this->approvedSubmissions,
            'rejectedSubmissions' => $this->rejectedSubmissions,
            'disputedSubmissions' => $this->disputedSubmissions,
            'taskComments' => $this->taskComments,
            'pendingCount' => TaskSubmission::where('task_id', $this->task->id)->whereNull('reviewed_at')->count(),
            'approvedCount' => TaskSubmission::where('task_id', $this->task->id)->where('accepted', true)->count(),
            'rejectedCount' => TaskSubmission::where('task_id', $this->task->id)->whereNotNull('reviewed_at')->where('accepted', false)->whereDoesntHave('dispute')->count(),
            'disputedCount' => TaskSubmission::where('task_id', $this->task->id)->whereHas('dispute', function($q) { $q->whereNull('resolved_at'); })->count(),
            'commentsCount' => Comment::where('commentable_type', TaskModel::class)->where('commentable_id', $this->task->id)->where('is_flag', false)->whereNull('parent_id')->count(),
        ]);
    }
}
