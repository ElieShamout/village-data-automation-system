<template>
  <div class="engagment-certificate-container">
    <Header />

    <div class="certificate-body" dir="rtl">
      <div class="certificate-body-header">
        <div class="certificate-name">وثـيــقــة خـطـوبـة</div>
      </div>

      <div class="certificate-body-content" dir="rtl">
        <div class="statement">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; مكتب رعيّة كفربهم, مطرانية حماة
          وتوابعها للرّوم الأرثوذُكس, وبالرّجوع إلى سجلات عقود الزّواج المحفوظة
          لديه, يعلن بهذه الوثيقة أنَّ:
        </div>
        <div class="husband">
          السّيّد
          <b
            >{{ husband.first_name }} {{ husband.father_name }}
            {{ husband.last_name }}</b
          >&nbsp; والدته
          <b>{{ husband.mother_name }}</b>
          المولود في
          <b>{{ husband.birtdate_place }}</b>
          بتاريخ
          <b dir="ltr">{{ husband.birthdate }}</b>
          محّل ورقم القيد
          <b>{{ husband.registration_place }}</b
          >&nbsp;
          <b dir="ltr">{{ husband.registration_number }}</b>
        </div>
        <div class="statement">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; كان قد عقد
          <b>خطوبةً كنسيةً شرعيةً</b>
          على
        </div>
        <div class="wife">
          السّيّدة
          <b
            >{{ wife.first_name }} {{ wife.father_name }}
            {{ wife.last_name }}</b
          >
          والدتها
          <b>{{ wife.mother_name }}</b>
          المولودة في
          <b>{{ wife.birtdate_place }}</b>
          بتاريخ
          <b dir="ltr">{{ wife.birthdate }}</b>
          محّل ورقم القيد
          <b>{{ wife.registration_place }}</b
          >&nbsp;
          <b dir="ltr">{{ wife.registration_number }}</b>
        </div>
        <div class="statement">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; وقد منحهما بركة الإكليل المقدَّس,
          حسب شعائر الكنيسة الأرثوذُكسيّة, قدس الأب
          <b>{{ engagment.baptized_father }}</b
          >, وسجّل هذا الزّواج في سجلِّه المخصوص برقم
          <b dir="ltr">{{ engagment.record_number }}</b> تاريخ
          <b dir="ltr">{{ engagment.registration_date }}</b>
        </div>
        <div class="statement">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; إشعاراً بالواقع وبناءً على الطلب
          أُعطيت هذه الوثيقة للاعتماد عليها حيث يلزم.
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
    const engagment = ref([]);
    const husband = ref([]);
    const wife = ref([]);

    engagment.value = props.data;
    husband.value = props.data.husband;
    wife.value = props.data.wife;

    return { engagment, husband, wife };
  },
};
</script>
  
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600&display=swap");
.engagment-certificate-container {
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
}
.certificate-body-content {
  margin: 30px 0 0 0;
}
.certificate-name {
  font-size: 30px;
  font-weight: 600;
}
.statement,
.husband,
.wife {
  font-size: 18px;
  margin: 10px 0 0 0;
  line-height: 35px;
}
@media print {
  .bapistmal-certificate-container {
    box-shadow: initial;
    width: 100vw;
    height: 100vh;
  }
}
</style>