# Admin Announcement System

This system allows administrators to send announcements to all users on the Wonegig platform.

## Features

- **Send Announcements**: Admins can compose and send messages to all active users
- **Email Notifications**: Users receive announcements via email
- **Database Storage**: All announcements are stored with metadata
- **History Tracking**: View all previously sent announcements
- **Permission Control**: Only users with `system_settings` permission can access

## Components

### 1. AnnouncementController
- **Location**: `app/Http/Controllers/AnnouncementController.php`
- **Methods**:
  - `index()`: Shows announcement form and history
  - `send()`: Processes and sends announcements

### 2. AnnouncementNotification
- **Location**: `app/Notifications/AnnouncementNotification.php`
- **Channels**: Email and database notifications
- **Features**: Customizable subject and message content

### 3. Announcement Model
- **Location**: `app/Models/Announcement.php`
- **Fields**: subject, message, sent_by, recipients_count, status, timestamps
- **Relationships**: Belongs to User (sender)

### 4. Database Migration
- **File**: `database/migrations/2025_08_15_101414_create_announcements_table.php`
- **Features**: Foreign key constraints, indexes for performance

### 5. Admin Interface
- **View**: `resources/views/backend/announcements.blade.php`
- **Features**: Form validation, character counter, announcement history table

## Routes

```php
// Admin announcement routes
Route::group(['prefix' => 'announcements', 'as' => 'announcements.', 'middleware' => ['permission:system_settings']], function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('index');
    Route::post('send', [AnnouncementController::class, 'send'])->name('send');
});
```

## Usage

### For Administrators

1. **Access**: Navigate to Admin Dashboard → Settings → Announcements
2. **Compose**: Fill in subject and message (max 5000 characters)
3. **Send**: Click "Send Announcement" button
4. **Confirm**: Confirm the action in the popup dialog

### For Users

- Users receive announcements via email
- Notifications are stored in the database
- Users can view notifications in their dashboard

## Security Features

- **Permission Check**: Only users with `system_settings` permission can access
- **Input Validation**: Subject and message are validated
- **Confirmation Dialog**: Prevents accidental sending
- **Error Handling**: Graceful failure handling with status tracking

## Configuration

### Mail Settings
Ensure your `.env` file has proper mail configuration:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@wonegig.com
MAIL_FROM_NAME="Wonegig"
```

### Database
Run the migration to create the announcements table:
```bash
php artisan migrate
```

## Customization

### Notification Content
Edit `app/Notifications/AnnouncementNotification.php` to customize:
- Email template
- Subject line format
- Action button text
- Additional notification channels

### View Styling
Modify `resources/views/backend/announcements.blade.php` to:
- Change form layout
- Modify table columns
- Add additional features

## Troubleshooting

### Common Issues

1. **Emails not sending**: Check mail configuration in `.env`
2. **Permission denied**: Ensure user has `system_settings` permission
3. **Database errors**: Run `php artisan migrate` to create table

### Testing

Test the system by:
1. Creating a test announcement
2. Checking email delivery
3. Verifying database records
4. Testing permission restrictions

## Future Enhancements

Potential improvements:
- **Scheduled Announcements**: Send at specific times
- **Targeted Groups**: Send to specific user segments
- **Rich Content**: Support for HTML/markdown
- **Analytics**: Track open rates and engagement
- **Templates**: Pre-defined announcement templates
