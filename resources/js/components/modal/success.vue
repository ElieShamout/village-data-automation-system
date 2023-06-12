<template>
  <!-- Modal -->
  <div
    class="modal fade"
    id="successModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between py-0 border-0">
          <div class="d-flex align-items-center">
            <h5 class="modal-title" id="exampleModalLabel">نجحت العملية</h5>
          </div>
          <button
            type="button"
            class="btn modal-btn-close text-light"
            data-bs-dismiss="modal"
            aria-label="Close"
          >
            <i class="bi bi-x"></i>
          </button>
        </div>
        <div
          class="modal-body d-flex justify-content-between align-items-center"
        >
          <div class="">
            {{ message }}
          </div>
          <div class="modal-icon">
            <i class="bi bi-check-circle ms-2"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
    },
  },
};
</script>

<style scoped>
.modal-header {
  background-color: rgb(28, 190, 31);
  color: white;
}

.modal-btn-close {
  cursor: pointer;
  font-size: 30px;
  padding: 0 !important;
  margin: 0 !important;
}

.modal-body {
  font-size: 25px;
  position: relative;
  min-height: 150px;
  overflow: hidden;
}
.modal-icon {
  font-size: 80px;
  color: rgb(28, 190, 31);
  animation: example linear 0.8s infinite alternate;
  text-shadow: 0 0 3px #00000040;
  min-width: 80px;
  width: 80px;
}
@keyframes example {
  from {
    transform: scale(1);
  }
  to {
    transform: scale(1.1);
  }
}
</style>