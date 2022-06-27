<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Payment;
use App\Datatables\PaymentDatatable;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

class PaymentController extends Controller
{
    /**
     * Share the model name and route with the view
     */
    public function __construct()
    {
        $modelName = 'Payment';
        $route = 'payments';

        $methods = [
            'Cash',
            'Debit/Credit',
            'Online Banking',
            'eWallet'
        ];

        //TODO: Add more banks
        $banks = [
            'Maybank2U'
        ];

        View::share(compact('modelName', 'route', 'methods', 'banks'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with(['order', 'order.customer', 'order.table'])->get();
        $table = new PaymentDatatable($payments);
        $hideCreateButton = true;

        return view('payments.index', compact('table', 'hideCreateButton'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orderID = request()->orderID;
        $payment = Payment::where('order_id', $orderID)->first();

        if ($payment)
            return Redirect::route('payments.edit', $payment->id);

        $order = Order::with('table')->find($orderID);

        if (is_null($order))
            return redirect()->route('orders.index')->with('error_message', 'No order found');

        if (is_null($order->total))
            return redirect()->route('orders.edit', $order->id)->with('error_message', 'Please add some items');

        return view('payments.create', compact('order',));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePaymentRequest $request)
    {
        $validatedRequest = $request->validated();
        $validatedRequest['paid_at'] = Carbon::now();
        Payment::create($validatedRequest);

        return redirect()->route('payments.index')
            ->with('success_message', 'Payment added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $id = $payment->id;
        $order = Order::find($payment->order_id);

        return view('payments.edit', compact('payment', 'order', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $validatedRequest = $request->validated();
        if ($validatedRequest['method'] != 2) {
            $validatedRequest['bank'] = null;
        }
        $payment->update($validatedRequest);

        return redirect()->route('payments.index')
            ->with('success_message', 'Payment modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')
            ->with('success_message', 'Payment deleted successfully');
    }
}
