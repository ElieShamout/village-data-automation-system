<template>
  <Spinner v-if="spinner" />

  <div v-else>
    <div
      class="d-flex justify-content-between align-items-center mb-5"
      id="non-printable"
    >
      <h1>إصدار شهادة</h1>
      <div class="">
        <div
          class="btn btn-primary mx-2"
          @click="exportToPDF"
          v-if="data.length != 0"
        >
          طباعة
          <i class="bi bi-printer-fill me-2"></i>
        </div>
        <BackBtn />
      </div>
    </div>

    <div v-if="data.length != 0">
      <Marriage
        :data="data"
        v-if="certificateType == 'marriage'"
        id="certificate"
      />
      <Baptismal
        :data="data"
        :test="certificateType"
        v-else-if="certificateType == 'baptismal'"
        id="certificate"
      />
      <Engagment
        :data="data"
        v-if="certificateType == 'engagment'"
        id="certificate"
      />
    </div>
    <EmptyData v-else />
  </div>

  <ErrorModal :message="errorMessage" />
</template>
  
<script>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import Baptismal from "../components/certificates/baptismal.vue";
import Engagment from "../components/certificates/engagement.vue";
import Marriage from "../components/certificates/marriage.vue";
import html2pdf from "html2pdf.js";
import Spinner from "../components/common/spinner.vue";
import EmptyData from "../components/common/dataNotFound.vue";
import BackBtn from "../components/common/backBtn.vue";
import ErrorModal from "../components/modal/error.vue";
export default {
  components: {
    Baptismal,
    Marriage,
    Engagment,
    Spinner,
    EmptyData,
    BackBtn,
    ErrorModal,
  },
  setup() {
    const route = useRoute();

    const links = {
      baptismal: "https://elie.test/api/person/certificate/baptismal/",
      engagment: "https://elie.test/api/person/certificate/engagment/",
      marriage: "https://elie.test/api/person/certificate/marriage/",
    };

    const certificateType = ref("");
    certificateType.value = route.params.type;

    const data = ref([]);
    const spinner = ref(true);

    const errorMessage = ref("");

    onMounted(() => {
      axios
        .get(links[certificateType.value] + route.params.person_id)
        .then((res) => {
          console.log(res);
          /**
           * code :
           *    - 0 : person not found
           *    - 1 : certificate not found
           *    - 2 : husband family not found
           *    - 3 : wife family not found
           */
          if (res.data.status) {
            data.value = res.data.certificate;
          } else {
            if (res.data.code == 0) {
              // person not found
              errorMessage.value = "الشخص غير موجود";
            } else if (res.data.code == 1) {
              // certificate not found
              errorMessage.value = "الشهادة غير موجودة";
            } else if (res.data.code == 2) {
              // husband family not found
              errorMessage.value = "عائلة الزوج غير معروفة";
            } else if (res.data.code == 3) {
              // wife family not found
              errorMessage.value = "عائلة الزوجة غير معروفة";
            } else {
              errorMessage.value = "حصل خطأ الرجاء إعادة المحاولة";
            }
            $("#ErrorModal").modal("show");
          }
          spinner.value = false;
        });
    });

    function exportToPDF() {
      html2pdf()
        .set({
          id: "certificate",
          margin: 1,
          filename: "Baptismal.pdf",
          html2canvas: {
            dpi: 8000,
            scale: 4,
            letterRendering: false,
            useCORS: true,
          },
          jsPDF: {
            unit: "mm",
            format: "a4",
            orientation: "portrait",
            pagesplit: true,
          },
        })
        .from(document.getElementById("certificate"))
        .outputPdf() // add this to replace implicite .save() method, which triggers file download
        .get("pdf")
        .then(function (pdfObj) {
          pdfObj.autoPrint();
          window.open(pdfObj.output("bloburl"), "T");
        });
    }

    return {
      certificateType,
      data,
      exportToPDF,
      spinner,
      errorMessage,
    };
  },
};
</script>
  
<style scoped>
</style>