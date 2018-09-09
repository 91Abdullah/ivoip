<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use Carbon\Carbon;
use App\Queue;
use App\QueueLog;
use App\Cdr;
use App\Role;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    
    public function boot()
    {
        View::composer('dashboard.index', function ($view) {

            $date = Carbon::parse("2018-08-15");
            $totalCalls = QueueLog::whereDate("created", $date->format("Y-m-d"))
            ->whereIn("event", ["ENTERQUEUE"])
            ->get()
            ->count();

            $answered =  QueueLog::whereDate("created", $date->format("Y-m-d"))
            ->whereIn("event", ["CONNECT"])
            ->get()
            ->count();

            $abandoned = QueueLog::whereDate("created", $date->format("Y-m-d"))
            ->whereIn("event", ["ABANDON"])
            ->get()
            ->count();

            $avgTalkTime = QueueLog::whereDate("created", $date->format("Y-m-d"))
            ->whereIn("event", ["COMPLETECALLER", "COMPLETEAGENT"])
            ->get()
            ->avg->data2; 

            $answerRate = $answered/$totalCalls * 100;
            $abandonRate = $abandoned/$totalCalls * 100;

            $role = Role::whereIn("name", ["Outbound", "Blended"])->get();
            $outNums = $role->map(function ($item, $key) {
                return $item->users;
            })->flatten()->pluck("extension");

            $outCalls = Cdr::whereDate("start", $date->format("Y-m-d"))
            ->whereIn("src", $outNums)
            ->get();

            $outCount = $outCalls->count();
            $outAnswered = $outCalls->filter(function ($item, $key) {
                return $item->disposition == "ANSWERED";
            })->count();

            $outDuration = $outCalls->filter(function ($item, $key) {
                return $item->disposition == "ANSWERED";
            })->sum->billsec;

            $outAvg = $outCalls->filter(function ($item, $key) {
                return $item->disposition == "ANSWERED";
            })->avg->billsec;

            $outAnsRate = $outAnswered/$outCount * 100;
            $outNoAnsRate = ($outCount - $outAnswered)/$outCount * 100;

            $view->with(compact('totalCalls', 'answered', 'abandoned', 'answerRate', 'abandonRate', 'avgTalkTime', 'outCount', 'outAnswered', 'outDuration', 'outAvg', 'outAnsRate', 'outNoAnsRate'));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('composer', function ($app) {
            return new Composer($app['files'], $app->basePath());
        });
    }
}