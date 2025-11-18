<?php

namespace App\Http\Controllers;

use App\Models\PendingPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PendingPaymentController extends Controller
{
    public function index()
    {
        $payments = PendingPayment::where('user_name', Session::get('user_name'))->latest()->get();
        return view('pending-payments.index', compact('payments'));
    }

    public function create()
    {
        return view('pending-payments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'nullable|date',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
        ]);

        PendingPayment::create([
            'user_name' => Session::get('user_name'),
            'transaction_date' => $request->transaction_date ?: now()->toDateString(),
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pembayaran pending berhasil ditambahkan!');
    }

    public function edit(PendingPayment $pendingPayment)
    {
        if ($pendingPayment->user_name !== Session::get('user_name')) {
            abort(403);
        }
        return view('pending-payments.edit', compact('pendingPayment'));
    }

    public function update(Request $request, PendingPayment $pendingPayment)
    {
        if ($pendingPayment->user_name !== Session::get('user_name')) {
            abort(403);
        }

        $request->validate([
            'transaction_date' => 'nullable|date',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
        ]);

        $pendingPayment->update([
            'transaction_date' => $request->transaction_date ?: $pendingPayment->transaction_date,
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        return redirect()->route('pending-payments.index')->with('success', 'Pembayaran pending berhasil diperbarui!');
    }

    public function destroy(PendingPayment $pendingPayment)
    {
        if ($pendingPayment->user_name !== Session::get('user_name')) {
            abort(403);
        }

        $pendingPayment->delete();

        return redirect()->route('pending-payments.index')->with('success', 'Pembayaran pending berhasil dihapus!');
    }
}
