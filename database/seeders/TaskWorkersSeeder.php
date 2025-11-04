<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskWorker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskWorkersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get tasks and users
        $tasks = Task::take(5)->get();
        $users = User::whereNotNull('email_verified_at')->get();

        // If no users exist, create some sample users
        
        $sampleUsers = [
            [
                'name' => 'Sarah Johnson',
                'username' => 'sarah-johnson',
                'email' => 'sarah@wonegig.com',
                'password' => bcrypt('12345678'),
                'country_id' => '233', // USA
                'email_verified_at' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'Michael Chen',
                'username' => 'michael-chen',
                'email' => 'michael@wonegig.com',
                'password' => bcrypt('12345678'),
                'country_id' => '39', // Canada
                'email_verified_at' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'Emma Williams',
                'username' => 'emma-williams',
                'email' => 'emma@wonegig.com',
                'password' => bcrypt('12345678'),
                'country_id' => '232', // UK
                'email_verified_at' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'James Okafor',
                'username' => 'james-okafor',
                'email' => 'james@wonegig.com',
                'password' => bcrypt('12345678'),
                'country_id' => '161', // Nigeria
                'email_verified_at' => now(),
                'is_active' => true,
            ],
            [
                'name' => 'Priya Patel',
                'username' => 'priya-patel',
                'email' => 'priya@wonegig.com',
                'password' => bcrypt('12345678'),
                'country_id' => '101', // India
                'email_verified_at' => now(),
                'is_active' => true,
            ],
        ];

        foreach ($sampleUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
        
        $users = User::whereNotNull('email_verified_at')->take(10)->get();

        // Create task worker relationships
        $taskWorkers = [
            // Worker 1 working on task 1
            [
                'task_id' => $tasks->isNotEmpty() ? $tasks->first()->id : 1,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'Successfully completed the Facebook post creation task. The content was engaging and met all requirements.',
                'worker_rating' => 5,
            ],
            [
                'task_id' => $tasks->isNotEmpty() ? $tasks->first()->id : 1,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'Good job on the Facebook engagement. Professional approach.',
                'worker_rating' => 4,
            ],
            // Worker 2 working on task 2
            [
                'task_id' => $tasks->count() > 1 ? $tasks->get(1)->id : 2,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'Completed Twitter engagement tasks efficiently. High-quality interactions.',
                'worker_rating' => 5,
            ],
            [
                'task_id' => $tasks->count() > 1 ? $tasks->get(1)->id : 2,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'Met all Twitter engagement requirements. Professional service.',
                'worker_rating' => 4,
            ],
            // Worker 3 working on task 3
            [
                'task_id' => $tasks->count() > 2 ? $tasks->get(2)->id : 3,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'Instagram story engagement completed successfully. Great attention to detail.',
                'worker_rating' => 5,
            ],
            // Worker 4 working on task 4
            [
                'task_id' => $tasks->count() > 3 ? $tasks->get(3)->id : 4,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'Watched the full YouTube video and provided meaningful engagement.',
                'worker_rating' => 4,
            ],
            [
                'task_id' => $tasks->count() > 3 ? $tasks->get(3)->id : 4,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'Excellent YouTube engagement. Subscribed and left helpful comment.',
                'worker_rating' => 5,
            ],
            // Worker 5 working on task 5
            [
                'task_id' => $tasks->count() > 4 ? $tasks->get(4)->id : 5,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'LinkedIn post creation was professional and well-crafted.',
                'worker_rating' => 5,
            ],
            // Additional workers for different tasks
            [
                'task_id' => $tasks->count() > 0 ? $tasks->first()->id : 1,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'Fast completion of Facebook page task. Quality work.',
                'worker_rating' => 4,
            ],
            [
                'task_id' => $tasks->count() > 1 ? $tasks->get(1)->id : 2,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'Twitter retweet and comment task completed effectively.',
                'worker_rating' => 4,
            ],
            [
                'task_id' => $tasks->count() > 2 ? $tasks->get(2)->id : 3,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'Instagram post creation showed creativity and professionalism.',
                'worker_rating' => 5,
            ],
            [
                'task_id' => $tasks->count() > 3 ? $tasks->get(3)->id : 4,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'YouTube watch and engagement task done perfectly.',
                'worker_rating' => 5,
            ],
            [
                'task_id' => $tasks->count() > 4 ? $tasks->get(4)->id : 5,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : 1,
                'worker_review' => 'LinkedIn professional post exceeded expectations.',
                'worker_rating' => 5,
            ],
        ];

        foreach ($taskWorkers as $taskWorkerData) {
            TaskWorker::updateOrCreate(
                [
                    'task_id' => $taskWorkerData['task_id'],
                    'user_id' => $taskWorkerData['user_id'],
                ],
                [
                    'worker_review' => $taskWorkerData['worker_review'],
                    'worker_rating' => $taskWorkerData['worker_rating'],
                ]
            );
        }

        $this->command->info('Task workers seeded successfully.');
    }
}
