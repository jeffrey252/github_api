<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\MonthlyExpense;
use App\Models\SingleExpense;
use App\Models\MonthlyInstallment;

class BudgetForecastController extends Controller
{
    //

    public function generateReport($userId, $months)
    {
        /*$d = new \DateTime('first day of this month');
        echo $d->format('jS, F Y');
        $d->modify('+1 month');
        echo $d->format('jS, F Y');

        exit;
        */
        $monthlyInstallments = MonthlyInstallment::where('user_id', $userId)->get();
        $monthlyExpensesData = MonthlyExpense::where('user_id', $userId)->get();
        $monthlyExpenses = $monthlyExpensesData->sum('amount')/100;
        $singleExpenses = SingleExpense::where('user_id', $userId)->get();
        $salary = Salary::where('user_id', $userId)->firstOrFail();

        $singleExpensesData = [];
        foreach($singleExpenses AS $singleExpense) {
            $d = new \DateTime($singleExpense->expense_date);
            $d->modify('first day of this month');
            if (isset($singleExpensesData[$d->format('Y-m-d')])) {
                $singleExpensesData[$d->format('Y-m-d')] += $singleExpense->amount/100;
            } else {
                $singleExpensesData[$d->format('Y-m-d')] = $singleExpense->amount/100;
            }
        }


        //installments
        foreach($monthlyInstallments AS &$monthlyInstallment) {
            $monthlyInstallment = $monthlyInstallment->format();
        }

        $installmentsData = [];
        for ($x = 0; $x < $months; $x++) {
            $total = 0;
            foreach($monthlyInstallments AS $monthlyInstallment) {
                if($x < $monthlyInstallment->remaining_months) {
                    $total += $monthlyInstallment->amount;
                }
            }
            $installmentsData[] = $total;
        }

        //print_r($installmentsData);exit;

        $finalData = [];
        $data = [];
        $date = new \DateTime('first day of this month');
        $date->modify('+1 month');

        $netIncome = 2200;
        for($x = 0; $x < $months; $x++) {
            $data['start'] = $netIncome;
            $expenses = $monthlyExpenses+$installmentsData[$x];
            if(isset($singleExpensesData[$date->format('Y-m-d')])) {
                $expenses += $singleExpensesData[$date->format('Y-m-d')];
            }
            $data['expenses'] = $expenses;
            $data['salary'] = $salary->net_salary;
            $netIncome = $netIncome + $salary->net_salary - $expenses;
            $data['net_income'] = $netIncome;
            $finalData[$date->format('M Y')] = $data;
            $date->modify('+1 month');
            $data = [];
        }
        //return $finalData;

        echo '<h2>Monthly Expenses</h2>';
        echo '<table><tr><td>Description</td><td>Amount</td></tr>';
        foreach ($monthlyExpensesData AS $monthlyExpense) {
            echo '<tr><td>'.$monthlyExpense->description.'</td><td>'.($monthlyExpense->amount/100).'</td></tr>';
        }
        echo '</table>';

        echo '<h2>Monthly Installments</h2>';
        echo '<table><tr><td>Description</td><td>Amount</td><td>Remaining Months</td></tr>';
        foreach ($monthlyInstallments AS $monthlyInstallment) {
            echo '<tr><td>'.$monthlyInstallment->description.'</td><td>'.$monthlyInstallment->amount.'</td><td>'.$monthlyInstallment->remaining_months.'</tr>';
        }
        echo '</table>';

        echo '<h2>Budget Forecast</h2>';
        echo '<table><tr><td>Date</td><td>Current</td><td>Income</td><td>Expenses</td><td>Net Income</td></tr>';
        foreach($finalData AS $key => $value) {
            echo '<tr><td>'.$key.'</td><td>'.$value['start'].'</td><td>'.$value['salary'].'</td><td>'.$value['expenses'].'</td><td>'.$value['net_income'].'</td></tr>';
        }

        echo '</table>';
    }
}
