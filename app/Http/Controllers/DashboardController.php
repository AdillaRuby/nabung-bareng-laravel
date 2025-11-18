<?php

namespace App\Http\Controllers;

use App\Models\SavedPayment;
use App\Models\PendingPayment;
use App\Models\Withdraw;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $userName = Session::get('user_name');
        $isLoggedIn = Session::get('is_logged_in');

        if (!$isLoggedIn) {
            return redirect()->route('login');
        }

        // Calculate individual balances including pending payments
        $kasyaSaved = SavedPayment::where('user_name', 'Kasya')->where('status', 'confirmed')->sum('amount');
        $kasyaPending = SavedPayment::where('user_name', 'Kasya')->where('status', 'pending')->sum('amount') + PendingPayment::where('user_name', 'Kasya')->sum('amount');
        $kasyaWithdrawn = Withdraw::where('user_name', 'Kasya')->sum('amount');
        $kasyaBalance = $kasyaSaved + $kasyaPending - $kasyaWithdrawn;

        $casaSaved = SavedPayment::where('user_name', 'Casa')->where('status', 'confirmed')->sum('amount');
        $casaPending = SavedPayment::where('user_name', 'Casa')->where('status', 'pending')->sum('amount') + PendingPayment::where('user_name', 'Casa')->sum('amount');
        $casaWithdrawn = Withdraw::where('user_name', 'Casa')->sum('amount');
        $casaBalance = $casaSaved + $casaPending - $casaWithdrawn;

        $totalBalance = $kasyaBalance + $casaBalance;

        return view('dashboard', compact('kasyaBalance', 'casaBalance', 'totalBalance', 'userName'));
    }
}
