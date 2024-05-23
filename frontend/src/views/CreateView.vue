<script setup>
import CreateForm from '@/components/CreateForm.vue'
import { capitalize } from '@/utils/helper'
</script>

<template>
    <h1 class="title">{{ capitalize($route.name) }}</h1>
    <CreateForm />
</template>
