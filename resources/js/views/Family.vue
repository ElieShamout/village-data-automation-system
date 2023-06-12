<template>
  <div class="d-flex justify-content-end mb-3">
    <BackBtn />
  </div>
  <Spinner v-if="spinner" />
  <div
    class="container bg-light shadow rounded p-3"
    v-else-if="family.length != 0"
  >
    <div class="family-info">
      <div class="d-flex justify-content-between align-items-center">
        <h3 class="">بيانات العائلة</h3>
        <div class="d-flex">
          <router-link
            :to="{
              name: 'EditFamily',
              params: {
                id: family.id,
              },
            }"
            class="family-edit-icon"
          >
            <i class="bi bi-pencil-square"></i>
          </router-link>
          <div
            class="remove-family-icon text-danger me-2"
            @click="removeFamily"
          >
            <i class="bi bi-trash-fill"></i>
          </div>
        </div>
      </div>
      <table class="table table-hover">
        <tbody>
          <template v-for="column in columns.family" :key="column">
            <tr class="row">
              <th class="col-12 col-md-4">{{ column.label_ar }}</th>
              <td class="col-12 col-md-8">
                {{ family[column.label_en] }}
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <div class="family_location my-5">
      <h3 class="py-3">عنوان منزل العائلة</h3>
      <div class="row">
        <div class="col">
          <div>
            رقم القطعة {{ family.district_number }} رقم الكتلة
            {{ family.block_number }}
          </div>
        </div>
        <!-- <div class="col">
          <Map />
        </div> -->
      </div>
    </div>

    <div class="family-persons-info pt-5">
      <div class="d-flex">
        <h3>أفراد العائلة</h3>
      </div>
      <DataTable
        :columns="columns"
        :data="family.persons"
        :pagesCount="0"
        :resultCount="-1"
        tableStyle="bg-light"
        routeName="Person"
      />
      <NewPersonBtn :family_id="family.id" />
    </div>
  </div>

  <EmptyData v-else />

  <WarningModal :message="warningMessage" />
  <SuccessModal :message="successMessage" />
  <ErrorModal :message="errorMessage" />
</template>
  
<script>
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import PageTitle from "../components/common/pageTitle.vue";
import DataTable from "../components/dataTable.vue";
import Spinner from "../components/common/spinner.vue";
import BackBtn from "../components/common/backBtn.vue";
import NewPersonBtn from "../components/common/newPersonBtn.vue";
import Map from "../components/map/map.vue";
import EmptyData from "../components/common/dataNotFound.vue";
import WarningModal from "../components/modal/warning.vue";
import SuccessModal from "../components/modal/success.vue";
import ErrorModal from "../components/modal/error.vue";
export default {
  props: {
    id: Number,
    family_id: Number,
  },
  components: {
    PageTitle,
    DataTable,
    Spinner,
    BackBtn,
    NewPersonBtn,
    Map,
    EmptyData,
    WarningModal,
    SuccessModal,
    ErrorModal,
  },
  setup() {
    const route = useRoute();
    const router = useRouter();

    const links = {
      person: "https://elie.test/api/person/",
      family: "https://elie.test/api/family/",
      deleteFamily: "https://elie.test/api/family/delete/",
    };

    const columns = ref({});

    columns.value = {
      family: [
        {
          label_ar: "رقم العائلة",
          label_en: "id",
          view: true,
          sortAble: true,
          searchAble: true,
        },
        {
          label_ar: "رقم السجل المدني",
          label_en: "registration_summary_number",
          view: true,
          sortAble: true,
          searchAble: true,
        },
        {
          label_ar: " رقم الهاتف الأرضي",
          label_en: "landline_phone_number",
          view: true,
          sortAble: true,
          searchAble: true,
        },
        {
          label_ar: "رقم الموبايل",
          label_en: "phone",
          view: true,
          sortAble: true,
          searchAble: true,
        },
        {
          label_ar: "مكان السكن الحالي",
          label_en: "current_place_of_residence",
          view: true,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "نوع السكن",
          label_en: "accommodation_type",
          view: true,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "رقم المنطقة",
          label_en: "district_number",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "رقم القطعة",
          label_en: "block_number",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "عدد الأفراد الغير متزوجين",
          label_en: "total_persons_singles",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "عدد الأفراد متزوجين",
          label_en: "total_persons_married",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "عدد الأفراد المتوفين",
          label_en: "total_persons_dead",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "عدد الافراد الكلي",
          label_en: "total_persons_count",
          view: true,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "الملاحظات",
          label_en: "notes",
          view: true,
          sortAble: true,
          searchAble: false,
        },
      ],
      basic: [
        {
          label_ar: "الرقم",
          label_en: "id",
          view: true,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "الاسم الأول",
          label_en: "first_name",
          view: true,
          sortAble: true,
          searchAble: true,
        },
        {
          label_ar: "الكنية",
          label_en: "last_name",
          view: true,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "اسم الأب",
          label_en: "father_name",
          view: true,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "اسم الأم",
          label_en: "mother_name",
          view: true,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "العمل",
          label_en: "work",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "تاريخ الولادة",
          label_en: "birthdate",
          view: false,
          sortAble: true,
          searchAble: true,
        },
        {
          label_ar: "الجنس",
          label_en: "gender",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "الحالة الاجتماعية",
          label_en: "marital_status",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "الرقم الوطني",
          label_en: "ID_number",
          view: false,
          sortAble: true,
          searchAble: true,
        },
        {
          label_ar: "رقم الهاتف",
          label_en: "phone",
          view: false,
          sortAble: false,
          searchAble: false,
        },
        {
          label_ar: "مكان الولادة",
          label_en: "birthdate_place",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "اسم العراب",
          label_en: "godfather_name",
          view: false,
          sortAble: false,
          searchAble: false,
        },
        {
          label_ar: "اسم الأب المعمد",
          label_en: "name_baptized_father",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "مكان المعمودية",
          label_en: "baptismal_place",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "تاريخ المعمودية",
          label_en: "baptismal_date",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "المرحلة الدراسية",
          label_en: "study_phase",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "المسمى الدراسي",
          label_en: "academic_title",
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "رقم القيد",
          label_en: "registration_number",
          view: false,
          sortAble: true,
          searchAble: true,
        },
        {
          label_ar: "مكان القيد",
          label_en: "registration_place",
          view: false,
          sortAble: false,
          searchAble: false,
        },
        {
          label_ar: "مكان المعمودية",
          label_en: "baptismal_place",
          view: false,
          sortAble: false,
          searchAble: false,
        },
        {
          label_ar: "تاريخ المعمودية",
          label_en: "baptismal_date",
          view: false,
          sortAble: false,
          searchAble: false,
        },
      ],
      other: [
        {
          label_ar: "الصفة العائلية",
          label_en: "adjective",
        },
        {
          label_ar: "معلومات أخرى",
          label_en: "other_information",
        },
      ],
    };

    const family = ref([]);
    const spinner = ref(true);

    axios.get(links.family + route.params.family_id).then(function (res) {
      family.value = res.data.family;
      spinner.value = false;
    });

    const warningMessage = ref("");
    const successMessage = ref("");
    const errorMessage = ref("");
    function removeFamily() {
      console.log(family.value.id);
      if (confirm("هل أنت متأكد من حذف العائلة؟")) {
        axios.post(links.deleteFamily + family.value.id).then((res) => {
          console.log(res);
          if (res.data.status) {
            successMessage.value = "تم حذف العائلة بنجاح";
            $("#successModal").modal("show");

            setTimeout(() => {
              $("#successModal").modal("hide");
              setTimeout(() => {
                router.push({
                  name: "TownFamilies",
                });
              }, 500);
            }, 2000);
          } else {
            if (res.data.code == 404) {
              // data not found
              errorMessage.value = "العائلة غير موجودة";
            } else if (res.data.code == 500) {
              errorMessage.value = "حصل خطأ ما عند حذف بيانات العائلة";
              // serve error
            } else if (res.data.code == 501) {
              // serve error
              errorMessage.value =
                "تم حذف بيانات العائلة بنجاح ولكن حصل خطأ اثناء حذف الأشخاص";
            }

            $("#ErrorModal").modal("show");
          }
        });
      }
    }

    return {
      columns,
      family,
      spinner,
      removeFamily,
      successMessage,
      errorMessage,
      warningMessage,
    };
  },
};
</script>
  
<style scoped>
.family_location img {
  width: 600px;
}
.back-btn {
  position: relative;
  z-index: 100000000;
}

.family-edit-icon {
  cursor: pointer;
  transition: all 0.4s;
}
.family-edit-icon:hover {
  color: #dd2929;
  transform: scale(1.5);
}
.remove-family-icon {
  cursor: pointer;
}
</style>