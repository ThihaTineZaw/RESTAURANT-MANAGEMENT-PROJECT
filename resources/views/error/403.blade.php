<x-errorlayout>
    <x-slot name="title">
        403 - Forbidden
    </x-slot>

     <div class="flex items-center justify-center min-h-screen">
        <div class="text-center">
            <h1 class="text-9xl font-bold text-red-500">403</h1>

            <p class="mt-4 text-lg text-white">
                {{ $message }}
            </p>

            <a href="{{ $url }}"
               class="inline-block mt-6 px-4 py-2 bg-blue-500 text-white rounded-lg">
               Back to {{ $name }}
            </a>
        </div>
    </div>

</x-errorlayout>
