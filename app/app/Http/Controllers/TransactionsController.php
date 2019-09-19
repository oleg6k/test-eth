<?php


namespace App\Http\Controllers;


use App\WalletTransaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
  public function index(Request $request)
  {
      /** @var WalletTransaction[] $transactions */
      $transactions = WalletTransaction::with('wallet')->limit(50)->get();
      return response(['transactions'=>$transactions]);
  }
}