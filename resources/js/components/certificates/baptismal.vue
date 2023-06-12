<template>
  <div class="bapistmal-certificate-container">
    <Header />

    <div class="certificate-body" dir="rtl">
      <div class="certificate-body-header">
        <div class="cross">
          <img src="../../../assets/Cross.png" alt="" srcset="" />
        </div>
        <div class="certificate-name">شهادة معمودية</div>
        <div class="cross">
          <img src="../../../assets/Cross.png" alt="" srcset="" />
        </div>
      </div>

      <div class="certificate-body-content" dir="rtl">
        <div class="sector">
          <table>
            <tr>
              <td class="row-th">اسم المُعَمَّد وعائلته</td>
              <td class="colon">:</td>
              <td class="row-td-result">
                {{ data.first_name }} {{ data.last_name }}
              </td>
            </tr>
            <tr>
              <td class="row-th">اسم الأب</td>
              <td class="colon">:</td>
              <td class="row-td-result">
                {{ data.father_name }}
              </td>
            </tr>
            <tr>
              <td class="row-th">اسم الأم وعائلتها</td>
              <td class="colon">:</td>
              <td class="row-td-result">
                {{ data.mother_name ?? "" }}
              </td>
            </tr>
            <tr>
              <td class="row-th">مكان وتاريخ الولادة</td>
              <td class="colon">:</td>
              <td class="row-td-result">
                {{ data.birthdate_place }}
                <span class="m-2" dir="ltr">{{ data.birthdate }}</span>
              </td>
            </tr>
            <tr>
              <td class="row-th">محل ورقم القيد</td>
              <td class="colon">:</td>
              <td class="row-td-result">
                {{ data.registration_place }}
                <span class="m-2" dir="ltr">{{
                  data.registration_number
                }}</span>
              </td>
            </tr>
            <tr>
              <td class="row-th">اسم العرّاب وعائلته</td>
              <td class="colon">:</td>
              <td class="row-td-result">{{ data.godfather }}</td>
            </tr>
            <tr>
              <td class="row-th">اسم الكاهن المُعِّمد</td>
              <td class="colon">:</td>
              <td class="row-td-result">
                {{ baptismal.baptized_father }}
              </td>
            </tr>
          </table>
        </div>
        <div class="sector statement">
          للبيان, وبناءً على الطلب, أُعطيَتْ هذه الشهادة, وهي مأخوذة عمّا وردَ
          لدينا في سجل المعموديّة رقم
          <span class="record-number">{{
            baptismal.baptismal_record_number
          }}</span>
          الصفحة رقم
          <span class="page-number">{{ baptismal.page_number }}</span>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
import { ref } from "vue";
import Header from "./Header.vue";
import Footer from "./Footer.vue";
export default {
  components: { Header, Footer },
  props: {
    data: {
      type: Object,
    },
  },
  setup(props) {
    const data = ref({});
    const baptismal = ref({});
    data.value = props.data;
    baptismal.value = props.data.baptismal;

    return { data, baptismal };
  },
  // setup(props, context) {
  //   const data = ref([]);
  //   const baptismal = ref([]);
  //   const link = "https://elie.test/api/person/certificate/baptismal/";

  //   onMounted(() => {
  //     axios.get(link + props.person_id).then((res) => {
  //       data.value = res.data;
  //       baptismal.value = res.data.baptismal;
  //       context.emit("checkData", res.data);
  //     });
  //   });

  //   return { data, baptismal };
  // },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600&display=swap");
.bapistmal-certificate-container {
  font-family: "Cairo", sans-serif !important;
  padding: 0;
  width: 750px;
  min-height: 1000px;
  /* min-height: 100vh; */
  margin: auto;
  background: #fff;
  padding: 60px;
  box-shadow: 0 0 5px #000000a0;
  color: #000;
  position: relative;
  overflow: hidden;
}
.certificate-body {
  margin: 100px 0 0 0;
}
.certificate-body-header {
  display: flex;
  align-items: center;
  justify-content: space-around;
  border: 1px solid black;
  padding: 10px;
}
.certificate-name {
  font-size: 30px;
  font-weight: 600;
}
.cross img {
  width: 50px;
}
.certificate-body-content {
  margin: 40px 0 0 0;
  font-weight: initial;
  line-height: 35px;
}
.certificate-body-content .row-th {
  font-size: 18px;
}
.certificate-body-content .colon {
  font-weight: 800;
  width: 30px;
  text-align: end;
  padding: 0 0 0 10px;
}
.certificate-body-content .row-td-result {
  font-size: 18px;
  font-weight: 700;
}
.statement {
  font-size: 18px;
  margin: 10px 0 0 0;
}

.record-number {
  font-weight: 600;
}
.page-number {
  font-weight: 600;
}
@media print {
  .bapistmal-certificate-container {
    box-shadow: initial;
    width: 100vw;
    height: 100vh;
  }
}
</style>