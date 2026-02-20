@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex flex-col items-center">
        <div class="flex items-center gap-3">
            <img src="images/batstateu-logo.png" alt="BSU Logo" class="h-14 w-auto">
            <h1 class="text-4xl font-black text-red-700 tracking-tighter">IRJIEST</h1>
        </div>
        <div class="h-1 w-24 bg-red-700 mt-2 rounded-full"></div>
    </div>

    <div class="max-w-md w-full space-y-6 bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Create an account</h2>
            <p class="mt-1 text-xs text-gray-500 uppercase font-semibold tracking-widest">Batangas State University</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700">Full Name</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="block w-full pl-10 pr-3 py-2 border rounded-lg text-sm transition focus:ring-2 focus:ring-red-500 focus:border-red-500 {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                        placeholder="Juan Dela Cruz"/>
                </div>
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="block w-full pl-10 pr-3 py-2 border rounded-lg text-sm transition focus:ring-2 focus:ring-red-500 focus:border-red-500 {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}"
                        placeholder="user@example.com"/>
                </div>
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border rounded-lg text-sm transition focus:ring-2 focus:ring-red-500 focus:border-red-500 {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}"/>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg text-sm transition focus:ring-2 focus:ring-red-500 focus:border-red-500"/>
                </div>
            </div>

            <div class="pt-2">
                <p class="block text-sm font-semibold text-gray-700 mb-2">Register as:</p>
                <div class="grid grid-cols-3 gap-2">
                    @foreach (['author' => 'Author', 'reviewer' => 'Reviewer', 'editor' => 'Editor'] as $value => $label)
                        <label class="group flex flex-col items-center justify-center py-2 border-2 rounded-xl cursor-pointer transition-all hover:bg-red-50 has-checked:border-red-600 has-checked:bg-red-50">
                            <input type="checkbox" name="roles[]" value="{{ $value }}"
                                {{ in_array($value, old('roles', [])) ? 'checked' : '' }}
                                class="role-checkbox sr-only" data-role="{{ $value }}"/>
                            <span class="text-xs font-bold text-gray-400 group-has-checked:text-red-700">{{ $label }}</span>
                            <div class="h-1.5 w-1.5 rounded-full mt-1 bg-transparent group-has-checked:bg-red-600"></div>
                        </label>
                    @endforeach
                </div>
                @error('roles') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div id="expertise-section" class="{{ (in_array('editor', old('roles', [])) || in_array('reviewer', old('roles', []))) ? 'block' : 'hidden' }} animate-fade-in bg-gray-50 p-4 rounded-xl border border-dashed border-gray-300">
                <p class="text-xs font-bold text-gray-600 mb-2">Fields of Expertise:</p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($categories as $category)
                        <label class="flex items-center gap-2 p-1.5 cursor-pointer">
                            <input type="checkbox" name="expertise[]" value="{{ $category }}"
                                {{ in_array($category, old('expertise', [])) ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500"/>
                            <span class="text-xs text-gray-700 truncate">{{ $category }}</span>
                        </label>
                    @endforeach
                </div>
                @error('expertise') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 transition-all transform active:scale-95">
                Complete Registration
            </button>

            <div class="relative py-2">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
                <div class="relative flex justify-center text-xs uppercase"><span class="bg-white px-2 text-gray-400 italic">Already a member?</span></div>
            </div>

            <a href="{{ route('login') }}" class="block text-center text-sm font-bold text-red-700 hover:text-red-800 hover:underline">
                Sign into your Account
            </a>
        </form>
    </div>
</div>

<script>
    const expertiseSection = document.getElementById('expertise-section');
    const roleCheckboxes = document.querySelectorAll('.role-checkbox');

    function toggleExpertise() {
        const needsExpertise = Array.from(roleCheckboxes).some(cb =>
            cb.checked && (cb.getAttribute('data-role') === 'editor' || cb.getAttribute('data-role') === 'reviewer')
        );

        if (needsExpertise) {
            expertiseSection.classList.remove('hidden');
        } else {
            expertiseSection.classList.add('hidden');
        }
    }

    roleCheckboxes.forEach(cb => cb.addEventListener('change', toggleExpertise));
</script>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Form Validation Error',
            html: `<ul class="text-left text-sm">{!! implode('', array_map(fn($err) => "<li>• $err</li>", $errors->all())) !!}</ul>`,
            confirmButtonColor: '#b91c1c',
        });
    @endif
</script>
@endpush
@endsection
