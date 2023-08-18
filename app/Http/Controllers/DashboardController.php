<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Sfp;
use App\Models\Patchcord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $sfpDashboard = SFP::select('jenis', 'bandwidth', 'jarak')
            ->whereNull('bkeluar_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('jenis', 'bandwidth', 'jarak')
            ->get();

        $patchcordDashboard = Patchcord::select('jenis', 'konektor', 'jarak')
            ->whereNull('bkeluar_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('jenis', 'konektor', 'jarak')
            ->get();

        $modulDashboard = Modul::select('vendor', 'tipe_board')
            ->whereNull('bkeluar_id')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('vendor', 'tipe_board')
            ->get();

        return view('dashboard', compact('sfpDashboard', 'patchcordDashboard', 'modulDashboard'));
    }
}
