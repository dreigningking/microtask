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



class TaskManage extends Component
{
    use WithFileUploads, WithPagination;

    public Task $task;
    public $search;
    public $commentResponses = [];


    public function mount(Task $task)
    {
        $this->task = $task->load([
            'user.country',
            'platform',
            'platformTemplate',
            'promotions',
            'taskSubmissions.task_worker.user',
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

    public function getWorkersQuery()
    {
        return TaskWorker::where('task_id', $this->task->id)
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->with('user');
    }

    public function render()
    {
        // Get invitees statistics

        return view('livewire.tasks.task-manage', []);
    }
}
