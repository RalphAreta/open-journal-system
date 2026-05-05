@extends('layouts.app')

@section('title', 'Edit Role: ' . $role->display_name)

@section('content')
    <div
        class="min-h-screen bg-[#faf6ef] font-sans text-[#1a1209]"
        x-data="{ tab: 'settings' }"
    >
        <div class="max-w-4xl mx-auto px-4 sm:px-6 pb-16">
            <div
                class="relative pt-10 sm:pt-14 pb-8 mb-8 border-b border-[#e8dfd0]"
            >
                <div
                    class="absolute bottom-[-1px] left-0 w-24 h-[3px] bg-gradient-to-r from-[#c9a84c] to-transparent rounded-full"
                ></div>

                <nav
                    class="flex items-center gap-2 mb-5 text-[0.70rem] font-semibold tracking-[0.08em] uppercase"
                >
                    <a
                        href="{{ route('admin.roles.index') }}"
                        class="text-[#6b5740] hover:text-[#c9a84c] transition-colors"
                    >
                        Roles
                    </a>
                    <svg
                        class="w-3 h-3 text-[#c9b99a]"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        viewBox="0 0 24 24"
                    >
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                    <span class="text-[#1a1209]">
                        {{ $role->display_name }}
                    </span>
                </nav>

                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4"
                >
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-3 mb-1.5">
                            <div
                                class="w-9 h-9 rounded-lg bg-[#1a4d46] flex items-center justify-center shrink-0"
                            >
                                <svg
                                    class="w-4 h-4 text-[#c9a84c]"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                            </div>
                            <h1
                                class="text-2xl sm:text-3xl font-bold tracking-tight text-[#1a1209] truncate"
                            >
                                {{ $role->display_name }}
                            </h1>
                        </div>
                        @if ($role->description)
                            <p
                                class="text-[0.84rem] text-[#6b5740] font-medium pl-12"
                            >
                                {{ $role->description }}
                            </p>
                        @endif
                    </div>

                    <div
                        class="flex items-center gap-2 shrink-0 bg-white border border-[#e8dfd0] rounded-xl px-4 py-2.5 shadow-sm"
                    >
                        <svg
                            class="w-4 h-4 text-[#2d8176]"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.75"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0z"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                        <span class="text-[0.78rem] font-bold text-[#1a1209]">
                            {{ $role->users->count() }}
                        </span>
                        <span class="text-[0.72rem] text-[#6b5740] font-medium">
                            {{ Str::plural('member', $role->users->count()) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 mb-6">
                <button
                    @click="tab = 'settings'"
                          ettings'"
                          'settings' ? 'bg-[#1a4d46] text-white shadow-[0_4px_16px_rgba(26,77,70,0.22)]' : 'bg-white border border-[#e8dfd0] text-[#6b5740] hover:bg-[#f3ece0]'"
                          ex items-center gap-2 text-[0.68rem] font-bold tracking-[0.1em] uppercase px-5 py-2.5 rounded-lg transition-all duration-150"
                           h-3.5"
                          entColor"
                          ="2"
                           24 24"
                          25 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                          12" cy="12" r="3" />
                          embers'"
                          'members' ? 'bg-[#1a4d46] text-white shadow-[0_4px_16px_rgba(26,77,70,0.22)]' : 'bg-white border border-[#e8dfd0] text-[#6b5740] hover:bg-[#f3ece0]'"
                          ex items-center gap-2 text-[0.68rem] font-bold tracking-[0.1em] uppercase px-5 py-2.5 rounded-lg transition-all duration-150"
                           h-3.5"
                          entColor"
                          ="2"
                           24 24"
                          0h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0z"
                          inecap="round"
                          inejoin="round"
                          AqObUUNINqcKe7tB>
                          l-0.5 px-1.5 py-0.5 text-[0.58rem] font-bold rounded-full bg-[#e8f4f2] text-[#2d8176]"
                          lXZ9GFXDsIkg2KjNBppLB />
                          dAqObUUNINqcKe7tB>
                          8DOuJnbjB"
                          B1CdGrWCzsJGlsaKZ3IU4JaIUYiuE5NIfZB"
                          tart="opacity-0 translate-y-1"
                          nd="opacity-100 translate-y-0"
                          border border-[#e8dfd0] rounded-2xl shadow-[0_1px_8px_rgba(26,18,9,0.06)] overflow-hidden"
                          x] bg-gradient-to-r from-[#c9a84c] via-[#2d8176] to-transparent"
                          sm:px-8 py-5 border-b border-[#f0e8da] bg-[#fdfaf5]"
                          flex items-center gap-3">
                          s="text-[0.64rem] font-bold tracking-[0.18em] uppercase text-[#6b5740]"
                           Details
                          ss="flex-1 h-px bg-[#e8dfd0]"></div>
                          "
                          ASJ59ptRA1dn6SwXStrSzDe22pKppKGXuDGuB"
                          sm:px-8 py-7 space-y-6"
                          tflB />
                          s="block text-[0.64rem] font-bold tracking-[0.14em] uppercase text-[#6b5740] mb-2"
                          lay Name
                          n class="text-red-400">*</span>
                          ="text"
                          ="display_name"
                          e="{{ old('display_name', $role->display_name) }}"
                          ired
                          eholder="e.g. Content Editor"
                          s="w-full px-4 py-3 bg-[#f9f5ee] border border-[#e8dfd0] rounded-xl text-[0.93rem] font-semibold text-[#1a1209] placeholder:text-[#c9b99a] placeholder:font-normal focus:outline-none focus:border-[#c9a84c] focus:bg-white focus:ring-2 focus:ring-[rgba(201,168,76,0.15)] transition-all duration-150"
                          XSTfzGwxJynYvbLB>
                          class="mt-2 flex items-center gap-1.5 text-[0.72rem] text-red-500 font-semibold"
                          <svg
                              class="w-3 h-3 shrink-0"
                              fill="currentColor"
                              viewBox="0 0 20 20"
                          >
                              <path
                                  fill-rule="evenodd"
                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                  clip-rule="evenodd"
                              />
                          </svg>
                          {{ $message }}
                          3XSTfzGwxJynYvbLB>
                          s="block text-[0.64rem] font-bold tracking-[0.14em] uppercase text-[#6b5740] mb-2"
                          e Description
                          n
                          class="ml-2 text-[#c9b99a] font-medium normal-case tracking-normal"
                          Optional
                          an>
                          a
                          ="description"
                          ="4"
                          eholder="Describe the permissions and responsibilities of this role"
                          s="w-full px-4 py-3 bg-[#f9f5ee] border border-[#e8dfd0] rounded-xl text-[0.93rem] font-semibold text-[#1a1209] placeholder:text-[#c9b99a] placeholder:font-normal font-sans focus:outline-none focus:border-[#c9a84c] focus:bg-white focus:ring-2 focus:ring-[rgba(201,168,76,0.15)] transition-all duration-150 resize-none leading-relaxed"
                          VWpuAI1LB</textarea
                          5vM2BNr0lxyDBPB>
                          class="mt-2 flex items-center gap-1.5 text-[0.72rem] text-red-500 font-semibold"
                          <svg
                              class="w-3 h-3 shrink-0"
                              fill="currentColor"
                              viewBox="0 0 20 20"
                          >
                              <path
                                  fill-rule="evenodd"
                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                  clip-rule="evenodd"
                              />
                          </svg>
                          {{ $message }}
                          K5vM2BNr0lxyDBPB>
                          lex flex-wrap items-center gap-3 pt-2 border-t border-[#f0e8da]"
                          ="submit"
                          s="relative overflow-hidden inline-flex items-center gap-2 bg-[#2d8176] text-white text-[0.68rem] font-bold tracking-[0.1em] uppercase px-6 py-3 rounded-xl shadow-[0_4px_16px_rgba(45,129,118,0.28)] hover:bg-[#1a4d46] hover:-translate-y-0.5 active:translate-y-0 transition-all duration-150"
                          n
                          class="absolute inset-0 bg-gradient-to-br from-[rgba(201,168,76,0.18)] to-transparent pointer-events-none"
                          pan>
                          class="w-3.5 h-3.5 relative z-10"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="2.5"
                          viewBox="0 0 24 24"
                          <path
                              d="M5 13l4 4L19 7"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                          />
                          g>
                          n class="relative z-10">Save Changes</span>
                          >
                          ="{{ route('admin.roles.index') }}"
                          s="inline-flex items-center gap-2 bg-transparent border border-[#d4c5a9] text-[#6b5740] text-[0.68rem] font-bold tracking-[0.1em] uppercase px-6 py-3 rounded-xl hover:bg-[#f3ece0] hover:text-[#1a1209] hover:border-[#c9b99a] transition-all duration-150"
                          class="w-3.5 h-3.5"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="2"
                          viewBox="0 0 24 24"
                          <path
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                          />
                          g>
                          el
                          border border-red-100 rounded-2xl overflow-hidden"
                          sm:px-8 py-4 border-b border-red-50 bg-red-50/60"
                          flex items-center gap-3">
                          s="w-3.5 h-3.5 text-red-400 shrink-0"
                          ="none"
                          ke="currentColor"
                          ke-width="2"
                          Box="0 0 24 24"
                          h
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          s="text-[0.64rem] font-bold tracking-[0.18em] uppercase text-red-500"
                          er Zone
                          ss="flex-1 h-px bg-red-100"></div>
                           sm:px-8 py-5">
                          lex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
                          class="text-[0.86rem] font-semibold text-[#1a1209] mb-0.5"
                          Delete this role
                          lass="text-[0.78rem] text-[#6b5740]">
                          This action cannot be undone.
                          @if ($role->users->count() > 0)
                              <span
                                  class="text-red-500 font-semibold"
                              >
                                  {{ $role->users->count() }}
                                  {{ Str::plural('user', $role->users->count()) }}
                                  will be unassigned.
                              </span>
                          @endif
                          delete-role-form"
                          od="POST"
                          on="{{ route('admin.roles.destroy', $role) }}"
                          s="shrink-0"
                          tXB />
                          FlO1wbXiGG9dcWB />
                          ton
                          type="button"
                          onclick="
                              confirmRoleDeletion(
                                  '{{ $role->display_name }}',
                              )
                          "
                                    class="inline-flex items-center gap-2 bg-white border border-red-200 text-red-500 text-[0.68rem] font-bold tracking-[0.1em] uppercase px-5 py-2.5 rounded-xl hover:bg-red-500 hover:text-white hover:border-red-500 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-150 whitespace-nowrap"
                                >
                                    <svg
                                        class="w-3.5 h-3.5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                    Delete Role
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div
                x-show="tab === 'members'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
            >
                <div
                    class="bg-white border border-[#e8dfd0] rounded-2xl shadow-[0_1px_8px_rgba(26,18,9,0.06)] overflow-hidden"
                >
                    <div
                        class="h-[3px] bg-gradient-to-r from-[#c9a84c] via-[#2d8176] to-transparent"
                    ></div>

                    <div
                        class="px-6 sm:px-8 py-5 border-b border-[#f0e8da] bg-[#fdfaf5] flex items-center justify-between gap-4"
                    >
                        <div class="flex items-center gap-3">
                            <span
                                class="text-[0.64rem] font-bold tracking-[0.18em] uppercase text-[#6b5740]"
                            >
                                Assigned Members
                            </span>
                            <div
                                class="hidden sm:block w-8 h-px bg-[#e8dfd0]"
                            ></div>
                        </div>
                        <span
                            class="text-[0.64rem] font-bold bg-[#e8f4f2] border border-[#bce0da] text-[#2d8176] px-3 py-1 rounded-full tracking-[0.08em] uppercase whitespace-nowrap"
                        >
                            {{ $role->users->count() }}
                            {{ Str::plural('User', $role->users->count()) }}
                        </span>
                    </div>

                    <div class="divide-y divide-[#f5ede0]">
                        @forelse ($role->users as $u)
                            <div
                                class="flex items-center justify-between px-6 sm:px-8 py-4 hover:bg-[#fdfaf5] transition-colors duration-100 group gap-4"
                            >
                                <div class="flex items-center gap-4 min-w-0">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-[#2d8176] to-[#1a4d46] text-white rounded-xl flex items-center justify-center font-bold text-[0.88rem] uppercase shrink-0 shadow-sm"
                                    >
                                        {{ substr($u->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p
                                            class="text-[0.9rem] font-bold text-[#1a1209] leading-snug truncate"
                                        >
                                            {{ $u->name }}
                                        </p>
                                        <p
                                            class="text-[0.73rem] text-[#6b5740] leading-snug mt-0.5 truncate"
                                        >
                                            {{ $u->email }}
                                        </p>
                                    </div>
                                </div>
                                <a
                                    href="{{ route('admin.users.edit', $u) }}"
                                    class="sm:opacity-0 sm:group-hover:opacity-100 inline-flex items-center gap-1.5 text-[0.62rem] font-bold tracking-[0.1em] uppercase text-[#2d8176] hover:text-[#1a4d46] transition-all shrink-0 px-3 py-1.5 rounded-lg hover:bg-[#e8f4f2]"
                                >
                                    View
                                    <svg
                                        class="w-3 h-3"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M9 18l6-6-6-6" />
                                    </svg>
                                </a>
                            </div>
                        @empty
                            <div class="text-center py-16 sm:py-20 px-8">
                                <div
                                    class="w-16 h-16 mx-auto rounded-2xl bg-[#f3ece0] flex items-center justify-center mb-4"
                                >
                                    <svg
                                        class="w-8 h-8 text-[#c9b99a]"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0zm6 4a2 2 0 11-4 0 2 2 0 014 0zM7 16a2 2 0 11-4 0 2 2 0 014 0z"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </div>
                                <p
                                    class="text-[0.78rem] font-bold tracking-[0.12em] uppercase text-[#c9b99a] mb-1"
                                >
                                    No Users Assigned
                                </p>
                                <p class="text-[0.78rem] text-[#c9b99a]">
                                    Users assigned to this role will appear
                                    here.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmRoleDeletion(roleName) {
                Swal.fire({
                    title: 'Delete Role?',
                    html:
                        'Are you sure you want to permanently remove the <strong>"' +
                        roleName +
                        '"</strong> role? This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#d4c5a9',
                    confirmButtonText: 'Yes, Delete Role',
                    cancelButtonText: 'Keep Role',
                    reverseButtons: true,
                }).then(function (result) {
                    if (result.isConfirmed) {
                        document.getElementById('delete-role-form').submit();
                    }
                });
            }
        </script>
    @endpush
@endsection
