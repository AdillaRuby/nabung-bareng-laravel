<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WithdrawController extends Controller
{
    public function index()
    {
        $withdraws = Withdraw::latest()->get();
        return view('withdraws.index', compact('withdraws'));
    }

    public function create()
    {
        return view('withdraws.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => 'nullable|date',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
        ]);

        Withdraw::create([
            'user_name' => Session::get('user_name'),
            'transaction_date' => $request->transaction_date ?: now()->toDateString(),
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        return redirect()->route('dashboard')->with('success', 'Penarikan berhasil ditambahkan!');
    }

    public function edit(Withdraw $withdraw)
    {
        if ($withdraw->user_name !== Session::get('user_name')) {
            abort(403);
        }
        return view('withdraws.edit', compact('withdraw'));
    }

    public function update(Request $request, Withdraw $withdraw)
    {
        if ($withdraw->user_name !== Session::get('user_name')) {
            abort(403);
        }

        $request->validate([
            'transaction_date' => 'nullable|date',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
        ]);

        $withdraw->update([
            'transaction_date' => $request->transaction_date ?: $withdraw->transaction_date,
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        return redirect()->route('withdraws.index')->with('success', 'Penarikan berhasil diperbarui!');
    }

    public function destroy(Withdraw $withdraw)
    {
        if ($withdraw->user_name !== Session::get('user_name')) {
            abort(403);
        }

        $withdraw->delete();

        return redirect()->route('withdraws.index')->with('success', 'Penarikan berhasil dihapus!');
    }
}
