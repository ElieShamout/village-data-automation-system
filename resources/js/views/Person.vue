<template>
  <div class="d-flex justify-content-end">
    <BackBtn />
  </div>
  <Spinner v-if="spinner" />

  <div v-else>
    <div class="d-flex justify-content-start mb-3" v-if="data.length != 0">
      <router-link
        :to="{
          name: 'Certificate',
          params: {
            type: 'baptismal',
            person_id: data.id ?? 0,
          },
        }"
        class="btn certificate-button shadow me-2"
        >شهادة معمودية
      </router-link>
      <router-link
        :to="{
          name: 'Certificate',
          params: {
            type: 'marriage',
            person_id: data.id ?? 0,
          },
        }"
        class="btn certificate-button shadow me-2"
        >شهادة زواج
      </router-link>
      <router-link
        :to="{
          name: 'Certificate',
          params: {
            type: 'engagment',
            person_id: data.id ?? 0,
          },
        }"
        class="btn certificate-button shadow me-2"
        >شهادة خطوبة
      </router-link>
    </div>

    <div class="container bg-light shadow rounded" v-if="data.length != 0">
      <div class="person-info">
        <div class="d-flex justify-content-between align-items-center">
          <h2 class="py-3">
            {{ data.first_name }} {{ data.father_name }} {{ data.last_name }}
          </h2>
          <div class="d-flex">
            <router-link
              :to="{
                name: 'EditPerson',
                params: {
                  id: data.id,
                  family_id: data.family.id,
                },
              }"
            >
              <i class="bi bi-pencil-square"></i>
            </router-link>
            <div
              class="me-2 text-danger remove-person-icon"
              @click="removePerson"
            >
              <i class="bi bi-trash-fill"></i>
            </div>
          </div>
        </div>
        <table class="table table-hover">
          <tbody>
            <template v-for="column in columns.basic" :key="column">
              <tr class="row">
                <td class="col-12 col-md-4">{{ column.label_ar }}</td>
                <td class="col-12 col-md-8">{{ data[column.label_en] }}</td>
              </tr>
            </template>
            <tr class="row">
              <td class="col-12 col-md-4">الصفة العائلية</td>
              <td class="col-12 col-md-8">
                <template v-for="adjective in data.adjectives" :key="adjective">
                  <span
                    class="badge bg-primary"
                    v-if="adjective['adjective'] != 'أبن'"
                    >{{ adjective.adjective }}</span
                  >
                  <span class="badge bg-secondary" v-else>{{
                    adjective.adjective
                  }}</span>
                </template>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="person-diseases">
        <h2 class="py-3">الأمراض</h2>
        <table class="table table-hover" v-if="data.diseases">
          <thead class="table-warning">
            <tr>
              <th v-for="column in columns.diseases" :key="column.label_en">
                {{ column.label_ar }}
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="disease in data.diseases" :key="disease.id">
              <td v-for="column in columns.diseases" :key="column.id">
                {{ disease[column.label_en] }}
              </td>
            </tr>
          </tbody>
        </table>
        <h5 class="text-muted px-4" v-else>لا يوجد امراض</h5>
      </div>

      <div class="family-info mt-5">
        <h3 class="mt-5">بيانات العائلة</h3>
        <table class="table table-hover">
          <tbody>
            <template v-for="column in columns.family" :key="column.label_en">
              <tr class="row">
                <td class="col-12 col-md-4">{{ column.label_ar }}</td>
                <td class="col-12 col-md-8">
                  {{ family[column.label_en] }}
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>

      <div class="family_location">
        <h3 class="py-3">عنوان منزل العائلة</h3>
        <div class="row">
          <div class="col">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam cum
            deleniti reiciendis laboriosam odit totam alias enim neque animi?
            Perspiciatis dolorum atque magni eaque accusantium commodi
            voluptatibus ducimus, exercitationem hic!
          </div>
          <div class="col">
            <img
              class="border"
              src="../../assets/kafr-buhum-border-map.png"
              alt=""
            />
          </div>
        </div>
      </div>

      <div class="family-persons-info mt-5">
        <div class="d-flex justify-content-between">
          <h3>أفراد العائلة</h3>
        </div>
        <DataTable
          :columns="columns"
          :data="family.persons"
          :pagesCount="0"
          :resultCount="-1"
          tableStyle="bg-light"
        />
      </div>
    </div>

    <EmptyData v-else />
  </div>

  <WarningModal :message="warningMessage" />
  <SuccessModal :message="successMessage" />
  <ErrorModal :message="errorMessage" />
</template>
<script>
import { ref, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
import PageTitle from "../components/common/pageTitle.vue";
import DataTable from "../components/dataTable.vue";
import Spinner from "../components/common/spinner.vue";
import BackBtn from "../components/common/backBtn.vue";
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
      removePerson: "https://elie.test/api/person/delete/",
    };

    const columns = ref({});
    columns.value = {
      basic: [
        {
          label_ar: "الرقم",
          label_en: "id",
          view: true,
          sortAble: true,
        },
        {
          label_ar: "الاسم الأول",
          label_en: "first_name",
          view: true,
          sortAble: true,
        },
        {
          label_ar: "اسم الأب",
          label_en: "father_name",
          view: false,
          sortAble: true,
        },
        {
          label_ar: "اسم الأم",
          label_en: "mother_name",
          view: false,
          sortAble: true,
        },
        {
          label_ar: "الكنية",
          label_en: "last_name",
          view: false,
          sortAble: true,
        },
        {
          label_ar: "الجنس",
          label_en: "gender",
          view: true,
          sortAble: true,
        },
        {
          label_ar: "العمل",
          label_en: "work",
          view: true,
          sortAble: true,
        },
        {
          label_ar: "تاريخ الولادة",
          label_en: "birthdate",
          view: true,
          sortAble: true,
        },
        {
          label_ar: "مكان الولادة",
          label_en: "birthdate_place",
          view: false,
          sortAble: true,
        },

        {
          label_ar: "الحالة الاجتماعية",
          label_en: "marital_status",
          view: false,
          sortAble: true,
        },
        {
          label_ar: "الرقم الوطني",
          label_en: "ID_number",
          view: false,
          sortAble: false,
        },
        {
          label_ar: "رقم الهاتف",
          label_en: "phone",
          view: false,
          sortAble: false,
        },

        {
          label_ar: "اسم العراب",
          label_en: "godfather_name",
          view: false,
          sortAble: false,
        },
        {
          label_ar: "اسم الأب المعمد",
          label_en: "name_baptized_father",
          view: false,
          sortAble: false,
        },
        {
          label_ar: "مكان المعمودية",
          label_en: "baptismal_place",
          view: false,
          sortAble: false,
        },
        {
          label_ar: "تاريخ المعمودية",
          label_en: "baptismal_date",
          view: false,
          sortAble: false,
        },
        {
          label_ar: "المرحلة الدراسية",
          label_en: "study_phase",
          view: false,
          sortAble: true,
        },
        {
          label_ar: "المسمى الدراسي",
          label_en: "academic_title",
          view: false,
          sortAble: true,
        },
        {
          label_ar: "رقم القيد",
          label_en: "registration_number",
          view: false,
          sortAble: true,
        },
        {
          label_ar: "مكان القيد",
          label_en: "registration_place",
          view: false,
          sortAble: false,
        },
      ],
      family: [
        {
          label_ar: "رقم السجل المدني",
          label_en: "registration_summary_number",
        },
        {
          label_ar: " رقم الهاتف الأرضي",
          label_en: "landline_phone_number",
        },
        {
          label_ar: "رقم الموبايل",
          label_en: "phone",
        },
        {
          label_ar: "مكان السكن الحالي",
          label_en: "current_place_of_residence",
        },
        {
          label_ar: "نوع السكن",
          label_en: "accommodation_type",
        },
        {
          label_ar: "الملاحظات",
          label_en: "notes",
        },
      ],
      diseases: [
        {
          label_ar: "اسم المرض",
          label_en: "disease_name",
        },
        {
          label_ar: "أدوية المرض",
          label_en: "treatment",
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

    const data = ref([]);
    const family = ref([]);
    const spinner = ref(true);

    const warningMessage = ref("");
    const successMessage = ref("");
    const errorMessage = ref("");

    watch(() => {
      spinner.value = true;
      axios
        .get(
          links.person + route.params.person_id + "/" + route.params.family_id
        )
        .then(function (res) {
          console.log(res.data.status);
          if (res.data.status) {
            family.value = res.data.person.family;
            data.value = res.data.person;
            spinner.value = false;
          } else {
            spinner.value = false;
          }
        });
    });

    function removePerson() {
      if (confirm("هل أنت متأكد من حذف الشخص؟")) {
        axios.post(links.removePerson + data.value.id).then((res) => {
          console.log(res);
          if (res.data.status) {
            successMessage.value = "تم حذف الشخص بنجاح";
            $("#successModal").modal("show");

            setTimeout(() => {
              $("#successModal").modal("hide");
              setTimeout(() => {
                router.push({
                  name: "Persons",
                });
              }, 500);
            }, 2000);
          } else {
            if (res.data.code == 404) {
              errorMessage.value = "حصل خطأ الرجاء إعادة المحاولة";
            } else {
              errorMessage.value = "حصل خطأ الرجاء إعادة المحاولة";
            }
            $("#ErrorModal").modal("show");
          }
        });
      }
    }

    return {
      data,
      family,
      columns,
      spinner,
      removePerson,
      successMessage,
      errorMessage,
      warningMessage,
    };
  },
};
</script>
    
<style scoped>
.certificate-button {
  background-color: #dd2929;
  color: white;
}
.badge {
  margin: 0 5px;
}
.dropdown-menu {
  min-width: 500px;
}
.dropdown-toggle {
  background: #dd2929;
  color: white;
}
.persons-link {
  text-decoration: none;
  cursor: pointer;
}

.family_location img {
  width: 600px;
}

.remove-person-icon {
  cursor: pointer;
}
</style>