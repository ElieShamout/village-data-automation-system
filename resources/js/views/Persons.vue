<template>
  <div class="container">
    <PageTitle pageTitle="الأشخاص" />

    <Spinner v-if="spinner" />
    <div v-else>
      <div class="row mt-4 filtering" v-if="filteringVisible">
        <div
          class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-12 mb-2"
          v-if="
            columns.basic.filter((col) => col.label_en == 'first_name')[0].view
          "
        >
          <inputText
            placeholder="البحث باستخدام الأسم"
            @inputData="searchName"
          />
        </div>
        <div
          class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-12 mb-2"
          v-if="
            columns.basic.filter((col) => col.label_en == 'ID_number')[0].view
          "
        >
          <inputText placeholder="الرقم الوطني" @inputData="idNumber" />
        </div>
        <div
          class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-12 mb-2"
          v-if="
            columns.basic.filter(
              (col) => col.label_en == 'registration_number'
            )[0].view
          "
        >
          <inputText placeholder="رقم السجل" @inputData="registerNumber" />
        </div>
        <div
          class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-12 mb-2"
          v-if="
            columns.basic.filter((col) => col.label_en == 'birthdate')[0].view
          "
        >
          <inputText
            placeholder="تاريخ الميلاد 01-11-2000"
            @inputData="birthDate"
            dir="ltr"
          />
        </div>
        <!-- <div
          class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-12 mb-2"
          v-if="
            columns.basic.filter((col) => col.label_en == 'birthdate')[0].view
          "
        >
          <input
            type="date"
            class="form-control"
            @change="birthDate"
            dir="ltr"
          />
        </div> -->
      </div>

      <DataTable
        :columns="columns"
        :data="data"
        :pagesCount="pagesCount"
        :resultCount="resultCount"
        @paginateEvent="paginateEvent"
        routeName="Person"
      />
    </div>
  </div>
</template>
      
<script>
import { ref } from "vue";

import PageTitle from "../components/common/pageTitle.vue";
import Spinner from "../components/common/spinner.vue";
import DataTable from "../components/dataTable.vue";
import inputText from "../components/filtering/inputText.vue";
import Birthdate from "../components/filtering/birthdate.vue";
export default {
  components: { PageTitle, DataTable, inputText, Birthdate, Spinner },
  setup(props, context) {
    const links = {
      persons: "http://csdm.test/api/persons",
      person: "http://csdm.test/api/person",
      name: "http://csdm.test/api/person/filter/name/",
      idNumber: "http://csdm.test/api/person/filter/idnumber/",
      birthdate: "http://csdm.test/api/person/filter/birthdate/",
      registerNumber: "http://csdm.test/api/person/filter/registerNumber/",
    };

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

    const filteringVisible = ref(0);

    const data = ref([]);
    const pagesCount = ref(0);
    const resultCount = ref(0);
    const spinner = ref(true);

    axios.get(links.persons).then(function (res) {
      if (res.data.status) {
        filteringVisible.value = res.data.status;
        data.value = res.data.persons.data;
        pagesCount.value = res.data.persons.last_page;
        resultCount.value = res.data.persons.total;
      }
      spinner.value = false;
    });

    function getAllPersons() {
      axios.get(links.persons).then(function (res) {
        if (res.data.status) {
          console.log(res);
          data.value = res.data.persons.data;
          pagesCount.value = res.data.persons.last_page;
          resultCount.value = res.data.persons.total;
        }
        spinner.value = false;
      });
    }

    function paginateEvent(page) {
      axios.get(links.persons + "?page=" + page).then(function (res) {
        data.value = res.data.persons.data;
      });
    }

    function searchName(name) {
      if (name.length > 0) {
        axios.get(links.name + name).then((res) => {
          if (res.data.status) {
            console.log(res);
            data.value = res.data.persons.data;
            pagesCount.value = res.data.persons.last_page;
            resultCount.value = res.data.persons.total;
          }
          spinner.value = false;
        });
      } else {
        getAllPersons();
      }
    }

    function idNumber(idNum) {
      if (idNum.length > 0) {
        axios.get(links.idNumber + idNum).then((res) => {
          if (res.data.status) {
            data.value = res.data.persons.data;
            pagesCount.value = res.data.persons.last_page;
            resultCount.value = res.data.persons.total;
          }
          spinner.value = false;
        });
      } else {
        getAllPersons();
      }
    }
    function birthDate(birthdate) {
      if (birthdate.length > 0) {
        axios.get(links.birthdate + birthdate).then((res) => {
          if (res.data.status) {
            data.value = res.data.persons.data;
            pagesCount.value = res.data.persons.last_page;
            resultCount.value = res.data.persons.total;
          }
          spinner.value = false;
        });
      } else {
        getAllPersons();
      }
    }
    function registerNumber(registerNum) {
      if (registerNum.length > 0) {
        axios.get(links.idNumber + registerNum).then((res) => {
          if (res.data.status) {
            console.log(res);
            data.value = res.data.persons.data;
            pagesCount.value = res.data.persons.last_page;
            resultCount.value = res.data.persons.total;
          }
          spinner.value = false;
        });
      } else {
        getAllPersons();
      }
    }

    return {
      columns,
      data,
      searchName,
      idNumber,
      registerNumber,
      birthDate,
      pagesCount,
      resultCount,
      paginateEvent,
      spinner,
      filteringVisible,
    };
  },
};
</script>
      
<style scoped>
.filtering {
  position: relative;
  z-index: 10000;
}
</style>


<!-- function birthDate(e) {
  // console.log(e.target.value);
  if (date.length > 0) {
    axios.get(links.idNumber + date).then((res) => {
      if (res.data.status) {
        console.log(res);
        data.value = res.data.persons.data;
        pagesCount.value = res.data.persons.last_page;
        resultCount.value = res.data.persons.total;
      }
      spinner.value = false;
    });
  } else {
    getAllPersons();
  }
} -->