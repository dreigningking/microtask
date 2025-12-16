<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use App\Models\Booster;
use App\Models\Country;
use App\Models\Gateway;
use App\Models\Setting;
use App\Models\Platform;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PlatformTemplate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $staff = User::whereNotNull('role_id')->with('role')->get();
        $countries = Country::all();
        $gateways = Gateway::orderBy('name')->get();
        return view('backend.settings.index', compact('settings', 'roles', 'permissions', 'staff','countries', 'gateways'));
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
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
        ]);
        $role = Role::create(['name' => $data['name']]);
        if (!empty($data['permissions'])) {
            $role->permissions()->sync($data['permissions']);
        }
        return back()->with('success', 'Role created successfully.');
    }

    public function updateRole(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);
        $role->update(['name' => $data['name']]);
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
        $templates = PlatformTemplate::orderBy('name','asc')->get();
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
        $template = new PlatformTemplate();
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
        $template = PlatformTemplate::findOrFail($request->id);
        
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
        $template = PlatformTemplate::findOrFail($request->id);
        
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
            'minimum_duration_days' => 'required|numeric|min:1',
            'max_multiplier' => 'required|numeric|min:1',
        ]);

        $booster = new Booster();
        $booster->name = $request->name;
        $booster->description = $request->description;
        $booster->minimum_duration_days = $request->minimum_duration_days;
        $booster->max_multiplier = $request->max_multiplier;
        $booster->is_active = $request->has('is_active') ? true : false;
        $booster->save();

        return redirect()->back()->with('success', 'Booster created successfully.');
    }

    public function update_boosters(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:boosters,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'minimum_duration_days' => 'required|numeric|min:1',
            'max_multiplier' => 'required|numeric|min:1',
        ]);

        $booster = Booster::findOrFail($request->id);
        $booster->name = $request->name;
        $booster->description = $request->description;
        $booster->minimum_duration_days = $request->minimum_duration_days;
        $booster->max_multiplier = $request->max_multiplier;
        $booster->is_active = $request->has('is_active') ? true : false;
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
        $user->role_id = $data['role_id'];
        $user->save();

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
        $user->role_id = $data['role_id'];
        $user->save();
      

        return back()->with('success', 'Staff member updated successfully.');
    }

    /**
     * Delete a staff user.
     */
    public function staffDestroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Staff member deleted successfully.');
    }

    /**
     * Store a new gateway.
     */
    public function gatewayStore(Request $request)
    {
        
        // Validate main fields first
        $request->validate([
            'name' => 'required|string|max:255',
            'bank_account_storage' => 'required|in:on_premises,off_premises',
        ]);

        // Re-index banking fields to ensure sequential indices
        $bankingFields = [];
        if ($request->has('banking_fields') && is_array($request->banking_fields)) {
            $bankingFields = array_values($request->banking_fields);
        }

        // Validate banking fields separately
        $bankingValidator = Validator::make(['banking_fields' => $bankingFields], [
            'banking_fields' => 'nullable|array',
            'banking_fields.*.title' => 'required|string|max:255',
            'banking_fields.*.slug' => 'required|string|max:255',
            'banking_fields.*.type' => 'required|in:text,number,email,tel,select',
            'banking_fields.*.min_length' => 'nullable|integer|min:1',
            'banking_fields.*.max_length' => 'nullable|integer|min:1',
            'banking_fields.*.placeholder' => 'nullable|string|max:255',
            'banking_fields.*.default' => 'nullable|string|max:255',
        ]);

        if($bankingValidator->fails()){
            return back()->withErrors($bankingValidator)->withInput();
        }

        $gateway = new Gateway();
        $gateway->name = $request->name;
        $gateway->bank_account_storage = $request->bank_account_storage;
        $gateway->banking_fields = $bankingFields;
        $gateway->save();

        return back()->with('success', 'Gateway created successfully.');
    }

    /**
     * Update an existing gateway.
     */
    public function gatewayUpdate(Request $request, Gateway $gateway)
    {
        // Validate main fields first
        $request->validate([
            'name' => 'required|string|max:255',
            'bank_account_storage' => 'required|in:on_premises,off_premises',
        ]);

        // Re-index banking fields to ensure sequential indices
        $bankingFields = [];
        if ($request->has('banking_fields') && is_array($request->banking_fields)) {
            $bankingFields = array_values($request->banking_fields);
        }

        // Validate banking fields separately
        $bankingValidator = Validator::make(['banking_fields' => $bankingFields], [
            'banking_fields' => 'nullable|array',
            'banking_fields.*.title' => 'required|string|max:255',
            'banking_fields.*.slug' => 'required|string|max:255',
            'banking_fields.*.type' => 'required|in:text,number,email,tel,select',
            'banking_fields.*.min_length' => 'nullable|integer|min:1',
            'banking_fields.*.max_length' => 'nullable|integer|min:1',
            'banking_fields.*.placeholder' => 'nullable|string|max:255',
            'banking_fields.*.default' => 'nullable|string|max:255',
        ]);

        if($bankingValidator->fails()){
            return back()->withErrors($bankingValidator)->withInput();
        }

        $gateway->name = $request->name;
        $gateway->bank_account_storage = $request->bank_account_storage;
        $gateway->banking_fields = $bankingFields;
        $gateway->save();

        return back()->with('success', 'Gateway updated successfully.');
    }

    /**
     * Delete a gateway.
     */
    public function gatewayDestroy(Gateway $gateway)
    {
        // Check if gateway is being used by any countries
        if ($gateway->countries()->count() > 0) {
            return back()->with('error', 'Cannot delete gateway. It is being used by ' . $gateway->countries()->count() . ' countries.');
        }

        $gateway->delete();
        return back()->with('success', 'Gateway deleted successfully.');
    }
}
