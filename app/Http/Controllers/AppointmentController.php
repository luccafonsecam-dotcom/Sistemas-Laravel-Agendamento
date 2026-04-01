<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query();

        // FILTRO POR DATA: Se o usuário pesquisar uma data, filtramos por ela
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date', $request->date);
        }

        // Ordena primeiro pela data (mais próxima) e depois pelo horário (mais cedo)
        $appointments = $query->orderBy('date', 'asc')
                              ->orderBy('time', 'asc')
                              ->paginate(10)
                              ->withQueryString();

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'observation' => 'nullable|string',
            // O status não é obrigatório na criação, o banco já põe 'pendente' por padrão
            'status' => 'nullable|in:pendente,concluído,cancelado',
        ]);

        Appointment::create($validated);

        return redirect()->route('appointments.index')->with('success', 'Agendamento marcado com sucesso!');
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'client' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'observation' => 'nullable|string',
            'status' => 'required|in:pendente,concluído,cancelado', // Na edição, o status é obrigatório
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Agendamento cancelado e excluído!');
    }
}