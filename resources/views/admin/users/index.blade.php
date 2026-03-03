@extends('layouts.app')

@section('title', 'Manage Users')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Source+Sans+3:wght@300;400;500;600;700;900&display=swap"
        rel="stylesheet"
    />
    <style>
        :root {
            --teal:   #2D8176;
            --teal-d: #236860;
            --gold:   #c9a84c;
            --gold-l: #f0d678;
            --ink:    #0d1628;
            --mist:   #f5f0e8;
            --red:    #dc2626;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes shimmer {
            0%   { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 0 0 rgba(45,129,118,.5); }
            50%       { box-shadow: 0 0 0 5px rgba(45,129,118,0); }
        }
        @keyframes rowIn {
            from { opacity: 0; transform: translateX(-8px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .fade-up { opacity: 0; animation: fadeUp 0.55s cubic-bezier(.22,.68,0,1.2) forwards; }

        .shimmer-bar {
            background: linear-gradient(90deg, transparent, var(--gold), var(--gold-l), var(--gold), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }

        /* Search field */
        .search-wrap {
            position: relative;
            background: #fff;
            border: 1.5px solid #e2ddd4;
            border-radius: 16px;
            display: flex;
            align-items: center;
            padding: 0 16px;
            transition: border-color .2s, box-shadow .2s;
        }
        .search-wrap:focus-within {
            border-color: var(--teal);
            box-shadow: 0 0 0 4px rgba(45,129,118,.10);
        }
        .search-wrap input {
            flex: 1;
            padding: 13px 10px;
            border: none;
            background: transparent;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
            outline: none;
        }
        .search-wrap input::placeholder { color: #b8b0a4; font-weight: 500; }

        /* Role filter */
        .filter-wrap {
            position: relative;
            background: var(--teal);
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            transition: background .2s;
        }
        .filter-wrap:hover { background: var(--teal-d); }
        .filter-inner {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 18px;
            pointer-events: none;
        }
        .filter-wrap select {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        /* Stats chips */
        .stat-chip {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1.5px solid #ede8e0;
            border-radius: 16px;
            padding: 14px 20px;
            min-width: 100px;
            transition: border-color .18s, transform .15s;
        }
        .stat-chip:hover { border-color: var(--teal); transform: translateY(-1px); }

        /* Table */
        .users-table { width: 100%; border-collapse: collapse; }
        .users-table thead tr {
            background: linear-gradient(to right, #faf8f5, #f5f0e8);
            border-bottom: 1.5px solid #ede8e0;
        }
        .users-table thead th {
            padding: 14px 20px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .18em;
            color: #b0aaa0;
        }
        .users-table tbody tr {
            border-bottom: 1px solid #f0ece6;
            transition: background .15s;
            animation: rowIn 0.4s ease forwards;
        }
        .users-table tbody tr:hover { background: #faf8f5; }
        .users-table tbody tr:last-child { border-bottom: none; }
        .users-table td { padding: 16px 20px; vertical-align: middle; }

        /* Avatar */
        .avatar {
            width: 38px; height: 38px;
            border-radius: 12px;
            background: var(--teal);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Libre Baskerville', serif;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
            transition: background .18s;
            text-transform: uppercase;
        }
        tr:hover .avatar { background: var(--gold); }

        /* Role badge */
        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 9px;
            border-radius: 6px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .1em;
            background: rgba(45,129,118,.08);
            color: var(--teal);
            border: 1px solid rgba(45,129,118,.15);
        }

        /* Action buttons */
        .action-edit {
            display: inline-flex; align-items: center; gap-5px;
            padding: 6px 14px;
            border-radius: 8px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--teal);
            border: 1.5px solid rgba(45,129,118,.2);
            background: rgba(45,129,118,.05);
            text-decoration: none;
            transition: background .15s, border-color .15s, color .15s;
        }
        .action-edit:hover { background: var(--teal); color: #fff; border-color: var(--teal); }

        .action-delete {
            display: inline-flex; align-items: center;
            padding: 6px 14px;
            border-radius: 8px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--red);
            border: 1.5px solid rgba(220,38,38,.15);
            background: rgba(220,38,38,.05);
            cursor: pointer;
            transition: background .15s, border-color .15s, color .15s;
        }
        .action-delete:hover { background: var(--red); color: #fff; border-color: var(--red); }

        /* Empty state */
        .empty-state {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; padding: 64px 24px; text-align: center;
        }
        .empty-icon {
            width: 56px; height: 56px;
            border-radius: 18px;
            background: #f5f0e8;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin-bottom: 14px;
        }

        /* Pagination area */
        .table-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid #ede8e0;
            background: #faf8f5;
        }
    </style>
@endpush

@section('content')
    <div
        class="min-h-screen font-['Source_Sans_3']"
        style="
            background: linear-gradient(
                135deg,
                #f5f0e8 0%,
                #ede5d5 50%,
                #e8e0f0 100%
            );
        "
    >
        {{-- Shimmer top bar --}}
        <div class="fixed top-0 left-0 right-0 h-0.5 shimmer-bar z-50"></div>

        <div class="max-w-6xl mx-auto py-10 px-4 space-y-6">
            {{-- Header --}}
            <div
                class="fade-up flex flex-col md:flex-row justify-between items-start md:items-end gap-6"
                style="animation-delay: 60ms"
            >
                <div>
                    <nav
                        class="flex items-center gap-2 text-[10px] font-black text-[#b0aaa0] uppercase tracking-widest mb-3"
                    >
                        <a
                            href="{{ route('dashboard.admin') }}"
                            class="hover:text-(--teal) transition-colors"
                        >
                            Admin
                        </a>
                        <svg
                            class="w-3 h-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M9 5l7 7-7 7" stroke-width="2.5" />
                        </svg>
                        <span class="text-(--ink)">Directory</span>
                    </nav>
                    <p
                        class="text-[10px] font-black uppercase tracking-[.2em] text-(--teal) mb-1 flex items-center gap-2"
                    >
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-(--teal)"
                            style="animation: pulse-dot 2s ease-in-out infinite"
                        ></span>
                        Journal System · Admin Panel
                    </p>
                    <h1
                        class="font-['Libre_Baskerville'] text-4xl font-bold text-(--ink) leading-tight"
                    >
                        User
                        <em
                            class="not-italic bg-linear-to-r from-(--teal) to-[#1a6b62] bg-clip-text text-transparent"
                        >
                            Directory
                        </em>
                    </h1>
                </div>

                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('dashboard.admin') }}"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-xl border border-[#ddd8ce] bg-white/80 text-[10px] font-black uppercase tracking-widest text-[#9ea8b8] hover:text-(--teal) hover:border-(--teal) transition-all active:scale-95 backdrop-blur-sm"
                    >
                        <svg
                            class="w-3 h-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M15 19l-7-7 7-7"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                        Back
                    </a>
                    <a
                        href="{{ route('admin.users.create') }}"
                        class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-(--teal) text-white text-[10px] font-black uppercase tracking-widest hover:bg-(--teal-d) transition-all shadow-lg shadow-[rgba(45,129,118,.25)] active:scale-95"
                    >
                        <svg
                            class="w-3 h-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 4v16m8-8H4"
                                stroke-width="2.5"
                                stroke-linecap="round"
                            />
                        </svg>
                        Add New User
                    </a>
                </div>
            </div>

            {{-- Stats Row --}}
            <div
                class="fade-up flex flex-wrap gap-3"
                style="animation-delay: 140ms"
            >
                @php
                    $totalUsers = $users->count();
                    $roleGroups = \App\Models\Role::withCount('users')
                        ->orderBy('display_name')
                        ->get();
                @endphp

                <div class="stat-chip">
                    <span
                        class="font-['Libre_Baskerville'] text-2xl font-bold text-(--ink)"
                    >
                        {{ $totalUsers }}
                    </span>
                    <span
                        class="text-[9px] font-black uppercase tracking-widest text-[#b0aaa0] mt-0.5"
                    >
                        Total Users
                    </span>
                </div>
                @foreach ($roleGroups as $rg)
                    <div class="stat-chip">
                        <span
                            class="font-['Libre_Baskerville'] text-2xl font-bold text-(--teal)"
                        >
                            {{ $rg->users_count }}
                        </span>
                        <span
                            class="text-[9px] font-black uppercase tracking-widest text-[#b0aaa0] mt-0.5"
                        >
                            {{ $rg->display_name }}
                        </span>
                    </div>
                @endforeach
            </div>

            {{-- Search + Filter --}}
            <div
                class="fade-up grid grid-cols-1 md:grid-cols-12 gap-3"
                style="animation-delay: 200ms"
            >
                <div class="md:col-span-8 search-wrap">
                    <svg
                        class="w-4 h-4 text-[#c0b8b0] shrink-0"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            stroke-width="2.5"
                            stroke-linecap="round"
                        />
                    </svg>
                    <input
                        type="text"
                        id="userSearch"
                        onkeyup="applyFilters()"
                        placeholder="Search by name or email…"
                    />
                    <span
                        class="text-[10px] font-bold text-[#c0b8b0] uppercase tracking-widest hidden md:block whitespace-nowrap"
                    >
                        ⌘K
                    </span>
                </div>

                <div class="md:col-span-4 filter-wrap">
                    <div class="filter-inner">
                        <svg
                            class="w-3.5 h-3.5 text-white/60 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                        <div class="flex flex-col flex-1 min-w-0">
                            <span
                                class="text-[8px] font-black text-white/40 uppercase tracking-[.2em]"
                            >
                                Filter by Role
                            </span>
                            <span
                                class="text-[11px] font-black uppercase tracking-wider text-white truncate"
                                id="filterLabel"
                            >
                                All Roles
                            </span>
                        </div>
                        <svg
                            class="w-3.5 h-3.5 text-white/50 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M19 9l-7 7-7-7" stroke-width="2.5" />
                        </svg>
                    </div>
                    <select
                        id="roleFilter"
                        onchange="
                            applyFilters();
                            document.getElementById('filterLabel').innerText =
                                this.options[this.selectedIndex].text;
                        "
                    >
                        <option value="">All Roles</option>
                        @foreach (\App\Models\Role::orderBy('display_name')->get() as $role)
                            <option
                                value="{{ strtolower($role->display_name) }}"
                            >
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Table Card --}}
            <div
                class="fade-up bg-white/95 border border-[#ede8e0] rounded-3xl overflow-hidden shadow-xl shadow-[rgba(13,22,40,.07)] backdrop-blur-sm"
                style="animation-delay: 260ms"
            >
                <div class="overflow-x-auto">
                    <table class="users-table" id="userTable">
                        <thead>
                            <tr>
                                <th class="text-left">User Identity</th>
                                <th class="text-left">Email Address</th>
                                <th class="text-left">Assigned Roles</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f5f0e8]">
                            @forelse ($users as $u)
                                <tr
                                    class="user-row group"
                                    data-roles="{{ strtolower($u->roles->pluck('display_name')->implode(',')) }}"
                                    style="
                                        animation-delay: {{ $loop->index * 40 }}ms;
                                    "
                                >
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                {{ substr($u->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <p
                                                    class="font-['Libre_Baskerville'] text-sm font-bold text-(--ink) leading-tight"
                                                >
                                                    {{ $u->name }}
                                                </p>
                                                <p
                                                    class="text-[10px] text-[#b0aaa0] font-medium mt-0.5"
                                                >
                                                    ID #{{ $u->id }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="text-sm font-medium text-[#6a7890]"
                                        >
                                            {{ $u->email }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex flex-wrap gap-1.5">
                                            @php
                                                $displayRoles = $u->roles->pluck('display_name')->filter();
                                            @endphp

                                            @forelse ($displayRoles as $roleName)
                                                <span class="role-badge">
                                                    {{ $roleName }}
                                                </span>
                                            @empty
                                                <span
                                                    class="text-[10px] font-bold text-[#c8c0b8] uppercase italic"
                                                >
                                                    No Roles
                                                </span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            class="flex items-center justify-end gap-2"
                                        >
                                            <a
                                                href="{{ route('admin.users.edit', $u) }}"
                                                class="action-edit"
                                            >
                                                <svg
                                                    class="w-3 h-3 mr-1.5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2.5"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                    />
                                                </svg>
                                                Edit
                                            </a>
                                            @if (! $u->isAdmin() || \App\Models\User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->count() > 1)
                                                <form
                                                    id="delete-form-{{ $u->id }}"
                                                    method="POST"
                                                    action="{{ route('admin.users.destroy', $u) }}"
                                                    class="inline-flex"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="button"
                                                        class="action-delete"
                                                        onclick="
                                                            confirmUserDeletion(
                                                                {{ $u->id }},
                                                                '{{ $u->name }}',
                                                            )
                                                        "
                                                    >
                                                        <svg
                                                            class="w-3 h-3 mr-1.5"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            viewBox="0 0 24 24"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2.5"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                            />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <div class="empty-icon">👤</div>
                                            <p
                                                class="font-['Libre_Baskerville'] font-bold text-(--ink) text-sm"
                                            >
                                                No users found
                                            </p>
                                            <p
                                                class="text-[12px] text-[#b0aaa0] mt-1"
                                            >
                                                The system directory is
                                                currently empty.
                                            </p>
                                            <a
                                                href="{{ route('admin.users.create') }}"
                                                class="mt-4 px-5 py-2.5 bg-(--teal) text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-(--teal-d) transition-all"
                                            >
                                                Add First User
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Table Footer --}}
                <div class="table-footer">
                    <p class="text-[11px] font-semibold text-[#b0aaa0]">
                        Showing
                        <span
                            id="visibleCount"
                            class="font-black text-(--ink)"
                        >
                            {{ $users->count() }}
                        </span>
                        of {{ $users->count() }} users
                    </p>
                    <p
                        class="text-[10px] text-[#c0b8b0] uppercase tracking-widest"
                    >
                        BatStateU · BIRJISE
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function applyFilters() {
                const searchText = document
                    .getElementById('userSearch')
                    .value.toLowerCase();
                const roleFilter = document
                    .getElementById('roleFilter')
                    .value.toLowerCase();
                const rows = document.querySelectorAll('.user-row');
                let visible = 0;

                rows.forEach((row) => {
                    const rowText = row.innerText.toLowerCase();
                    const rowRoles = row.getAttribute('data-roles');
                    const matchesSearch = rowText.includes(searchText);
                    const matchesRole =
                        roleFilter === '' || rowRoles.includes(roleFilter);
                    const show = matchesSearch && matchesRole;
                    row.style.display = show ? '' : 'none';
                    if (show) visible++;
                });

                const counter = document.getElementById('visibleCount');
                if (counter) counter.textContent = visible;
            }

            function confirmUserDeletion(userId, userName) {
                Swal.fire({
                    title: 'Delete user?',
                    text: `Are you sure you want to remove ${userName}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#2D8176',
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-3xl border border-slate-100 shadow-2xl p-6',
                        title: 'text-xl font-black tracking-tighter uppercase italic text-slate-900',
                        confirmButton:
                            'px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest mx-1',
                        cancelButton:
                            'px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest mx-1',
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        document
                            .getElementById('delete-form-' + userId)
                            .submit();
                    }
                });
            }
        </script>
    @endpush
@endsection
