<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Expense;
use App\Share;
use App\SharePayment;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index() {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $users = User::all();

        return view('users.index', ['users' => $users]);
    }

    public function edit(User $user) {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user) {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        if(isset($request['password'])) {
            if($request['email'] == $user->email || $request['dni'] == $user->dni) {
                $validated = $request->validate([
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'dni' => ['required', 'string'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
					'commission' => ['required', 'numeric']
                ]);
            } else {
                $validated = $request->validate([
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'dni' => ['required', 'string', 'unique:users'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
					'commission' => ['required', 'numeric']
                ]);
            }

            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->dni = $validated['dni'];
            $user->email = $validated['email'];
            $user->commission = $validated['commission'];
            $user->password = Hash::make($validated['password']);

            $user->save();
            return redirect('/users');
        } else {
            if($request['email'] == $user->email || $request['dni'] == $user->dni) {
                $validated = $request->validate([
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'dni' => ['required', 'string'],
                    'email' => ['required', 'string', 'email', 'max:255'],
					'commission' => ['required', 'numeric']
                ]);
            }
            else {
                $validated = $request->validate([
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'dni' => ['required', 'string', 'unique:users'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
					'commission' => ['required', 'numeric']
                ]);
            }

            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->dni = $validated['dni'];
            $user->commission = $validated['commission'];
            $user->email = $validated['email'];

            $user->save();
            return redirect('/users');
        }
    }

    public function disable(User $user) {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $user->role = 'disabled';
        $user->save();

        return redirect('/users');
    }

    public function enable(User $user) {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $user->role = 'seller';
        $user->save();

        return redirect('/disabled-users');
    }

    public function disabledUsers()
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $users = User::where('role', 'disabled')->get();

        return view('users.disabledUsers', ['users' => $users]);
    }

    public function resume(User $user)
    {
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $today = Carbon::today();
        $sharePayments = SharePayment::whereDate('created_at', $today)->get();

        $shares = collect();
        $shares->paymentsCount = 0;
        $payed = 0;
        foreach($sharePayments as $sharePayment) {
			if($sharePayment->seller_id === $user->id) {
				$payed += $sharePayment->payment_amount;
				$shares->paymentsCount += 1;
			}
        }
        $shares->paymentsAmount = $payed;

        $expiredShares = Share::whereDate('expiration_date', '<', $today)->get();
        $shares->expiredCount = 0;
        $debt = 0;
        foreach($expiredShares as $expiredShare) {
			if($expiredShare->credit->seller_id === Auth::user()->id) {
				$debt += $expiredShare->money;
				$shares->expiredCount += 1;
			}
        }
        $shares->expiredAmount = $debt;

        $todayCredits = Credit::whereDate('created_at', $today)->where('seller_id', $user->id)->get();
        $credits = collect();

        $creditMoney = 0;
        foreach($todayCredits as $credit) {
            $creditMoney += $credit->money;
        }
        $credits->todayCount = $todayCredits->count();
        $credits->todayMoney = $creditMoney;

        $expiredCredits = Credit::where('expiration_date', '<', $today)->where('seller_id', $user->id)->where('credit_cancelled', 0)->get();
        $expiredMoney = 0;
        foreach($expiredCredits as $expiredCredit) {
            $expiredMoney += $expiredCredit->money;
        }
        $credits->expiredCount = $expiredCredits->count();
        $credits->expiredMoney = $expiredMoney;

        $cancelledCredits = Credit::whereDate('updated_at', $today)->whereColumn('updated_at', '>', 'created_at')->where('seller_id', $user->id)->where('credit_cancelled', 1)->get();
        $cancelledMoney = 0;
        foreach($cancelledCredits as $cancelledCredit) {
            $cancelledMoney += $cancelledCredit->money;
        }
        $credits->cancelledCount = $cancelledCredits->count();
        $credits->cancelledMoney = $cancelledMoney;

        $expenses = collect();
        $todayExpenses = Expense::whereDate('created_at', $today)->where('seller_id', $user->id)->where('description', '!=', null)->get();
        $expensesMoney = 0;
        foreach($todayExpenses as $expense) {
            $expensesMoney += $expense->money;
        }
        $expenses->expensesCount = $todayExpenses->count();
        $expenses->expensesMoney = $expensesMoney;
       
        

        return view('users.resume', [
            'user' => $user,
            'shares' => $shares,
            'credits' => $credits,
            'expenses' => $expenses,
            ]);
    }

	public function resumeShares(User $user)
	{
        if(Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $today = Carbon::today();
        $sharePayments = SharePayment::whereDate('created_at', $today)->get();

        $shares = collect();
		$shares->allPayed = collect();
        $shares->paymentsCount = 0;
        $payed = 0;
        foreach($sharePayments as $sharePayment) {
			if($sharePayment->seller_id === $user->id) {
				$payed += $sharePayment->payment_amount;
				$shares->paymentsCount += 1;
				$shares->allPayed->add($sharePayment);
			}
        }

        $shares->paymentsAmount = $payed;

        $expiredShares = Share::whereDate('expiration_date', '<', $today)->get();
		$shares->allExpired = collect();
        $shares->expiredCount = 0;
        $debt = 0;
        foreach($expiredShares as $expiredShare) {
			if($expiredShare->credit->seller_id === Auth::user()->id) {
				$debt += $expiredShare->money;
				$shares->expiredCount += 1;
				$shares->allExpired->add($expiredShare);
			}
        }
        $shares->expiredAmount = $debt;

		return view('users.resumeShares')->withShares($shares)->withUser($user);
	}

	public function resumeCredits(User $user)
	{
        $today = Carbon::today();

        $todayCredits = Credit::whereDate('created_at', $today)->where('seller_id', $user->id)->get();
        $credits = collect();
		$credits->allNormal = collect();

        $creditMoney = 0;
        foreach($todayCredits as $credit) {
            $creditMoney += $credit->money;
			$credits->allNormal->add($credit);
        }
        $credits->todayCount = $todayCredits->count();
        $credits->todayMoney = $creditMoney;

        $expiredCredits = Credit::where('expiration_date', '<', $today)->where('seller_id', $user->id)->where('credit_cancelled', 0)->get();
        $expiredMoney = 0;
		$credits->allExpired = collect();
        foreach($expiredCredits as $expiredCredit) {
            $expiredMoney += $expiredCredit->money;
			$credits->allExpired->add($expiredCredit);
        }
        $credits->expiredCount = $expiredCredits->count();
        $credits->expiredMoney = $expiredMoney;

        $cancelledCredits = Credit::whereDate('updated_at', $today)->whereColumn('updated_at', '>', 'created_at')->where('seller_id', $user->id)->where('credit_cancelled', 1)->get();
        $cancelledMoney = 0;
		$credits->allCancelled = collect();
        foreach($cancelledCredits as $cancelledCredit) {
            $cancelledMoney += $cancelledCredit->money;
			$credits->allCancelled->add($cancelledCredit);
        }
        $credits->cancelledCount = $cancelledCredits->count();
        $credits->cancelledMoney = $cancelledMoney;

		return view('users.resumeCredits')->withCredits($credits)->withUser($user);
	}

	public function resumeExpenses(User $user)
	{
        $today = Carbon::today();

        $expenses = collect();
		$expenses->allExpenses = collect();
        $todayExpenses = Expense::whereDate('created_at', $today)->where('seller_id', $user->id)->where('description', '!=', null)->get();
        $expensesMoney = 0;
        foreach($todayExpenses as $expense) {
            $expensesMoney += $expense->money;
			$expenses->allExpenses->add($expense);
        }
        $expenses->expensesCount = $todayExpenses->count();
        $expenses->expensesMoney = $expensesMoney;

		return view('users.resumeExpenses')->withExpenses($expenses)->withUser($user);
	}

    public function sellersReport()
    {
        return view('users.sellersReport');
    }

    public function findReport(Request $request)
    {
        $validated = $request->validate([
            'from' => ['required', 'date'],
            'until' => ['required', 'date']
        ]);

        $from = new Carbon($validated['from']);
        $until = new Carbon($validated['until']);

        $payments = SharePayment::whereBetween('created_at', [$from, $until])->get();

        if(empty($payments->first())) {
            return redirect()->back()->withInput();
        }

        $sellers = [];

        foreach($payments as $payment) {
            if(array_key_exists($payment->share->credit->seller->id, $sellers)) {
                $array = [
                    'payed' => $payment->payment_amount,
                    'share' => $payment->share,
                ];

                array_push($sellers[$payment->share->credit->seller->id]['credits'], $array);
            } else {
                $sellers[$payment->share->credit->seller->id] = [
                    'seller' => $payment->share->credit->seller,
                    'credits' => [
                        [
                            'payed' => $payment->payment_amount,
                            'share' => $payment->share,
                        ]
                    ],
                ];
            }
        }

        return view('users.sellersReport', ['sellers' => $sellers]);
    }

    public function search(Request $request)
    {
        if(isset($request->first_name)) {
            $validated = $request->validate([
                'first_name' => ['string', 'max:255']
            ]);

            $sellers = User::where('first_name', 'like', '%' . $validated['first_name'] . '%')->get();
            return view('initial_cash.results', ['sellers' => $sellers]);
        } elseif(isset($request->last_name)) {
            $validated = $request->validate([
                'last_name' => ['string', 'max:255']
            ]);

            $sellers = User::where('last_name', 'like', '%' . $validated['last_name'] . '%')->get();
            return view('initial_cash.results', ['sellers' => $sellers]);
        } elseif(isset($request->dni)) {
            $validated = $request->validate([
                'dni' => ['string']
            ]);

            $sellers = User::where('dni', $validated['dni'])->first();
        }

        return view('initial_cash.index', ['sellers' => $sellers]);
    }

    public function clientsView(User $user)
    {
    foreach($user->clients as $client) {
        $credits = $client->credits->where('credit_cancelled', '=', 0);
        $client->payed = 0;
        $client->totalCreditsValue = 0;
        foreach($credits as $credit) {
            $client->totalCreditsValue += $credit->money + $credit->profit + $credit->seller_profit;
            foreach($credit->shares as $share) {
                foreach($share->payments as $payments) {
                    $client->payed += $payments->payment_amount;
                }
            }
        }

        $client->debt = $client->totalCreditsValue - $client->payed;
    }
        
        return view('users.clients')->withUser($user);
    }
}
