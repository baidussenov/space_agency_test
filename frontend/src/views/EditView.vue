<script setup>
import EditForm from '@/components/EditForm.vue'
import { capitalize } from '@/utils/helper'
</script>

<template>
    <h1 class="title">{{ capitalize($route.name) }}</h1>
    <EditForm />
</template>
