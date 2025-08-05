<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Line Numbers Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/css/textarea-linenumbers.css') }}" rel="stylesheet" />
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        
        .w-5 {
            width: 1.25rem;
        }
        
        .h-5 {
            height: 1.25rem;
        }
        
        .w-10 {
            width: 2.5rem;
        }
        
        .h-10 {
            height: 2.5rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Line Numbers Test</h1>
        
        <div class="mb-4">
            <label for="description-editor" class="form-label fw-medium mb-1">Write step by step instructions on what to do<span class="text-danger">*</span></label>
            <div class="linenumbered-textarea">
                <div class="line-numbers"></div>
                <textarea id="description-editor" rows="4" class="form-control" placeholder="Provide a detailed description of the job. Include specific tasks, goals, and any special instructions.">This is line 1
This is line 2
This is line 3 with more content to test wrapping
This is line 4</textarea>
                <input type="hidden" id="description-hidden">
            </div>
        </div>
        
        <div class="alert alert-info">
            <h5>Test Instructions:</h5>
            <ul>
                <li>Type in the textarea above to see line numbers appear</li>
                <li>Press Enter to create new lines</li>
                <li>Delete content to see line numbers update</li>
                <li>Check the browser console for any errors</li>
            </ul>
        </div>
    </div>

    <script src="{{ asset('frontend/js/textarea-linenumbers.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing line numbers...');
            if (typeof window.initLineNumberedTextareas === 'function') {
                window.initLineNumberedTextareas();
                console.log('Line numbers initialized');
            } else {
                console.error('initLineNumberedTextareas function not found');
            }
        });
    </script>
</body>
</html> 