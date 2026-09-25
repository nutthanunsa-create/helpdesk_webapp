<?php

namespace App\Http\Controllers;

use App\Models\Sla;
use Illuminate\Http\Request;

class SlaController extends Controller
{
    private function authorizeAdministrator()
    {
        if (! request()->user() || request()->user()->role !== 'administrator') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index()
    {
        $this->authorizeAdministrator();
        $slas = Sla::orderBy('company')->get()->groupBy('company');

        return view('slas.index', compact('slas'));
    }

    public function update(Request $request)
    {
        $this->authorizeAdministrator();

        $request->validate([
            'slas' => 'required|array',
            'slas.*.id' => 'required|exists:slas,id',
            'slas.*.hours' => 'required|integer|min:1',
        ]);

        foreach ($request->slas as $slaData) {
            $sla = Sla::find($slaData['id']);
            if ($sla) {
                $sla->update(['hours' => $slaData['hours']]);
            }
        }

        return redirect()->route('slas.index')->with('success', 'อัปเดตการตั้งค่า SLA เรียบร้อยแล้ว');
    }
}
