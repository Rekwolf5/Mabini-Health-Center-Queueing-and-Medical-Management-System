# 🔧 Troubleshoot Form Issues

## Step 1: Check Laravel Logs
Open terminal and run:
\`\`\`bash
tail -f storage/logs/laravel.log
\`\`\`
Keep this running and try to submit a form. You'll see exactly what's happening.

## Step 2: Check Browser Network Tab
1. Open browser (F12)
2. Go to Network tab
3. Submit form
4. Look for the POST request
5. Check if it shows:
   - ✅ Status 200 (success)
   - ❌ Status 500 (server error)
   - ❌ Status 422 (validation error)

## Step 3: Test Simple Form
Try this minimal test - create a file `test-form.blade.php`:

\`\`\`html
<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <form action="{{ route('patients.store') }}" method="POST">
        @csrf
        <input type="text" name="first_name" value="John" required>
        <input type="text" name="last_name" value="Doe" required>
        <input type="number" name="age" value="30" required>
        <select name="gender" required>
            <option value="male">Male</option>
        </select>
        <input type="text" name="contact" value="123456789" required>
        <textarea name="address" required>Test Address</textarea>
        <button type="submit">Save</button>
    </form>
</body>
</html>
\`\`\`

## Step 4: Check These Common Issues

### ❌ **CSRF Token Problem**
Check if this meta tag exists in your layout:
\`\`\`html
<meta name="csrf-token" content="{{ csrf_token() }}">
\`\`\`

### ❌ **Route Problem**
Check routes:
\`\`\`bash
php artisan route:list | grep patients
\`\`\`

### ❌ **Middleware Problem**
Check if auth middleware is blocking:
\`\`\`bash
php artisan route:list --name=patients.store
\`\`\`

### ❌ **Database Problem**
Test database:
\`\`\`bash
php artisan migrate:status
\`\`\`

## Step 5: Quick Fixes

### Clear Everything:
\`\`\`bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
\`\`\`

### Check Permissions:
\`\`\`bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
\`\`\`

## What to Look For:

1. **In Laravel logs:** Look for errors, validation failures, or database issues
2. **In browser network:** Check if form is actually submitting
3. **In browser console:** Look for JavaScript errors

Try these steps and let me know what you find in the logs!
