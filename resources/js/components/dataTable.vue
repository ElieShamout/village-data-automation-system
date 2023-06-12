<template>
  <div v-if="data.length">
    <div
      class="my-2 d-flex justify-content-between table-header align-items-center"
    >
      <div class="data-length">
        <span v-if="resultCount != -1">عدد النتائج {{ resultCount }}</span>
      </div>
      <div class="d-flex align-items-center">
        <!-- <div class="ms-2" @click="refreshEvent">
          <button class="refresh-button btn shadow shadow">
            <div class="bi bi-arrow-clockwise"></div>
          </button>
        </div> -->
        <div class="dropdown">
          <button
            class="view-columns-dropdown dropdown-toggle"
            type="button"
            id="dropdownMenuClickableOutside"
            data-bs-toggle="dropdown"
            data-bs-auto-close="outside"
            aria-expanded="false"
          >
            <span class="ps-2">إظهار الأعمدة</span>
          </button>
          <div
            class="dropdown-menu shadow container"
            aria-labelledby="dropdownMenuButton1"
          >
            <div class="row">
              <template
                v-for="(key, index) in columns.basic"
                :key="key.label_en"
              >
                <div class="col-6" v-if="index <= columns.basic.length / 2 + 1">
                  <label class="dropdown-item text-end">
                    <div class="d-flex justify-content-between">
                      <div class="">
                        <input
                          type="checkbox"
                          v-model="key.view"
                          class="mx-1"
                          checked
                        />
                        {{ key.label_ar }}
                      </div>
                      <div class="">
                        <i
                          class="bi bi-search checkbox-icons"
                          v-if="key.searchAble"
                        ></i>
                        <i
                          class="bi bi-funnel checkbox-icons"
                          v-if="key.sortAble"
                        ></i>
                      </div>
                    </div>
                  </label>
                </div>
                <div class="col-6" v-else>
                  <label class="dropdown-item text-end">
                    <div class="d-flex justify-content-between">
                      <div class="">
                        <input
                          type="checkbox"
                          v-model="key.view"
                          class="mx-1"
                          checked
                        />
                        {{ key.label_ar }}
                      </div>
                      <div class="">
                        <i
                          class="bi bi-search checkbox-icons"
                          v-if="key.searchAble"
                        ></i>
                        <i
                          class="bi bi-funnel checkbox-icons"
                          v-if="key.sortAble"
                        ></i>
                      </div>
                    </div>
                  </label>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div>
      <!-- class="bg-light rounded shadow" -->
      <div :class="tableStyle">
        <table class="table table-hover">
          <thead>
            <tr>
              <template v-for="column in columns.basic" :key="column.label_en">
                <th
                  v-if="column.view"
                  @click="column.sortAble ? sortData(column.label_en) : ''"
                >
                  <div class="th-content d-flex">
                    {{ column.label_ar }}

                    <div
                      class="arrow me-2"
                      v-if="column.label_en == sortColumn"
                    >
                      <i
                        v-bind:class="
                          sortType
                            ? 'bi bi-sort-alpha-up'
                            : 'bi bi-sort-alpha-down'
                        "
                      ></i>
                      <!-- <i class="bi bi-sort-alpha-up"></i> -->
                      <!-- <i class="bi bi-sort-alpha-up"></i> -->
                    </div>
                  </div>
                </th>
              </template>
              <!-- <th>الصفة العائلية</th>
              <th>معلومات أخرى</th> -->
              <template v-for="column in columns.other" :key="column.label_en">
                <th>
                  {{ column.label_ar }}
                </th>
              </template>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in data" :key="item.id">
              <template v-for="field in columns.basic" :key="field">
                <td v-if="field.view">
                  {{ item[field.label_en] }}
                </td>
              </template>

              <td
                v-if="
                  columns.other.filter((col) => col.label_en == 'adjective')
                    .length
                "
              >
                <template v-for="adjective in item.adjectives" :key="adjective">
                  <router-link
                    :to="{
                      name: routeName,
                      params: {
                        person_id: item.id,
                        family_id: adjective.family_id,
                      },
                    }"
                    v-if="adjective['adjective'] == 'أب'"
                    class="route-link badge bg-primary persons-link"
                    >{{ adjective["adjective"] }}
                  </router-link>
                  <router-link
                    :to="{
                      name: routeName,
                      params: {
                        person_id: item.id,
                        family_id: adjective.family_id,
                      },
                    }"
                    v-else-if="adjective['adjective'] == 'أم'"
                    class="route-link badge bg-primary persons-link"
                    >{{ adjective["adjective"] }}</router-link
                  >
                  <router-link
                    :to="{
                      name: routeName,
                      params: {
                        person_id: item.id,
                        family_id: adjective.family_id,
                      },
                    }"
                    v-else
                    class="route-link badge bg-secondary persons-link"
                    >{{ adjective["adjective"] }}</router-link
                  >
                </template>
              </td>
              <td
                v-if="
                  columns.other.filter(
                    (col) => col.label_en == 'other_information'
                  ).length
                "
              >
                <div class="badge bg-warning" v-if="item.immigration">
                  مهاجر
                </div>
                <div class="badge bg-danger" v-if="item.military_service">
                  عسكري
                </div>
                <div class="badge bg-dark" v-if="item.live_dead">متوفي</div>
              </td>

              <td
                v-if="
                  columns.other.filter((col) => col.label_en == 'view').length
                "
              >
                <router-link
                  :to="{
                    name: routeName,
                    params: {
                      family_id: item.id,
                    },
                  }"
                  class="route-link badge bg-primary persons-link"
                  >استعراض
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div
        class="pagination d-flex justify-content-center"
        v-if="pagesCount && resultCount"
      >
        <paginate
          class="shadow"
          v-model="page"
          :page-count="pagesCount"
          :page-range="3"
          :margin-pages="2"
          :click-handler="event"
          :prev-text="'السابق'"
          :next-text="'التالي'"
          :container-class="'pagination'"
          :page-class="'page-item'"
          dir="ltr"
        >
        </paginate>
      </div>
    </div>
  </div>
  <EmptyData v-else />
</template>

<script>
import { ref, watch } from "vue";

import Paginate from "vuejs-paginate-next";

import EmptyData from "./common/dataNotFound.vue";

export default {
  props: {
    columns: {
      type: Object,
      default: [],
    },
    data: {
      type: Object,
      default: [],
    },
    pagesCount: {
      type: Number,
      default: 0,
    },
    resultCount: {
      type: Number,
      default: 0,
    },
    tableStyle: {
      type: String,
      default: "bg-light shadw rounded",
    },
    routeName: {
      type: String,
    },
  },
  components: { EmptyData, Paginate },
  setup(props, context) {
    const sortColumn = ref("");
    const sortType = ref(0);

    const data = ref([]);
    const pagesCount = ref(0);
    const resultCount = ref(0);
    const routeName = ref("");

    data.value = props.data;
    pagesCount.value = props.pagesCount ?? 0;
    resultCount.value = props.resultCount ?? 0;
    routeName.value = props.routeName;

    watch(() => {
      data.value = props.data;
    });

    function event(ele) {
      context.emit("paginateEvent", ele);
    }

    function sortData(col) {
      if (sortColumn.value === col) {
        sortType.value = !sortType.value;
      } else {
        sortType.value = 0;
        sortColumn.value = col;
      }

      if (!sortType.value) {
        data.value.sort((per1, per2) =>
          per1[col] > per2[col] ? 1 : per1[col] < per2[col] ? -1 : 0
        );
      } else {
        data.value.sort((per1, per2) =>
          per1[col] < per2[col] ? 1 : per1[col] > per2[col] ? -1 : 0
        );
      }
    }

    return { data, event, routeName, sortData, sortColumn, sortType };
  },
};
</script>

<style >
@import "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css";

.table-header {
  padding: 10px 0 0 0;
}
.data-length {
  font-size: 16px;
  font-weight: 600;
}
.view-columns-dropdown {
  padding: 5px;
  border: 0;
  outline: 0;
  box-shadow: 0 0 3px #00000050;
  border-radius: 5px;
  background: #dd2929;
  color: white;
}
.dropdown .dropdown-menu {
  min-width: 500px;
  width: 500px;
}
.dropdown-menu .dropdown-item {
  cursor: pointer;
}
.refresh-button {
  background: #555555e9;
  padding: 0 !important;
  color: #fff;
  overflow: hidden;
  max-height: 35px;
  height: 35px;
  max-width: 30px;
  width: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.refresh-button:hover {
  color: #fff !important;
}

.refresh-button:hover > .bi {
  animation: refreshRotate linear 1.2s infinite;
}
@keyframes refreshRotate {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
.checkbox-icons {
  margin: 0 5px 0 0;
}
.badge {
  margin: 0 5px;
}
.route-link {
  text-decoration: none;
  transition: background-color 0.2s;
}
.route-link:hover {
  color: white;
}

.page-item .page-link {
  cursor: pointer !important;
}
</style>







<!-- <td>
  <template
    v-for="adjective in item.adjectives"
    :key="adjective"
  >
    <router-link
      :to="{
        name: routeName,
        params: {
          person_id: item.id,
          family_id: adjective.family_id,
        },
      }"
      v-if="adjective['adjective'] == 'أب'"
      class="route-link badge bg-primary persons-link"
      >{{ adjective["adjective"] }}
    </router-link>
    <router-link
      :to="{
        name: routeName,
        params: {
          person_id: item.id,
          family_id: adjective.family_id,
        },
      }"
      v-else-if="adjective['adjective'] == 'أم'"
      class="route-link badge bg-primary persons-link"
      >{{ adjective["adjective"] }}</router-link
    >
    <router-link
      :to="{
        name: routeName,
        params: {
          person_id: item.id,
          family_id: adjective.family_id,
        },
      }"
      v-else
      class="route-link badge bg-secondary persons-link"
      >{{ adjective["adjective"] }}</router-link
    >
  </template>
</td>
<td v-if="columns.other">
  <div class="badge bg-warning" v-if="item.immigration">
    مهاجر
  </div>
  <div class="badge bg-danger" v-if="item.military_service">
    عسكري
  </div>
  <div class="badge bg-dark" v-if="item.live_dead">متوفي</div>
</td> -->