<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transactionList()
    {
        $transaction = Transaction::select('*',DB::raw('DATE_FORMAT(created_at, "%m/%d/%Y %H:%i") as formatted_date'))->orderBy('created_at', 'desc')->get()->toArray();
        return response()->json([ 'status' => '200', 'list' => $transaction ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addTransaction(Request $request)
    {
        $last_transaction = Transaction::select('*')->latest()->first();
        if(!empty($last_transaction)){
            $balance = $last_transaction->balance;
        } else {
            $balance = 0;
        }

        $transaction = new Transaction();
        $transaction->type = $request->transaction_type;
        $transaction->amount = $request->amount;
        $transaction->description = $request->description;
        if($request->transaction_type == Transaction::TYPE_CREDIT){
            $transaction->balance = $balance + $request->amount;
        } else {
            $transaction->balance = $balance - $request->amount;
        }
        if($transaction->save()){
            return response()->json([ 'status' => '200', 'message' => 'Successfully created' ]);
        } else {
            return response()->json([ 'status' => '500', 'message' => 'Something went wrong' ]); 
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
