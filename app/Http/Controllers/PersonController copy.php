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

            $persons = Person::join('family_persons', function ($q) {
                return $q->on('family_persons.person_id', '=', 'persons.id')
                    ->join('families', 'families.id', '=', 'family_persons.family_id');
            })->with('adjectives', 'diseases')->select('persons.*', 'families.id as family_id')->orderby('id', 'ASC')->paginate(50);


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

            return $persons;
        } else {
            return response()->json([
                'message' => 'Empty data',
                'status' => 'success',
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

            return response()->json($person);
        } else {
            return 'error';
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

        return $persons;
    }

    public function filter_person_birthdate(Request $request)
    {

        $persons = Person::join('family_persons', function ($q) {
            return $q->on('family_persons.person_id', '=', 'persons.id')
                ->join('families', 'families.id', '=', 'family_persons.family_id');
        })
            ->with('adjectives', 'diseases')->select('persons.*', 'families.id as family_id')
            ->where('birthdate', 'LIKE',  "%$request->filter_key%")
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

        return $persons;
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

        return $persons;
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

        return $persons;
    }


    // Certificates

    public function baptismal_certificate(Request $request)
    {
        $person = Person::with('adjectives', 'baptismal')->find($request->id);

        if (!isset($person->baptismal)) {
            return '';
        }

        $godFatherName = Person::find($person->baptismal->godfather_id);

        $person['godfather'] = $godFatherName->first_name . ' ' . $godFatherName->last_name;
        $person['father_name'] = '';
        $person['mother_name'] = '';
        foreach ($person->adjectives as $key => $adjective) {
            if ($adjective->adjective == 'أبن') {
                $person['father_name'] = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                    ->where('family_persons.family_id', '=', $adjective->family_id)
                    ->where('family_persons.person_id', '<>', $person->id)
                    ->where('family_persons.adjective', '=', 'أب')
                    ->select('persons.first_name', 'family_persons.family_id', 'family_persons.adjective')
                    ->get()[0]->first_name ?? '';

                $mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
                    ->where('family_persons.family_id', '=', $adjective->family_id)
                    ->where('family_persons.person_id', '<>', $person->id)
                    ->where('family_persons.adjective', '=', 'أم')
                    ->select('persons.first_name', 'persons.last_name', 'family_persons.family_id', 'family_persons.adjective')
                    ->get()->first() ?? '';
                $person['mother_name'] = $mother->first_name . " " . $mother->last_name;
            }
        };

        unset($person->adjectives);

        return $person;
    }

    public function engagment_certificate(Request $request)
    {

        $engagment = Engagment::where('husband_id', '=', $request->id)->get()->first();
        if (!isset($engagment)) {
            return '';
        }

        $engagment['husband'] = Person::find($request->id);

        $husband_family_id = FamilyPersons::where('person_id', '=', $request->id)
            ->where('adjective', '=', 'أبن')->get()->first()->family_id;
        $husband_mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
            ->where('family_persons.family_id', '=',  $husband_family_id)
            ->where('family_persons.adjective', '=', 'أم')
            ->select('persons.first_name', 'persons.last_name')
            ->get()
            ->first();
        $engagment['husband']['mother_name'] = $husband_mother->first_name . ' ' . $husband_mother->last_name;

        $husband_father = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
            ->where('family_persons.family_id', '=',  $husband_family_id)
            ->where('family_persons.adjective', '=', 'أب')
            ->select('persons.first_name')
            ->get()
            ->first();
        $engagment['husband']['father_name'] = $husband_father->first_name;



        $engagment['wife'] = Person::find($engagment->wife_id);

        // get family id for wife to get her mother name
        $wife_family_id = FamilyPersons::where('person_id', '=', $engagment->wife_id)
            ->where('adjective', '=', 'أبن')->get()->first()->family_id;

        $wife_mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
            ->where('family_persons.family_id', '=',  $wife_family_id)
            ->where('family_persons.adjective', '=', 'أم')
            ->select('persons.first_name', 'persons.last_name')
            ->get()
            ->first();
        $engagment['wife']['mother_name'] = $wife_mother->first_name . ' ' . $wife_mother->last_name;

        $wife_father = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
            ->where('family_persons.family_id', '=',  $wife_family_id)
            ->where('family_persons.adjective', '=', 'أب')
            ->select('persons.first_name')
            ->get()
            ->first();
        $engagment['wife']['father_name'] = $wife_father->first_name;
        return $engagment;
    }

    public function marriage_certificate(Request $request)
    {
        $marriage = Marriage::where('husband_id', '=', $request->id)->get()->first();

        if (!isset($marriage)) {
            return '';
        }

        $marriage['husband'] = Person::find($request->id);


        $husband_family_id = FamilyPersons::where('person_id', '=', $request->id)
            ->where('adjective', '=', 'أبن')->get()->first()->family_id;
        $husband_mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
            ->where('family_persons.family_id', '=',  $husband_family_id)
            ->where('family_persons.adjective', '=', 'أم')
            ->select('persons.first_name', 'persons.last_name')
            ->get()
            ->first();
        $marriage['husband']['mother_name'] = $husband_mother->first_name . ' ' . $husband_mother->last_name;

        $husband_father = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
            ->where('family_persons.family_id', '=',  $husband_family_id)
            ->where('family_persons.adjective', '=', 'أب')
            ->select('persons.first_name')
            ->get()
            ->first();
        $marriage['husband']['father_name'] = $husband_father->first_name;



        $marriage['wife'] = Person::find($marriage->wife_id);

        // get family id for wife to get her mother name
        $wife_family_id = FamilyPersons::where('person_id', '=', $marriage->wife_id)
            ->where('adjective', '=', 'أبن')->get()->first()->family_id;

        $wife_mother = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
            ->where('family_persons.family_id', '=',  $wife_family_id)
            ->where('family_persons.adjective', '=', 'أم')
            ->select('persons.first_name', 'persons.last_name')
            ->get()
            ->first();
        $marriage['wife']['mother_name'] = $wife_mother->first_name . ' ' . $wife_mother->last_name;

        $wife_father = FamilyPersons::join('persons', 'persons.id', '=', 'family_persons.person_id')
            ->where('family_persons.family_id', '=',  $wife_family_id)
            ->where('family_persons.adjective', '=', 'أب')
            ->select('persons.first_name')
            ->get()
            ->first();
        $marriage['wife']['father_name'] = $wife_father->first_name;
        return $marriage;
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
}
