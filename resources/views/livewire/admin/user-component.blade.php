<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <x-slot name='header'>
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                Lista de usuarios
            </h2>
        </div>
    </x-slot>

    <div class="container py-12">
        <x-table-responsive>
            <div class="px-6 py-4">
                <x-jet-input wire:model="search" type="text" class="w-full" placeholder="Ingrese nombre o email  del usuario para buscar" />
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rol
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)    
                        <tr wire:key='{{ $user->email }}'>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $user->id }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $user->email }}
                                </div>
                            </td>
                            <td>
                                <div class="text-sm text-gray-900">
                                    @if (count($user->roles))
                                        Admin
                                    @else
                                        No tiene rol
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <label for="">
                                    <input wire:change='assignRole({{ $user->id }}, $event.target.value)' {{ count($user->roles) ? 'checked' : '' }} type="radio" name="{{ $user->email }}" value="1">
                                    Si
                                </label>
                                <label for="" class="ml-2">
                                    <input wire:change='assignRole({{ $user->id }}, $event.target.value)' {{ count($user->roles) ? '' : 'checked' }} type="radio" name="{{ $user->email }}" value="0">
                                    No
                                </label>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4">
                                Sin resultado para "{{ $search }}"
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($users->hasPages())
                <div class="px-6 py-4">
                    {{ $users->links() }}
                </div>
            @endif
        </x-table-responsive>
    </div>
</div>
