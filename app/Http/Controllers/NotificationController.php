<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

use App\Notifications\VehicleTaxExpired;
use App\Notifications\VehicleControlExpired;
use App\Notifications\VehicleInsuranceExpired;
use App\Notifications\AgentConfirmedLevel;
use App\Models\Vehicle;
use App\Models\Agent;
use Carbon\Carbon;
use Mail;
use App\Mail\SendEmail;

class NotificationController extends Controller
{
   public function getNotifications()
   {
    Auth::user()->notifications()->delete();

    $current_date = Carbon::now();
    $userStructureId = Auth::user()->structure_id ? :-1;
    

    $role = Auth::user()->getRoleNames()->first();
    if ($role == 'user' ) {

        // $vehiclesWithExpiredInsurances = Vehicle::with('model.brand','insurances')->whereHas('latestInsurance', function ($query) use($current_date){
        //     $query->whereRaw("ended_at <= '$current_date'")
        //     ->orWhereRaw("ended_at <= DATE_ADD('$current_date', INTERVAL 30 DAY)");
        // })->orWhereDoesntHave('insurances')
        // ->groupBy("vehicles.id")->havingRaw("vehicles.structure_id = $userStructureId")->get();

        // $vehiclesWithExpiredTaxes = Vehicle::with('model.brand','annualTaxes')->whereHas('latestAnnualTax', function ($query) use($current_date){
        //     $query->whereRaw("DATE_ADD(bought_at, INTERVAL 1 YEAR) <= current_date")
        //     ->orWhereRaw('DATE_ADD(bought_at, INTERVAL 1 YEAR) <= DATE_ADD(now(), INTERVAL 30 DAY)');
        // })->orWhereDoesntHave('annualTaxes')
        // ->groupBy("vehicles.id")->havingRaw("vehicles.structure_id = $userStructureId")->get();

        // $vehiclesWithExpiredControls = Vehicle::with('model.brand','technicalControls')->whereHas('latestTechnicalControl', function ($query) use($current_date){
        //     $query->whereRaw("ends_at <= '$current_date'")
        //     ->orWhereRaw("ends_at <= DATE_ADD('$current_date', INTERVAL 30 DAY)");
        // })->orWhereDoesntHave('technicalControls')
        // ->groupBy("vehicles.id")->havingRaw("vehicles.structure_id = $userStructureId")->get();

            
            $agents = Agent::with('level','department','fonction','confirmedLevels')
            ->whereHas('confirmedLevels', function ($query) 
            {
                     $query->whereRaw("state = 'VALIDE'");})->whereHas('department', function ($query) 
            use($userStructureId,$current_date){
                     $query->whereRaw("structure_id = '$userStructureId'");});
                
           

        $AgentConfirmedLevel = $agents->whereHas('latestConfirmedLevel', function ($query) use($current_date){
            $query->whereRaw("next_at <= '$current_date'")
            ->orWhereRaw("next_at <= DATE_ADD('$current_date', INTERVAL 30 DAY)");
        })->orWhereDoesntHave('latestConfirmedLevel')
        ->groupBy("agents.id")->get();

    //     $AgentConfirmedLevel = Agent::select("SELECT
    //     *
    // FROM
    //     `agents`,departments
    // WHERE EXISTS
    //     (
    //     SELECT
    //         *
    //     FROM
    //         `confirmed_levels`
    //     WHERE
    //         `agents`.`id` = `confirmed_levels`.`agent_id` AND(
    //             next_at <= '$current_date' OR next_at <= DATE_ADD(
    //                 '$current_date',
    //                 INTERVAL 30 DAY
    //             )
    //         )
    // ) OR NOT EXISTS(
    //     SELECT
    //         *
    //     FROM
    //         `confirmed_levels`
    //     WHERE
    //         `agents`.`id` = `confirmed_levels`.`agent_id`
    // )
    // GROUP BY
    //     `agents`.`id`
    // HAVING
    //     departments.structure_id = $userStructureId");



        // $agentUnconfirmedLevels = Agent::with('level','fonction','department')->whereHas('latestConfirmedLevel', function ($query) use($current_date){
        //     $query->whereRaw("next_at <= '$current_date'")
        //     ->orWhereRaw("next_at <= DATE_ADD('$current_date', INTERVAL 30 DAY)");
        // })->orWhereDoesntHave('latestConfirmedLevel')
        // ->groupBy("agent.id")->havingRaw("agent.department.structure_id = $userStructureId")->get();


        // $vehiclesWithExpiredInsurances = Vehicle::with('department')->whereHas('department', function ($query) use($userStructureId){
        // $query->whereRaw("structure_id = '$userStructureId'")
        // ->orWhereRaw("ended_at <= DATE_ADD('$current_date', INTERVAL 30 DAY)");
        // })->orWhereDoesntHave('insurances')
        // ->groupBy("vehicles.id")->havingRaw("vehicles.structure_id = $userStructureId")->get();




        // $AgentConfirmedLevel = Agent::with('department')->whereHas('department', function ($query) use($userStructureId,$current_date){
        //     $query->whereRaw("structure_id = '$userStructureId'")
        //     ->whereRaw("recrutment_date <= '$current_date'")
        // ->orWhereRaw("recrutment_date <= DATE_ADD('$current_date', INTERVAL 30 DAY)");
        // })
        // ->groupBy("agents.id")->get();

        foreach ($AgentConfirmedLevel as $agent) {

            Auth::user()->notify( new AgentConfirmedLevel($agent));
        }

        // foreach ($vehiclesWithExpiredControls as $vehicle) {

        //     Auth::user()->notify( new VehicleControlExpired($vehicle));
        // }
        // foreach ($vehiclesWithExpiredTaxes as $vehicle) {

        //     Auth::user()->notify( new VehicleTaxExpired($vehicle));
        // }
        // foreach ($vehiclesWithExpiredInsurances as $vehicle) {

        //     Auth::user()->notify( new VehicleInsuranceExpired($vehicle));
        // }
    }
        // get fresh notifications
        $notifications = Auth::user()->unreadNotifications()->get();


        return response()->json([
            'notifications' => $notifications,
        ]);
   }

   public function markAsRead($id)
   {
       $notifications = Auth::user()->unreadNotifications()->findOrFail($id)->markAsRead();
        // get fresh notifications
        $notifications = Auth::user()->unreadNotifications()->get();

        return response()->json([
            'notifications' => $notifications,
        ]);
   }

   public function test()
   {
    $userStructureId = Auth::user()->structure_id ? :-1;
    $current_date = Carbon::now();
    // $vehicles = Vehicle::with('model.brand','technicalControls')->where("structure_id", Auth::user()->structure_id)->get();
    // $vehiclesWithExpiredControls = $vehicles->whereHas('latestTechnicalControl', function ($query) {
    //     $query->whereRaw("ends_at <= current_date")
    //     ->orWhereRaw('ends_at <= DATE_ADD(current_date, INTERVAL 30 DAY)');
    // })->orWhereDoesntHave('technicalControls')->get();
    // $vehiclesWithExpiredControls = Vehicle::where("structure_id", Auth::user()->structure_id)->with('model.brand','technicalControls')->whereHas('latestTechnicalControl', function ($query) {
    //     $query->whereRaw("ends_at <= current_date")
    //     ->orWhereRaw('ends_at <= DATE_ADD(current_date, INTERVAL 30 DAY)');
    // })->orWhereDoesntHave('technicalControls')->get();
    // $vehiclesWithExpiredControls = Vehicle::with('model.brand','technicalControls')->whereHas('latestTechnicalControl', function ($query) {
    //     $query->whereRaw("ends_at <= current_date")
    //     ->orWhereRaw('ends_at <= DATE_ADD(current_date, INTERVAL 30 DAY)');
    // })->orWhereDoesntHave('technicalControls')
    // ->groupBy("vehicles.id")->havingRaw("vehicles.structure_id = $userStructureId")->get();
    // $driversWithExpiredLicence = Driver::whereRaw("licence_experation_date <= '$current_date'")
    // ->orWhereRaw("licence_experation_date <= DATE_ADD('$current_date', INTERVAL 30 DAY)")
    // ->groupBy("drivers.id")->havingRaw("drivers.structure_id = $userStructureId")->get();

    // $vehiclesWithExpiredControls = Vehicle::with('model.brand','technicalControls')->whereHas('latestTechnicalControl', function ($query) use($current_date){
    //     $query->whereRaw("ends_at <= current_date")
    //     ->orWhereRaw("ends_at <= DATE_ADD('$current_date', INTERVAL 30 DAY)");
    // })->orWhereDoesntHave('technicalControls')
    // ->groupBy("vehicles.id")->havingRaw("vehicles.structure_id = $userStructureId")->get();
    // $vehiclesWithExpiredTaxes = Vehicle::with('model.brand','annualTaxes')->whereHas('latestAnnualTax', function ($query) use($current_date){
    //     $query->whereRaw("DATE_ADD(bought_at, INTERVAL 1 YEAR) <= current_date")
    //     ->orWhereRaw('DATE_ADD(bought_at, INTERVAL 1 YEAR) <= DATE_ADD(now(), INTERVAL 30 DAY)');
    // })->orWhereDoesntHave('annualTaxes')
    // ->groupBy("vehicles.id")->havingRaw("vehicles.structure_id = $userStructureId")->get();
    // $vehiclesWithExpiredInsurances = Vehicle::with('model.brand','insurances')->whereHas('latestInsurance', function ($query) use($current_date){
    //     $query->whereRaw("ended_at <= '$current_date'")
    //     ->orWhereRaw("ended_at <= DATE_ADD('$current_date', INTERVAL 30 DAY)");
    // })->orWhereDoesntHave('insurances')
    // ->groupBy("vehicles.id")->havingRaw("vehicles.structure_id = $userStructureId")->get();
    Mail::to('esselamia@cnas.com')->send(new SendEmail("lool", "this is an email test from laravel application"));
    // Mail::to('zegraouib@cnas.com')->send(new SendEmail("Testing email", "this is an email test from laravel application"));
       return "Mail sent";
   }

}
