<?php

namespace App\Http\Controllers;

use App\Models\SavedPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SavedPaymentController extends Controller
{
    public function index()
    {
        $payments = SavedPayment::where('user_name', Session::get('user_name'))->latest()->get();
        return view('saved-payments.index', compact('payments'));
    }

    public function create()
    {
        return view('saved-payments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'nullable|date',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
        ]);

        SavedPayment::create([
            'user_name' => Session::get('user_name'),
            'transaction_date' => $request->transaction_date ?: now()->toDateString(),
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pembayaran tersimpan berhasil ditambahkan!');
    }

    public function edit(SavedPayment $savedPayment)
    {
        if ($savedPayment->user_name !== Session::get('user_name')) {
            abort(403);
        }
        return view('saved-payments.edit', compact('savedPayment'));
    }

    public function update(Request $request, SavedPayment $savedPayment)
    {
        if ($savedPayment->user_name !== Session::get('user_name')) {
            abort(403);
        }

        $request->validate([
            'transaction_date' => 'nullable|date',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
        ]);

        $savedPayment->update([
            'transaction_date' => $request->transaction_date ?: $savedPayment->transaction_date,
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        return redirect()->route('saved-payments.index')->with('success', 'Pembayaran tersimpan berhasil diperbarui!');
    }

    public function destroy(SavedPayment $savedPayment)
    {
        if ($savedPayment->user_name !== Session::get('user_name')) {
            abort(403);
        }

        $savedPayment->delete();

        return redirect()->route('saved-payments.index')->with('success', 'Pembayaran tersimpan berhasil dihapus!');
    }
}
