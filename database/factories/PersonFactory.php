<?php

namespace Database\Factories;

use App\Models\Baptismal;
use App\Models\Engagment;
use App\Models\Family;
use App\Models\FamilyPersons;
use App\Models\Marriage;
use App\Models\Person;
use App\Models\PersonDiseases;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        foreach (Family::get() as $i) {
            $father = Person::create([
                'first_name' => $this->faker->randomElement([
                    'مارسيل', 'إيلي', 'مراد', 'شويري', 'نصري', 'باسل', 'خوليو', 'أميل', 'إيوان', 'ملحم', 'سامي', 'ناجي', 'نزار', 'وديع', 'مروان', 'غتوان', 'نبيل', 'قيس', 'كاسب', 'شاكر', 'نديم', 'فادي'
                ]),
                'last_name' => $this->faker->randomElement(['شموط', 'الياس', 'ابراهيم', 'عساف', 'سمعان', 'جروج', 'الراعي', 'سلوم', 'خضر', 'واصل', 'محفوض', 'السعد']),
                'phone' => '09' . $this->faker->numerify('########'),
                'ID_number' => $this->faker->numerify('###########'),
                'birthdate_place' => 'حماه-كفربهم',
                'birthdate' => $this->faker->dateTimeBetween('1960-01-01', '1980-2-6'),
                'gender' => $this->faker->randomElement(['ذكر']),
                'marital_status' => $this->faker->randomElement(['متجوز', 'أعزب', 'أرمل', 'مطلق']),
                'academic_title' => $this->faker->randomElement(['صيدلة', 'هندسة عمارة', 'هندسة مدنية', 'صف أول', 'صف ثاني', 'صف ثالث', 'صف رابع', 'صف خامس']),
                'study_phase' => $this->faker->randomElement(['حلقة أولى', 'حلقة ثانية', 'حلقة ثالثة', 'جامعة']),
                'work' => $this->faker->randomElement(['مهندس', 'طبيب', 'عامل', 'موظف', 'فلاح']),
                'registration_number' => $this->faker->numerify('###'),
                'registration_place' => 'حماه-كفربهم',
                'immigration' => $this->faker->randomElement([false, true]),
                'military_service' => $this->faker->randomElement([false, true]),
                'live_dead' => $this->faker->randomElement([false, true]),
            ]);
            $mother = Person::create([
                'first_name' => $this->faker->randomElement([
                    'فيفيان', 'افراميا', 'كرستين', 'كارولين', 'أديل', 'مارلي', 'ميريام', 'كريستينا', 'دولوريس', 'مرثا', 'دوللي', 'جيسيكا', 'جاسمين', 'آني', 'جينا', 'فيرونيا', 'مارتينا',
                ]),
                'last_name' => $this->faker->randomElement(['شموط', 'الياس', 'ابراهيم', 'عساف', 'سمعان', 'جروج', 'الراعي', 'سلوم', 'خضر', 'واصل', 'محفوض', 'السعد']),
                'phone' => '09' . $this->faker->numerify('########'),
                'ID_number' => $this->faker->numerify('###########'),
                'birthdate_place' => 'حماه-كفربهم',
                'birthdate' => $this->faker->dateTimeBetween('1970-01-01', '1980-2-6'),
                'gender' => $this->faker->randomElement(['أنثى']),
                'marital_status' => $this->faker->randomElement(['متجوز', 'أعزب', 'أرمل', 'مطلق']),
                'academic_title' => $this->faker->randomElement(['صيدلة', 'هندسة عمارة', 'هندسة مدنية', 'صف أول', 'صف ثاني', 'صف ثالث', 'صف رابع', 'صف خامس']),
                'study_phase' => $this->faker->randomElement(['حلقة أولى', 'حلقة ثانية', 'حلقة ثالثة', 'جامعة']),
                'work' => $this->faker->randomElement(['مهندس', 'طبيب', 'عامل', 'موظف', 'فلاح']),
                'registration_number' => $this->faker->numerify('###'),
                'registration_place' => 'حماه-كفربهم',
                'immigration' => $this->faker->randomElement([false, true]),
                'military_service' => false,
                'live_dead' => $this->faker->randomElement([false, true]),
            ]);

            FamilyPersons::create([
                'family_id' => $i->id,
                'person_id' => $father->id,
                'adjective' => 'أب'
            ]);
            
            Baptismal::create([
                'person_id' => $father->id,
                'godfather_id' => Person::all()->random()->id ?? 0,
                'baptismal_date' => $this->faker->dateTimeBetween('1970-01-01', '1990-2-6'),
                'baptismal_place' => $this->faker->randomElement(['حماه-كفربهم', 'حماه', 'حمص', 'حلب']),
                'baptismal_record_number' => $this->faker->numerify('####'),
                'page_number' => $this->faker->numerify('###'),
                'baptized_father' => $this->faker->randomElement([
                    'افرام الياس', 'غيفارا شموط', 'جورج محفوض'
                ]),
            ]);
            FamilyPersons::create([
                'family_id' => $i->id,
                'person_id' => $mother->id,
                'adjective' => 'أم'
            ]);
            Baptismal::create([
                'person_id' => $mother->id,
                'godfather_id' => Person::all()->random()->id ?? 0,
                'baptismal_date' => $this->faker->dateTimeBetween('1970-01-01', '1990-2-6'),
                'baptismal_place' => $this->faker->randomElement(['حماه-كفربهم', 'حماه', 'حمص', 'حلب']),
                'baptismal_record_number' => $this->faker->numerify('####'),
                'page_number' => $this->faker->numerify('###'),
                'baptized_father' => $this->faker->randomElement([
                    'افرام الياس', 'غيفارا شموط', 'جورج محفوض'
                ]),
            ]);

            Engagment::create([
                'husband_id' => $father->id,
                'wife_id' => $mother->id,
                'baptized_father' => $this->faker->randomElement([
                    'افرام الياس', 'غيفارا شموط', 'جورج محفوض'
                ]),
                'registration_date' => $this->faker->dateTimeBetween('2010-01-01', '2024-2-6'),
                'record_number' => $this->faker->numerify('####'),
            ]);
            Marriage::create([
                'husband_id' => $father->id,
                'wife_id' => $mother->id,
                'baptized_father' => $this->faker->randomElement([
                    'افرام الياس', 'غيفارا شموط', 'جورج محفوض'
                ]),
                'registration_date' => $this->faker->dateTimeBetween('2010-01-01', '2024-2-6'),
                'record_number' => $this->faker->numerify('####'),
            ]);

            $disease_name = $this->faker->randomElement([
                'حساسية', 'سكري', 'ضغط', 'ربو', 'ديسك', 'زهايمر',
                'ضعف بصر', 'ضعف سمع', 'بحصة', 'رمل', false
            ]);
            $treatment = $this->faker->randomElement([
                'سيتامول', 'انسولين', 'بروفين', 'باراسيتامول', 'بيتا سبرك', 'كاريزول',
                'اغومنتين', 'سيتاكودائين', 'امبرازول', 'نيو ايد'
            ]);
            if ($disease_name) {
                PersonDiseases::create([
                    'person_id' => $father->id,
                    'disease_name' => $disease_name,
                    'treatment' => $treatment
                ]);
            }

            $disease_name = $this->faker->randomElement([
                'حساسية', 'سكري', 'ضغط', 'ربو', 'ديسك', 'زهايمر',
                'ضعف بصر', 'ضعف سمع', 'بحصة', 'رمل', false
            ]);
            $treatment = $this->faker->randomElement([
                'سيتامول', 'انسولين', 'بروفين', 'باراسيتامول', 'بيتا سبرك', 'كاريزول',
                'اغومنتين', 'سيتاكودائين', 'امبرازول', 'نيو ايد'
            ]);
            if ($disease_name) {
                PersonDiseases::create([
                    'person_id' => $mother->id,
                    'disease_name' => $disease_name,
                    'treatment' => $treatment
                ]);
            }

            for ($j = 1; $j <= rand(1, 5); $j++) {
                $gender = $this->faker->randomElement(['ذكر', 'أنثى']);
                $study_phase = $this->faker->randomElement(['رياض أطفال', 'حلقة أولى', 'حلقة ثانية', 'حلقة ثالثة', 'جامعة']);
                switch ($study_phase) {
                    case 'رياض أطفال';
                        $academic_title = $this->faker->randomElement(['تحضيري', 'روضة']);
                        break;
                    case 'حلقة أولى';
                        $academic_title = $this->faker->randomElement(['صف أول', 'صف ثاني', 'صف ثالث', 'صف رابع', 'صف خامس']);
                        break;
                    case 'حلقة ثانية';
                        $academic_title = $this->faker->randomElement(['صف سابع', 'صف ثامن', 'صف تاسع']);
                        break;
                    case 'حلقة ثالثة';
                        $academic_title = $this->faker->randomElement(['صف عاشر', 'صف ثاني عاشر', 'صف ثالث عاشر']);
                        break;
                    case 'جامعة';
                        $academic_title = $this->faker->randomElement(['صيدلة', 'هندسة عمارة', 'هندسة مدنية']);
                        break;
                    default:
                        $academic_title = "";
                        break;
                }
                $child = Person::create([
                    'first_name' => ($gender == 'ذكر') ? $this->faker->randomElement([
                        'مارسيل', 'إيلي', 'مراد', 'شويري', 'نصري', 'باسل', 'خوليو', 'أميل', 'إيوان', 'ملحم', 'سامي', 'ناجي', 'نزار', 'وديع', 'مروان', 'غتوان', 'نبيل', 'قيس', 'كاسب', 'شاكر', 'نديم', 'فادي',
                    ])
                        :
                        $this->faker->randomElement([
                            'فيفيان', 'افراميا', 'كرستين', 'كارولين', 'أديل', 'مارلي', 'ميريام', 'كريستينا', 'دولوريس', 'مرثا', 'دوللي', 'جيسيكا', 'جاسمين', 'آني', 'جينا', 'فيرونيا', 'مارتينا',
                        ]),
                    'last_name' => $father->last_name,
                    'phone' => '09' . $this->faker->numerify('########'),
                    'ID_number' => $this->faker->numerify('###########'),
                    'birthdate_place' => 'حماه-كفربهم',
                    'birthdate' => $this->faker->dateTimeBetween('2000-01-01', '2010-2-6'),
                    'gender' => $gender,
                    'marital_status' => $this->faker->randomElement(['متجوز', 'أعزب', 'أرمل', 'مطلق']),
                    'study_phase' => $study_phase,
                    'academic_title' => $academic_title,
                    'work' => $this->faker->randomElement(['مهندس', 'طبيب', 'عامل', 'موظف', 'فلاح']),
                    'registration_number' => $this->faker->numerify('###'),
                    'registration_place' => 'حماه-كفربهم',
                    'immigration' => $this->faker->randomElement([false, true]),
                    'military_service' => ($gender == 'ذكر') ? $this->faker->randomElement([false, true]) : false,
                    'live_dead' => $this->faker->randomElement([false, true]),
                ]);
                FamilyPersons::create([
                    'family_id' => $i->id,
                    'person_id' => $child->id,
                    'adjective' => 'أبن'
                ]);
                Baptismal::create([
                    'person_id' => $child->id,
                    'godfather_id' => Person::all()->random()->id,
                    'baptismal_date' => $this->faker->dateTimeBetween('2000-01-01', '2000-2-6'),
                    'baptismal_place' => $this->faker->randomElement(['حماه-كفربهم', 'حماه', 'حمص', 'حلب']),
                    'baptismal_record_number' => $this->faker->numerify('####'),
                    'page_number' => $this->faker->numerify('####'),
                    'baptized_father' => $this->faker->randomElement([
                        'افرام الياس', 'غيفارا شموط', 'جورج محفوض'
                    ]),
                ]);

                $disease_name = $this->faker->randomElement([
                    'حساسية', 'سكري', 'ضغط', 'ربو', 'ديسك', 'زهايمر',
                    'ضعف بصر', 'ضعف سمع', 'بحصة', 'رمل', false
                ]);
                $treatment = $this->faker->randomElement([
                    'سيتامول', 'انسولين', 'بروفين', 'باراسيتامول', 'بيتا سبرك', 'كاريزول',
                    'اغومنتين', 'سيتاكودائين', 'امبرازول', 'نيو ايد'
                ]);
                if ($disease_name) {
                    PersonDiseases::create([
                        'person_id' => $child->id,
                        'disease_name' => $disease_name,
                        'treatment' => $treatment
                    ]);
                }
            }
        }
    }
}
