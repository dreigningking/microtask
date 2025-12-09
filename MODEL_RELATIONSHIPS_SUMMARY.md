# Database Model Relationships Implementation Summary

This document summarizes all the relationships implemented across the Laravel models based on the database migrations.

## 1. Basic BelongsTo and HasMany Relationships

### User Model
- `user->country()` - User belongs to Country
- `user->state()` - User belongs to State  
- `user->city()` - User belongs to City
- `user->bankAccount()` - User has one BankAccount
- `user->tasks()` - User has many Tasks
- `user->taskWorkers()` - User has many TaskWorkers
- `user->taskSubmissions()` - User has many TaskSubmissions
- `user->referrals()` - User has many Referrals
- `user->settlements()` - User has many Settlements
- `user->wallets()` - User has many Wallets
- `user->subscriptions()` - User has many Subscriptions
- `user->loginActivities()` - User has many LoginActivities
- `user->posts()` - User has many Posts
- `user->announcements()` - User has many Announcements
- `user->loginActivities()` - User has many LoginActivities
- `user->carts()` - User has many Carts
- `user->orders()` - User has many Orders
- `user->payments()` - User has many Payments
- `user->withdrawals()` - User has many Withdrawals
- `user->taskPromotions()` - User has many TaskPromotions
- `user->supports()` - User has many Supports
- `user->preferredLocations()` - User has many PreferredLocations
- `user->userVerifications()` - User has many UserVerifications
- `user->withdrawals()` - User has many Withdrawals

### Task Model  
- `task->user()` - Task belongs to User
- `task->platform()` - Task belongs to Platform
- `task->platformTemplate()` - Task belongs to PlatformTemplate
- `task->taskWorkers()` - Task has many TaskWorkers
- `task->taskSubmissions()` - Task has many TaskSubmissions
- `task->taskPromotions()` - Task has many TaskPromotions
- `task->referrals()` - Task has many Referrals

### Comment Model
- `comment->user()` - Comment belongs to User
- `comment->parent()` - Comment belongs to Comment (self-referential for nesting)
- `comment->children()` - Comment has many Comments (replies)

### Moderation Model
- `moderation->moderator()` - Moderation belongs to User (moderator)
- `moderation->moderatable()` - Moderation morphTo (polymorphic)

### Post Model
- `post->category()` - Post belongs to Category
- `post->user()` - Post belongs to User

## 2. Many-to-Many Relationships

### User Model
- `user->roles()` - User belongsToMany Role (via 'role_user' table)
- `user->preferredPlatforms()` - User belongsToMany Platform (via 'preferred_platforms' table)
- `user->blockedUsers()` - User belongsToMany User (via 'blocklists' table as blocker)
- `user->blockedByUsers()` - User belongsToMany User (via 'blocklists' table as blocked)

### Platform Model
- `platform->preferredByUsers()` - Platform belongsToMany User (via 'preferred_platforms' table)

### Category Model
- `category->posts()` - Category hasMany Post

### Tag Model
- `tag->posts()` - Tag belongsToMany Post (via 'post_tag' table)

### Role Model
- `role->permissions()` - Role belongsToMany Permission (via 'permission_role' table)
- `role->users()` - Role belongsToMany User (via 'role_user' table)

### Permission Model
- `permission->roles()` - Permission belongsToMany Role (via 'permission_role' table)

## 3. Polymorphic Relationships

### Comments (supports commentable)
- `comment->commentable()` - Comment morphTo (can belong to: Support, Post, Task, Dispute, UserVerification)

### Moderations (moderatable)
- `moderation->moderatable()` - Moderation morphTo (can belong to: UserVerification, Task, Withdrawal, Post, Comment)

### Notifications
- `user->notifications()` - User morphMany \Illuminate\Notifications\DatabaseNotification

### Country Prices (priceable)
- `countryPrice->priceable()` - CountryPrice morphTo (can belong to: Booster, PlatformTemplate)

### Order Items (orderable)
- `orderItem->orderable()` - OrderItem morphTo (can belong to: Task, Promotion, Subscription)

## 4. HasOneThrough and HasManyThrough Relationships

These relationships are typically used when you want to access a model through an intermediate model. Based on the current migration structure, here are potential candidates:

### Potential HasOneThrough Relationships:
- `user->countrySettings()` - User hasOneThrough CountrySetting via Country
- `user->countryPrices()` - User hasManyThrough CountryPrice via Country

### Potential HasManyThrough Relationships:
- `platform->countryPrices()` - Platform hasManyThrough CountryPrice via PlatformTemplate
- `user->activeSubscriptions()` - User hasManyThrough Booster via Subscription
- `country->users()` - Country hasManyThrough User via Location (if needed)

*Note: These are potential relationships that could be implemented if needed for specific use cases. Currently, the models use traditional relationships or JSON fields for configuration data.*

## 5. Self-Referential Relationships

### User Model
- `user->bannedBy()` - User belongsTo User (self-referential for who banned the user)
- `user->bannedUsers()` - User hasMany User (users banned by this user)

### Comment Model  
- `comment->parent()` - Comment belongsTo Comment (parent comment for nested comments)
- `comment->children()` - Comment hasMany Comment (replies to comment)

## 6. Complex Relationship Patterns

### Task-Worker-Submission Chain
- `task->taskWorkers()` - Task hasMany TaskWorker
- `taskWorker->taskSubmissions()` - TaskWorker hasMany TaskSubmission
- `taskSubmission->taskDispute()` - TaskSubmission hasOne TaskDispute
- `taskDispute->trails()` - TaskDispute hasMany Trail

### Order-Payment-Fulfillment Chain  
- `order->orderItems()` - Order hasMany OrderItem
- `order->payment()` - Order hasOne Payment
- `orderItem->orderable()` - OrderItem morphTo (links to Task/Promotion/Subscription)

### User-Preference Chain
- `user->preferredPlatforms()` - User belongsToMany Platform
- `user->preferredLocations()` - User hasMany PreferredLocation

## 7. Key Implementation Notes

### Foreign Key Naming Patterns
- All models follow Laravel naming conventions for foreign keys
- Models use proper `belongsTo()`, `hasMany()`, `belongsToMany()`, and `morphTo()` relationships

### Polymorphic Relationship Types
- **Comments**: Supports multiple entities (Support, Post, Task, Dispute, UserVerification)
- **Moderations**: Handles approval workflows for multiple content types
- **Notifications**: Built-in Laravel notification system integration
- **Pricing**: Supports pricing for multiple entity types
- **Order Items**: Handles multiple purchase types

### Many-to-Many Table Names
- **roles**: Uses 'role_user' for User-Role relationship
- **permissions**: Uses 'permission_role' for Role-Permission relationship  
- **preferred_platforms**: Uses 'preferred_platforms' for User-Platform relationship
- **post_tags**: Uses 'post_tag' for Post-Tag relationship
- **blocklists**: Uses 'blocklists' for User-User blocking relationship

### Relationship Scopes Added
- Scopes for filtering by status, type, country, platform, etc.
- Utility methods for checking relationship states
- Helper methods for common relationship queries

## 8. Models Updated

The following models were updated with comprehensive relationships:

1. **User** - Core user model with all major relationships
2. **Moderation** - Polymorphic moderation relationships  
3. **Comment** - Polymorphic comments with nesting support
4. **TaskDispute** - Dispute resolution workflow relationships
5. **TaskDisputeTrail** - Dispute trail tracking relationships
6. **CountrySetting** - Country-specific configuration relationships
7. **Blocklist** - User blocking relationships
8. **TaskSubmission** - Task completion workflow relationships
9. **Announcement** - Announcement sender relationships
10. **CountryPrice** - Polymorphic pricing relationships
11. **Cart** - Shopping cart relationships
12. **Order** - Order management relationships
13. **OrderItem** - Polymorphic order item relationships
14. **Payment** - Payment processing relationships
15. **Post** - Blog post relationships with comments and moderation
16. **Platform** - Platform management relationships
17. **PlatformTemplate** - Template pricing and task relationships

## 9. Clarifications Needed

1. **Country Model**: The migrations reference `country_id` but no Country model was provided. You may need to create a Country model with relationships to CountrySetting and CountryPrice.

2. **Location Models**: Similar to Country, you may need State and City models if you want to use proper relationships instead of just storing IDs.

3. **Skill Model**: Referenced in User imports but not defined in migrations.

4. **HasOneThrough**: Not implemented yet as they may not be needed for the current use case. Can be added if specific requirements emerge.

5. **Role-User Relationship**: Currently using 'role_user' table, but check if your migrations match this exact table name.

All relationships are now properly implemented based on the database migration structure provided.