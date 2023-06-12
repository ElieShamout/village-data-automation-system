<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\FamilyPersons;
use App\Models\Person;
use Illuminate\Http\Request;

class FamiliesController extends Controller
{

    public function all_families(Family $family)
    {
        $families = Family::with('persons')->paginate(100);

        if ($families->total()) {
            foreach ($families as $key => $family) {
                $analisis = $this->families_analysis($family->persons);

                $families[$key]['total_single'] = $analisis['total_single'];
                $families[$key]['total_marriad'] = $analisis['total_marriad'];
                $families[$key]['total_died'] = $analisis['total_died'];
                $families[$key]['persons_total'] = $analisis['persons_total'];


                foreach ($family->persons as $key => $person) {
                    $family->persons[$key]['adjectives'] = FamilyPersons::where('family_persons.person_id', '=', $person->id)->get();
                }
            }

            return response()->json([
                'message' => 'get data successfully',
                'status' => 'success',
                'families' => $families
            ]);
        } else {
            return response()->json([
                'message' => 'Empty data',
                'status' => 'success',
                'families' => []
            ]);
        }
    }

    static function families_analysis($persons)
    {

        // total of persons
        $total = $persons->count();

        // total of marriad persons
        $marriad = ($persons->filter(function ($per) {
            return $per->marital_status != 'أعزب';
        }))->count();

        // total of singles persons
        $single = ($persons->filter(function ($per) {
            return $per->marital_status === 'أعزب';
        }))->count();

        // total of died persons
        $died = $persons->filter(function ($per) {
            return $per->live_dead;
        })->count();

        return [
            'total_single' => $single,
            'total_marriad' => $marriad,
            'total_died' => $died,
            'persons_total' => $total,
        ];
    }

    public function family(Request $request)
    {
        if ($family = Family::with('persons')->find($request->family_id)) {

            foreach ($family->persons as $key => $person) {
                $family->persons[$key]['adjectives'] = FamilyPersons::where('family_persons.person_id', '=', $person->id)->get();

                foreach ($person->adjectives as $key => $adjective) {
                    if ($adjective->adjective == 'أبن') {
                        // هون عم يجيب اسم الأب من نفس العائلة ويعطي للأم وعم يجيب اسم الأم ويعطي للاب على انو هيي ام الأب
                        $person['father_name'] = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                            ->where('family_persons.family_id', '=', $adjective->family_id)
                            ->where('family_persons.person_id', '<>', $person->id)
                            ->where('family_persons.adjective', '=', 'أب')
                            ->select('persons.first_name', 'family_persons.family_id', 'family_persons.adjective')
                            ->get()[0]->first_name ?? '';

                        $person['mother_name'] = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                            ->where('family_persons.family_id', '=', $adjective->family_id)
                            ->where('family_persons.person_id', '<>', $person->id)
                            ->where('family_persons.adjective', '=', 'أم')
                            ->select('persons.first_name', 'family_persons.family_id', 'family_persons.adjective')
                            ->get()[0]->first_name ?? '';
                    }
                };
            }

            if ($family) {
                return response()->json([
                    'status' => true,
                    'message' => 'get family successfull',
                    'family' => $family,
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Family dosn\'t exsits',
                'family' => [],
            ], 200);
        }
    }

    /**
     * Filtering
     * 
     */
    public function family_id(Request $request)
    {
        $families = Family::with('persons')->where('id', 'LIKE', $request->filter_key . "%")->paginate(100);

        foreach ($families as $key => $family) {
            $analisis = $this->families_analysis($family->persons);

            $families[$key]['total_single'] = $analisis['total_single'];
            $families[$key]['total_marriad'] = $analisis['total_marriad'];
            $families[$key]['total_died'] = $analisis['total_died'];
            $families[$key]['persons_total'] = $analisis['persons_total'];
        }
        return response()->json([
            'message' => 'get data successfully',
            'status' => 'success',
            'families' => $families
        ]);
    }
    public function family_registration_summary_number(Request $request)
    {
        $families = Family::with('persons')->where('registration_summary_number', 'LIKE',  $request->filter_key . '%')->paginate(100);

        foreach ($families as $key => $family) {
            $analisis = $this->families_analysis($family->persons);

            $families[$key]['total_single'] = $analisis['total_single'];
            $families[$key]['total_marriad'] = $analisis['total_marriad'];
            $families[$key]['total_died'] = $analisis['total_died'];
            $families[$key]['persons_total'] = $analisis['persons_total'];
        }
        return response()->json([
            'message' => 'get data successfully',
            'status' => 'success',
            'families' => $families
        ]);
    }
    public function family_phone(Request $request)
    {
        $families = Family::with('persons')->where('phone', 'LIKE',  $request->filter_key . '%')->paginate(100);

        foreach ($families as $key => $family) {
            $analisis = $this->families_analysis($family->persons);

            $families[$key]['total_single'] = $analisis['total_single'];
            $families[$key]['total_marriad'] = $analisis['total_marriad'];
            $families[$key]['total_died'] = $analisis['total_died'];
            $families[$key]['persons_total'] = $analisis['persons_total'];
        }
        return response()->json([
            'message' => 'get data successfully',
            'status' => 'success',
            'families' => $families
        ]);
    }
    public function family_landline_phone_number(Request $request)
    {
        $families = Family::with('persons')->where('landline_phone_number', 'LIKE',  $request->filter_key . '%')->paginate(100);

        foreach ($families as $key => $family) {
            $analisis = $this->families_analysis($family->persons);

            $families[$key]['total_single'] = $analisis['total_single'];
            $families[$key]['total_marriad'] = $analisis['total_marriad'];
            $families[$key]['total_died'] = $analisis['total_died'];
            $families[$key]['persons_total'] = $analisis['persons_total'];
        }
        return response()->json([
            'message' => 'get data successfully',
            'status' => 'success',
            'families' => $families
        ]);
    }

    // public function family_address(Request $request)
    // {
    //     if ($request->block && $request->district) {
    //         $families = Family::with('persons')->where('district_number', '=',  $request->district)->where('block_number', '=',  $request->block)->paginate(100);
    //     } else if ($request->block && !$request->district) {
    //         $families = Family::with('persons')->where('block_number', '=',  $request->block)->paginate(100);
    //     } else if (!$request->block && $request->district) {
    //         $families = Family::with('persons')->where('district_number', '=',  $request->district)->paginate(100);
    //     } else {
    //         $families = Family::with('persons')->paginate(100);
    //     }

    //     foreach ($families as $key => $family) {
    //         $analisis = $this->families_analysis($family->persons);

    //         $families[$key]['total_single'] = $analisis['total_single'];
    //         $families[$key]['total_marriad'] = $analisis['total_marriad'];
    //         $families[$key]['total_died'] = $analisis['total_died'];
    //         $families[$key]['persons_total'] = $analisis['persons_total'];
    //     }


    //     return response()->json([
    //         'message' => 'get data successfully',
    //         'status' => 'success',
    //         'families' => $families
    //     ]);
    // }


    // Add new family

    public function check_exists_family($rsn)
    {
        return Family::where('registration_summary_number', '=', $rsn)->get();
    }

    public function add_new_family(Request $request)
    {
        $family = Family::create([
            'registration_summary_number' => $request->registration_summary_number,
            'landline_phone_number' => $request->landline_phone_number,
            'phone' => $request->phone,
            'current_place_of_residence' => $request->current_place_of_residence,
            'accommodation_type' => $request->accommodation_type,
            'monthly_rent_value' => $request->monthly_rent_value,
            'district_number' => $request->district,
            'block_number' => $request->block,
            'notes' => $request->notes,
        ]);

        if ($family) {
            return response()->json([
                'status' => true,
                'message' => 'add family successfully',
                'family' => $family
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'family dosn\'t added',
                'family' => []
            ]);
        }
    }


    public function edit_family(Request $request)
    {
        if (Family::find($request->id)) {
            $family = Family::find($request->id)->update([
                'registration_summary_number' => $request->registration_summary_number,
                'landline_phone_number' => $request->landline_phone_number,
                'phone' => $request->phone,
                'current_place_of_residence' => $request->current_place_of_residence,
                'accommodation_type' => $request->accommodation_type,
                'monthly_rent_value' => $request->monthly_rent_value,
                'district_number' => $request->district,
                'block_number' => $request->block,
                'notes' => $request->notes,
            ]);

            if ($family) {
                return response()->json([
                    'status' => true,
                    'message' => 'update family successfully',
                    'family' => $family
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'family dosn\'t updated',
                    'family' => []
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'family not found',
                'family' => []
            ]);
        }
    }

    public function delete_family(Request $request)
    {
        if ($family = Family::find($request->id)) {
            if ($family->delete()) {
                $familyPersonsLinks = FamilyPersons::where('family_id', '=', $request->id);
                if (!$familyPersonsLinks->delete()) {
                    return response()->json([
                        'status' => true,
                        'code' => '200',
                        'message' => 'family has removed successfully'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'code' => '501',
                        'message' => 'something went wrong please try again'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'code' => '500',
                    'message' => 'something went wrong please try again'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => '404',
                'message' => 'family not found'
            ]);
        }
    }
}
