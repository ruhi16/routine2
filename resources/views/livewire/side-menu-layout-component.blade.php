<div>
    <div class="flex space-x-4 h-full">
        {{-- Left Side: Menu --}}
        <aside class="w-1/5">
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <h3 class="font-bold text-lg mb-4">Menu</h3>
                <nav class="space-y-2">
                    @foreach ($menuItems as $item)
                        <a href="#"
                           wire:click.prevent="showComponent('{{ $item['component'] }}')"
                           class="flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors duration-150
                                  {{ $activeComponent == $item['component']
                                     ? 'bg-indigo-500 text-white'
                                     : 'text-gray-700 hover:bg-gray-100' }}">

                            {{-- Example of using Heroicons for menu icons --}}
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                            </svg>

                            <span>{{ $item['name'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>
        </aside>

        {{-- Right Side: Content --}}
        <main class="w-4/5 h-screen overflow-y-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Dynamically render the selected Livewire component --}}
                    @livewire($activeComponent)
                    
                </div>
            </div>
        </main>
    </div>
</div>