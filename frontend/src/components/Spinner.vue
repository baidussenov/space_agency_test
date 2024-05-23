<template>
    <div class='wrapper' :style="'display: ' + (show ? 'flex;' : 'none;')">
        <div class='spinner'></div>
    </div>
</template>

<script>
export default {
    props: {
        show: Boolean
    }
}
</script>

<style scoped>
.wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    justify-content: center;
    align-items: center;
}

.spinner {
    position: relative;
    transform: translate(-50%, -50%);

    height: 50px;
    width: 50px;
    border-radius: 50%;
    border: 10px solid #ccc;
    border-top-color: #007bff;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>