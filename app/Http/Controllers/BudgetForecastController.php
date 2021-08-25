<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;

class BudgetForecastController extends Controller
{
    //

    public function addSalary(Request $request)
    {
        $salary = new Salary($request->all());
        $salary->save();

        return $salary;
    }
}
