<template>
  <div class="row">
    <div
      class="col-12 col-xl-6 col-lg-7 col-md-9 m-auto bg-light shadow rounded"
    >
      <form action="" @submit.prevent="registerPerson">
        <div class="row">
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
            />
            <div class="text-danger mt-2" v-if="errors.ID_number.status">
              {{ errors.ID_number.message }}
            </div>
          </div>
        </div>
        <div class="row">
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
        <div class="row">
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
        <div class="row">
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
            />
            <div class="text-danger mt-2" v-if="errors.phone.status">
              {{ errors.phone.message }}
            </div>
          </div>
        </div>
        <div class="row">
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
        <div class="row">
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
        <div class="row">
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
        <div class="row">
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
        <div class="row">
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
        <div class="row">
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
        <div class="row">
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
        <div class="row">
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
            />
            <div
              class="text-danger mt-2"
              v-if="errors.registration_number.status"
            >
              {{ errors.registration_number.message }}
            </div>
          </div>
        </div>
        <div class="row">
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

        <div class="row ps-4 my-2">
          <div class="other-info-title mb-2">معلومات أخرى</div>
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

        <div class="row">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              الصفة العائلة
              <div class="text-danger mx-1" v-if="!person.adjective">
                *
              </div></label
            >
            <select class="form-select" v-model="person.adjective" dir="ltr">
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

<!--

  first_name:'',
  last_name:'',
  phone:'',
  ID_number:'',
  birthdate_place:'',
  birthdate:'',
  gender:'',
  marital_status:'',
  study_phase:'',
  academic_title:'',
  work:'',
  registration_number:'',
  registration_place:'',


  -->

<script>
import { ref, watch } from "vue";
import WarningModal from "../modal/warning.vue";
import SuccessModal from "../modal/success.vue";
import ErrorModal from "../modal/error.vue";
export default {
  props: {
    family_id: {
      type: String,
    },
    adjectives: {
      type: String,
    },
  },
  components: { WarningModal, SuccessModal, ErrorModal },
  setup(props, context) {
    const links = {
      newPerson: "https://elie.test/api/person/new/",
      checkPerson: "https://elie.test/api/person/check/",
    };

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
      adjective: "",
      soldier: false,
      migrated: false,
      died: false,
    };

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

    const warningMessage = ref("");
    const successMessage = ref("");
    const errorMessage = ref("");

    const rrr = ref("");

    watch(() => {
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
    });

    function registerPerson() {
      if (
        !errors.value.registration_number.status &&
        !errors.value.phone.status &&
        !errors.value.ID_number.status
      ) {
        if (
          person.value.first_name.length &&
          person.value.last_name.length &&
          person.value.adjective.length
        ) {
          axios
            .post(links.newPerson, {
              family_id: props.family_id,
              first_name: person.value.first_name,
              last_name: person.value.last_name,
              phone: person.value.phone,
              ID_number: person.value.ID_number,
              birthdate_place: person.value.birthdate_place,
              birthdate: person.value.birthdate,
              gender: person.value.gender,
              marital_status: person.value.marital_status,
              study_phase: person.value.study_phase,
              academic_title: person.value.academic_title,
              work: person.value.work,
              registration_number: person.value.registration_number,
              registration_place: person.value.registration_place,
              adjective: person.value.adjective,
              soldier: person.value.soldier,
              migrated: person.value.migrated,
              died: person.value.died,
            })
            .then((res) => {
              console.log(res);
              if (res.data.status) {
                successMessage.value = "تم التسجيل بنجاح";
                $("#successModal").modal("show");
                context.emit("refreshData", "1");
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
                  adjective: "",
                  soldier: false,
                  migrated: false,
                  died: false,
                };
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

    return {
      person,
      errors,
      registerPerson,
      warningMessage,
      successMessage,
      errorMessage,
      rrr,
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
</style>