@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-wrap justify-between items-center gap-4 bg-white p-5 rounded-lg border border-slate-200 shadow-sm">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="text-lg font-bold text-slate-900">{{ $interview->candidate_name }}</h1>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $interview->depth_score >= 75 ? 'bg-emerald-50 text-[#00965E]' : ($interview->depth_score >= 45 ? 'bg-amber-50 text-amber-700' : 'bg-rose-50 text-rose-700') }}">{{ $interview->verdict }}</span>
            </div>
            <p class="text-xs text-slate-500 mt-0.5">{{ $interview->role }} &bull; {{ $interview->tech_stack }}</p>
        </div>
        <a href="{{ route('interviews.show', $interview) }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 border border-slate-300 px-3 py-1.5 rounded">Back to Depth Report</a>
    </div>

    <div class="space-y-4">
        @forelse($interview->analysis_data['drill_downs'] ?? [] as $drill)
        <div class="bg-white p-5 rounded-lg border border-slate-200 shadow-sm space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200 uppercase tracking-wide">{{ $drill['topic'] ?? 'Follow-Up' }}</span>
                <button type="button" onclick="navigator.clipboard.writeText(this.getAttribute('data-q')).then(() => { const orig = this.innerText; this.innerText = 'Copied'; setTimeout(() => this.innerText = orig, 1500); })" data-q="{{ $drill['question'] ?? '' }}" class="text-xs font-semibold px-2.5 py-1 rounded bg-[#00A3E0] hover:bg-[#008bc0] text-white transition">Copy Question</button>
            </div>
            <p class="text-sm font-bold text-slate-900 leading-snug">{{ $drill['question'] ?? '' }}</p>
            <div class="bg-slate-50 p-3 rounded border border-slate-200 text-xs text-slate-600">
                <span class="font-semibold text-slate-700 block mb-1">Expected Authentic Signal vs LARP:</span>
                {{ $drill['expected_signal'] ?? '' }}
            </div>
        </div>
        @empty
        <div class="bg-white p-8 rounded-lg border border-slate-200 text-center text-xs text-slate-500">
            No drill-down questions available for this session.
        </div>
        @endforelse
    </div>

    <div class="flex justify-between items-center pt-4 border-t border-slate-200">
        <button type="button" onclick="window.print()" class="text-xs font-semibold px-4 py-2 rounded border border-slate-300 bg-white hover:bg-slate-50 text-slate-700">Print / Export PDF</button>
        <form action="{{ route('interviews.destroy', $interview) }}" method="POST" onsubmit="return confirm('Delete this interview session?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs font-semibold px-4 py-2 rounded bg-rose-600 hover:bg-rose-700 text-white">Delete Session</button>
        </form>
    </div>
</div>
@endsection
