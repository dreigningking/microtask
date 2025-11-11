<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Moderation;
use App\Notifications\General\Comments\TaskCommentNotification;
use App\Notifications\General\Comments\DisputeCommentNotification;
use App\Notifications\General\Comments\SupportCommentNotification;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        switch($comment->commentable_type){
            case('App\Models\Task'):
                //if is_flag is true, notify admin
                if($comment->is_flag){
                    if($comment->user->role_id){
                        $comment->commentable->user->notify(new TaskCommentNotification($comment,'author',true));
                    }else{
                        $this->getAdmin()->notify(new TaskCommentNotification($comment,'admin',true));
                    }  
                }elseif(!$comment->parent_id){
                    $comment->commentable->user->notify(new TaskCommentNotification($comment,'author'));
                }else{
                    $comment->parent->user->notify(new TaskCommentNotification($comment,'parent'));
                }
            break;        
            
            case('App\Models\Post'):
                Moderation::create(['moderatable_type'=> get_class($comment),'moderatable_id'=> $comment->id,
                    'purpose'=> 'created_post_comment','status'=> 'pending']);
            break;

            case('App\Models\Support'):
                if($comment->commentable->user_id == $comment->user_id){
                    $this->getAdmin()->notify(new SupportCommentNotification($comment));
                }
                if($comment->commentable->user_id != $comment->user_id){
                    $comment->user->notify(new SupportCommentNotification($comment));
                }
            break;

            case('App\Models\Dispute'):
                if($comment->user->role_id){
                    $comment->commentable->taskSubmission->task->user->notify(new DisputeCommentNotification($comment,'admin'));
                    $comment->commentable->taskSubmission->user->notify(new DisputeCommentNotification($comment,'admin'));
                }elseif($comment->commentable->taskSubmission->user_id == $comment->user_id){
                    $this->getAdmin()->notify(new DisputeCommentNotification($comment,'worker'));
                    $comment->commentable->taskSubmission->task->user->notify(new DisputeCommentNotification($comment,'worker'));
                }else{
                    $this->getAdmin()->notify(new DisputeCommentNotification($comment,'author'));
                    $comment->commentable->taskSubmission->user->notify(new DisputeCommentNotification($comment,'author'));
                }
            break;
        }
        

    }

    public function getAdmin(){
        return User::where('role_id',1)->first();
    }

    /**
     * Handle the Comment "updated" event.
     */
    public function updated(Comment $comment): void
    {
        
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "restored" event.
     */
    public function restored(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     */
    public function forceDeleted(Comment $comment): void
    {
        //
    }
}
