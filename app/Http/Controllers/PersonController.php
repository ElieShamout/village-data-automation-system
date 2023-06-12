<?php

namespace App\Http\Controllers;

use App\Models\Engagment;
use App\Models\Family;
use App\Models\FamilyPersons;
use App\Models\Marriage;
use App\Models\Person;
use App\Models\PersonDiseases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    public function persons()
    {

        if (Person::get()->count()) {

            // $persons = Person::join('family_persons', function ($q) {
            //     return $q->on('family_persons.person_id', '=', 'persons.id')
            //         ->join('families', 'families.id', '=', 'family_persons.family_id');
            // })
            //     ->with('adjectives', 'diseases')
            //     ->select('persons.*', 'families.id as family_id')
            //     ->orderby('id', 'ASC')
            //     ->paginate(50);

            $persons = Person::with('adjectives', 'diseases')
                ->orderby('id', 'ASC')
                ->paginate(50);

            foreach ($persons as $person) {
                foreach ($person->adjectives as $key => $adjective) {
                    if ($adjective->adjective == 'أبن') {
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

            return response()->json([
                'message' => 'get data',
                'status' => true,
                'persons' => $persons
            ]);
        } else {
            return response()->json([
                'message' => 'Empty data',
                'status' => false,
                'persons' => []
            ]);
        }
    }

    public function person(Request $request)
    {
        // check family person
        if ($person = Person::with('adjectives', 'diseases')->find($request->person_id)) {
            // get perents
            foreach ($person->adjectives as $key => $adjective) {
                if ($adjective->adjective == 'أبن') {
                    $person['father_name'] = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=', $adjective->family_id)
                        ->where('family_persons.person_id', '<>', $person->person_id)
                        ->where('family_persons.adjective', '=', 'أب')
                        ->select('persons.first_name', 'family_persons.family_id', 'family_persons.adjective')
                        ->get()[0]->first_name ?? '';

                    $person['mother_name'] = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=', $adjective->family_id)
                        ->where('family_persons.person_id', '<>', $person->person_id)
                        ->where('family_persons.adjective', '=', 'أم')
                        ->select('persons.first_name', 'family_persons.family_id', 'family_persons.adjective')
                        ->get()[0]->first_name ?? '';
                }
            };

            $person['family'] = Family::with('persons')->where('id', '=', $request->family_id)->first();
            foreach ($person->family->persons as $key => $p) {
                $person->family->persons[$key]['adjectives'] = FamilyPersons::where('family_persons.person_id', '=', $p->id)->get();
            }

            return response()->json([
                'status' => true,
                'message' => 'Data obtained successfully',
                'person' => $person
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'The specified person does not exist',
                'person' => []
            ]);
        }
    }

    public function filter_person_name(Request $request)
    {

        $persons = Person::join('family_persons', function ($q) {
            return $q->on('family_persons.person_id', '=', 'persons.id')
                ->join('families', 'families.id', '=', 'family_persons.family_id');
        })
            ->with('adjectives', 'diseases')->select('persons.*', 'families.id as family_id')
            ->where('first_name', 'LIKE', $request->filter_key . '%')
            ->paginate(50);

        foreach ($persons as $key => $person) {
            foreach ($person->adjectives as $key => $adjective) {
                if ($adjective->adjective == 'أبن') {
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

        return response()->json([
            'message' => 'get data',
            'status' => true,
            'persons' => $persons
        ]);
    }

    public function filter_person_birthdate(Request $request)
    {

        // return response()->json([
        //     'message' => 'get data',
        //     'status' => true,
        //     'persons' => $request->filter_key
        // ]);

        $persons = Person::join('family_persons', function ($q) {
            return $q->on('family_persons.person_id', '=', 'persons.id')
                ->join('families', 'families.id', '=', 'family_persons.family_id');
        })
            ->with('adjectives', 'diseases')->select('persons.*', 'families.id as family_id')
            ->where('birthdate', 'LIKE', "$request->filter_key%")
            ->paginate(50);

        foreach ($persons as $key => $person) {
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

        return response()->json([
            'message' => 'get data',
            'status' => true,
            'persons' => $persons
        ]);
    }
    public function filter_person_idnumber(Request $request)
    {

        $persons = Person::join('family_persons', function ($q) {
            return $q->on('family_persons.person_id', '=', 'persons.id')
                ->join('families', 'families.id', '=', 'family_persons.family_id');
        })
            ->with('adjectives', 'diseases')->select('persons.*', 'families.id as family_id')
            ->where('ID_number', 'LIKE',  $request->filter_key . '%')
            ->paginate(50);

        foreach ($persons as $key => $person) {
            foreach ($person->adjectives as $key => $adjective) {
                if ($adjective->adjective == 'أبن') {
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

        return response()->json([
            'message' => 'get data',
            'status' => true,
            'persons' => $persons
        ]);
    }
    public function filter_person_registernumber(Request $request)
    {

        $persons = Person::join('family_persons', function ($q) {
            return $q->on('family_persons.person_id', '=', 'persons.id')
                ->join('families', 'families.id', '=', 'family_persons.family_id');
        })
            ->with('adjectives', 'diseases')->select('persons.*', 'families.id as family_id')
            ->where('registration_number', 'LIKE',  $request->filter_key . '%')
            ->paginate(50);

        foreach ($persons as $key => $person) {
            foreach ($person->adjectives as $key => $adjective) {
                if ($adjective->adjective == 'أبن') {
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

        return response()->json([
            'message' => 'get data',
            'status' => true,
            'persons' => $persons
        ]);
    }


    // Certificates

    public function baptismal_certificate(Request $request)
    {

        if ($certificate = Person::with('adjectives', 'baptismal')->find($request->id)) {

            $godFatherName = Person::find($certificate->baptismal->godfather_id);

            $certificate['godfather'] = $godFatherName->first_name . ' ' . $godFatherName->last_name;
            $certificate['father_name'] = '';
            $certificate['mother_name'] = '';
            foreach ($certificate->adjectives as $key => $adjective) {
                if ($adjective->adjective == 'أبن') {
                    $certificate['father_name'] = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=', $adjective->family_id)
                        ->where('family_persons.person_id', '<>', $certificate->id)
                        ->where('family_persons.adjective', '=', 'أب')
                        ->select('persons.first_name', 'family_persons.family_id', 'family_persons.adjective')
                        ->get()[0]->first_name ?? '';

                    $mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=', $adjective->family_id)
                        ->where('family_persons.person_id', '<>', $certificate->id)
                        ->where('family_persons.adjective', '=', 'أم')
                        ->select('persons.first_name', 'persons.last_name', 'family_persons.family_id', 'family_persons.adjective')
                        ->get()->first() ?? '';
                    $certificate['mother_name'] = $mother->first_name . " " . $mother->last_name;
                }
            };

            unset($certificate->adjectives);

            return response()->json([
                'message' => 'get data',
                'status' => true,
                'certificate' => $certificate
            ]);
        } else {
            return response()->json([
                'message' => 'get data',
                'status' => true,
                'certificate' => []
            ]);
        }
    }

    public function engagment_certificate(Request $request)
    {
        if (Person::find($request->id)) {

            if (
                $certificate = Engagment::where('husband_id', '=', $request->id)->get()->first()
            ) {
                $certificate['husband'] = Person::find($request->id);

                if ($husband_family = FamilyPersons::where('person_id', '=', $request->id)
                    ->where('adjective', '=', 'أبن')->get()->first()
                ) {
                    $husband_mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $husband_family->family_id)
                        ->where('family_persons.adjective', '=', 'أم')
                        ->select('persons.first_name', 'persons.last_name')
                        ->get()
                        ->first();
                    $certificate['husband']['mother_name'] = $husband_mother->first_name . ' ' . $husband_mother->last_name;

                    $husband_father = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $husband_family->family_id)
                        ->where('family_persons.adjective', '=', 'أب')
                        ->select('persons.first_name')
                        ->get()
                        ->first();
                    $certificate['husband']['father_name'] = $husband_father->first_name;
                } else {
                    return response()->json([
                        'message' => 'husband family not found',
                        'status' => false,
                        'code' => '2',
                        'certificate' => []
                    ]);
                }

                $certificate['wife'] = Person::find($certificate->wife_id);
                if ($wife_family = FamilyPersons::where('person_id', '=', $certificate->wife_id)
                    ->where('adjective', '=', 'أبن')->get()->first()
                ) {
                    $wife_mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $wife_family->family_id)
                        ->where('family_persons.adjective', '=', 'أم')
                        ->select('persons.first_name', 'persons.last_name')
                        ->get()
                        ->first();
                    $certificate['wife']['mother_name'] = $wife_mother->first_name . ' ' . $wife_mother->last_name;

                    $wife_father = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $wife_family->family_id)
                        ->where('family_persons.adjective', '=', 'أب')
                        ->select('persons.first_name')
                        ->get()
                        ->first();
                    $certificate['wife']['father_name'] = $wife_father->first_name;
                } else {
                    return response()->json([
                        'message' => 'wife family not found',
                        'status' => false,
                        'code' => '3',
                        'certificate' => []
                    ]);
                }

                return response()->json([
                    'adj' => 'اب',
                    'message' => 'certificate not found',
                    'status' => true,
                    'certificate' => $certificate,
                ]);
            } else if (
                $certificate = Engagment::where('wife_id', '=', $request->id)->get()->first()
            ) {
                $certificate['wife'] = Person::find($request->id);

                if ($wife_family = FamilyPersons::where('person_id', '=', $request->id)
                    ->where('adjective', '=', 'أبن')->get()->first()
                ) {
                    $wife_mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $wife_family->family_id)
                        ->where('family_persons.adjective', '=', 'أم')
                        ->select('persons.first_name', 'persons.last_name')
                        ->get()
                        ->first();
                    $certificate['wife']['mother_name'] = $wife_mother->first_name . ' ' . $wife_mother->last_name;

                    $wife_father = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $wife_family->family_id)
                        ->where('family_persons.adjective', '=', 'أب')
                        ->select('persons.first_name')
                        ->get()
                        ->first();
                    $certificate['wife']['father_name'] = $wife_father->first_name;
                } else {
                    return response()->json([
                        'message' => 'wife family not found',
                        'status' => false,
                        'code' => '2',
                        'certificate' => []
                    ]);
                }

                $certificate['husband'] = Person::find($certificate->husband_id);


                if ($husband_family = FamilyPersons::where('person_id', '=', $certificate->husband_id)
                    ->where('adjective', '=', 'أبن')->get()->first()
                ) {
                    $husband_mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $husband_family->family_id)
                        ->where('family_persons.adjective', '=', 'أم')
                        ->select('persons.first_name', 'persons.last_name')
                        ->get()
                        ->first();
                    $certificate['husband']['mother_name'] = $husband_mother->first_name . ' ' . $husband_mother->last_name;

                    $husband_father = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $husband_family->family_id)
                        ->where('family_persons.adjective', '=', 'أب')
                        ->select('persons.first_name')
                        ->get()
                        ->first();
                    $certificate['husband']['father_name'] = $husband_father->first_name;
                } else {
                    return response()->json([
                        'message' => 'husband family not found',
                        'status' => false,
                        'code' => '3',
                        'certificate' => []
                    ]);
                }

                // return $certificate;


                return response()->json([
                    'adj' => 'ام',

                    'message' => 'certificate not found',
                    'status' => true,
                    'certificate' => $certificate
                ]);
            } else {
                return response()->json([
                    'message' => 'certificate not found',
                    'status' => false,
                    'code' => '1',
                    'certificate' => []
                ]);
            }
        } else {
            return response()->json([
                'message' => 'person not found',
                'status' => false,
                'code' => '0',
                'certificate' => []
            ]);
        }
    }

    public function marriage_certificate(Request $request)
    {
        if (Person::find($request->id)) {

            if ($certificate = Marriage::where('husband_id', '=', $request->id)->get()->first()) {
                $certificate['husband'] = Person::find($request->id);

                if ($husband_family = FamilyPersons::where('person_id', '=', $request->id)
                    ->where('adjective', '=', 'أبن')->get()->first()
                ) {
                    $husband_mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $husband_family->family_id)
                        ->where('family_persons.adjective', '=', 'أم')
                        ->select('persons.first_name', 'persons.last_name')
                        ->get()
                        ->first();
                    $certificate['husband']['mother_name'] = $husband_mother->first_name . ' ' . $husband_mother->last_name;

                    $husband_father = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $husband_family->family_id)
                        ->where('family_persons.adjective', '=', 'أب')
                        ->select('persons.first_name')
                        ->get()
                        ->first();
                    $certificate['husband']['father_name'] = $husband_father->first_name;
                } else {
                    return response()->json([
                        'message' => 'husband family not found',
                        'status' => false,
                        'code' => '2',
                        'certificate' => []
                    ]);
                }

                $certificate['wife'] = Person::find($certificate->wife_id);
                if ($wife_family = FamilyPersons::where('person_id', '=', $certificate->wife_id)
                    ->where('adjective', '=', 'أبن')->get()->first()
                ) {
                    $wife_mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $wife_family->family_id)
                        ->where('family_persons.adjective', '=', 'أم')
                        ->select('persons.first_name', 'persons.last_name')
                        ->get()
                        ->first();
                    $certificate['wife']['mother_name'] = $wife_mother->first_name . ' ' . $wife_mother->last_name;

                    $wife_father = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $wife_family->family_id)
                        ->where('family_persons.adjective', '=', 'أب')
                        ->select('persons.first_name')
                        ->get()
                        ->first();
                    $certificate['wife']['father_name'] = $wife_father->first_name;
                } else {
                    return response()->json([
                        'message' => 'wife family not found',
                        'status' => false,
                        'code' => '3',
                        'certificate' => []
                    ]);
                }

                return response()->json([
                    'message' => 'certificate not found',
                    'status' => true,
                    'certificate' => $certificate
                ]);
            } else if ($certificate = Marriage::where('wife_id', '=', $request->id)->get()->first()) {
                $certificate['wife'] = Person::find($certificate->wife_id);

                if ($wife_family = FamilyPersons::where('person_id', '=', $request->id)
                    ->where('adjective', '=', 'أبن')->get()->first()
                ) {
                    $wife_mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $wife_family->family_id)
                        ->where('family_persons.adjective', '=', 'أم')
                        ->select('persons.first_name', 'persons.last_name')
                        ->get()
                        ->first();
                    $certificate['wife']['mother_name'] = $wife_mother->first_name . ' ' . $wife_mother->last_name;

                    $wife_father = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $wife_family->family_id)
                        ->where('family_persons.adjective', '=', 'أب')
                        ->select('persons.first_name')
                        ->get()
                        ->first();
                    $certificate['wife']['father_name'] = $wife_father->first_name;
                } else {
                    return response()->json([
                        'message' => 'wife family not found',
                        'status' => false,
                        'code' => '2',
                        'certificate' => []
                    ]);
                }

                $certificate['husband'] = Person::find($certificate->husband_id);
                if ($husband_family = FamilyPersons::where('person_id', '=', $certificate->husband_id)
                    ->where('adjective', '=', 'أبن')->get()->first()
                ) {
                    $husband_mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $husband_family->family_id)
                        ->where('family_persons.adjective', '=', 'أم')
                        ->select('persons.first_name', 'persons.last_name')
                        ->get()
                        ->first();
                    $certificate['husband']['mother_name'] = $husband_mother->first_name . ' ' . $husband_mother->last_name;

                    $husband_father = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                        ->where('family_persons.family_id', '=',  $husband_family->family_id)
                        ->where('family_persons.adjective', '=', 'أب')
                        ->select('persons.first_name')
                        ->get()
                        ->first();
                    $certificate['husband']['father_name'] = $husband_father->first_name;
                } else {
                    return response()->json([
                        'message' => 'husband family not found',
                        'status' => false,
                        'code' => '3',
                        'certificate' => []
                    ]);
                }

                return response()->json([
                    'message' => 'certificate not found',
                    'status' => true,
                    'certificate' => $certificate
                ]);
            } else {
                return response()->json([
                    'message' => 'certificate not found',
                    'status' => false,
                    'code' => '1',
                    'certificate' => []
                ]);
            }
        } else {
            return response()->json([
                'message' => 'person not found',
                'status' => false,
                'code' => '0',
                'certificate' => []
            ]);
        }
    }

    // Add new Person
    public function add_new_person(Request $request)
    {

        if (Family::find($request->family_id)) {
            if (isset($request->ID_number)) {
                if (Person::where('ID_number', '=', $request->ID_number)->first()) {
                    return response()->json([
                        'status' => false,
                        'code' => '1',
                        'message' => 'alreade exsits',
                    ]);
                }
            }

            $newPerson = null;
            $family = null;
            DB::transaction(function () use ($request, &$newPerson, &$family) {

                try {
                    $newPerson = Person::create([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'phone' => $request->phone ?? null,
                        'ID_number' => $request->ID_number ?? null,
                        'birthdate_place' => $request->birthdate_place ?? null,
                        'birthdate' => $request->birthdate ?? null,
                        'gender' => $request->gender ?? null,
                        'marital_status' => $request->marital_status ?? null,
                        'study_phase' => $request->study_phase ?? null,
                        'academic_title' => $request->academic_title ?? null,
                        'work' => $request->work ?? null,
                        'registration_number' => $request->registration_number ?? null,
                        'registration_place' => $request->registration_place ?? null,
                        'military_service' => $request->soldier,
                        'immigration' => $request->migrated,
                        'live_dead' => $request->died,
                    ]);

                    foreach ($request->diseases as $disease) {
                        PersonDiseases::create([
                            'person_id' => $newPerson->id,
                            'disease_name' => $disease['name'],
                            'treatment' => $disease['medicament']
                        ]);
                    }


                    $family = FamilyPersons::create([
                        'family_id' => $request->family_id, 'adjective' => $request->adjective, 'person_id' => $newPerson->id
                    ]);
                } catch (\Exception $exp) {
                    DB::rollBack();
                }
            });
            $person = Person::with('adjectives', 'diseases')->find($newPerson->id);
            return response()->json([
                'status' => true,
                'code' => '2',
                'message' => 'success',
                'person' => $person
            ]);
        } else {
            return response()->json([
                'status' => false,
                'code' => '0',
                'message' => 'family not exsits',
            ]);
        }
    }

    public function check_person_id_number(Request $request)
    {
        return Person::where('id_number', '=', $request->id_number)->count();
    }


    public function edit_person(Request $request)
    {
        if (Person::find($request->id)) {
            $person = Person::find($request->id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'ID_number' => $request->ID_number,
                'birthdate_place' => $request->birthdate_place,
                'birthdate' => $request->birthdate,
                'gender' => $request->gender,
                'marital_status' => $request->marital_status,
                'academic_title' => $request->academic_title,
                'study_phase' => $request->study_phase,
                'work' => $request->work,
                'registration_number' => $request->registration_number,
                'registration_place' => $request->registration_place,
                'soldier' => $request->soldier,
                'immigration' => $request->immigration,
                'military_service' => $request->military_service,
                'live_dead' => $request->live_dead,
            ]);

            if ($person) {
                return response()->json([
                    'status' => true,
                    'code' => '200',
                    'message' => 'person has been updated successfully'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'code' => '500',
                    'message' => 'person not updated, something went wrong! please try again'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => '404',
                'message' => 'person not found'
            ]);
        }
    }

    public function remove_person_disease(Request $request)
    {
        if (PersonDiseases::find($request->id)) {

            if (PersonDiseases::find($request->id)->where('person_id', '=', $request->person_id)) {

                if (PersonDiseases::find($request->id)->delete()) {
                    return response()->json([
                        'status' => true,
                        'code' => 200,
                        'messgage' => 'disease has removed successfully'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'code' => 500,
                        'messgage' => 'somthing went wrong please try again'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 301,
                    'messgage' => 'disease dose not belonge for this person'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => 404,
                'messgage' => 'disease not found'
            ]);
        }
    }

    public function add_person_disease(Request $request)
    {
        if (Person::find($request->id)) {
            $disease = PersonDiseases::create([
                'person_id' => $request->id,
                'disease_name' => $request->name,
                'treatment' => $request->medicament
            ]);

            if ($disease) {
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'messgage' => 'disease has added successfully',
                    'disease' => $disease
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 500,
                    'messgage' => 'disease dose not added'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => 404,
                'messgage' => 'person not found'
            ]);
        }
    }

    public function separate_person_family(Request $request)
    {
        if ($adj = FamilyPersons::find($request->id)) {


            if ($adj->delete()) {
                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'messgage' => 'link has remove successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 500,
                    'messgage' => 'link has not removed'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => 404,
                'messgage' => 'link not found'
            ]);
        }
    }

    public function add_person_adjective(Request $request)
    {
        if (Person::find($request->person_id)) {
            if (Family::find($request->family_id)) {
                if (
                    !FamilyPersons::where('family_id', '=', $request->family_id)
                        ->where('person_id', '=', $request->person_id)
                        ->first()
                ) {

                    if ($request->adjective == 'أب' || $request->adjective == "أم") {
                        if (FamilyPersons::where('family_id', '=', $request->family_id)
                            ->where('adjective', '=', $request->adjective)
                            ->first()
                        ) {
                            return response()->json([
                                'status' => false,
                                'code' => 502,
                                'messgage' => 'you can not add two "' . $request->adjective . '"'
                            ]);
                        }
                    }

                    if (FamilyPersons::where('person_id', '=', $request->person_id)
                        ->where('adjective', '=', $request->adjective)
                        ->first()
                    ) {
                        return response()->json([
                            'status' => false,
                            'code' => 504,
                            'messgage' => 'you can not add person two time like "' . $request->adjective . '"'
                        ]);
                    }


                    $check = FamilyPersons::create([
                        'family_id' => $request->family_id,
                        'person_id' => $request->person_id,
                        'adjective' => $request->adjective,
                    ]);

                    if ($check) {
                        return response()->json([
                            'status' => true,
                            'code' => 200,
                            'messgage' => 'the link has added successfully',
                            'adjective' => $check
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'code' => 503,
                            'messgage' => 'somethenk went wrong please try again'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => false,
                        'code' => 501,
                        'messgage' => 'the link has added before!'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 405,
                    'messgage' => 'family not found'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => 404,
                'messgage' => 'person not found'
            ]);
        }
    }


    public function delete_person(Request $request)
    {
        if ($person = Person::find($request->id)) {

            if ($person->delete()) {

                return response()->json([
                    'status' => true,
                    'code' => 200,
                    'message' => 'person has removed successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'code' => 500,
                    'message' => 'something went wrong please try again'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'code' => 404,
                'message' => 'person not found'
            ]);
        }
    }
}
