<?php
namespace App\Http\Controllers;

use App\Models\Tarifa;
use App\Models\ConsumoSinMedidor;
use Illuminate\Http\Request;

class ValorGeneralController extends Controller
{
    public function editAll()
    {
        $tarifas = Tarifa::orderBy('categoria')->orderBy('rango_min')->get();
        $cs      = ConsumoSinMedidor::orderBy('categoria')->get();
        return view('facturation.valores.edit', compact('tarifas','cs'));
    }

    public function updateAll(Request $request)
    {
        // Validamos que vengan como arrays anidados
        $data = $request->validate([
            'tarifas' => 'required|array',
            'tarifas.*.tarifa_agua'           => 'required|numeric|min:0',
            'tarifas.*.tarifa_alcantarillado' => 'required|numeric|min:0',
            'tarifas.*.cargo_fijo'            => 'required|numeric|min:0',

            'cs' => 'required|array',
            'cs.*.asignado_m3'          => 'required|integer|min:0',
            'cs.*.asignado_m3_menos_5h' => 'nullable|integer|min:0',
            'cs.*.asignado_m3_5h_o_mas' => 'nullable|integer|min:0',
        ]);

        // Actualizamos cada tarifa
        foreach($data['tarifas'] as $id => $t) {
            Tarifa::where('id',$id)
                  ->update([
                      'tarifa_agua'           => $t['tarifa_agua'],
                      'tarifa_alcantarillado' => $t['tarifa_alcantarillado'],
                      'cargo_fijo'            => $t['cargo_fijo'],
                  ]);
        }

        // Actualizamos cada consumo sin medidor
        foreach($data['cs'] as $id => $c) {
            ConsumoSinMedidor::where('id',$id)
                  ->update([
                      'asignado_m3'           => $c['asignado_m3'],
                      'asignado_m3_menos_5h'  => $c['asignado_m3_menos_5h'],
                      'asignado_m3_5h_o_mas'  => $c['asignado_m3_5h_o_mas'],
                  ]);
        }

        return back()->with('success','Valores actualizados correctamente.');
    }
}
