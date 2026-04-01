<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Agendamento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-bold border-b pb-2 mb-4">Informações do Cliente</h3>
                        <p><strong>Cliente:</strong> {{ $appointment->client }}</p>
                        <p><strong>Serviço Solicitado:</strong> {{ $appointment->service }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-bold border-b pb-2 mb-4">Dados do Atendimento</h3>
                        <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</p>
                        <p><strong>Horário:</strong> {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</p>
                        <p class="mt-2">
                            <strong>Status:</strong> 
                            <span class="uppercase font-semibold text-sm px-2 py-1 rounded 
                                {{ $appointment->status == 'concluído' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $appointment->status == 'cancelado' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $appointment->status == 'pendente' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                {{ $appointment->status }}
                            </span>
                        </p>
                    </div>

                    @if($appointment->observation)
                    <div class="mb-6">
                        <h3 class="text-lg font-bold border-b pb-2 mb-4">Observações</h3>
                        <p class="bg-gray-50 p-4 rounded border">{{ $appointment->observation }}</p>
                    </div>
                    @endif

                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('appointments.edit', $appointment) }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded shadow">
                            Editar
                        </a>
                        <a href="{{ route('appointments.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded shadow">
                            Voltar
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>