<template>
    <div class="w-full h-screen fixed top-0 left-0 flex flex-col justify-center items-center loader__wrap">
        <div class="loader"></div>
        <h4 class="mt-3 font-semibold text-white text-2xl">Please wait...</h4>
    </div>
</template>
<style lang="css">
    .loader__wrap {
        background-color: rgba(51, 51, 51, 0.7);
        z-index: 999;
    }
    .loader {
        width: 100px;
        height: 100px;
        border-radius: 100%;
        border: 3px solid #b9b1b1;
        border-top: 5px solid #ffffff;
        animation: loader 1s infinite;
    }
    @keyframes loader {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>