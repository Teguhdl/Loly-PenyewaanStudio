<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'User Dashboard | VR World' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: radial-gradient(circle at top, #0b0f1a, #05070d);
            color: #d4d4ff;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .glow-card {
            background: rgba(20, 20, 40, 0.6);
            border: 1px solid rgba(120, 120, 255, 0.3);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
            box-shadow: 0 0 20px rgba(0, 150, 255, 0.1);
        }

        .glow-card:hover {
            border-color: #00e0ff;
            box-shadow: 0 0 25px rgba(0, 200, 255, 0.4);
            transform: translateY(-3px);
        }

        .neon-text {
            text-shadow: 0 0 10px #00f6ff, 0 0 20px #00f6ff;
        }

        .nav-link {
            color: #94a3b8;
            transition: all 0.3s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #00e0ff;
            text-shadow: 0 0 8px #00f6ff;
        }
    </style>
</head>
