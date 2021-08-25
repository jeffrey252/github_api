<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonthlyInstallment;
use \DateTime;

class MonthlyInstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $monthlyInstallment = new MonthlyInstallment($request->all());
        $monthlyInstallment->save();

        return $monthlyInstallment;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        $monthlyInstallment = MonthlyInstallment::where('user_id', $userId)->firstOrFail();
        $monthlyInstallment->amount /= 100;

        $origin = new DateTime($monthlyInstallment->start_date);
        $target = new DateTime();
        $interval = $origin->diff($target);
        $monthlyInstallment->remaining_months = $monthlyInstallment->terms - ($interval->m + ($interval->y * 12)) - 1;
        return $monthlyInstallment;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
