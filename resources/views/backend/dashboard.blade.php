@extends('layouts.backend')

@section('title', 'Dashboard | NomadThread Admin')
@section('admin_section_title', 'Dashboard Overview')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Users Count Card -->
    <div class="rounded-xl table-glass p-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Users</p>
            <h3 class="mt-2 text-3xl font-extrabold text-white" id="admin-stat-users">{{ $stats['users_count'] }}</h3>
        </div>
        <div class="p-3 bg-teal-500/10 text-teal-400 rounded-lg">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
            </svg>
        </div>
    </div>

    <!-- Threads Count Card -->
    <div class="rounded-xl table-glass p-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Threads</p>
            <h3 class="mt-2 text-3xl font-extrabold text-white" id="admin-stat-threads">{{ $stats['threads_count'] }}</h3>
        </div>
        <div class="p-3 bg-cyan-500/10 text-cyan-400 rounded-lg">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
            </svg>
        </div>
    </div>

    <!-- Active Threads Card -->
    <div class="rounded-xl table-glass p-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Active Threads</p>
            <h3 class="mt-2 text-3xl font-extrabold text-teal-400" id="admin-stat-active">{{ $stats['active_threads'] }}</h3>
        </div>
        <div class="p-3 bg-emerald-500/10 text-emerald-400 rounded-lg">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
    </div>

    <!-- Archived Threads Card -->
    <div class="rounded-xl table-glass p-6 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Archived Threads</p>
            <h3 class="mt-2 text-3xl font-extrabold text-slate-400" id="admin-stat-archived">{{ $stats['archived_threads'] }}</h3>
        </div>
        <div class="p-3 bg-slate-500/10 text-slate-400 rounded-lg">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
            </svg>
        </div>
    </div>
</div>

<!-- Detailed Data Sections -->
<div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
    
    <!-- Recent Discussions List (Left/Middle Column) -->
    <div class="rounded-xl table-glass p-6 lg:col-span-2 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-base font-bold text-slate-200">Recent Discussion Activity</h3>
                <a href="{{ route('backend.threads.index') }}" id="link-moderate-threads" class="text-xs font-semibold text-teal-400 hover:text-teal-300 transition-colors">
                    Moderate All &rarr;
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-400">
                    <thead class="text-xs uppercase text-slate-500 border-b border-slate-800">
                        <tr>
                            <th class="py-3 px-4">Title</th>
                            <th class="py-3 px-4">Author</th>
                            <th class="py-3 px-4">Location</th>
                            <th class="py-3 px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse($recentThreads as $thread)
                            <tr class="hover:bg-slate-800/25 transition-colors">
                                <td class="py-3.5 px-4 font-medium text-slate-200 truncate max-w-xs">{{ $thread->title }}</td>
                                <td class="py-3.5 px-4 text-xs">{{ $thread->user->name }}</td>
                                <td class="py-3.5 px-4 text-xs font-semibold text-slate-300">{{ $thread->location }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center gap-1 rounded-md px-2 py-0.5 text-xs font-medium {{ $thread->status === 'active' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-slate-800 text-slate-400' }}">
                                        {{ ucfirst($thread->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500">No recent threads.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active Locations Breakdown (Right Column) -->
    <div class="rounded-xl table-glass p-6">
        <h3 class="text-base font-bold text-slate-200 mb-6">Location Hotspots</h3>
        
        <div class="space-y-4">
            @forelse($locations as $loc)
                <div class="flex items-center justify-between p-3 rounded-lg bg-slate-800/40 border border-slate-800/30">
                    <div class="flex items-center gap-2.5">
                        <span class="h-2 w-2 rounded-full bg-teal-400"></span>
                        <span class="text-sm font-medium text-slate-300">{{ $loc->location ?? 'Unknown' }}</span>
                    </div>
                    <span class="rounded bg-teal-500/10 px-2 py-0.5 text-xs font-semibold text-teal-400">
                        {{ $loc->total }} {{ Str::plural('thread', $loc->total) }}
                    </span>
                </div>
            @empty
                <p class="text-center py-8 text-slate-500 text-sm">No locations mapped yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
