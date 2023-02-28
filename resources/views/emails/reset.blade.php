<x-mail::message>
    Blood Bank Reset Password.
    Hello {{ $user->name }}

        <p>your reset code is {{ $user->pin_code }}</p>
        Thanks,<br>
        {{ config('app.name') }}
</x-mail::message>
