<template>
    <div v-if='showPopup' class='popup'>
        <div :class="['popup-content', isSuccess ? 'success' : 'error']">
            <p>{{ message }}</p>
            <button @click="closePopup">Закрыть</button>
        </div>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            showPopup: false,
            isSuccess: false,
            message: ''
        };
    },
    methods: {
        openPopup(isSuccess, message) {
            this.isSuccess = isSuccess;
            this.message = message;
            this.showPopup = true;
        },
        closePopup() {
            this.showPopup = false;
        }
    }
};
</script>
  
<style scoped>
.popup {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.4);
    z-index: 9999;
}

.popup-content {
    padding: 20px;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0 10px 20px 0 rgba(0, 0, 0, 0.3);
}

.popup-content p {
    font-weight: bold;
    margin-bottom: 15px;
}

.success {
    color: green;
}

.error {
    color: coral;
}

button {

}
</style>
  