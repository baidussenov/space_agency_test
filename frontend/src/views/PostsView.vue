<script setup>
import PostsList from '@/components/PostsList.vue'
import { capitalize } from '@/utils/helper'
</script>

<template>
    <h1 class="title">{{ capitalize($route.name) }}</h1>
    <PostsList />
</template>
