@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1
            class="font-['Libre_Baskerville'] text-3xl font-bold text-[#0d1628] mb-6"
        >
            Notifications
        </h1>

        <div
            class="bg-white border border-[#ede8e0] rounded-2xl overflow-hidden shadow-sm"
        >
            @forelse ($notifications as $notif)
                <div
                    class="px-6 py-4 border-b border-[#f0ece6] flex items-start gap-4 {{ is_null($notif->read_at) ? 'bg-blue-50/40' : '' }} hover:bg-[#faf8f5] transition-colors"
                >
                    <div
                        class="w-2.5 h-2.5 rounded-full mt-1.5 flex-shrink-0 {{ is_null($notif->read_at) ? 'bg-[#2D8176]' : 'bg-[#e0dbd3]' }}"
                    ></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-[#0d1628]">
                            {{ $notif->title }}
                        </p>
                        <p class="text-sm text-[#6a7890] mt-0.5">
                            {{ $notif->message }}
                        </p>
                        <p class="text-[10px] text-[#b0aaa0] mt-1">
                            {{ $notif->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @if (is_null($notif->read_at))
                        <form
                            method="POST"
                            action="{{ route('notifications.read', $notif) }}"
                        >
                            @csrf
                            <button
                                type="submit"
                                class="text-[10px] font-bold text-[#2D8176] hover:text-[#1f5d54] uppercase tracking-wider flex-shrink-0"
                            >
                                Mark read
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="px-6 py-16 text-center">
                    <p class="text-[#b0aaa0]">No notifications yet.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-4">{{ $notifications->links() }}</div>
    </div>
@endsection
