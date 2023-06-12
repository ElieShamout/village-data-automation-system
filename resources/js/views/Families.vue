<template>
  <div class="container">
    <PageTitle pageTitle="عائلات البلدة" />

    <Spinner v-if="spinner" />

    <div v-else>
      <div class="row mt-4 filtering" v-if="filteringVisible">
        <div
          class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-12 mb-2"
          v-if="columns.basic.filter((col) => col.label_en == 'id')[0].view"
        >
          <inputText placeholder="رقم العائلة" @inputData="familyId" />
        </div>
        <div
          class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-12 mb-2"
          v-if="
            columns.basic.filter(
              (col) => col.label_en == 'registration_summary_number'
            )[0].view
          "
        >
          <inputText
            placeholder="رقم السجل المدني"
            @inputData="registrationNumber"
          />
        </div>
        <div
          class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-12 mb-2"
          v-if="
            columns.basic.filter(
              (col) => col.label_en == 'landline_phone_number'
            )[0].view
          "
        >
          <inputText
            placeholder="رقم الهاتف الأرضي"
            @inputData="landlinePhoneNumber"
          />
        </div>
        <div
          class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-12 mb-2"
          v-if="columns.basic.filter((col) => col.label_en == 'phone')[0].view"
        >
          <inputText placeholder="رقم الهاتف" @inputData="phoneNumber" />
        </div>
        <!-- <div
          class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-12 mb-2"
          v-if="
            columns.basic.filter((col) => col.label_en == 'district_number')[0]
              .view
          "
        >
          <inputCheckList
            placeholder="رقم القطعة"
            @inputData="districtNumber"
          />
        </div>
        <div
          class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-12 mb-2"
          v-if="
            columns.basic.filter((col) => col.label_en == 'block_number')[0]
              .view
          "
        >
          <inputCheckList placeholder="رقم الكتلة" @inputData="blockNumber" />
        </div> -->
      </div>

      <DataTable
        :columns="columns"
        :link="link"
        :data="data"
        :pagesCount="pagesCount"
        :resultCount="resultCount"
        @paginateEvent="paginateEvent"
        routeName="Family"
      />
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import PageTitle from "../components/common/pageTitle.vue";
import DataTable from "../components/dataTable.vue";
import inputText from "../components/filtering/inputText.vue";
import inputCheckList from "../components/filtering/inputCheckList.vue";
import inputNumber from "../components/filtering/inputNumber.vue";
import Birthdate from "../components/filtering/birthdate.vue";
import Spinner from "../components/common/spinner.vue";
export default {
  components: {
    PageTitle,
    DataTable,
    inputText,
    inputNumber,
    Birthdate,
    Spinner,
    inputCheckList,
  },
  setup() {
    const links = {
      families: "http://csdm.test/api/families",
      number: "http://csdm.test/api/family/filter/number/",
      registerNumber: "http://csdm.test/api/family/filter/registerNumber/",
      phone: "http://csdm.test/api/family/filter/phone/",
      landingPhone: "http://csdm.test/api/family/filter/landingPhone/",
      address: "http://csdm.test/api/family/filter/address/",
    };

    const columns = ref([]);
    columns.value = {
      basic: [
        {
          label_ar: "رقم العائلة",
          label_en: "id",
          view: true,
          sortAble: true,
          searchAble: true,
          searchMethod: "familyId",
        },
        {
          label_ar: "رقم السجل المدني",
          label_en: "registration_summary_number",
          view: true,
          sortAble: true,
          searchAble: true,
          searchMethod: "registrationNumber",
        },
        {
          label_ar: " رقم الهاتف الأرضي",
          label_en: "landline_phone_number",
          view: true,
          sortAble: true,
          searchAble: true,
          searchMethod: "landlinePhoneNumber",
        },
        {
          label_ar: "رقم الموبايل",
          label_en: "phone",
          view: true,
          sortAble: true,
          searchAble: true,
          searchMethod: "phoneNumber",
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
          view: false,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "رقم المنطقة",
          label_en: "district_number",
          view: false,
          sortAble: true,
          searchAble: false,
          searchMethod: "districtNumber",
        },
        {
          label_ar: "رقم القطعة",
          label_en: "block_number",
          view: false,
          sortAble: true,
          searchAble: false,
          searchMethod: "blockNumber",
        },
        {
          label_ar: "غير متزوجين",
          label_en: "total_single",
          view: true,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "المتجوزين",
          label_en: "total_marriad",
          view: true,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "المتوفين",
          label_en: "total_died",
          view: true,
          sortAble: true,
          searchAble: false,
        },
        {
          label_ar: "عدد الافراد الكلي",
          label_en: "persons_total",
          view: true,
          sortAble: true,
          searchAble: false,
        },
      ],
      other: [
        {
          label_ar: "استعراض",
          label_en: "view",
        },
      ],
    };

    const filteringVisible = ref(0);
    const data = ref([]);
    const pagesCount = ref(0);
    const resultCount = ref(0);
    const spinner = ref(true);

    axios.get(links.families).then(function (res) {
      if (res.data.status == "success") {
        data.value = res.data.families.data;
        pagesCount.value = res.data.families.last_page;
        resultCount.value = res.data.families.total;
        spinner.value = false;
        filteringVisible.value = res.data.status;
      }
    });

    function getAllFamilies() {
      axios.get(links.families).then(function (res) {
        data.value = res.data.families.data;
        pagesCount.value = res.data.families.last_page;
        resultCount.value = res.data.families.total;
      });
    }

    function paginateEvent(page) {
      axios.get(links.families + "?page=" + page).then(function (res) {
        data.value = res.data.families.data;
      });
    }

    function familyId(req) {
      if (req.length > 0) {
        axios.get(links.number + req).then(function (res) {
          if (res.data.status) {
            data.value = res.data.families.data;
            pagesCount.value = res.data.families.last_page;
            resultCount.value = res.data.families.total;
          }
        });
      } else {
        getAllFamilies();
      }
    }

    function registrationNumber(req) {
      if (req.length > 0) {
        axios.get(links.registerNumber + req).then(function (res) {
          if (res.data.status) {
            data.value = res.data.families.data;
            pagesCount.value = res.data.families.last_page;
            resultCount.value = res.data.families.total;
          }
        });
      } else {
        getAllFamilies();
      }
    }

    function landlinePhoneNumber(req) {
      if (req.length > 0) {
        axios.get(links.landingPhone + req).then(function (res) {
          if (res.data.status) {
            data.value = res.data.families.data;
            pagesCount.value = res.data.families.last_page;
            resultCount.value = res.data.families.total;
          }
        });
      } else {
        getAllFamilies();
      }
    }

    function phoneNumber(req) {
      if (req.length > 0) {
        axios.get(links.phone + req).then(function (res) {
          if (res.data.status) {
            data.value = res.data.families.data;
            pagesCount.value = res.data.families.last_page;
            resultCount.value = res.data.families.total;
          }
        });
      } else {
        getAllFamilies();
      }
    }

    function districtNumber(req) {
      if (req.length > 0) {
        axios.get(links.address + req).then(function (res) {
          console.log("districtNumber: ", res.data.status);
          data.value = res.data.data;
          pagesCount.value = res.data.last_page;
          resultCount.value = res.data.total;
        });
      } else {
        getAllFamilies();
      }
    }

    function blockNumber(req) {
      if (req.length > 0) {
        axios.get(links.number + req).then(function (res) {
          console.log("blockNumber: ", res.data.status);
          data.value = res.data.data;
          pagesCount.value = res.data.last_page;
          resultCount.value = res.data.total;
        });
      } else {
        getAllFamilies();
      }
    }

    return {
      columns,
      data,
      pagesCount,
      resultCount,
      paginateEvent,
      familyId,
      registrationNumber,
      landlinePhoneNumber,
      phoneNumber,
      districtNumber,
      blockNumber,
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