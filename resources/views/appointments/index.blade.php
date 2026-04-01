<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Agenda de Atendimentos') }}
            </h2>
            
            <a href="{{ route('appointments.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded shadow">
                + Novo Agendamento
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('appointments.index') }}" method="GET" class="mb-6 flex gap-4 items-end bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex-1 max-w-xs">
                            <label class="block text-sm font-medium text-gray-700">Filtrar por Data</label>
                            <input type="date" name="date" value="{{ request('date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">Filtrar</button>
                            <a href="{{ route('appointments.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">Limpar</a>
                        </div>
                    </form>

                    @if($appointments->isEmpty())
                        <p class="text-gray-500 text-center py-4">Nenhum agendamento encontrado.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-3 px-4 border-b text-left">Data e Hora</th>
                                        <th class="py-3 px-4 border-b text-left">Cliente</th>
                                        <th class="py-3 px-4 border-b text-left">Serviço</th>
                                        <th class="py-3 px-4 border-b text-center">Status</th>
                                        <th class="py-3 px-4 border-b text-right">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 px-4 border-b font-medium">
                                                {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }} às {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                            </td>
                                            <td class="py-3 px-4 border-b">{{ $appointment->client }}</td>
                                            <td class="py-3 px-4 border-b">{{ $appointment->service }}</td>
                                            <td class="py-3 px-4 border-b text-center">
                                                @if($appointment->status == 'concluído')
                                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">Concluído</span>
                                                @elseif($appointment->status == 'cancelado')
                                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400">Cancelado</span>
                                                @else
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-400">Pendente</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 border-b text-right">
                                                <div class="flex justify-end space-x-3">
                                                    <a href="{{ route('appointments.show', $appointment) }}" class="text-gray-600 hover:text-gray-900">Ver</a>
                                                    <a href="{{ route('appointments.edit', $appointment) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                                    
                                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar e excluir este agendamento?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6">
                            {{ $appointments->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>