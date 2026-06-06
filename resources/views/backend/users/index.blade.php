@extends('layouts.backend')

@section('title', 'Manage Users | NomadThread Admin')
@section('admin_section_title', 'User Accounts')

@section('content')
<div class="rounded-xl table-glass p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-base font-bold text-slate-200">Registered Users</h3>
            <p class="text-xs text-slate-400 mt-1">Review user profiles and their posting activity counts.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-400">
            <thead class="text-xs uppercase text-slate-500 border-b border-slate-800">
                <tr>
                    <th class="py-3.5 px-4">User ID</th>
                    <th class="py-3.5 px-4">Name</th>
                    <th class="py-3.5 px-4">Email Address</th>
                    <th class="py-3.5 px-4 text-center">Threads Count</th>
                    <th class="py-3.5 px-4">Registered Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/60">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-800/25 transition-colors">
                        <td class="py-3.5 px-4 font-mono text-xs text-slate-500">#{{ $user->id }}</td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-slate-800 flex items-center justify-center text-xs font-bold text-slate-300">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span class="font-medium text-slate-200">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-xs">{{ $user->email }}</td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-flex items-center rounded-full bg-teal-500/10 px-2.5 py-0.5 text-xs font-semibold text-teal-400">
                                {{ $user->threads_count }} {{ Str::plural('thread', $user->threads_count) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-xs text-slate-500">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-500">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
