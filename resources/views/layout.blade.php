<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Book Planet</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>
    <body class="bg-light">
        @yield('content')
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    <style>
        :root {
            --primary-blue: #3b82f6; /* Adjust to match your Figma blue */
            --bg-light: #f8fafc;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--bg-light);
            /* This creates your Figma grid background effect */
            background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 20px 20px;
            font-family: 'Inter', sans-serif;
            overflow-y: scroll;
        }

        .custom-card {
            border: none;
            border-radius: 1.5rem; /* Matches your soft rounded Figma corners */
            box-shadow: var(--card-shadow);
            transition: transform 0.2s;
        }

        .custom-card:hover {
            transform: translateY(-5px);
        }

        .badge-approved { background-color: #d1fae5; color: #065f46; border-radius: 9999px; padding: 0.35rem 0.85rem; font-size: 0.75rem; font-weight: 600; }
        .badge-pending { background-color: #fef3c7; color: #92400e; border-radius: 9999px; padding: 0.35rem 0.85rem; font-size: 0.75rem; font-weight: 600; }
        .badge-rejected { background-color: #fee2e2; color: #991b1b; border-radius: 9999px; padding: 0.35rem 0.85rem; font-size: 0.75rem; font-weight: 600; }
        .badge-returned { background-color: #d2d6d4; color: #616161; border-radius: 9999px; padding: 0.35rem 0.85rem; font-size: 0.75rem; font-weight: 600; }
        .badge-picked_up { background-color: #bfdbfe; color: #1e40af; border-radius: 9999px; padding: 0.35rem 0.85rem; font-size: 0.75rem; font-weight: 600; }
        .badge-expired { background-color: #000000; color: #ffffff; border-radius: 9999px; padding: 0.35rem 0.85rem; font-size: 0.75rem; font-weight: 600; }

        .figma-card-footer {
            background-color: #f8fafc;
            border-radius: 1rem;
            padding: 0.85rem 1rem;
            margin: 0 1rem 1rem 1rem;
        }

        .figma-search {
            background-color: #f1f5f9;
            border: none;
            border-radius: 9999px;
            padding: 0.5rem 1.5rem;
        }
    </style>
</html>