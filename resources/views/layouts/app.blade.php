<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LARPMINATOR - Technical Depth Copilot</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen">
    <nav class="bg-white border-b border-slate-200 px-6 py-3.5 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('interviews.index') }}" class="font-bold tracking-wider text-slate-900 text-lg">LARPMINATOR</a>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">Technical Depth Copilot</span>
            </div>
            <div class="flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('interviews.index') }}" class="text-slate-600 hover:text-slate-900 {{ request()->routeIs('interviews.index') ? 'text-slate-900 font-semibold' : '' }}">Dashboard</a>
                <a href="{{ route('interviews.create') }}" class="px-3.5 py-1.5 rounded-md bg-[#00A3E0] hover:bg-[#008bc0] text-white transition">New Session</a>
                <span class="text-xs text-slate-500 pl-3 border-l border-slate-200">Role: Tech Lead</span>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>
</body>
</html>
