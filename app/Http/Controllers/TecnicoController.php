<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTecnicoRequest;
use App\Http\Requests\UpdateTecnicoRequest;
use Illuminate\Support\Facades\Hash;

class TecnicoController extends Controller
{
    /**
     * Mostrar listado de técnicos.
     */
    public function index()
    {
        $tecnicos = Tecnico::orderBy('apellido')->paginate(15);
        return view('tecnico.index', compact('tecnicos'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        // recogemos todos los técnicos paginados (o sin paginar si lo prefieres)
        $tecnicos = Tecnico::orderBy('apellido')->paginate(15);

        return view('tecnico.create', compact('tecnicos'));
    }

    /**
     * Almacenar un nuevo técnico.
     */
    public function store(StoreTecnicoRequest $request)
    {
        $data = $request->validated();

        // Encriptar contraseña
        $data['password'] = Hash::make($data['password']);

        Tecnico::create($data);

        return redirect()
            ->route('tecnico.index')
            ->with('success', 'Técnico creado correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Tecnico $tecnico)
    {
        return view('tecnico.edit', compact('tecnico'));
    }

    /**
     * Actualizar un técnico existente.
     */
    public function update(UpdateTecnicoRequest $request, Tecnico $tecnico)
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            // Si han enviado nueva contraseña, la encriptamos
            $data['password'] = Hash::make($data['password']);
        } else {
            // Si no, quitamos el campo para no sobrescribir
            unset($data['password']);
        }

        $tecnico->update($data);

        return redirect()
            ->route('tecnico.index')
            ->with('success', 'Técnico actualizado correctamente.');
    }

    /**
     * Eliminar un técnico.
     */
    public function destroy(Tecnico $tecnico)
    {
        $tecnico->delete();

        return back()->with('success', 'Técnico eliminado.');
    }
}
