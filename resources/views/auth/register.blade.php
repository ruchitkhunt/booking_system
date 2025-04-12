<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="registrationForm">
        @csrf


        <div>
            <x-input-label for="fname" :value="__('First Name')" />
            <x-text-input id="fname" class="block mt-1 w-full" type="text" name="fname" :value="old('fname')" autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('fname')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="lname" :value="__('Last Name')" />
            <x-text-input id="lname" class="block mt-1 w-full" type="text" name="lname" :value="old('lname')" autofocus autocomplete="lname" />
            <x-input-error :messages="$errors->get('lname')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#registrationForm').validate({
                rules: {
                    fname: {
                        required: true,
                        minlength: 2
                    },
                    lname: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    }
                },
                messages: {
                    fname: {
                        required: "First name is required",
                        minlength: "First name must be at least 2 characters"
                    },
                    lname: {
                        required: "Last name is required",
                        minlength: "Last name must be at least 2 characters"
                    },
                    email: {
                        required: "Email is required",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Password is required",
                        minlength: "Password must be at least 8 characters"
                    }
                },
                errorElement: 'span',
                errorClass: 'text-sm text-red-600',
                highlight: function(element) {
                    $(element).addClass('border-red-500');
                },
                unhighlight: function(element) {
                    $(element).removeClass('border-red-500');
                }
            });
        });
    </script>

</x-guest-layout>