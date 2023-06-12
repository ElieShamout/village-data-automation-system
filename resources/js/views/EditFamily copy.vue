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
      <form
        action=""
        @submit.prevent="updateFamily"
        class="mt-4 family-form px-3"
      >
        <div class="row">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex"
              >رقم السجل الوطني
              <div class="text-danger mx-1" v-if="!family.rsn">*</div></label
            >
            <input
              type="text"
              class="form-control"
              placeholder="EX. 521XXXXXXXX"
              dir="ltr"
              v-model="family.rsn"
              @keyup="checkRegistrationNumber"
              maxlength="11"
            />
            <div class="text-danger mt-2" v-if="errors.rsn.status">
              {{ errors.rsn.message }}
            </div>
          </div>
        </div>
        <div class="row my-3">
          <h5 class="border-bottom p-0 py-2">معلومات التواصل</h5>
          <div class="input-field col-md-6 col-12">
            <label for="staticEmail" class="col-form-label d-flex">
              رقم الهاتف الأرضي
              <div class="text-danger mx-1" v-if="!family.lpn">*</div></label
            >
            <input
              type="text"
              class="form-control"
              placeholder="EX. 0334XXXXXX"
              dir="ltr"
              v-model="family.lpn"
              maxlength="10"
            />
            <div class="text-danger mt-2" v-if="errors.lpn.status">
              {{ errors.lpn.message }}
            </div>
          </div>
          <div class="input-field col-md-6 col-12">
            <label for="staticEmail" class="col-form-label d-flex">
              رقم الموبايل
              <div class="text-danger mx-1" v-if="!family.phone">*</div></label
            >
            <input
              type="text"
              class="form-control"
              placeholder="EX. 09XXXXXXXX"
              v-model="family.phone"
              dir="ltr"
              maxlength="10"
            />
            <div class="text-danger mt-2" v-if="errors.phone.status">
              {{ errors.phone.message }}
            </div>
          </div>
        </div>
        <div class="row my-3 my-3">
          <h5 class="border-bottom p-0 py-2">معلومات السكن</h5>
          <div class="input-field col-md-6 col-12">
            <label for="staticEmail" class="col-form-label d-flex">
              مكان السكن الحالي
              <div class="text-danger mx-1" v-if="!family.cpor">*</div></label
            >
            <input
              type="text"
              class="form-control"
              placeholder="حماه-كفربهم"
              v-model="family.cpor"
            />
          </div>
          <div class="input-field col-md-6 col-12">
            <label for="staticEmail" class="col-form-label d-flex">
              نوع السكن
              <div class="text-danger mx-1" v-if="!family.acct">*</div></label
            >
            <select class="form-select" dir="ltr" v-model="family.acct">
              <option value="" disabled class="d-none">نوع السكن</option>
              <option value="منزل ملك">منزل ملك</option>
              <option value="منزل إجار">منزل إجار</option>
              <option value="مركز إيواء">مركز إيواء</option>
              <option value="خيمة">خيمة</option>
              <option @click="family.acct = ''" class="text-danger">
                مسح التحديد
              </option>
            </select>
          </div>

          <div class="input-field col-12">
            <label for="staticEmail" class="col-form-label d-flex">
              الأجار الشهري
              <div class="text-danger mx-1" v-if="!family.mrv">*</div>
              <span class="text-muted px-2">(ليرة سورية)</span>
            </label>
            <input
              type="number"
              v-model="family.mrv"
              placeholder="150000"
              dir="ltr"
              class="form-control"
              min="0"
            />
          </div>
        </div>
        <div class="row">
          <h5 class="border-bottom p-0 py-2">العنوان</h5>
          <div class="input-field col-md-6 col-12">
            <label for="staticEmail" class="col-form-label d-flex">
              رقم المنطقة
              <div class="text-danger mx-1" v-if="!family.district">
                *
              </div></label
            >
            <select class="form-select" dir="ltr" v-model="family.district">
              <option value="" disabled class="d-none">
                تحديد رقم المنطقة
              </option>
              <template v-for="ditrict in 30" :key="ditrict">
                <option :value="ditrict">{{ ditrict }}</option>
              </template>
              <option @click="family.district = ''" class="text-danger">
                مسح التحديد
              </option>
            </select>
          </div>
          <div class="input-field col-md-6 col-12">
            <label for="staticEmail" class="col-form-label d-flex">
              رقم القطعة
              <div class="text-danger mx-1" v-if="!family.block">*</div></label
            >
            <select class="form-select" dir="ltr" v-model="family.block">
              <option value="" disabled class="d-none">
                تحديد رقم المنطقة
              </option>
              <template v-for="blockNumber in 30" :key="blockNumber">
                <option :value="blockNumber">{{ blockNumber }}</option>
              </template>
              <option @click="family.block = ''" class="text-danger">
                مسح التحديد
              </option>
            </select>
          </div>
        </div>

        <div class="row my-3">
          <div class="input-field">
            <label for="staticEmail" class="col-form-label d-flex">
              الملاحظات
              <div class="text-danger mx-1" v-if="!family.notes">*</div></label
            >
            <textarea class="form-control" v-model="family.notes"></textarea>
          </div>
        </div>
        <div class="row my-3">
          <div class="input-field">
            <button class="btn btn-success" v-if="1">حفظ</button>
            <button class="btn btn-primary" v-else>متابعة</button>
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
      family: "https://elie.test/api/family/",
      checkFamily: "https://elie.test/api/family/check/",
      updateFamily: "https://elie.test/api/family/edit/",
    };

    const family = ref({
      id: "",
      rsn: "",
      lpn: "",
      cpor: "",
      acct: "",
      mrv: "",
      district: "",
      block: "",
      phone: "",
      notes: "",
    });
    const spinner = ref(true);

    axios.get(links.family + route.params.id).then((res) => {
      if (res.data.status) {
        spinner.value = false;
        family.value.id = res.data.family.id ?? "";
        family.value.rsn = res.data.family.registration_summary_number ?? "";
        family.value.lpn = res.data.family.landline_phone_number ?? "";
        family.value.cpor = res.data.family.current_place_of_residence ?? "";
        family.value.acct = res.data.family.accommodation_type ?? "";
        family.value.mrv = res.data.family.monthly_rent_value ?? "";
        family.value.district = res.data.family.district_number ?? "";
        family.value.block = res.data.family.block_number ?? "";
        family.value.phone = res.data.family.phone ?? "";
        family.value.notes = res.data.family.notes ?? "";
      } else {
        alert("Error");
      }
    });

    const warningMessage = ref("");
    const successMessage = ref("");
    const errorMessage = ref("");

    setTimeout(() => {
      watch(() => {
        if (family.value.lpn.length > 0) {
          if (!family.value.lpn.match(/^\d+$/)) {
            errors.value.lpn.message = "الرجاء إدخال أرقام فقط";
            errors.value.lpn.status = true;
          } else {
            if (
              !family.value.lpn.match(
                /^0(11|14|15|16|21|22|23|31|33|41|43|51|52)[0-9]*/
              )
            ) {
              errors.value.lpn.message =
                "يجب أن يبدأ رقم الهاتف ب النداء مثلاً 033";
              errors.value.lpn.status = true;
            } else {
              if (family.value.lpn.length < 10) {
                errors.value.lpn.message =
                  "يجب أن يتألف رقم الهاتف الأرضي من 10 خانات";
                errors.value.lpn.status = true;
              } else {
                errors.value.lpn.status = false;
              }
            }
          }
        } else {
          errors.value.lpn.status = false;
        }

        if (family.value.phone.length > 0) {
          if (!family.value.phone.match(/[0-9]/)) {
            errors.value.phone.status = true;
            errors.value.phone.message = "الرجاء إدخال أرقام فقط";
          } else {
            if (!family.value.phone.match(/^(09)(3|4|5|6|8|9)[0-9]*/)) {
              errors.value.phone.status = true;
              errors.value.phone.message =
                "يجب أن يبدأ الرقم ب 09 ويتبع ب 3,4,5,6,8,9";
            } else {
              if (family.value.phone.length != 10) {
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
      });
    }, 2000);

    function checkRegistrationNumber() {
      if (family.value.rsn.length > 0) {
        if (!family.value.rsn.match(/^\d+$/)) {
          errors.value.rsn.message = "الرجاء إدخال أرقام فقط";
          errors.value.rsn.status = true;
        } else {
          if (family.value.rsn.length == 11) {
            errors.value.rsn.status = false;
            axios.get(links.checkFamily + family.value.rsn).then((res) => {
              if (res.data.length > 0) {
                warningMessage.value = "رقم السجل موجود مسبقاً";
                $("#warningModal").modal("show");
              }
            });
          } else {
            errors.value.rsn.message = "يجب أن يتألف الرقم الوطني من 11 خانة";
            errors.value.rsn.status = true;
          }
        }
      } else {
        errors.value.rsn.status = false;
      }
    }

    function updateFamily() {
      if (
        !errors.value.lpn.status &&
        !errors.value.phone.status &&
        !errors.value.rsn.status
      ) {
        if (family.value.rsn.length == 11) {
          if (family.value.district > 0 && family.value.block > 0) {
            axios
              .post(links.updateFamily + family.value.id, {
                registration_summary_number: family.value.rsn,
                landline_phone_number: family.value.lpn,
                current_place_of_residence: family.value.cpor,
                accommodation_type: family.value.acct,
                monthly_rent_value: family.value.mrv,
                district: family.value.district,
                block: family.value.block,
                phone: family.value.phone,
                notes: family.value.notes,
              })
              .then((res) => {
                if (res.data.status) {
                  successMessage.value = "تم تعديل بيانات العائلة بنجاح";
                  $("#successModal").modal("show");
                  setTimeout(() => {
                    $("#successModal").modal("hide");
                    setTimeout(() => {
                      router.push({
                        name: "NewPerson",
                        params: { family_id: family.value.id },
                      });
                    }, 500);
                  }, 2000);
                } else {
                  errorMessage.value = "حصل خطأ الرجاء إعادة المحاولة";
                  $("#ErrorModal").modal("show");
                }
              });
          } else {
            errorMessage.value = "يجب إدخال رقم المنطقة ورقم القطعة";
            $("#ErrorModal").modal("show");
          }
        } else {
          errorMessage.value = "يجب إدخال رقم السجل الوطني للعائلة";
          $("#ErrorModal").modal("show");
        }
      } else {
        errorMessage.value = "الرجاء تصحيح البيانات المدخلة في الحقول";
        $("#ErrorModal").modal("show");
      }
    }
    const errors = ref({
      rsn: {
        status: false,
        message: "",
      },
      lpn: {
        status: false,
        message: "",
      },
      cpor: "",
      acct: "",
      mrv: "",
      district: "",
      block: "",
      phone: {
        status: false,
        message: "",
      },
      notes: "",
    });

    return {
      family,
      errors,
      warningMessage,
      successMessage,
      errorMessage,
      spinner,
      updateFamily,
      checkRegistrationNumber,
    };
  },
};
</script>

<style scoped>
</style>