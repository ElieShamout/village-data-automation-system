<template>
  <div class="d-flex justify-content-between">
    <PageTitle pageTitle="تعديل بيانات العائلة" />
    <div class="">
      <BackBtn />
    </div>
  </div>
  <Spinner v-if="spinner" />

  <div class="row mt-5" v-else>
    <div
      class="col-12 col-xl-6 col-lg-7 col-md-9 m-auto bg-light shadow rounded"
    >
      <form action="" @submit.prevent="updatePerson">
        <div class="row my-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              الرقم الوطني
              <div class="text-danger mx-1" v-if="!person.ID_number">
                *
              </div></label
            >
            <input
              type="text"
              class="form-control"
              v-model="person.ID_number"
              placeholder="EX. 521XXXXXXXX"
              dir="ltr"
              @keyup="checkIdNumber"
            />
            <div class="text-danger mt-2" v-if="errors.ID_number.status">
              {{ errors.ID_number.message }}
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              الاسم الأول
              <div class="text-danger mx-1" v-if="!person.first_name">
                *
              </div></label
            >
            <input
              type="text"
              class="form-control"
              v-model="person.first_name"
              placeholder="EX. الياس"
              dir="ltr"
            />
          </div>
        </div>
        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              الكنية
              <div class="text-danger mx-1" v-if="!person.last_name">
                *
              </div></label
            >
            <input
              type="text"
              class="form-control"
              v-model="person.last_name"
              placeholder="EX. الياس"
              dir="ltr"
            />
          </div>
        </div>
        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              رقم الموبايل
              <div class="text-danger mx-1" v-if="!person.phone">*</div></label
            >
            <input
              type="text"
              class="form-control"
              v-model="person.phone"
              placeholder="EX. 09XXXXXXXX"
              dir="ltr"
              maxlength="10"
              @keyup="checkPhoneNumber"
            />
            <div class="text-danger mt-2" v-if="errors.phone.status">
              {{ errors.phone.message }}
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              مكان الميلاد
              <div class="text-danger mx-1" v-if="!person.birthdate_place">
                *
              </div></label
            >
            <input
              type="text"
              class="form-control"
              v-model="person.birthdate_place"
              placeholder="EX. كفربهم"
              dir="ltr"
            />
          </div>
        </div>
        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              تاريخ الميلاد
              <div class="text-danger mx-1" v-if="!person.birthdate">
                *
              </div></label
            >
            <input
              type="date"
              class="form-control"
              v-model="person.birthdate"
              placeholder="EX. 521XXXXXXXX"
              dir="ltr"
            />
          </div>
        </div>
        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              الجنس
              <div class="text-danger mx-1" v-if="!person.gender">*</div></label
            >
            <select class="form-select" v-model="person.gender" dir="ltr">
              <option value="" class="d-none">الجنس</option>
              <option value="ذكر">ذكر</option>
              <option value="أنثى">أنثى</option>
              <option @click="person.gender == ''" class="text-danger" value="">
                مسح التحديد
              </option>
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              الحالة الأجتماعية
              <div class="text-danger mx-1" v-if="!person.marital_status">
                *
              </div></label
            >
            <select
              class="form-select"
              v-model="person.marital_status"
              dir="ltr"
            >
              <option value="" class="d-none">الحالة الاجتماعية</option>
              <option value="اعزب">اعزب</option>
              <option value="متجوز">متجوز</option>
              <option value="مطلق">مطلق</option>
              <option value="ارمل">ارمل</option>
              <option
                @click="person.marital_status == ''"
                class="text-danger"
                value=""
              >
                مسح التحديد
              </option>
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              المرحلة الدراسية
              <div class="text-danger mx-1" v-if="!person.study_phase">
                *
              </div></label
            >
            <select class="form-select" v-model="person.study_phase" dir="ltr">
              <option value="" class="d-none">المرحلة الدراسية</option>
              <option value="مرحلة اولى">مرحلة أولى (ابتدائية)</option>
              <option value="مرحلة ثانية">مرحلة ثانية (إعدادية)</option>
              <option value="مرحلة ثالثة">مرحلة ثالثة (ثانوية)</option>
              <option value="جامعة">جامعة</option>
              <option
                @click="person.study_phase == ''"
                class="text-danger"
                value=""
              >
                مسح التحديد
              </option>
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              المسمى الدراسي
              <div class="text-danger mx-1" v-if="!person.academic_title">
                *
              </div></label
            >
            <input
              type="text"
              class="form-control"
              v-model="person.academic_title"
              placeholder="EX. هندسة مدنية"
              dir="ltr"
            />
          </div>
        </div>
        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              العمل
              <div class="text-danger mx-1" v-if="!person.work">*</div></label
            >
            <input
              type="text"
              class="form-control"
              v-model="person.work"
              placeholder="EX. موظف"
              dir="ltr"
            />
          </div>
        </div>
        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              رقم القيد
              <div class="text-danger mx-1" v-if="!person.registration_number">
                *
              </div></label
            >
            <input
              v-model="person.registration_number"
              type="text"
              class="form-control"
              placeholder="EX. 2XX"
              dir="ltr"
              @keyup="ckeckRegisterNumber"
            />
            <div
              class="text-danger mt-2"
              v-if="errors.registration_number.status"
            >
              {{ errors.registration_number.message }}
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              مكان القيد
              <div class="text-danger mx-1" v-if="!person.registration_place">
                *
              </div></label
            >
            <input
              v-model="person.registration_place"
              type="text"
              class="form-control"
              placeholder="EX. حماه-كفربهم"
              dir="ltr"
            />
          </div>
        </div>

        <div class="row mb-3 ps-4">
          <div class="input-field">
            <label class="col-form-label d-flex"> معلومات أخرى </label>
            <div class="row">
              <div class="form-check col-4 mb-2" dir="ltr">
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="person.soldier"
                  id="soldier"
                />
                <label class="form-check-label" for="soldier"> عسكري </label>
              </div>
              <div class="form-check col-4 mb-2" dir="ltr">
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="person.died"
                  id="died"
                />
                <label class="form-check-label" for="died"> متوفي </label>
              </div>
              <div class="form-check col-4 mb-2" dir="ltr">
                <input
                  class="form-check-input"
                  type="checkbox"
                  v-model="person.migrated"
                  id="migrated"
                />
                <label class="form-check-label" for="migrated"> مهاجر </label>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="input-field">
            <label class="col-form-label d-flex"> الأمراض </label>

            <table
              class="table diseasesTable"
              v-if="person.diseases && person.diseases.length"
            >
              <thead class="">
                <tr>
                  <th>اسم المرض</th>
                  <th>اسم الدواء</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="dis in person.diseases" :key="dis">
                  <td style="min-width: 45%">{{ dis.name }}</td>
                  <td style="min-width: 45%">{{ dis.medicament }}</td>
                  <td @click="removeDis(dis.id)" class="removeDis text-danger">
                    <i class="bi bi-trash-fill"></i>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="row">
              <div class="col-5">
                <input
                  type="text"
                  class="form-control"
                  placeholder="اسم المرض"
                  dir="rtl"
                  v-model="disease.name"
                />
              </div>
              <div class="col-5">
                <input
                  type="text"
                  class="form-control"
                  placeholder="اسم الدواء"
                  dir="rtl"
                  v-model="disease.medicament"
                />
              </div>
              <div class="col-2 d-flex align-items-center">
                <div class="diseaseBtn" @click="addDisesae">
                  <i class="bi bi-plus"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              الصفة العائلة
              <div class="text-danger mx-1" v-if="!person.adjective">
                *
              </div></label
            >

            <table
              class="table adjectiveTable"
              v-if="person.adjectives && person.adjectives.length"
            >
              <thead class="">
                <tr>
                  <th>رقم العائلة</th>
                  <th>الصفة العائلية</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="adj in person.adjectives" :key="adj">
                  <td style="width: 45%">
                    {{ adj.family_id }}
                  </td>
                  <td style="width: 45%">
                    {{ adj.adjective }}
                  </td>
                  <td style="width: 80px" class="d-flex justify-content-evenly">
                    <div
                      class="text-danger cursorPointer"
                      @click="removeAdj(adj.id)"
                    >
                      <i class="bi bi-trash-fill"></i>
                    </div>
                    <div class="text-primary cursorPointer">
                      <i class="bi bi-pencil-square"></i>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="row" v-if="person.adjectives.length < 2">
              <div class="col-5">
                <select
                  class="form-select"
                  v-model="newAdjective.adjective"
                  dir="ltr"
                >
                  <option value="" class="d-none">الصفة العائلة</option>
                  <template v-for="adj in adjectives" :key="adj">
                    <option :value="adj">{{ adj }}</option>
                  </template>
                  <option
                    @click="person.adjective == ''"
                    class="text-danger"
                    value=""
                  >
                    مسح التحديد
                  </option>
                </select>
              </div>
              <div class="col-5">
                <input
                  type="text"
                  class="form-control"
                  placeholder="رقم العائلة"
                  v-model="newAdjective.family_id"
                />
              </div>
              <div class="col-2">
                <div class="btn btn-primary" @click="addAdjective">إضافة</div>
              </div>
            </div>
          </div>
        </div>
        <div class="row my-3">
          <div class="col-12">
            <button class="btn btn-success">حفظ</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <WarningModal :message="warningMessage" />
  <SuccessModal :message="successMessage" />
  <ErrorModal :message="errorMessage" />
</template>

<script>
import { useRoute, useRouter } from "vue-router";
import { ref, watch } from "vue";

import WarningModal from "../components/modal/warning.vue";
import SuccessModal from "../components/modal/success.vue";
import ErrorModal from "../components/modal/error.vue";
import PageTitle from "../components/common/pageTitle.vue";
import Spinner from "../components/common/Spinner.vue";
import BackBtn from "../components/common/BackBtn.vue";

export default {
  components: {
    WarningModal,
    SuccessModal,
    ErrorModal,
    PageTitle,
    Spinner,
    BackBtn,
  },
  setup() {
    const route = useRoute();
    const router = useRouter();

    const links = {
      person: "https://elie.test/api/person/",
      checkPerson: "https://elie.test/api/person/check/",
      editPerson: "https://elie.test/api/person/edit/",
      removeDisease: "https://elie.test/api/person/disease/remove/",
      addDisease: "https://elie.test/api/person/disease/add/",
      addAdjective: "https://elie.test/api/person/adjective/add/",
      removeAdj: "https://elie.test/api/person/adjective/remove/",
    };

    const spinner = ref(true);

    const person = ref({});
    person.value = {
      first_name: "",
      last_name: "",
      phone: "",
      ID_number: "",
      birthdate_place: "",
      birthdate: "",
      gender: "",
      marital_status: "",
      study_phase: "",
      academic_title: "",
      work: "",
      registration_number: "",
      registration_place: "",
      adjectives: [],
      soldier: false,
      migrated: false,
      died: false,
      diseases: [],
    };

    const disease = ref({
      name: "",
      medicament: "",
    });
    const adjectives = ref(["أب", "أم", "أبن"]);

    axios
      .get(links.person + route.params.id + "/" + route.params.family_id)
      .then((res) => {
        console.log(res.data);
        if (res.data.status) {
          spinner.value = false;
          person.value.id = res.data.person.id ?? "";
          person.value.first_name = res.data.person.first_name ?? "";
          person.value.last_name = res.data.person.last_name ?? "";
          person.value.phone = res.data.person.phone ?? "";
          person.value.ID_number = res.data.person.ID_number ?? "";
          person.value.birthdate_place = res.data.person.birthdate_place ?? "";
          person.value.birthdate = res.data.person.birthdate ?? "";
          person.value.gender = res.data.person.gender ?? "";
          person.value.marital_status = res.data.person.marital_status ?? "";
          person.value.academic_title = res.data.person.academic_title ?? "";
          person.value.study_phase = res.data.person.study_phase ?? "";
          person.value.work = res.data.person.work ?? "";
          person.value.registration_number =
            res.data.person.registration_number ?? "";
          person.value.registration_place =
            res.data.person.registration_place ?? "";

          person.value.adjectives = res.data.person.adjectives ?? "";

          person.value.soldier = res.data.person.military_service
            ? true
            : false;
          person.value.migrated = res.data.person.immigration ? true : false;
          person.value.died = res.data.person.live_dead ? true : false;
          person.value.diseases =
            res.data.person.diseases.map((dis) => ({
              id: dis.id,
              name: dis.disease_name,
              medicament: dis.treatment,
            })) ?? "";
        } else {
          alert("Error");
        }
      });

    const warningMessage = ref("");
    const successMessage = ref("");
    const errorMessage = ref("");

    function checkIdNumber() {
      if (person.value.ID_number.length > 0) {
        if (!person.value.ID_number.match(/^\d+$/)) {
          errors.value.ID_number.message = "الرجاء إدخال أرقام فقط";
          errors.value.ID_number.status = true;
        } else {
          if (person.value.ID_number.length == 11) {
            errors.value.ID_number.status = false;
            axios
              .get(links.checkPerson + person.value.ID_number)
              .then((res) => {
                if (res.data) {
                  warningMessage.value = "الرقم الوطني موجود مسبقاً";
                  $("#warningModal").modal("show");
                }
              });
          } else {
            errors.value.ID_number.message =
              "يجب أن يتألف الرقم الوطني من 11 خانة";
            errors.value.ID_number.status = true;
          }
        }
      } else {
        errors.value.ID_number.status = false;
      }
    }

    function ckeckRegisterNumber() {
      if (person.value.registration_number.length > 0) {
        if (!person.value.registration_number.match(/^\d+$/)) {
          errors.value.registration_number.status = true;
          errors.value.registration_number.message = "الرجاء إدخال أرقام فقط";
        } else {
          errors.value.registration_number.status = false;
        }
      } else {
        errors.value.registration_number.status = false;
      }
    }

    function checkPhoneNumber() {
      if (person.value.phone.length > 0) {
        if (!person.value.phone.match(/[0-9]/)) {
          errors.value.phone.status = true;
          errors.value.phone.message = "الرجاء إدخال أرقام فقط";
        } else {
          if (!person.value.phone.match(/^(09)(3|4|5|6|8|9)[0-9]*/)) {
            errors.value.phone.status = true;
            errors.value.phone.message =
              "يجب أن يبدأ الرقم ب 09 ويتبع ب 3,4,5,6,8,9";
          } else {
            if (person.value.phone.length != 10) {
              errors.value.phone.status = true;
              errors.value.phone.message =
                "يجب أن يتألف رقم الهاتف من 10 خانات";
            } else {
              errors.value.phone.status = false;
            }
          }
        }
      } else {
        errors.value.phone.status = false;
      }
    }

    const errors = ref({});
    errors.value = {
      first_name: false,
      last_name: false,
      phone: {
        status: false,
        message: "",
      },
      ID_number: {
        status: false,
        message: "",
      },
      birthdate_place: false,
      birthdate: false,
      gender: false,
      marital_status: false,
      study_phase: false,
      academic_title: false,
      work: false,
      registration_number: {
        status: false,
        message: "",
      },
      registration_place: false,
      adjective: false,
    };

    function updatePerson() {
      if (
        !errors.value.registration_number.status &&
        !errors.value.phone.status &&
        !errors.value.ID_number.status
      ) {
        if (person.value.first_name.length && person.value.last_name.length) {
          axios
            .post(links.editPerson + person.value.id, {
              first_name: person.value.first_name,
              last_name: person.value.last_name,
              phone: person.value.phone,
              ID_number: person.value.ID_number,
              birthdate_place: person.value.birthdate_place,
              birthdate: person.value.birthdate,
              gender: person.value.gender,
              marital_status: person.value.marital_status,
              academic_title: person.value.study_phase,
              study_phase: person.value.academic_title,
              work: person.value.work,
              registration_number: person.value.registration_number,
              registration_place: person.value.registration_place,
              immigration: person.value.adjective,
              military_service: person.value.soldier,
              live_dead: person.value.migrated,
              died: person.value.died,
            })
            .then((res) => {
              if (res.data.status) {
                successMessage.value = "تم التعديل بنجاح";
                $("#successModal").modal("show");
                setTimeout(() => {
                  $("#successModal").modal("hide");
                  setTimeout(() => {
                    router.push({
                      name: "Person",
                      params: {
                        person_id: person.value.id,
                        family_id: route.params.family_id,
                      },
                    });
                  }, 500);
                }, 2000);
              } else {
                if (res.data.code == 0) {
                  errorMessage.value = "العائلة غير موجودة مسبقاً";
                } else if (res.code == 1) {
                  errorMessage.value = "الرقم الوطني موجود مسبقاً";
                } else {
                  errorMessage.value = "حصل خطأ الرجاء إعادة المحاولة";
                }
                $("#errorModal").modal("show");
              }
            });
        } else {
          errorMessage.value =
            "يجب إدخال أسم الشخص والكنية وأختيار الصفة العائلية";
          $("#ErrorModal").modal("show");
        }
      } else {
        errorMessage.value = "الرجاء تصحيح البيانات المدخلة في الحقول";
        $("#ErrorModal").modal("show");
      }
    }

    function addDisesae() {
      if (disease.value.name.length > 0) {
        axios
          .post(links.addDisease + person.value.id, {
            name: disease.value.name,
            medicament: disease.value.medicament,
          })
          .then((res) => {
            if (res.data.status) {
              person.value.diseases.push({
                id: res.data.disease.id,
                name: disease.value.name,
                medicament: disease.value.medicament,
              });
              disease.value.name = "";
              disease.value.medicament = "";
            } else {
              errorMessage.value = "حصل خطأ ما الرجاء إعادة المحاولة لاحقاً";
              $("#ErrorModal").modal("show");
            }
          });
      } else {
        errorMessage.value = "الرجاء إدخال اسم المرض أولاً";
        $("#ErrorModal").modal("show");
      }
    }

    function removeDis(id) {
      let ttt = person.value.diseases;
      axios
        .get(links.removeDisease + id + "/" + person.value.id)
        .then((res) => {
          if (res.data.status) {
            person.value.diseases = ttt.filter((ele) => ele.id != id);
          } else {
            errorMessage.value = "حصل خطأ ما الرجاء إعادة المحاولة";
            $("#ErrorModal").modal("show");
          }
        });
    }

    const newAdjective = ref({
      family_id: "",
      adjective: "",
    });
    function addAdjective() {
      if (
        !person.value.adjectives.filter(
          (adj) => adj.family_id == newAdjective.value.family_id
        ).length
      ) {
        {
          axios
            .post(links.addAdjective + person.value.id, {
              family_id: newAdjective.value.family_id,
              adjective: newAdjective.value.adjective,
            })
            .then((res) => {
              if (res.data.status) {
                adjectives.value = adjectives.value.filter((adj) => {
                  adj.adjective !== newAdjective.adjective;
                });

                person.value.adjectives.push({
                  id: res.data.adjective.id,
                  person_id: res.data.adjective.person_id,
                  family_id: res.data.adjective.family_id,
                  adjective: res.data.adjective.adjective,
                });

                newAdjective.value = {
                  family_id: "",
                  adjective: "",
                };
              } else {
                if (res.data.code == 503) {
                  errorMessage.value = "حصل خطأ ما الرجاء إعادة المحاولة";
                } else if (res.data.code == 502) {
                  errorMessage.value =
                    'لايمكن إضافة شخصين من صفة "' +
                    newAdjective.value.adjective +
                    '" لنفس العائلة';
                } else if (res.data.code == 501) {
                  errorMessage.value = "الرابط موجود مسبقاً";
                } else if (res.data.code == 504) {
                  errorMessage.value =
                    "لايمكنك إضافة الشخص الواحدة بصفة أبن لأكثر من عائلة";
                } else if (res.data.code == 405) {
                  errorMessage.value = "العائلة غير موجودة";
                } else if (res.data.code == 404) {
                  errorMessage.value = "الشخص غير موجود";
                }
                $("#ErrorModal").modal("show");
              }
            });
        }
      } else {
        errorMessage.value = "لايمكنك إضافة الشخص لنفس العائلة أكثر من مرة";
        $("#ErrorModal").modal("show");
      }
    }

    function removeAdj(linkId) {
      if (person.value.adjectives.length > 1) {
        axios.post(links.removeAdj + linkId).then((res) => {
          console.log(res);
          if (res.data.status) {
            person.value.adjectives = person.value.adjectives.filter(
              (adj) => adj.id != linkId
            );
          } else {
            errorMessage.value = "حصل خطأ ما الرجاء إعادة المحاولة";
            $("#ErrorModal").modal("show");
          }
        });
      } else {
        errorMessage.value =
          "لايمكن حذف الارتباط! يجب وجود ارتباط واحد على الأقل";
        $("#ErrorModal").modal("show");
      }
    }

    return {
      person,
      disease,
      errors,
      warningMessage,
      successMessage,
      errorMessage,
      spinner,
      addDisesae,
      updatePerson,
      checkIdNumber,
      ckeckRegisterNumber,
      checkPhoneNumber,
      adjectives,
      removeDis,
      addAdjective,
      newAdjective,
      removeAdj,
    };
  },
};
</script>

<style scoped>
.input-field {
  margin: 0 0 10px 0;
}
.input-field label {
  font-weight: 600;
}
.exclamation-mark {
  font-size: 60px;
}

.other-info-title {
  font-weight: 600;
}
.diseasesTable {
  /* border: 2px solid #dd2929; */
  overflow: hidden !important;
  width: 80%;
  margin: 0 auto 30px auto;
}
.diseaseBtn {
  font-size: 25px;
  background: #0074d9;
  color: white;
  box-shadow: 0 0 2px #000000a0;
  border-radius: 5px;
  width: 35px;
  height: 35px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transform: scale(1);
}
.diseaseBtn:hover {
  animation: diseaseBtn 1s linear 0s infinite alternate;
}
.removeDis {
  cursor: pointer;
}
@keyframes diseaseBtn {
  from {
    transform: scale(1);
  }
  to {
    transform: scale(1.15);
  }
}

.adjectiveTable {
  overflow: hidden !important;
  width: 80%;
  margin: 0 auto 30px auto;
}
.cursorPointer {
  cursor: pointer;
}
</style>