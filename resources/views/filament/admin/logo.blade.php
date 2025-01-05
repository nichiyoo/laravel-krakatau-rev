<div class="flex items-center gap-2">
  <img src="{{ asset('logo.svg') }}" alt="Logo" class="h-10"> 

  <div class="flex flex-col space-y-0">
    <span class="text-xl font-bold">{{ config('app.name', 'Laravel') }}</span>
    <span class="text-sm opacity-50">{{ $type }} Panel</span>
  </div>
</div>
