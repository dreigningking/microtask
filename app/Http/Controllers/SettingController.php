<?php

namespace App\Http\Controllers;

use App\Models\Booster;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\Country;
use App\Models\Setting;
use App\Models\Platform;
use App\Models\Permission;
use Illuminate\Support\Str;
use App\Models\TaskTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::all();
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        // Load users who have at least one role
        $staff = User::whereHas('roles')->with('roles')->get();
        $countries = Country::all();
        return view('backend.settings.index', compact('settings', 'roles', 'permissions', 'staff','countries'));
    }

    /**
     * Save core system settings
     */
    public function saveCoreSettings(Request $request)
    {
        
        $fields = [
            'enable_system_review' => 'boolean',
            'freeze_wallets_globally' => 'boolean',
            'allow_wallet_funds_exchange' => 'boolean',
            'job_invite_expiry' => 'integer|min:1',
            'enforce_2fa' => 'boolean',
            'allow_public_profile' => 'boolean',
            'free_user_task_limit' => 'integer|min:1',
            'submission_review_deadline' => 'integer|min:1',
            'blog_categories' => 'array',
        ];
        $data = $request->validate($fields);
        foreach ($fields as $name => $type) {
            $value = $data[$name] ?? ($type === 'boolean' ? false : null);

            // For boolean fields, store as true/false (not 1/0)
            if ($type === 'boolean') {
                $value = (bool)$value;
            }

            // For arrays, store as JSON
            if (is_array($value)) {
                $value = json_encode($value);
            }
            Setting::setValue($name, $value);
        }
        return back()->with('success', 'Core settings saved successfully.');
    }

    /**
     * Save notification settings
     */
    public function saveNotificationSettings(Request $request)
    {
        $fields = [
            'email_notifications' => 'array',
            'web_notifications' => 'array',
        ];
        $data = $request->validate($fields);
        foreach ($fields as $name => $type) {
            $value = $data[$name] ?? [];
            \App\Models\Setting::setValue($name, json_encode($value));
        }
        return back()->with('success', 'Notification settings saved successfully.');
    }

    public function storeRole(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string|unique:roles,description',
            'permissions' => 'array',
        ]);
        $role = Role::create(['description' => $data['description']]);
        if (!empty($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }
        return back()->with('success', 'Role created successfully.');
    }

    public function updateRole(Request $request, Role $role)
    {
        $data = $request->validate([
            'description' => 'required|string|unique:roles,description,' . $role->id,
            'permissions' => 'array',
        ]);
        $role->update(['description' => $data['description']]);
        $role->permissions()->sync($data['permissions'] ?? []);
        return back()->with('success', 'Role updated successfully.');
    }

    public function destroyRole(Role $role)
    {
        $role->delete();
        return back()->with('success', 'Role deleted successfully.');
    }

    public function templates()
    {
        $templates = TaskTemplate::orderBy('name','asc')->get();
        $platforms = Platform::orderBy('name','asc')->get();
        return view('backend.settings.templates', compact('templates','platforms'));
    }

    /**
     * Store a newly created template resource in storage.
     */
    public function store_templates(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'platform_id' => 'required',
            'is_active' => 'nullable|boolean'
        ]);

        // Process task fields and submission fields
        $taskFields = [];
        $submissionFields = [];

        if ($request->has('task_fields')) {
            foreach ($request->task_fields as $field) {
                if (!empty($field['title']) && !empty($field['type'])) {
                    $taskFields[] = [
                        'title' => $field['title'],
                        'name' => Str::slug($field['title'], '_'),
                        'type' => $field['type'],
                        'options' => isset($field['options']) ? $field['options'] : null,
                        'placeholder' => isset($field['placeholder']) ? $field['placeholder'] : null,
                        'required' => isset($field['required']) ? true : false
                    ];
                }
            }
        }

        if ($request->has('submission_fields')) {
            foreach ($request->submission_fields as $field) {
                if (!empty($field['title']) && !empty($field['type'])) {
                    $submissionFields[] = [
                        'title' => $field['title'],
                        'name' => Str::slug($field['title'], '_'),
                        'type' => $field['type'],
                        'options' => isset($field['options']) ? $field['options'] : null,
                        'placeholder' => isset($field['placeholder']) ? $field['placeholder'] : null,
                        'required' => isset($field['required']) ? true : false
                    ];
                }
            }
        }

        // Create new template
        $template = new TaskTemplate();
        $template->name = $request->name;
        $template->platform_id = $request->platform_id;
        $template->description = $request->description;
        $template->is_active = $request->has('is_active') ? true : false;
        $template->task_fields = $taskFields;
        $template->submission_fields = $submissionFields;
        $template->save();

        return redirect()->back()->with('success', 'Template created successfully.');
    }

    /**
     * Update the specified template in storage.
     */
    public function update_templates(Request $request)
    {
        // Find the template
        $template = TaskTemplate::findOrFail($request->id);
        
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'platform_id' => 'required',
            'is_active' => 'nullable|boolean'
        ]);

        // Process task fields and submission fields
        $taskFields = [];
        $submissionFields = [];

        if ($request->has('task_fields')) {
            foreach ($request->task_fields as $field) {
                if (!empty($field['title']) && !empty($field['type'])) {
                    $taskFields[] = [
                        'title' => $field['title'],
                        'name' => Str::slug($field['title'], '_'),
                        'type' => $field['type'],
                        'options' => isset($field['options']) ? $field['options'] : null,
                        'placeholder' => isset($field['placeholder']) ? $field['placeholder'] : null,
                        'required' => isset($field['required']) ? true : false
                    ];
                }
            }
        }

        if ($request->has('submission_fields')) {
            foreach ($request->submission_fields as $field) {
                if (!empty($field['title']) && !empty($field['type'])) {
                    $submissionFields[] = [
                        'title' => $field['title'],
                        'name' => Str::slug($field['title'], '_'),
                        'type' => $field['type'],
                        'options' => isset($field['options']) ? $field['options'] : null,
                        'placeholder' => isset($field['placeholder']) ? $field['placeholder'] : null,
                        'required' => isset($field['required']) ? true : false
                    ];
                }
            }
        }

        // Update template
        $template->name = $request->name;
        $template->description = $request->description;
        $template->platform_id = $request->platform_id;
        $template->is_active = $request->has('is_active') ? true : false;
        $template->task_fields = $taskFields;
        $template->submission_fields = $submissionFields;
        $template->save();

        return redirect()->back()->with('success', 'Template updated successfully.');
    }

    /**
     * Delete the specified template from storage.
     */
    public function destroy_templates(Request $request)
    {
        $template = TaskTemplate::findOrFail($request->id);
        
        // Check if the template is being used by any tasks
        $tasksUsingTemplate = Task::where('template_id', $template->id)->count();
        
        if ($tasksUsingTemplate > 0) {
            return redirect()->back()->with('error', 'Cannot delete template. It is being used by ' . $tasksUsingTemplate . ' task(s).');
        }
        
        $template->delete();
        
        return redirect()->back()->with('success', 'Template deleted successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function platforms()
    {
        // Get all platforms with task count
        $platforms = Platform::withCount('tasks')
            ->orderBy('name','asc')
            ->get();
            
        return view('backend.settings.platforms', compact('platforms'));
    }

    /**
     * Store a new platform in storage.
     */
    public function store_platforms(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        // Create new platform
        $platform = new Platform();
        $platform->name = $request->name;
        $platform->description = $request->description;
        $platform->is_active = $request->has('is_active') ? true : false;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('platforms', $imageName,'public');
            $platform->image = Storage::url($imagePath);
        }

        $platform->save();

        return redirect()->back()
            ->with('success', 'Platform created successfully.');
    }

    /**
     * Update the specified platform in storage.
     */
    public function update_platforms(Request $request)
    {
        // Find the platform
        $platform = Platform::findOrFail($request->id);
        
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        // Update platform
        $platform->name = $request->name;
        $platform->description = $request->description;
        $platform->is_active = $request->has('is_active') ? true : false;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($platform->image && Storage::exists(str_replace('/storage', 'public', $platform->image))) {
                Storage::delete(str_replace('/storage', 'public', $platform->image));
            }
            
            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('platforms', $imageName,'public');
            $platform->image = Storage::url($imagePath);
        }

        $platform->save();

        return redirect()->back()
            ->with('success', 'Platform updated successfully.');
    }
    
    /**
     * Delete the specified platform from storage.
     */
    public function destroy_platforms(Request $request)
    {
        $platform = Platform::findOrFail($request->id);
        
        // Delete platform image if exists
        if ($platform->image && Storage::exists(str_replace('/storage', 'public', $platform->image))) {
            Storage::delete(str_replace('/storage', 'public', $platform->image));
        }
        
        $platform->delete();
        
        return redirect()->back()
            ->with('success', 'Platform deleted successfully.');
    }

    public function boosters(){
        // Get all boosters with subscriptions count
        $boosters = Booster::withCount('subscriptions')
            ->orderBy('name','asc')
            ->get();
            
        return view('backend.settings.boosters', compact('boosters'));
    }

    public function store_boosters(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:taskmaster,worker',
            'is_active' => 'nullable|boolean',
            // type-specific validation
            'featured_promotion' => 'nullable|boolean',
            'broadcast_promotion' => 'nullable|boolean',
            'active_tasks_per_hour' => 'nullable|numeric|min:1',
            'withdrawal_maximum_multiplier' => 'nullable|numeric|min:1',
        ]);

        $booster = new Booster();
        $booster->name = $request->name;
        $booster->description = $request->description;
        $booster->type = $request->type;
        $booster->is_active = $request->has('is_active') ? true : false;

        if ($request->type === 'taskmaster') {
            $booster->featured_promotion = $request->has('featured_promotion') ? true : false;
            $booster->broadcast_promotion = $request->has('broadcast_promotion') ? true : false;
            $booster->active_tasks_per_hour = 1;
            $booster->withdrawal_maximum_multiplier = 1;
        } else {
            $booster->featured_promotion = false;
            $booster->broadcast_promotion = false;
            $booster->active_tasks_per_hour = $request->input('active_tasks_per_hour', 1);
            $booster->withdrawal_maximum_multiplier = $request->input('withdrawal_maximum_multiplier', 1);
        }
        $booster->save();

        return redirect()->back()->with('success', 'Booster created successfully.');
    }

    public function update_boosters(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:boosters,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:taskmaster,worker',
            'is_active' => 'nullable|boolean',
            // type-specific validation
            'featured_promotion' => 'nullable|boolean',
            'broadcast_promotion' => 'nullable|boolean',
            'active_tasks_per_hour' => 'nullable|numeric|min:1',
            'withdrawal_maximum_multiplier' => 'nullable|numeric|min:1',
        ]);

        $booster = Booster::findOrFail($request->id);
        $booster->name = $request->name;
        $booster->description = $request->description;
        $booster->type = $request->type;
        $booster->is_active = $request->has('is_active') ? true : false;

        if ($request->type === 'taskmaster') {
            $booster->featured_promotion = $request->has('featured_promotion') ? true : false;
            $booster->broadcast_promotion = $request->has('broadcast_promotion') ? true : false;
            $booster->active_tasks_per_hour = 1;
            $booster->withdrawal_maximum_multiplier = 1;
        } else {
            $booster->featured_promotion = false;
            $booster->broadcast_promotion = false;
            $booster->active_tasks_per_hour = $request->input('active_tasks_per_hour', 1);
            $booster->withdrawal_maximum_multiplier = $request->input('withdrawal_maximum_multiplier', 1);
        }
        $booster->save();

        return redirect()->back()->with('success', 'Booster updated successfully.');
    }

    public function destroy_boosters(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:boosters,id',
        ]);

        $booster = Booster::findOrFail($request->id);
        // Optionally, check for subscriptions and prevent delete if needed
        if ($booster->subscriptions()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete booster. It has active subscriptions.');
        }
        $booster->delete();

        return redirect()->back()->with('success', 'Booster deleted successfully.');
    }

    /**
     * Store a new staff user.
     */
    public function staffStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'country_id' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->country_id = $data['country_id'] ?? null;
        $user->is_active = $request->has('is_active') ? (bool)$data['is_active'] : true;
        $user->save();
        $user->roles()->sync([$data['role_id']]);

        return back()->with('success', 'Staff member created successfully.');
    }

    /**
     * Update an existing staff user.
     */
    public function staffUpdate(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'country_id' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->country_id = $data['country_id'] ?? null;
        $user->is_active = $request->has('is_active') ? (bool)$data['is_active'] : false;
        $user->save();
        $user->roles()->sync([$data['role_id']]);

        return back()->with('success', 'Staff member updated successfully.');
    }

    /**
     * Delete a staff user.
     */
    public function staffDestroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();
        return back()->with('success', 'Staff member deleted successfully.');
    }
}
