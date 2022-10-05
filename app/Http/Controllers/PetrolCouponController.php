<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\View;
use App\Models\PetrolCoupon;
use App\Models\Driver;
use App\Models\Vehicle;

class PetrolCouponController extends Controller
{
    public function index()
    {
        $role = Auth::user()->getRoleNames()->first();
        switch ($role) {
            case 'chef_parc':
                $vehicles = Vehicle::with('petrolCoupons')->where('structure_id',Auth::user()->structure_id)->get();
                return view('parc_manager.petrolCoupons_list',compact('vehicles'));
                break;
            case 'responsable_patrimoine':
            $vehicles = Vehicle::with('petrolCoupons')->where('structure_id',Auth::user()->structure_id)->get();
            return view('parc_manager.petrolCoupons_list',compact('vehicles'));
                break;
            case 'superviseur':
            $vehicles = Vehicle::with('petrolCoupons')->where('structure_id',Auth::user()->structure_id)->get();
            return view('parc_manager.petrolCoupons_list',compact('vehicles'));
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getPetrolCoupons()
    {
        $structure_id = Auth::user()->structure_id;
        $vehicles = Vehicle::with('model.brand','energyType')->where('structure_id', Auth::user()->structure_id)->get();
        $drivers = Driver::where('structure_id', Auth::user()->structure_id)->get();
        $petrolCoupons = PetrolCoupon::with('vehicle.model.brand','driver')
            ->whereHas('vehicle', function ($query)
                {
                    $query->where('structure_id', '=', Auth::user()->structure_id);
                })
                ->whereHas('driver', function ($query)
                {
                    $query->where('structure_id', '=', Auth::user()->structure_id);
                })
        ->get();

        $coupons = \DB::table('petrol_coupons')
            ->select("assigned_at"
                ,\DB::raw("(GROUP_CONCAT(coupon_number)) as `coupons`"))
            ->groupBy('assigned_at')
            ->get();
            // $petrolCoupons_agency_month = \DB::select("SELECT (SELECT s.name FROM vehicles v,structures s WHERE v.structure_id = s.id AND 
            //     v.id = p.vehicle_id ) AS AGENCE, DATE_FORMAT(p.assigned_at, '%M/%Y') AS ASSIGNED_AT,    (
            //     LENGTH(TRIM(BOTH ',' FROM GROUP_CONCAT(coupon_number))) - LENGTH(REPLACE(TRIM(BOTH ',' FROM GROUP_CONCAT(coupon_number)
            //             ),',','')) + 1) AS PETROL_COUPONS FROM `petrol_coupons` p GROUP BY vehicle_id");

            $petrolCoupons_agency_month = \DB::select("SELECT
            idMonth,
            MONTHNAME(STR_TO_DATE(idMonth, '%m')) as m,
            IFNULL((
                  LENGTH(
                      TRIM(
                          BOTH ','
                      FROM
                          GROUP_CONCAT(p.coupon_number)
                      )
                  ) - LENGTH(
                  REPLACE
                      (
                          TRIM(
                              BOTH ','
                          FROM
                              GROUP_CONCAT(p.coupon_number)
                          ),
                          ',',
                          ''
                      )
              ) + 1
              ), 0) as total
          FROM petrol_coupons p
          right JOIN (
            SELECT 1 as idMonth
            UNION SELECT 2 as idMonth
            UNION SELECT 3 as idMonth
            UNION SELECT 4 as idMonth
            UNION SELECT 5 as idMonth
            UNION SELECT 6 as idMonth
            UNION SELECT 7 as idMonth
            UNION SELECT 8 as idMonth
            UNION SELECT 9 as idMonth
            UNION SELECT 10 as idMonth
            UNION SELECT 11 as idMonth
            UNION SELECT 12 as idMonth
          ) as Month
          ON Month.idMonth = month(assigned_at)
          and p.vehicle_id in (select v.id FROM vehicles v, structures s WHERE s.id = $structure_id and v.structure_id = s.id)
          GROUP BY Month.idMonth");



        return response()->json([
            'vehicles' => $vehicles,
            'drivers' => $drivers,
            'petrolCoupons' => $petrolCoupons,
            'coupons' => $coupons,
            'petrolCoupons_agency_month' => $petrolCoupons_agency_month,
        ]);
    }
    public function getCoupons()
    {
        // $coupons = PetrolCoupon::with('vehicle.model.brand','driver')
        // ->whereHas('vehicle', function ($query)
        //     {
        //         $query->where('structure_id', '=', Auth::user()->structure_id);
        //     })
        //     ->whereHas('driver', function ($query)
        //     {
        //         $query->where('structure_id', '=', Auth::user()->structure_id);
        //     })->select('petrol_coupons.*', \DB::raw('group_concat(coupon_number) as coupon_numbers'))
        //                         ->groupBy('petrol_coupons.assigned_at')
        //                         ->get();
        $petrolCoupons_agency_month = \DB::select("SELECT (SELECT s.name FROM vehicles v,structures s WHERE v.structure_id = s.id AND v.id = p.vehicle_id ) AS AGENCE, CONCAT(MONTH(assigned_at),'/',YEAR(assigned_at)) AS ASSIGNED_AT,    (
            LENGTH(
                TRIM(
                    BOTH ','
                FROM
                    GROUP_CONCAT(coupon_number)
                )
            ) - LENGTH(
            REPLACE
                (
                    TRIM(
                        BOTH ','
                    FROM
                        GROUP_CONCAT(coupon_number)
                    ),
                    ',',
                    ''
                )
        ) + 1
        ) AS PETROL_COUPONS, p.assigned_at FROM `petrol_coupons` p GROUP BY vehicle_id,YEAR(assigned_at),MONTH(assigned_at)");

        // $vehicles = Vehicle::with('model.brand','energyType')->where('structure_id', Auth::user()->structure_id)->get();
        // $drivers = Driver::where('structure_id', Auth::user()->structure_id)->get();
        // $coupons = PetrolCoupon::with('vehicle.model.brand','driver')
        //     ->whereHas('vehicle', function ($query)
        //         {
        //             $query->where('structure_id', '=', Auth::user()->structure_id);
        //         })
        //         ->whereHas('driver', function ($query)
        //         {
        //             $query->where('structure_id', '=', Auth::user()->structure_id);
        //         })
        // ->get();
        return response()->json([
            // 'vehicles' => $vehicles,
            // 'drivers' => $drivers,
            'coupons' => $petrolCoupons_agency_month
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $petrolCoupon = PetrolCoupon::create($request->all());
        return response()->json([
            'success'=>'Informations ajoutées avec succès',
            'petrolCoupon' => $petrolCoupon
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $petrolCoupon = PetrolCoupon::findOrFail($id);
        $petrolCoupon = $petrolCoupon->update($request->all());

        return response()->json([
            'success'=>'Informations modifiées avec succès',
            'petrolCoupon' => $petrolCoupon
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $petrolCoupon = PetrolCoupon::findOrFail($id);
        $petrolCoupon->delete();

        return response()->json([
            'success'=>'Informations supprimées avec succès',
            ]);
    }
}
