<template>
  <div class="d-flex justify-content-end mb-3">
    <BackBtn />
  </div>
  <Spinner v-if="spinner" />
  <div v-else>
    <div v-if="family.status">
      <div class="family-info bg-light rounded shadow p-3">
        <h3 class="">بيانات العائلة</h3>
        <table class="table table-hover">
          <tbody>
            <template v-for="column in columns.family" :key="column">
              <tr class="row">
                <th class="col-12 col-md-4">{{ column.label_ar }}</th>
                <td class="col-12 col-md-8">
                  {{ family.family[column.label_en] }}
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>

      <div class="bg-light rounded shadow p-3 mt-5">
        <h3>أفراد العائلة</h3>
        <DataTable
          :columns="columns"
          :data="family.family.persons"
          :pagesCount="0"
          :resultCount="-1"
          tableStyle="bg-light"
          routeName="Person"
        />
      </div>

      <div class="mt-5">
        <h3>إضافة فرد جديد</h3>
        <NewPerson
          :adjectives="adjectives"
          :family_id="family.family.id"
          @refreshData="refreshData"
        />
      </div>
    </div>
    <EmptyData v-else />
  </div>
</template>
  
<script>
import { onUpdated, ref, watch } from "vue";
import { useRoute } from "vue-router";
import BackBtn from "../components/common/backBtn.vue";
import DataTable from "../components/dataTable.vue";
import NewPerson from "../components/new-family/addPersonForm.vue";
import Spinner from "../components/common/spinner.vue";
import EmptyData from "../components/common/dataNotFound.vue";

export default {
  components: { NewPerson, DataTable, BackBtn, Spinner, EmptyData },
  setup() {
    const route = useRoute();

    const links = {
      person: "https://elie.test/api/person/",
      family: "https://elie.test/api/family/",
    };
    const family = ref({});
    const columns = ref([]);
    columns.value = {
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

    const spinner = ref(true);
    const adjectives = ref(["أب", "أم", "أبن"]);

    axios.get(links.family + route.params.family_id).then((res) => {
      spinner.value = false;
      if (res.data.status) {
        family.value = res.data;
        res.data.family.persons.forEach((person) => {
          person.adjectives.forEach((ele) => {
            if (ele.family_id == route.params.family_id) {
              if (ele.adjective === "أب" || ele.adjective === "أم") {
                adjectives.value = adjectives.value.filter(
                  (e) => e !== ele.adjective
                );
              }
            }
          });
        });
      }
    });

    function refreshData(e) {
      if (e) {
        axios.get(links.family + route.params.family_id).then((res) => {
          spinner.value = false;
          if (res.data.status) {
            family.value = res.data;

            res.data.family.persons.forEach((person) => {
              person.adjectives.forEach((ele) => {
                if (ele.family_id == route.params.family_id) {
                  if (ele.adjective === "أب" || ele.adjective === "أم") {
                    console.log(ele.adjective);
                    adjectives.value = adjectives.value.filter(
                      (e) => e !== ele.adjective
                    );
                  }
                }
              });
            });
          }
        });
      }
    }

    return { columns, family, spinner, adjectives, refreshData };
  },
};
</script>
  
  <style>
</style>