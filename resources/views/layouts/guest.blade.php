<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Planet Library') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f4f7fb; /* Light soft background from your Figma */
            font-family: 'Inter', sans-serif; /* Standard modern font */
        }
        
        /* Figma Input Styling */
        .figma-input {
            background-color: #eff4ff; /* Very light blue */
            border: 1px solid #c2d6ff; /* Soft blue border */
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            color: #4b5563;
        }
        .figma-input:focus {
            background-color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }

        /* Figma Button Styling */
        .figma-btn {
            background-color: #e8efff;
            color: #3b82f6;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .figma-btn:hover {
            background-color: #3b82f6;
            color: #ffffff;
        }
        
        .feature-image {
            object-fit: contain;
            border-radius: 20px 20px 20px 20px; /* The rounded corners on your big image */
            height: auto;
            max-width: 100%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            img-fluid: true;
        }
    </style>
</head>
<body>
    <div class="container-fluid vh-100">
        <div class="row h-100 align-items-center justify-content-center">
            
            <div class="col-12 col-md-5 d-flex flex-column align-items-center px-4">
                {{ $slot }}
            </div>

            <div class="col-md-6 d-none d-md-block p-4">
                <img src="{{ asset('images/shakespeare.png') }}" alt="Planet Library Character" class="feature-image">
            </div>

        </div>
    </div>
</body>
</html>